<?php

namespace App\Http\Controllers;

use App\Models\Seats;
use Illuminate\Http\Request;

class SeatsController extends Controller
{
    public function index()
    {
        $seats = Seats::all();
        return view('seats.index', compact('seats'));
    }

    public function create()
    {
        return view('seats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'status' => 'required|string|max:255',
        ]);

        Seats::create($validated);
        return redirect()->route('seats.index')->with('success', 'Seat created successfully.');
    }

    public function show(Seats $seat)
    {
        return view('seats.show', compact('seat'));
    }

    public function edit(Seats $seat)
    {
        return view('seats.edit', compact('seat'));
    }

    public function update(Request $request, Seats $seat)
    {
        $validated = $request->validate([
            'area_id' => 'required|exists:areas,id',
            'status' => 'required|string|max:255',
        ]);

        $seat->update($validated);
        return redirect()->route('seats.index')->with('success', 'Seat updated successfully.');
    }

    public function destroy(Seats $seat)
    {
        $seat->delete();
        return redirect()->route('seats.index')->with('success', 'Seat deleted successfully.');
    }
}