<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Match Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .ticket {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #22c55e;
            border-radius: 8px;
            overflow: hidden;
        }
        .ticket-header {
            background-color: #22c55e;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .ticket-body {
            padding: 20px;
        }
        .match-details {
            margin-bottom: 20px;
        }
        .ticket-info {
            margin-bottom: 20px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
        h2 {
            color: #22c55e;
            font-size: 20px;
            margin-top: 0;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h1>FootballTix Match Ticket</h1>
        </div>
        
        <div class="ticket-body">
            <div class="match-details">
                <h2>Match Details</h2>
                <div class="detail-row">
                    <span class="label">Teams:</span>
                    <span>{{ $ticket->match->home_team }} vs {{ $ticket->match->away_team }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Date & Time:</span>
                    <span>{{ $ticket->match->match_date->format('F j, Y g:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Stadium:</span>
                    <span>{{ $ticket->match->stadium }}</span>
                </div>
            </div>

            <div class="ticket-info">
                <h2>Ticket Information</h2>
                <div class="detail-row">
                    <span class="label">Ticket Type:</span>
                    <span>{{ $ticket->ticketType->name ?? 'Standard' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Ticket Number:</span>
                    <span>{{ $ticket->ticket_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Holder Name:</span>
                    <span>{{ $ticket->user->name }}</span>
                </div>
            </div>

            <div class="footer">
                <p>This is an official ticket from FootballTix. Please present this ticket at the stadium entrance.</p>
                <p>For any inquiries, please contact support@footballtix.com</p>
            </div>
        </div>
    </div>
</body>
</html>
