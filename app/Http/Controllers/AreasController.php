<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan daftar areas
        return view('areas.index');
    }

    public function create()
    {
        // Logika untuk menampilkan form create area
        return view('areas.create');
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan data area baru
        return redirect()->route('areas.index');
    }

    public function show($id)
    {
        // Logika untuk menampilkan detail area
        return view('areas.show');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit area
        return view('areas.edit');
    }

    public function update(Request $request, $id)
    {
        // Logika untuk mengupdate data area
        return redirect()->route('areas.show', $id);
    }

    public function destroy($id)
    {
        // Logika untuk menghapus area
        return redirect()->route('areas.index');
    }
}
