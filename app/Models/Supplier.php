<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'airport_id',
        'name',
        'code',
        'email',
        'phone',
        'postal_code',
        'address',
        'commission',
    ];

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'supplier_id', 'id');
    }
}
