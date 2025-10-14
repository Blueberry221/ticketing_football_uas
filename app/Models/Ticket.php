<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'match_id',
        'area_id',
        'seat_id',
        'order_id',
        'ticket_number',
        'price',
        'status',
        'qr_code',
        'checked_in_at'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'checked_in_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = $ticket->generateTicketNumber();
            }
            if (empty($ticket->qr_code)) {
                $ticket->qr_code = $ticket->generateQRCode();
            }
        });
    }

    /**
     * Get the match this ticket belongs to
     */
    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    /**
     * Get the area this ticket belongs to
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the seat this ticket belongs to
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Get the order this ticket belongs to
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Generate unique ticket number
     */
    public function generateTicketNumber()
    {
        do {
            $ticketNumber = 'TKT-' . strtoupper(Str::random(8));
        } while (self::where('ticket_number', $ticketNumber)->exists());

        return $ticketNumber;
    }

    /**
     * Generate QR code for ticket
     */
    public function generateQRCode()
    {
        return hash('sha256', $this->ticket_number . $this->match_id . $this->seat_id . now());
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get ticket status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'sold' => 'bg-blue-100 text-blue-800',
            'used' => 'bg-gray-100 text-gray-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get ticket status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'pending' => 'Pending',
            'sold' => 'Terjual',
            'used' => 'Digunakan',
            'cancelled' => 'Dibatalkan',
            'refunded' => 'Dikembalikan',
            default => 'Unknown'
        };
    }

    /**
     * Get seat information
     */
    public function getSeatInfoAttribute()
    {
        if ($this->seat) {
            return $this->area->name . ' - ' . $this->seat->name;
        }
        return $this->area->name;
    }

    /**
     * Get match information
     */
    public function getMatchInfoAttribute()
    {
        return $this->match->title . ' - ' . $this->match->formatted_date;
    }

    /**
     * Check if ticket is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Check if ticket is sold
     */
    public function isSold()
    {
        return $this->status === 'sold';
    }

    /**
     * Check if ticket is used
     */
    public function isUsed()
    {
        return $this->status === 'used';
    }

    /**
     * Check if ticket can be refunded
     */
    public function canBeRefunded()
    {
        if (!$this->isSold()) {
            return false;
        }

        // Check if match is still more than 24 hours away
        $refundDeadline = $this->match->match_date->subHours(24);
        return now() < $refundDeadline;
    }

    /**
     * Check if ticket can be used (checked in)
     */
    public function canBeUsed()
    {
        if (!$this->isSold()) {
            return false;
        }

        // Can be used 2 hours before match and during match
        $checkInStart = $this->match->match_date->subHours(2);
        $checkInEnd = $this->match->match_date->addHours(3);
        
        return now() >= $checkInStart && now() <= $checkInEnd;
    }

    /**
     * Mark ticket as sold
     */
    public function markAsSold($orderId)
    {
        $this->update([
            'status' => 'sold',
            'order_id' => $orderId
        ]);

        // Update seat status
        if ($this->seat) {
            $this->seat->occupy();
        }
    }

    /**
     * Mark ticket as used (check in)
     */
    public function checkIn()
    {
        if ($this->canBeUsed()) {
            $this->update([
                'status' => 'used',
                'checked_in_at' => now()
            ]);
            return true;
        }
        return false;
    }

    /**
     * Cancel ticket
     */
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);

        // Release seat
        if ($this->seat) {
            $this->seat->release();
        }
    }

    /**
     * Refund ticket
     */
    public function refund()
    {
        if ($this->canBeRefunded()) {
            $this->update(['status' => 'refunded']);

            // Release seat
            if ($this->seat) {
                $this->seat->release();
            }
            return true;
        }
        return false;
    }

    /**
     * Reserve ticket temporarily
     */
    public function reserve($orderId = null)
    {
        if ($this->isAvailable()) {
            $this->update([
                'status' => 'pending',
                'order_id' => $orderId
            ]);

            // Reserve seat
            if ($this->seat) {
                $this->seat->reserve();
            }
            return true;
        }
        return false;
    }

    /**
     * Release reservation
     */
    public function releaseReservation()
    {
        if ($this->status === 'pending') {
            $this->update([
                'status' => 'available',
                'order_id' => null
            ]);

            // Release seat
            if ($this->seat) {
                $this->seat->release();
            }
        }
    }

    /**
     * Scope for available tickets
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for sold tickets
     */
    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    /**
     * Scope for pending tickets
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for used tickets
     */
    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    /**
     * Scope for tickets by match
     */
    public function scopeByMatch($query, $matchId)
    {
        return $query->where('match_id', $matchId);
    }

    /**
     * Scope for tickets by area
     */
    public function scopeByArea($query, $areaId)
    {
        return $query->where('area_id', $areaId);
    }

    /**
     * Scope for tickets by price range
     */
    public function scopeByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Get QR code URL for display
     */
    public function getQrCodeUrlAttribute()
    {
        // In a real implementation, this would generate a QR code image
        return "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($this->qr_code);
    }

    /**
     * Get ticket validation data
     */
    public function getValidationDataAttribute()
    {
        return [
            'ticket_number' => $this->ticket_number,
            'match_id' => $this->match_id,
            'seat_info' => $this->seat_info,
            'match_info' => $this->match_info,
            'qr_code' => $this->qr_code,
            'status' => $this->status
        ];
    }

    /**
     * Validate QR code
     */
    public static function validateQRCode($qrCode)
    {
        return self::where('qr_code', $qrCode)->first();
    }

    /**
     * Get ticket PDF data
     */
    public function getPdfData()
    {
        return [
            'ticket_number' => $this->ticket_number,
            'match' => $this->match,
            'area' => $this->area,
            'seat' => $this->seat,
            'price' => $this->formatted_price,
            'qr_code' => $this->qr_code_url,
            'order' => $this->order
        ];
    }
}