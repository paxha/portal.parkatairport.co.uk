<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'badge',
        'features',
    ];

    public function price(): HasOne
    {
        return $this->hasOne(BrandPrice::class);
    }
}
