<x-app-layout>
    <div class="py-12 mt-16 p-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">My Tickets</h2>

                    @if ($tickets->isEmpty())
                        <p class="text-gray-600">You haven't purchased any tickets yet.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($tickets as $ticket)
                                <div
                                    class="border rounded-lg overflow-hidden bg-white shadow-md hover:shadow-lg transition">
                                    <div class="bg-green-600 text-white px-4 py-2">
                                        <h3 class="text-lg font-semibold">{{ $ticket->match->home_team }} vs
                                            {{ $ticket->match->away_team }}</h3>
                                        <p class="text-sm opacity-90 capitalize">
                                            {{ $ticket->ticketType->type ?? 'Standard' }}</p>
                                    </div>
                                    <div class="p-4">
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Date & Time</p>
                                            <p class="font-medium">
                                                {{ $ticket->match->match_date->format('F j, Y g:i A') }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Stadium</p>
                                            <p class="font-medium">{{ $ticket->match->stadium }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Ticket Number</p>
                                            <p class="font-medium">{{ $ticket->ticket_number }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Status</p>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $ticket->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </div>
                                        <div class="flex justify-center space-x-4">
                                            <a href="{{ route('tickets.download', $ticket) }}"
                                                class="flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                E-Ticket
                                            </a>
                                            <a href="{{ route('tickets.download-pdf', $ticket) }}"
                                                class="flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
