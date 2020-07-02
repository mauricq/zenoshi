<?php


namespace App\Controller;


use App\Controller\Share\ControllerProvider;
use App\Entity\Constants;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use App\Service\Files\FilesService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * This class allows to manage the receipts but only the image files.
 *
 * @Route("files")
 */
class FilesController
{
    /**
     * @var ClassMetadataFactory
     */
    private ClassMetadataFactory $classMetadataFactory;
    /**
     * @var ObjectNormalizer
     */
    private ObjectNormalizer $normalizer;
    /**
     * @var Serializer
     */
    private Serializer $serializer;
    /**
     * @var FilesService
     */
    private FilesService $fileService;

    /**
     * @required
     * @param string $dateTimeFormat
     * @throws AnnotationException
     */
    public function setClassMetadataFactory(string $dateTimeFormat)
    {
        $this->classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $this->normalizer = new ObjectNormalizer($this->classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $this->serializer = new Serializer([new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => $dateTimeFormat]), $this->normalizer], [new JsonEncoder()]);
    }

    /**
     * FileController constructor.
     * @param FilesService $fileService
     */
    public function __construct(FilesService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @Route("/", name="saveFiles", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function save(Request $request): JsonResponse
    {
        $img = $request->getContent();
        try {
            $object = $this->fileService->save($img);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_SUCCESS,
                    Constants::RESULT_LABEL_DATA => $this->serializer->normalize($object, null, ['groups' => [strtolower($this->fileService->getClassOnly())]])
                ),
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            $error = join('-', [$e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode(), $e->getTraceAsString()]);
            $result = new JsonResponse(
                array(
                    Constants::RESULT_LABEL_STATUS => Constants::RESULT_ERROR,
                    Constants::RESULT_LABEL_DATA => $error
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $result;
    }
}