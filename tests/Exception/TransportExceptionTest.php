<?php

namespace Pils36\Rexpay\Tests;

use PHPUnit\Framework\TestCase;
use Pils36\Rexpay\Exception\TransportException;
use Pils36\Rexpay\Http\Request;

class TransportExceptionTest extends TestCase
{
    public function testTransportExceptionHierarchy(): void
    {
        $e = new TransportException("Connection timed out");
        $this->assertInstanceOf(\Pils36\Rexpay\Exception\RexpayException::class, $e);
        $this->assertSame("Connection timed out", $e->getMessage());
    }

    public function testSendThrowsTransportExceptionWhenAllTransportsFail(): void
    {
        $request = new Request();
        $request->endpoint = "http://127.0.0.1:54321/invalid-endpoint-test";
        $request->method = "GET";

        $this->expectException(TransportException::class);
        $request->send();
    }
}