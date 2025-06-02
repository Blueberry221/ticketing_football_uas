<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    public function index()
    {
        $areas = Areas::all();
        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'placement' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        Areas::create($validated);
        return redirect()->route('areas.index')->with('success', 'Area created successfully.');
    }

    public function show(Areas $area)
    {
        return view('areas.show', compact('area'));
    }

    public function edit(Areas $area)
    {
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, Areas $area)
    {
        $validated = $request->validate([
            'placement' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $area->update($validated);
        return redirect()->route('areas.index')->with('success', 'Area updated successfully.');
    }

    public function destroy(Areas $area)
    {
        $area->delete();
        return redirect()->route('areas.index')->with('success', 'Area deleted successfully.');
    }
}