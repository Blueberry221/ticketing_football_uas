<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-16 p-4">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Buy Tickets</h2>
                    
                    <!-- Match Details -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Match Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600">Match Name</p>
                                <p class="font-semibold">{{ $match->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Teams</p>
                                <p class="font-semibold">{{ $match->home_team }} vs {{ $match->away_team }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Stadium</p>
                                <p class="font-semibold">{{ $match->stadium }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Date & Time</p>
                                <p class="font-semibold">{{ $match->match_date->format('D, M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status</p>
                                <p class="font-semibold capitalize">{{ $match->match_status }}</p>
                            </div>
                        </div>

                        @if($match->stadium_image)
                            <div class="mt-4">
                                <img src="{{ url($match->stadium_image) }}" 
                                     alt="{{ $match->stadium }}" 
                                     class="w-154 h-64 object-cover rounded-lg">
                            </div>
                        @endif

                        @if($match->description)
                            <div class="mt-4">
                                <p class="text-gray-600">Description</p>
                                <p class="mt-1">{{ $match->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Booking Form -->
                    <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="match_id" value="{{ $match->id }}">

                        <!-- Ticket Type Selection -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Select Tickets</h3>
                            @foreach($match->ticketTypes as $type)
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div>
                                        <h4 class="font-medium uppercase tracking-wider">{{ $type->type }}</h4>
                                        <p class="text-sm text-gray-600">${{ number_format($type->price, 2) }}</p>
                                        <p class="text-sm text-gray-500">{{ $type->available_tickets }} tickets available</p>
                                    </div>
                                    <div class="w-24">
                                        <select name="quantities[{{ $type->id }}]" 
                                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-md"
                                                onchange="updateTotal()">
                                            @for($i = 0; $i <= min(10, $type->available_tickets); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total Amount -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-lg border-2 border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Total Amount</h3>
                                <p class="text-3xl font-bold text-green-600">$<span id="total-amount">0.00</span></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('matches.index') }}" 
                               class="text-base font-medium text-gray-600 hover:text-gray-900 mr-4">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 
                                           text-white text-base font-medium rounded-lg transition-colors duration-300">
                                Proceed to Payment
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotal() {
            let total = 0;
            const ticketTypes = @json($match->ticketTypes);
            
            ticketTypes.forEach(type => {
                const quantity = parseInt(document.querySelector(`select[name="quantities[${type.id}]"]`).value);
                total += quantity * type.price;
            });
            
            document.getElementById('total-amount').textContent = total.toFixed(2);
        }

        // Initialize total on page load
        document.addEventListener('DOMContentLoaded', updateTotal);
    </script>
</x-app-layout>
