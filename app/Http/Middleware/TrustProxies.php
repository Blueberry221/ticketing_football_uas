<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies;

    //Ini kalo butuh dipilih aja, untuk yg Header Forwarded all error karena undefined, pakai yang 2  dibawahnya aja salah satu

    // protected $headers = Request::HEADER_X_FORWARDED_ALL;
    // protected $headers = Request::HEADER_X_FORWARDED_AWS_ELB;
    protected $headers = Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO;
}
