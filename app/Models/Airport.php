<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public function terminals() 
    {
        return $this->hasMany(Terminal::class);
    }
}
