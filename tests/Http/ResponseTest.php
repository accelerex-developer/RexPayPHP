<?php
namespace Pils36\Rexpay\Tests;

use PHPUnit\Framework\TestCase;
use Pils36\Rexpay\Http\Response;
use Pils36\Rexpay\Exception\ApiException;

class ResponseTest extends TestCase
{
    public function testInstantiation()
    {
        $r = new Response();
        $this->assertNotNull($r);
    }

    public function testWrapUpForApiOkayNoStatusWithErrors()
    {
        $r = new Response();
        $r->okay = true;
        $r->forApi = true;
        $r->body = '{"message": "A validation error has occured","errors": {"email"';
        $r->body .= ': [{"rule": "required","message": "Email is required"},{"rule"';
        $r->body .= ': "email","message": "Email must be valid"}],"name": [{"rule":';
        $r->body .= ' "required","message": "Name is required"}]}}';

        $resp = $r->wrapUp();
        $this->assertIsObject($resp);
        $this->assertEquals("A validation error has occured", $resp->message);
        $this->assertInstanceOf(\stdClass::class, $resp->errors);
    }

    public function testWrapUpForApiOkay()
    {
        $r = new Response();
        $r->okay = true;
        $r->forApi = true;
        $r->body = '{"responseCode":"00", "status": "okay", "data":{"responseCode":"00", "status": "okay"}}';

        $resp = $r->wrapUp();
        $this->assertEquals('00', $resp->data->responseCode);
    }

    public function testWrapUpForApiOkayNoStatus()
    {
        $r = new Response();
        $r->okay = true;
        $r->forApi = true;
        $r->body = '{"message":"I failed on Api"}';

        $resp = $r->wrapUp();
        $this->assertIsObject($resp);
        $this->assertEquals("I failed on Api", $resp->message);
    }

    public function testWrapUpForApiOkayNoStatusNoMessage()
    {
        $r = new Response();
        $r->okay = true;
        $r->forApi = true;
        $r->body = '{"errors":"I failed on Api"}';

        $resp = $r->wrapUp();
        $this->assertIsObject($resp);
        $this->assertEquals("I failed on Api", $resp->errors);
    }

    public function testWrapUpThrowsApiExceptionOnInvalidJson()
    {
        $r = new Response();
        $r->okay = true;
        $r->forApi = true;
        $r->body = 'INVALID_NON_JSON_RESPONSE';

        $this->expectException(ApiException::class);
        $r->wrapUp();
    }
}