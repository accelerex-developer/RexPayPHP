<?php

namespace Pils36\Rexpay\Tests\Exception;

use Pils36\Rexpay\Exception\RexpayException;

class RexpayExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testInitialize()
    {
        $e = new RexpayException('message');
        $this->assertNotNull($e);
    }
}
