<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'airport_id',
        'supplier_id',
        'service_id',
        'reference',
        'status',
        'name',
        'email',
        'phone',
        'departure',
        'arrival',
        'departure_terminal_id',
        'arrival_terminal_id',
        'departure_flight_number',
        'arrival_flight_number',
        'registration_number',
        'make',
        'model',
        'color',
        'passengers',
        'amount',
        'supplier_cost',
    ];

    protected $casts = [
        'status' => BookingStatus::class,
        'departure' => 'datetime',
        'arrival' => 'datetime',
        'amount' => 'float',
        'supplier_cost' => 'float',
    ];

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function departureTerminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'departure_terminal_id');
    }

    public function arrivalTerminal(): BelongsTo
    {
        return $this->belongsTo(Terminal::class, 'arrival_terminal_id');
    }
}
