<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    public function index()
    {
        $matches = Matches::all();
        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        return view('matches.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        Matches::create($validated);
        return redirect()->route('matches.index')->with('success', 'Match created successfully.');
    }

    public function show(Matches $match)
    {
        return view('matches.show', compact('match'));
    }

    public function edit(Matches $match)
    {
        return view('matches.edit', compact('match'));
    }

    public function update(Request $request, Matches $match)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $match->update($validated);
        return redirect()->route('matches.index')->with('success', 'Match updated successfully.');
    }

    public function destroy(Matches $match)
    {
        $match->delete();
        return redirect()->route('matches.index')->with('success', 'Match deleted successfully.');
    }
}