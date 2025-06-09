<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;

class MatchesController extends Controller
{
    public function index()
    {
        $matches = Matches::all();
        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        // Logika untuk menampilkan form create match
        return view('matches.create');
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan data match baru
        return redirect()->route('matches.index');
    }

    public function show($id)
    {
        $match = Matches::findOrFail($id);
        return view('matches.show', compact('match'));
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit match
        return view('matches.edit');
    }

    public function update(Request $request, $id)
    {
        // Logika untuk mengupdate data match
        return redirect()->route('matches.show', $id);
    }

    public function destroy($id)
    {
        // Logika untuk menghapus match
        return redirect()->route('matches.index');
    }
}
