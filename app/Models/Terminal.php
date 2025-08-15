<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
     protected $fillable = [
        'airport_id',
        'name'
    ];

    public function airport() 
    {
        return $this->belongsTo(Airport::class);
    }
}
