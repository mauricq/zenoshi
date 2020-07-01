<?php


namespace App\Utils;

use SplFileObject;

class FileHandler
{
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