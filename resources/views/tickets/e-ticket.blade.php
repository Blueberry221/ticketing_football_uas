<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $ticket->match->home_team }} vs {{ $ticket->match->away_team }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-green-600 text-white px-6 py-4">
            <h1 class="text-2xl font-bold">Football Match E-Ticket</h1>
            <p class="text-sm opacity-90">{{ $ticket->ticketType->name ?? 'Standard' }}</p>
        </div>

        <!-- Match Details -->
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold mb-4">Match Details</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Teams</p>
                    <p class="font-medium">{{ $ticket->match->home_team }} vs {{ $ticket->match->away_team }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Date & Time</p>
                    <p class="font-medium">{{ $ticket->match->match_date->format('F j, Y g:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Stadium</p>
                    <p class="font-medium">{{ $ticket->match->stadium }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Ticket Number</p>
                    <p class="font-medium">{{ $ticket->ticket_number }}</p>
                </div>
            </div>
        </div>

        <!-- Ticket Info -->
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Important Information</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Please arrive at least 1 hour before kick-off time</li>
                    <li>Present this E-ticket at the stadium entrance</li>
                    <li>This ticket is valid for one-time entry only</li>
                    <li>No refunds or exchanges are permitted</li>
                </ul>
            </div>
            
            <div class="text-sm text-gray-500">
                <p>For any inquiries, please contact support at support@footballtickets.com</p>
            </div>
        </div>
    </div>
</body>
</html>
