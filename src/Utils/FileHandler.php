<?php


namespace App\Utils;

use App\Entity\Constants;
use Exception;
use SplFileObject;
use Symfony\Component\Filesystem\Filesystem;

class FileHandler
{
    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;
    protected string $fileModeCreation;

    /**
     * FileHandler constructor.
     * @param Filesystem $filesystem
     * @param string $fileModeCreation
     */
    public function __construct(Filesystem $filesystem, string $fileModeCreation)
    {
        $this->filesystem = $filesystem;
        $this->fileModeCreation = $fileModeCreation;
    }

    /**
     * @param array $dir
     * @return bool
     * @throws Exception
     */
    public function createDirectory(array $dir): bool
    {
        $result = false;
        try {
            $this->filesystem->mkdir($dir, $this->fileModeCreation);
            $result = true;
        } catch (Exception $e) {
            throw $e;
        }
        return $result;
    }

    /**
     * @param array $path
     * @return bool
     */
    private function validatePath(array $path): bool
    {
        return $this->filesystem->exists($path);
    }

    /**
     * Receive a multipart/data in order to transform it and then store in the path selected
     * @param string $pathImage
     * @param SplFileObject $content
     * @return bool
     */
    public function saveMultipartDataAsImage(string $pathImage, SplFileObject $content): Bool
    {
        $fileHandler = fopen($pathImage, 'w+');
        $responseWriteFile = fwrite($fileHandler, $content);
        fclose($fileHandler);
        return $responseWriteFile;
    }

    /**
     * @param string $path
     * @param string $fileName
     * @param string $data
     * @return bool
     * @throws Exception
     */
    public function saveFile(string $path, string $fileName, string $data): bool
    {
        $separator = Constants::FILE_SEPARATOR;
        $pathComplete = $path.$separator.$fileName;
        $exists = $this->validatePath([$path, $pathComplete]);
        if (!$exists){
            $this->createDirectory([$path]);
        }
        return $this->saveBase64($data, $pathComplete);
    }

    /**
     * @param string $image
     * @param string $fileName
     * @return bool
     */
    public function saveBase64(string $image, string $fileName): Bool
    {
        $img = str_replace('data:image/png;base64,', '', $image);
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $success = file_put_contents($fileName, $data);
        return (!$success) ? false : true;
    }

    /**
     * Remove a extension from either a filename or a path name
     * @param string $fileName
     * @return string|string[]|null
     */
    public function removeExtension(string $fileName): string
    {
        $replacements = 0;
        $pathFile = "";
        $pathFile = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName, -1, $replacements);
        if ($replacements > 0) {
            return $pathFile;
        } else {
            return $fileName;
        }
    }
}