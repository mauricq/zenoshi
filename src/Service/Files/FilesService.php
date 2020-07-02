<?php

namespace App\Service\Files;

use App\Entity\Constants;
use App\Entity\File;
use App\Entity\Reward;
use App\Errors\DuplicatedException;
use App\Errors\ElementNotFoundException;
use App\Service\FileService;
use App\Utils\FileHandler;
use App\Utils\Utils;
use Exception;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

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
     * @var string
     */
    private string $pathEnvironmentFiles;
    /**
     * @var FileHandler
     */
    private FileHandler $fileHandler;
    /**
     * @var string
     */
    protected string $saltImage;
    /**
     * @var Utils
     */
    protected Utils $utils;
    /**
     * @var array
     */
    protected array $filesTypeAllowed;
    /**
     * @var FileService
     */
    protected FileService $fileService;

    /**
     * FilesService constructor.
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface $serializer
     * @param string $pathTempFiles
     * @param string $pathEnvironmentFiles
     * @param FileHandler $fileHandler
     * @param string $saltImage
     * @param Utils $utils
     * @param array $filesTypeAllowed
     * @param FileService $fileService
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer, SerializerInterface $serializer, string $pathTempFiles, string $pathEnvironmentFiles, FileHandler $fileHandler, string $saltImage, Utils $utils, array $filesTypeAllowed, FileService $fileService)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer = $serializer;
        $this->pathTempFiles = $pathTempFiles;
        $this->pathEnvironmentFiles = $pathEnvironmentFiles;
        $this->fileHandler = $fileHandler;
        $this->saltImage = $saltImage;
        $this->utils = $utils;
        $this->filesTypeAllowed = $filesTypeAllowed;
        $this->fileService = $fileService;
    }

    /**
     * @param string $request
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function save(string $request): array
    {
        $body = $request;
        $object = $this->serializer->deserialize($body, File::class, Constants::REQUEST_FORMAT_JSON);
        $result = $this->saveFile($object);
        if (!$result) {
            throw new Exception("Error trying to save image", Response::HTTP_CONFLICT);
        }

        return $result;
    }

    /**
     * @param object $object
     * @return array
     * @throws Exception
     * @throws ExceptionInterface
     */
    private function saveFile(object $object): array
    {
        $result = [];
        $separator = Constants::FILE_SEPARATOR;
        $data = $object->getBase64File();
        $fileRealName = $object->getFileName();
        $securePath = $this->utils->generateCodRef(8)[1];
        $fileName = $securePath . $this->getFileExtension($data, $fileRealName);
        $path = $this->getSecurePath($object->getIdPerson()) . $separator;
        $pathFile = $this->pathTempFiles . $path;
        $server = "http://127.0.0.1:8000/"; //TODO get img server.
        $fileWebLocation = str_replace("\\", "/", $pathFile . $fileName);

        $newObject = clone $object;
        $newObject->setFileRealName($fileRealName);
        $newObject->setFileName($fileName);
        $newObject->setFileLocation($server . $fileWebLocation);

        try {
            // Step 1: save file
            $this->fileHandler->saveFile($this->pathEnvironmentFiles . $pathFile, $fileName, $data);

            // Step 2: save file metadata into database
            $result = $this->fileService->saveGeneric($newObject);

        } catch (DuplicatedException $e) {
            throw $e;
        } catch (ElementNotFoundException $e) {
            throw $e;
        } catch (ExceptionInterface $e) {
            throw $e;
        }

        return $result;
    }

    /**
     * @param string $base64
     * @param string $fileName
     * @return string
     */
    private function getFileExtension(string $base64, string $fileName): string
    {
        $delimiterExtension = ".";
        $inputFileInfoMimeT = strtoupper(finfo_buffer(
            finfo_open(),
            base64_decode($base64),
            FILEINFO_MIME_TYPE
        ));
        $fileAllowed = false;
        foreach ($this->filesTypeAllowed as $type) {
            if (strstr($inputFileInfoMimeT, strtoupper($type)) !== false) {
                $fileAllowed = true;
                break;
            }
        } //TODO
        $ext = explode($delimiterExtension, $fileName);
        return $delimiterExtension . end($ext);
    }

    /**
     * @param string $seed
     * @return string
     */
    private function getSecurePath(string $seed): string
    {
        $secure = $seed . $this->saltImage;
        return md5($secure);
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