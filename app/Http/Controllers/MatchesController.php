<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    public function index()
    {
        $Matches = Matches::all();
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

    public function show(Matches $Matches)
    {
        return view('matches.show', compact('match'));
    }

    public function edit(Matches $Matches)
    {
        return view('matches.edit', compact('match'));
    }

    public function update(Request $request, Matches $Matches)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $Matches->update($validated);
        return redirect()->route('matches.index')->with('success', 'Match updated successfully.');
    }

    public function destroy(Matches $Matches)
    {
        $Matches->delete();
        return redirect()->route('matches.index')->with('success', 'Match deleted successfully.');
    }
        public function schedule()
    {
        $matches = Matches::orderBy('match_date', 'asc')->get();
        return view('schedule', compact('matches'));
    }
}
