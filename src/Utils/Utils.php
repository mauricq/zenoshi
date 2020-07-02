<?php


namespace App\Utils;


use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Utils
{
    private int $sizeCodRef;

    /**
     * Utils constructor.
     * @param int $sizeCodRef
     */
    public function __construct(int $sizeCodRef)
    {
        $this->sizeCodRef = $sizeCodRef/2;
    }

    /**
     * @return UuidInterface
     */
    public function generateUid()
    {
        return Uuid::uuid4();
    }

    /**
     * @param string $size
     * @return array
     * @throws Exception
     */
    public function generateCodRef($size = ""): array
    {
        $sizeRandomBytes = empty($size) ? $this->sizeCodRef : $size;
        $codRef = [];
        $random = random_bytes($sizeRandomBytes);
        $codRef[] = $random;
        $codRef[] = bin2hex($random);
        return $codRef;
    }
}