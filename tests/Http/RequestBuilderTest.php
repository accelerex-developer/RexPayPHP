<?php
namespace Pils36\Rexpay\Tests\Http;

use Pils36\Rexpay\Http\RequestBuilder;
use Pils36\Rexpay;
use Pils36\Rexpay\Contracts\RouteInterface;
use Pils36\Rexpay\Routes\Customer;
use Pils36\Rexpay\Routes\Transaction;

class RequestBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testMoveArgsToSentargs()
    {
        $p = new Rexpay('REXSECK_');
        $interface = ['args'=>['id']];
        $payload = ['id'=>1,'reference'=>'something'];
        $sentargs = [];
        $rb = new RequestBuilder($p, $interface, $payload, $sentargs);

        $rb->moveArgsToSentargs();
        $this->assertEquals(1, $rb->sentargs['id']);
        $this->assertEquals(1, count($rb->payload));
    }

    public function testPutArgsIntoEndpoint()
    {
        $p = new Rexpay('REXSECK_');
        $rb = new RequestBuilder($p, null, [], ['reference'=>'some']);
        $endpoint = 'verify/{reference}';

        $rb->putArgsIntoEndpoint($endpoint);
        $this->assertEquals('verify/some', $endpoint);
    }

    public function testBuild()
    {
        $p = new Rexpay('REXSECK_');
        $params = ['reference' => 'sm23oyr1122', 'amount'=>2.00, 'currency'=>'NGN', 'userId'=> 'awoyeyetimilehin@gmail.com', 'callbackUrl'=>'google.com', 'metadata'=>['email' => "awoyeyetimilehin@gmail.com", 'customerName' => "Victor Musa"], 'mode' => 'test'];
        $rb = new RequestBuilder($p, Transaction::initialize(), $params);

        $r = $rb->build();


        $this->assertEquals('https://pgs-sandbox.globalaccelerex.com/api/cps/v1/payment/v2/createPayment', $r->endpoint);
        $this->assertEquals('post', $r->method);
        $this->assertEquals(json_encode($params), $r->body);


        $params = ['perPage'=>10];
        $rb = new RequestBuilder($p, Transaction::getList(), $params);

        $r = $rb->build();


        $this->assertEquals('https://pgs-sandbox.globalaccelerex.com/api/cps/v1/request?perPage=10', $r->endpoint);
        $this->assertEquals('get', $r->method);
        $this->assertEmpty($r->body);

        $args = ['transactionReference'=> 'sm23oyr1122'];
        $rb = new RequestBuilder($p, Transaction::verify(), [], $args);

        $r = $rb->build();


        $this->assertEquals('https://pgs-sandbox.globalaccelerex.com/api/cps/v1/getTransactionStatus?transactionReference=sm23oyr1122', $r->endpoint);
        $this->assertEquals('get', $r->method);
        $this->assertEmpty($r->body);
    }
}
