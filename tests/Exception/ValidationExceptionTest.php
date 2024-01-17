<?php

namespace Pils36\Rexpay\Tests\Exception;

use Pils36\Rexpay\Exception\ValidationException;

class ValidationExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $e = new ValidationException('message');
        $this->assertNotNull($e);
        $e = new ValidationException('message', []);
        $this->assertNotNull($e);
        $e = new ValidationException('message', ['this'=>'bad']);
        $this->assertNotNull($e);
    }
}
