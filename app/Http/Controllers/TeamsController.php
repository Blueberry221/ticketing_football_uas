<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan daftar teams
        return view('teams.index');
    }

    public function create()
    {
        // Logika untuk menampilkan form create team
        return view('teams.create');
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan data team baru
        return redirect()->route('teams.index');
    }

    public function show($id)
    {
        // Logika untuk menampilkan detail team
        return view('teams.show');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit team
        return view('teams.edit');
    }

    public function update(Request $request, $id)
    {
        // Logika untuk mengupdate data team
        return redirect()->route('teams.show', $id);
    }

    public function destroy($id)
    {
        // Logika untuk menghapus team
        return redirect()->route('teams.index');
    }
}
