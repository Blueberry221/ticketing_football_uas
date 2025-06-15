<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // '/midtrans-callback' untuk disable CSRF, harusnya bisa kalau routenya web.php
        //DIUnkomen aja kalau misal pas selesai pembelian malah ga berubah status pembeliannya
        // '/midtrans-callback',
    ];
}
