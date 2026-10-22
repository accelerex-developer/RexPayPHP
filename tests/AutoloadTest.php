<?php
namespace Pils36\Rexpay\Tests;

use PHPUnit\Framework\TestCase;
use Pils36\Rexpay;

class AutoloadTest extends TestCase
{
    public function testAutoload()
    {
        $this->assertTrue(class_exists(Rexpay::class));
    }
}