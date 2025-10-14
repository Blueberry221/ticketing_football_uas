<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'area_id',
        'row_number',
        'seat_number',
        'status'
    ];

    protected $casts = [
        'seat_number' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Get the area this seat belongs to
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get all tickets for this seat
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get seat identifier (Row + Seat Number)
     */
    public function getIdentifierAttribute()
    {
        return $this->row_number . '-' . $this->seat_number;
    }

    /**
     * Get formatted seat name
     */
    public function getNameAttribute()
    {
        return 'Row ' . $this->row_number . ', Seat ' . $this->seat_number;
    }

    /**
     * Get seat status color for UI
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'bg-green-500 hover:bg-green-600',
            'occupied' => 'bg-red-500',
            'reserved' => 'bg-yellow-500',
            'maintenance' => 'bg-gray-500',
            default => 'bg-gray-300'
        };
    }

    /**
     * Get seat status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'reserved' => 'Direservasi',
            'maintenance' => 'Maintenance',
            default => 'Unknown'
        };
    }

    /**
     * Check if seat is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Check if seat is occupied
     */
    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    /**
     * Check if seat is reserved
     */
    public function isReserved()
    {
        return $this->status === 'reserved';
    }

    /**
     * Reserve the seat
     */
    public function reserve()
    {
        if ($this->isAvailable()) {
            $this->update(['status' => 'reserved']);
            return true;
        }
        return false;
    }

    /**
     * Occupy the seat
     */
    public function occupy()
    {
        if ($this->isAvailable() || $this->isReserved()) {
            $this->update(['status' => 'occupied']);
            return true;
        }
        return false;
    }

    /**
     * Release the seat (make it available)
     */
    public function release()
    {
        $this->update(['status' => 'available']);
    }

    /**
     * Set seat to maintenance
     */
    public function setMaintenance()
    {
        $this->update(['status' => 'maintenance']);
    }

    /**
     * Get ticket for a specific match
     */
    public function getTicketForMatch($matchId)
    {
        return $this->tickets()->where('match_id', $matchId)->first();
    }

    /**
     * Check if seat is available for a specific match
     */
    public function isAvailableForMatch($matchId)
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $ticket = $this->getTicketForMatch($matchId);
        return !$ticket || $ticket->status === 'available';
    }

    /**
     * Scope for available seats
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for occupied seats
     */
    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    /**
     * Scope for reserved seats
     */
    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    /**
     * Scope for seats in maintenance
     */
    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    /**
     * Scope for seats by row
     */
    public function scopeByRow($query, $rowNumber)
    {
        return $query->where('row_number', $rowNumber);
    }

    /**
     * Scope for seats by area
     */
    public function scopeByArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    /**
     * Get seat position (for sorting)
     */
    public function getPositionAttribute()
    {
        // Extract numeric part from row_number for sorting
        $rowNum = (int) filter_var($this->row_number, FILTER_SANITIZE_NUMBER_INT);
        return ($rowNum * 1000) + $this->seat_number;
    }

    /**
     * Get seat coordinates for visual representation
     */
    public function getCoordinatesAttribute()
    {
        $rowNum = (int) filter_var($this->row_number, FILTER_SANITIZE_NUMBER_INT);
        return [
            'x' => $this->seat_number,
            'y' => $rowNum
        ];
    }

    /**
     * Get neighboring seats
     */
    public function getNeighbors()
    {
        return self::where('area_id', $this->area_id)
            ->where('row_number', $this->row_number)
            ->where(function($query) {
                $query->where('seat_number', $this->seat_number - 1)
                      ->orWhere('seat_number', $this->seat_number + 1);
            })
            ->get();
    }

    /**
     * Get seats in the same row
     */
    public function getRowSeats()
    {
        return self::where('area_id', $this->area_id)
            ->where('row_number', $this->row_number)
            ->orderBy('seat_number')
            ->get();
    }

    /**
     * Check if seat has good view (front rows)
     */
    public function hasGoodView()
    {
        $rowNum = (int) filter_var($this->row_number, FILTER_SANITIZE_NUMBER_INT);
        return $rowNum <= 10; // First 10 rows considered good view
    }

    /**
     * Get seat price based on area and position
     */
    public function getPrice()
    {
        $basePrice = $this->area->price_per_seat;
        
        // Add premium for good view seats
        if ($this->hasGoodView()) {
            $basePrice *= 1.2; // 20% premium for front rows
        }
        
        return $basePrice;
    }
}