<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Match Details -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">
                            {{ $match->home_team }} vs {{ $match->away_team }}
                        </h1>
                        
                        <!-- Stadium Image -->
                        @if($match->stadium_image)
                            <div class="w-full h-64 overflow-hidden rounded-lg mb-6">
                                <img src="{{ asset('storage/' . $match->stadium_image) }}" 
                                     alt="{{ $match->stadium }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Match Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <h2 class="text-xl font-semibold mb-4">Match Information</h2>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-gray-600">Stadium:</span>
                                        <span class="font-medium ml-2">{{ $match->stadium }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Date:</span>
                                        <span class="font-medium ml-2">{{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Time:</span>
                                        <span class="font-medium ml-2">{{ \Carbon\Carbon::parse($match->match_date)->format('g:i A') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Available Tickets:</span>
                                        <span class="font-medium ml-2">{{ $match->available_tickets }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Price per Ticket:</span>
                                        <span class="font-medium ml-2">${{ number_format($match->ticket_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Form -->
                            <div>
                                <h2 class="text-xl font-semibold mb-4">Book Tickets</h2>
                                @if($match->available_tickets > 0)
                                    <form action="{{ route('tickets.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="match_id" value="{{ $match->id }}">
                                        
                                        <div class="mb-4">
                                            <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">
                                                Number of Tickets
                                            </label>
                                            <select name="quantity" id="quantity" 
                                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                @for($i = 1; $i <= min(10, $match->available_tickets); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">
                                                Total Price: $<span id="totalPrice">{{ number_format($match->ticket_price, 2) }}</span>
                                            </p>
                                        </div>

                                        <button type="submit" 
                                                class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded hover:bg-green-700 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                                            Book Now
                                        </button>
                                    </form>

                                    @push('scripts')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const ticketPrice = {{ $match->ticket_price }};
                                            const quantitySelect = document.getElementById('quantity');
                                            const totalPriceSpan = document.getElementById('totalPrice');

                                            function updateTotalPrice() {
                                                const quantity = parseInt(quantitySelect.value);
                                                const total = (quantity * ticketPrice).toFixed(2);
                                                totalPriceSpan.textContent = total;
                                            }

                                            quantitySelect.addEventListener('change', updateTotalPrice);
                                            // Initialize total price
                                            updateTotalPrice();
                                        });
                                    </script>
                                    @endpush
                                @else
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    Sorry, this match is sold out!
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
