<?php
namespace Pils36\Rexpay\Tests;

class AutoloadTest extends \PHPUnit_Framework_TestCase
{
    public function testAutoload()
    {
        $rexpay_autoloader = require(__DIR__ . '/../src/autoload.php');
        $rexpay_autoloader('Pils36\\Rexpay\\Routes\\Invoice');
    }
}
