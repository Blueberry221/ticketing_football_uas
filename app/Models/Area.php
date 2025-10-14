<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'capacity',
        'price_per_seat',
        'status',
        'description'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'price_per_seat' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get all seats in this area
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    /**
     * Get all tickets for this area
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get available seats
     */
    public function availableSeats()
    {
        return $this->seats()->where('status', 'available');
    }

    /**
     * Get occupied seats
     */
    public function occupiedSeats()
    {
        return $this->seats()->where('status', 'occupied');
    }

    /**
     * Get area statistics
     */
    public function getStatsAttribute()
    {
        $totalSeats = $this->seats()->count();
        $availableSeats = $this->availableSeats()->count();
        $occupiedSeats = $this->occupiedSeats()->count();
        $ticketsSold = $this->tickets()->where('status', 'sold')->count();
        $revenue = $this->tickets()
            ->whereHas('order', function($query) {
                $query->where('status', 'paid');
            })
            ->sum('price');

        return [
            'total_seats' => $totalSeats,
            'available_seats' => $availableSeats,
            'occupied_seats' => $occupiedSeats,
            'tickets_sold' => $ticketsSold,
            'revenue' => $revenue,
            'occupancy_rate' => $totalSeats > 0 ? round(($occupiedSeats / $totalSeats) * 100, 2) : 0
        ];
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_seat, 0, ',', '.');
    }

    /**
     * Get category badge color
     */
    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'Regular' => 'bg-blue-100 text-blue-800',
            'Premium' => 'bg-purple-100 text-purple-800',
            'VIP' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Check if area can be deleted
     */
    public function canBeDeleted()
    {
        return $this->tickets()->where('status', 'sold')->count() === 0;
    }

    /**
     * Check if area can be edited
     */
    public function canBeEdited()
    {
        return $this->tickets()->where('status', 'sold')->count() === 0;
    }

    /**
     * Scope for active areas
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for areas by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for areas by price range
     */
    public function scopeByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price_per_seat', [$minPrice, $maxPrice]);
    }

    /**
     * Generate seats for this area
     */
    public function generateSeats($rows, $seatsPerRow, $rowPrefix = 'R')
    {
        // Delete existing seats if any
        $this->seats()->delete();

        $seats = [];
        
        for ($row = 1; $row <= $rows; $row++) {
            for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                $seats[] = [
                    'area_id' => $this->id,
                    'row_number' => $rowPrefix . $row,
                    'seat_number' => $seat,
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($seats)) {
            Seat::insert($seats);
            
            // Update area capacity
            $this->update(['capacity' => count($seats)]);
        }
    }

    /**
     * Get seat map for visualization
     */
    public function getSeatMap()
    {
        $seats = $this->seats()->orderBy('row_number')->orderBy('seat_number')->get();
        $seatMap = [];

        foreach ($seats as $seat) {
            $seatMap[$seat->row_number][$seat->seat_number] = [
                'id' => $seat->id,
                'status' => $seat->status,
                'row' => $seat->row_number,
                'seat' => $seat->seat_number
            ];
        }

        return $seatMap;
    }

    /**
     * Get available tickets for a specific match
     */
    public function getAvailableTicketsForMatch($matchId)
    {
        return $this->tickets()
            ->where('match_id', $matchId)
            ->where('status', 'available')
            ->with('seat')
            ->get();
    }

    /**
     * Get revenue for a specific match
     */
    public function getRevenueForMatch($matchId)
    {
        return $this->tickets()
            ->where('match_id', $matchId)
            ->whereHas('order', function($query) {
                $query->where('status', 'paid');
            })
            ->sum('price');
    }

    /**
     * Toggle area status
     */
    public function toggleStatus()
    {
        $this->update([
            'status' => $this->status === 'active' ? 'inactive' : 'active'
        ]);
    }

    /**
     * Get total revenue for this area
     */
    public function getTotalRevenueAttribute()
    {
        return $this->tickets()
            ->whereHas('order', function($query) {
                $query->where('status', 'paid');
            })
            ->sum('price');
    }

    /**
     * Get total tickets sold for this area
     */
    public function getTotalTicketsSoldAttribute()
    {
        return $this->tickets()->where('status', 'sold')->count();
    }
}