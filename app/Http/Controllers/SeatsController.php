<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeatsController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan daftar seats
        return view('seats.index');
    }

    public function create()
    {
        // Logika untuk menampilkan form create seat
        return view('seats.create');
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan data seat baru
        return redirect()->route('seats.index');
    }

    public function show($id)
    {
        // Logika untuk menampilkan detail seat
        return view('seats.show');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit seat
        return view('seats.edit');
    }

    public function update(Request $request, $id)
    {
        // Logika untuk mengupdate data seat
        return redirect()->route('seats.show', $id);
    }

    public function destroy($id)
    {
        // Logika untuk menghapus seat
        return redirect()->route('seats.index');
    }
}
