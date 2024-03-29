<?php
namespace Pils36\Rexpay\Tests\Helpers;

use Pils36\Rexpay;
use Pils36\Rexpay\Helpers\Router;
use Pils36\Rexpay\Routes\Balance;
use Pils36\Rexpay\Test\Mock\CustomRoute;
use Pils36\Rexpay\Contracts\RouteInterface;
use Pils36\Rexpay\Exception\ValidationException;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $p = new Rexpay('REXSECK_');
        $this->expectException(ValidationException::class);
        $r = new Router('nonexistent', $p);
    }

    public function testSingularFor()
    {
        $this->assertEquals('transaction', Router::singularFor('transactions'));
    }

    private function availableRoutes()
    {
        $routes = [];
        $files = scandir(dirname(dirname(__DIR__)) . '/src/Rexpay/Routes');
        foreach ($files as $file) {
            if ('php'===pathinfo($file, PATHINFO_EXTENSION)) {
                $routes[] = strtolower(substr($file, 0, strrpos($file, ".")));
            }
        }
        return $routes;
    }

    public function testAllAvailableRoutesAreListed()
    {
        $available = $this->availableRoutes();
        $listed = Router::$ROUTES;

        sort($available);
        sort($listed);

        $this->assertTrue($listed == $available);
    }

    public function testAllSingularsAreValidRoutes()
    {
        $available = $this->availableRoutes();
        $singulars = array_values(Router::$ROUTE_SINGULAR_LOOKUP);

        sort($available);
        sort($singulars);

        $this->assertEmpty(array_diff($singulars, $available));
    }

    public function testThatCustomRouteCanBeCalled()
    {
        $custom_route = ['charge' => CustomRoute::class];
        $p = new Rexpay('REXSECK_');

        $p->useRoutes($custom_route);

        $r = $p->charge;
        $reflection_property = new \ReflectionProperty($r, "methods");
        $reflection_property->setAccessible(true);
        $methods = $reflection_property->getValue($r);

        $this->assertTrue(in_array("test_route", array_keys($methods)));
        $this->assertTrue(is_callable($methods["test_route"]));
    }

    public function testThatOriginalRoutesCanBeCalledWhenCustomRouteIsSet()
    {
        $custom_route = ['charge' => CustomRoute::class];
        $p = new Rexpay('REXECK_');

        $p->useRoutes($custom_route);


        $r = $p->balance;


        $reflection_property = new \ReflectionProperty($r, "methods");
        $reflection_property->setAccessible(true);
        $methods = $reflection_property->getValue($r);

        $this->assertTrue(in_array("getList", array_keys($methods)));
        $this->assertTrue(is_callable($methods["getList"]));
    }

    public function testThatGetRouteClassMethodReturnsClassNameWhenCustomRouteIsNotSet()
    {
        $p = new Rexpay('REXSECK_');

        $route = $p->balance;

        $reflection = new \ReflectionClass(get_class($route));
        $method = $reflection->getMethod("getRouteClass");
        $method->setAccessible(true);

        $routeClass =  $method->invokeArgs($route, [$p]);
        $this->assertEquals(Balance::class, $routeClass);
    }

    public function testThatGetRouteClassMethodReturnsClassNameWhenCustomRouteIsSet()
    {
        $custom_route = ['charge' => CustomRoute::class];
        $p = new Rexpay('REXSECK_');

        $p->useRoutes($custom_route);

        $route = $p->charge;

        $reflection = new \ReflectionClass(get_class($route));
        $method = $reflection->getMethod("getRouteClass");
        $method->setAccessible(true);

        $routeClass =  $method->invokeArgs($route, [$p]);
        $this->assertEquals(CustomRoute::class, $routeClass);
    }
}
