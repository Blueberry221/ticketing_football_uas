<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Match extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_date',
        'status',
        'home_score',
        'away_score',
        'description'
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'home_score' => 'integer',
        'away_score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the home team
     */
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Get the away team
     */
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    /**
     * Get all tickets for this match
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get orders for this match through tickets
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Ticket::class);
    }

    /**
     * Get match title (Home vs Away)
     */
    public function getTitleAttribute()
    {
        return $this->homeTeam->name . ' vs ' . $this->awayTeam->name;
    }

    /**
     * Get formatted match date
     */
    public function getFormattedDateAttribute()
    {
        return $this->match_date->format('d M Y, H:i');
    }

    /**
     * Get match result
     */
    public function getResultAttribute()
    {
        if ($this->status !== 'finished' || is_null($this->home_score) || is_null($this->away_score)) {
            return null;
        }

        return $this->home_score . ' - ' . $this->away_score;
    }

    /**
     * Get match winner
     */
    public function getWinnerAttribute()
    {
        if ($this->status !== 'finished' || is_null($this->home_score) || is_null($this->away_score)) {
            return null;
        }

        if ($this->home_score > $this->away_score) {
            return $this->homeTeam;
        } elseif ($this->away_score > $this->home_score) {
            return $this->awayTeam;
        }

        return 'draw';
    }

    /**
     * Get ticket statistics
     */
    public function getTicketStatsAttribute()
    {
        $totalSeats = Area::sum('capacity');
        $ticketsSold = $this->tickets()->where('status', 'sold')->count();
        $pendingTickets = $this->tickets()->where('status', 'pending')->count();
        $availableTickets = $totalSeats - $ticketsSold - $pendingTickets;
        $revenue = $this->tickets()
            ->whereHas('order', function($query) {
                $query->where('status', 'paid');
            })
            ->sum('price');

        return [
            'total_seats' => $totalSeats,
            'tickets_sold' => $ticketsSold,
            'pending_tickets' => $pendingTickets,
            'available_tickets' => $availableTickets,
            'revenue' => $revenue,
            'sold_percentage' => $totalSeats > 0 ? round(($ticketsSold / $totalSeats) * 100, 2) : 0
        ];
    }

    /**
     * Check if match can be deleted
     */
    public function canBeDeleted()
    {
        return $this->tickets()->where('status', 'sold')->count() === 0;
    }

    /**
     * Check if match can be edited
     */
    public function canBeEdited()
    {
        return $this->tickets()->where('status', 'sold')->count() === 0;
    }

    /**
     * Check if match is upcoming
     */
    public function getIsUpcomingAttribute()
    {
        return $this->match_date > now() && $this->status === 'scheduled';
    }

    /**
     * Check if match is ongoing
     */
    public function getIsOngoingAttribute()
    {
        return $this->status === 'ongoing';
    }

    /**
     * Check if match is finished
     */
    public function getIsFinishedAttribute()
    {
        return $this->status === 'finished';
    }

    /**
     * Get time until match starts
     */
    public function getTimeUntilMatchAttribute()
    {
        if ($this->match_date <= now()) {
            return null;
        }

        return $this->match_date->diffForHumans();
    }

    /**
     * Scope for upcoming matches
     */
    public function scopeUpcoming($query)
    {
        return $query->where('match_date', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('match_date');
    }

    /**
     * Scope for finished matches
     */
    public function scopeFinished($query)
    {
        return $query->where('status', 'finished')
                    ->orderBy('match_date', 'desc');
    }

    /**
     * Scope for ongoing matches
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing')
                    ->orderBy('match_date');
    }

    /**
     * Scope for matches by team
     */
    public function scopeByTeam($query, $teamId)
    {
        return $query->where('home_team_id', $teamId)
                    ->orWhere('away_team_id', $teamId);
    }

    /**
     * Scope for matches by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('match_date', [$startDate, $endDate]);
    }

    /**
     * Generate tickets for this match
     */
    public function generateTickets()
    {
        $areas = Area::where('status', 'active')->get();
        $tickets = [];

        foreach ($areas as $area) {
            // Get all seats for this area
            $seats = $area->seats()->where('status', 'available')->get();
            
            foreach ($seats as $seat) {
                $tickets[] = [
                    'match_id' => $this->id,
                    'area_id' => $area->id,
                    'seat_id' => $seat->id,
                    'price' => $area->price_per_seat,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($tickets)) {
            Ticket::insert($tickets);
        }
    }

    /**
     * Start the match
     */
    public function startMatch()
    {
        $this->update([
            'status' => 'ongoing',
            'updated_at' => now()
        ]);
    }

    /**
     * Finish the match
     */
    public function finishMatch($homeScore = null, $awayScore = null)
    {
        $this->update([
            'status' => 'finished',
            'home_score' => $homeScore,
            'away_score' => $awayScore,
            'updated_at' => now()
        ]);
    }
}