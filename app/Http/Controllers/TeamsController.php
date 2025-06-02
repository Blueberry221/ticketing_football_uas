<?php

namespace App\Http\Controllers;

use App\Models\Teams;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function index()
    {
        $teams = Teams::all();
        return view('teams.index', compact('teams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        Teams::create($validated);
        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    public function show(Teams $team)
    {
        return view('teams.show', compact('team'));
    }

    public function edit(Teams $team)
    {
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Teams $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $team->update($validated);
        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Teams $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }
}