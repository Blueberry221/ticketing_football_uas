<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan daftar users
        return view('users.index');
    }

    public function create()
    {
        // Logika untuk menampilkan form create user
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan data user baru
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        // Logika untuk menampilkan detail user
        return view('users.show');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit user
        return view('users.edit');
    }

    public function update(Request $request, $id)
    {
        // Logika untuk mengupdate data user
        return redirect()->route('users.show', $id);
    }

    public function destroy($id)
    {
        // Logika untuk menghapus user
        return redirect()->route('users.index');
    }
}
