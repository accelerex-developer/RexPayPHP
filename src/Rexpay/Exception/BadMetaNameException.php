<?php

namespace Pils36\Rexpay\Exception;

class BadMetaNameException extends RexpayException
{
    public $errors;
    public function __construct($message, array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
}
