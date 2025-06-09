<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman dashboard setelah login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }
}
