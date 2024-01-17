<?php
namespace Pils36\Rexpay\Helpers;

use \Closure;
use \Pils36\Rexpay\Contracts\RouteInterface;
use \Pils36\Rexpay\Http\RequestBuilder;

class Caller
{
    private $rexpayObj;

    public function __construct($rexpayObj)
    {
        $this->rexpayObj = $rexpayObj;
    }

    public function callEndpoint($interface, $payload = [ ], $sentargs = [ ])
    {
        $builder = new RequestBuilder($this->rexpayObj, $interface, $payload, $sentargs);
        return $builder->build()->send()->wrapUp();
    }
}
