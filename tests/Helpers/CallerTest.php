<?php
namespace Pils36\Rexpay\Tests\Helpers;

use Pils36\Rexpay\Helpers\Caller;
use Pils36\Rexpay;
use Pils36\Rexpay\Contracts\RouteInterface;

class CallerTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $p = new Rexpay('REXSECK_');
        $c = new Caller($p);
        $this->assertNotNull($c);
    }
}
