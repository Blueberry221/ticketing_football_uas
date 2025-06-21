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
                                    <div class="bg-gray-900 text-white px-4 py-2">
                                        <h3 class="text-lg font-semibold">
                                            {{ $ticket->match->homeTeam->name }} vs
                                            {{ $ticket->match->awayTeam->name }}</h3>
                                        {{-- <p class="text-sm opacity-90 capitalize">
                                            {{ $ticket->ticketType->type ?? 'Standard' }}</p> --}}
                                    </div>
                                    <div class="p-4">
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Date & Time : </p>
                                            <p class="font-medium">
                                                {{ $ticket->match->match_date->format('F j, Y g:i A') }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Stadium :</p>
                                            <p>Maguwoharjo</p>
                                            <p class="font-medium">{{ $ticket->match->stadium }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Ticket Number : </p>
                                            <p class="font-medium">{{ $ticket->order_id }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600"> Seat Number : </p>
                                            <p class="font-medium">{{ $ticket->seat->number }}</p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Status : </p>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $ticket->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
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