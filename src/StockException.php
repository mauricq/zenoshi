<?php


namespace App;


abstract class StockException extends \Exception
{
    const DEFAULT_ERROR_CODE = 404;
}