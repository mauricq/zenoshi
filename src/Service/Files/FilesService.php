<?php

namespace App\Service\Files;

use App\Entity\Constants;
use App\Entity\File;
use App\Entity\Reward;
use App\Utils\FileHandler;
use Exception;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FilesService
{
    /**
     * @var ArrayTransformerInterface
     */
    protected ArrayTransformerInterface $arrayTransformer;
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;
    /**
     * @var string
     */
    private string $pathTempFiles;
    /**
     * @var FileHandler
     */
    private FileHandler $fileHandler;

    /**
     * FilesService constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param string $pathTempFiles
     * @param FileHandler $fileHandler
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer, SerializerInterface $serializer, string $pathTempFiles, FileHandler $fileHandler)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
        $this->pathTempFiles = $pathTempFiles;
        $this->fileHandler = $fileHandler;
    }

    /**
     * @param string $request
     * @return File
     * @throws Exception
     */
    public function save(string $request): File
    {
        $body = $request;
        $object = $this->serializer->deserialize($body, File::class, Constants::REQUEST_FORMAT_JSON);

        $file = $object->getBase64File();
        $fileName = $object->getFileName();
        $pathFile = $this->pathTempFiles . "/" . $fileName;
        $result = $this->fileHandler->saveBase64($file, $pathFile);
        if (!$result) {
            throw new Exception("Error trying to save image", Response::HTTP_CONFLICT);
        }

        return $object;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return Reward::class;
    }

    /**
     * @return string
     */
    public function getClassOnly(): string
    {
        return str_replace(Constants::PREPARED_DATA_PATH_ENTITY, "", $this->getClass());
    }

}