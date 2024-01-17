<?php

namespace Pils36\Rexpay\Exception;

class RexpayException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
