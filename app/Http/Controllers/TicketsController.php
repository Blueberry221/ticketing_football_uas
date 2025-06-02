<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Tickets::all();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'match_id' => 'required|exists:matches,id',
            'seat_id' => 'required|exists:seats mettendo,id',
            'status' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'booked_at' => 'required|date',
            'payment_method' => 'required|string|max:255',
        ]);

        Tickets::create($validated);
        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    public function show(Tickets $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Tickets $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Tickets $ticket)
    {
        $validated = $request->validate([
            'match_id' => 'required|exists:matches,id',
            'seat_id' => 'required|exists:seats,id',
            'status' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'booked_at' => 'required|date',
            'payment_method' => 'required|string|max:255',
        ]);

        $ticket->update($validated);
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Tickets $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}