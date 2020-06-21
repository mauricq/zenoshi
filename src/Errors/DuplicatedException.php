<?php


namespace App\Errors;


use App\Entity\Constants;
use Exception;

class DuplicatedException extends Exception
{
    protected string $defaultMessage = Constants::RESULT_MESSAGE_DUPLICATED;
    protected int $defaultCode = Constants::RESULT_DUPLICATED_CODE;

    /**
     * DuplicatedException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message . $this->defaultMessage, $this->defaultCode);
    }
}