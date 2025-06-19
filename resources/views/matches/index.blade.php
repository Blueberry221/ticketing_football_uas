<x-app-layout>
    <div class="py-12 mt-16 p-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8">Upcoming Matches</h1>

                    @if($matches->isEmpty())
                        <p class="text-gray-600">No upcoming matches available.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($matches as $match)
                                <x-match-card :match="$match" />
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $matches->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
