<?php
namespace Pils36\Rexpay\Tests\Routes;

use Pils36\Rexpay\Contracts\RouteInterface;
use Pils36\Rexpay\Routes\Decision;

class DecisionTest extends \PHPUnit_Framework_TestCase
{
    public function testRoot()
    {
        $r = new Decision();
        $this->assertEquals('/decision', $r->root());
    }

    public function testEndpoints()
    {
        $r = new Decision();
        $this->assertEquals('/decision/bin/{bin}', $r->bin()[RouteInterface::ENDPOINT_KEY]);
    }

    public function testMethods()
    {
        $r = new Decision();
        $this->assertEquals(RouteInterface::GET_METHOD, $r->bin()[RouteInterface::METHOD_KEY]);
    }
}
