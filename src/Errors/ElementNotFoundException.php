<?php


namespace App\Errors;


use App\Entity\Constants;
use Exception;

class ElementNotFoundException extends Exception
{
    protected string $defaultMessage = Constants::RESULT_MESSAGE_NOT_FOUND;
    protected int $defaultCode = Constants::RESULT_NOT_FOUND_CODE;

    /**
     * ElementNotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message . $this->defaultMessage, $this->defaultCode);
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message) {
        $this->message = $message;
    }
}