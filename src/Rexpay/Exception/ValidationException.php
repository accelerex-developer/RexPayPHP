<?php

namespace Pils36\Rexpay\Exception;

class ValidationException extends RexpayException
{
    public $errors;
    public function __construct($message, array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
}
