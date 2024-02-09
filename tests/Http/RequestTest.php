<?php
namespace Pils36\Rexpay\Tests\Http;

use Pils36\Rexpay\Http\Request;
use Pils36\Rexpay\Http\Response;
use Pils36\Rexpay;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $r = new Request();
        $this->assertNotNull($r);
    }

    public function testAllApiRequestsMustHaveJsonHeader()
    {
        $p = new Rexpay('REXSECK_');
        $r = new Request($p);
        $this->assertEquals('application/json', $r->headers['Content-Type']);
        $rNonApi = new Request();
        $this->assertFalse(array_key_exists('Content-Type', $rNonApi->headers));
    }

    public function testGetResponse()
    {
        $rq = new Request();
        $rp = $rq->getResponse();
        $this->assertNotNull($rp);
        $this->assertInstanceOf(Response::class, $rp);
    }

    public function testFlattenedHeadersAndThatOnlyContentTypeAddedByDefaultWhenRexpayObjectPresent()
    {
        $p = new Rexpay('REXSECK_');
        $rq = new Request($p);
        $hs = $rq->flattenedHeaders();
        $this->assertEquals(1, count($hs));
        $this->assertNotNull($hs[0]);
    }
}
