<?php

namespace Pils36\Rexpay\Tests\Exception;

use Pils36\Rexpay\Exception\ValidationException;

class ValidationExceptionTest extends \PHPUnit\Framework\TestCase
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
