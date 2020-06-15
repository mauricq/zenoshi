<?php


namespace App\Utils;


use Ramsey\Uuid\Uuid;

class Utils
{
    public function generateUid()
    {
        return Uuid::uuid4();
    }
}