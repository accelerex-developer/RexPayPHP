<?php
namespace Pils36\Rexpay\Tests\Routes;

use Pils36\Rexpay\Contracts\RouteInterface;
use Pils36\Rexpay\Routes\Settlement;

class SettlementTest extends \PHPUnit_Framework_TestCase
{
    public function testRoot()
    {
        $r = new Settlement();
        $this->assertEquals('/settlement', $r->root());
    }

    public function testEndpoints()
    {
        $r = new Settlement();
        $this->assertEquals('/settlement', $r->getList()[RouteInterface::ENDPOINT_KEY]);
    }

    public function testMethods()
    {
        $r = new Settlement();
        $this->assertEquals(RouteInterface::GET_METHOD, $r->getList()[RouteInterface::METHOD_KEY]);
    }
}
