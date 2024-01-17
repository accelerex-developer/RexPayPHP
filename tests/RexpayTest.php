<?php
namespace Pils36\Rexpay\Tests;

use Pils36\Rexpay;
use Pils36\Rexpay\Helpers\Router;
use Pils36\Rexpay\Test\Mock\CustomRoute;
use \Pils36\Rexpay\Exception\ValidationException;

class RexpayTest extends \PHPUnit_Framework_TestCase
{


    public function testVersion()
    {
        $this->assertEquals("2.1.19", Rexpay::VERSION);
    }

    public function testDisableFileGetContentsFallback()
    {
        Rexpay::disableFileGetContentsFallback();
        $this->assertFalse(Rexpay::$fallback_to_file_get_contents);
    }

    public function testEnableFileGetContentsFallback()
    {
        Rexpay::enableFileGetContentsFallback();
        $this->assertTrue(Rexpay::$fallback_to_file_get_contents);
    }


    public function testSetUseGuzzle()
    {
        $r = new Rexpay('REXSECK_');
        $r->useGuzzle();
        $this->assertTrue($r->use_guzzle);
    }

    public function testGetShouldBringRouter()
    {
        $r = new Rexpay('REXSECK_');
        $this->assertInstanceOf(Router::class, $r->customer);
        $this->expectException(ValidationException::class);
        $this->assertNull($r->nonexistent);
    }

    public function testListInvalidResource()
    {
        $r = new Rexpay('REXSECK_');
        $this->expectException(\InvalidArgumentException::class);
        $this->assertNull($r->nonexistents());
    }

    public function testFetchInvalidResource()
    {
        $r = new Rexpay('REXSECK_');
        $this->expectException(ValidationException::class);
        $this->assertNull($r->nonexistent(1));
    }

    public function testFetchWithInvalidParams2()
    {
        $r = new Rexpay('REXSECK_');
        $this->expectException(\InvalidArgumentException::class);
        $this->assertNull($r->customer());
    }

    public function testFetchWithInvalidParams3()
    {
        $r = new Rexpay('REXSECK_');
        $this->expectException(\InvalidArgumentException::class);
        $this->assertNull($r->customers(1));
    }

    public function testUseRoutes()
    {
        $custom_routes = ['custom_route' => CustomRoute::class];

        $r = new Rexpay('REXSECK_');
        $r->useRoutes($custom_routes);
        $this->assertTrue($r->custom_routes == $custom_routes);
    }

    public function testUseRoutesWithInvalidParams1()
    {
        $custom_routes = ['custom_route'];
        $r = new Rexpay('REXSECK_');
        $this->expectException(\InvalidArgumentException::class);
        $r->useRoutes($custom_routes);
        $this->assertNull($r->custom_routes);
    }

    public function testUseRoutesWithInvalidParams2()
    {
        $custom_routes = ['custom_route' => Rexpay::class];
        $r = new Rexpay('REXSECK_');
        $this->expectException(\InvalidArgumentException::class);
        $r->useRoutes($custom_routes);
        $this->assertNull($r->custom_routes);
    }

    public function testUseRoutesWithInvalidParams3()
    {
        $custom_routes = ['balance' => CustomRoute::class];
        $r = new Rexpay('REXSECK_');
        $this->expectException(\InvalidArgumentException::class);
        $r->useRoutes($custom_routes);
        $this->assertNull($r->custom_routes);
    }
}
