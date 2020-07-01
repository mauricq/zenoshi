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
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("files")
 */
class FileController
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
     * @throws AnnotationException
     */
    public function setClassMetadataFactory()
    {
        $this->classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $this->normalizer = new ObjectNormalizer($this->classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $this->serializer = new Serializer([$this->normalizer, new DateTimeNormalizer('Y/m')]);
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
     * @Route("", name="save", methods={"POST"})
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