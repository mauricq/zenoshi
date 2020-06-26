<?php


namespace App\Utils;


use Ramsey\Uuid\Uuid;

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

    public function generateUid()
    {
        return Uuid::uuid4();
    }

    public function generateCodRef(): array
    {
        $codRef = [];
        $random = random_bytes($this->sizeCodRef);
        $codRef[] = $random;
        $codRef[] = bin2hex($random);
        return $codRef;
    }
}