<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandPrice extends Model
{
    protected $fillable = [
        'service_id',
        'month',
        'year',
        'day_1',
        'day_2',
        'day_3',
        'day_4',
        'day_5',
        'day_6',
        'day_7',
        'day_8',
        'day_9',
        'day_10',
        'day_11',
        'day_12',
        'day_13',
        'day_14',
        'day_15',
        'day_16',
        'day_17',
        'day_18',
        'day_19',
        'day_20',
        'day_21',
        'day_22',
        'day_23',
        'day_24',
        'day_25',
        'day_26',
        'day_27',
        'day_28',
        'day_29',
        'day_30',
        'after_30',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function day1Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_1');
    }

    public function day2Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_1');
    }

    public function day3Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_3');
    }

    public function day4Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_4');
    }

    public function day5Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_5');
    }

    public function day6Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_6');
    }

    public function day7Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_7');
    }

    public function day8Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_8');
    }

    public function day9Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_9');
    }

    public function day10Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_10');
    }

    public function day11Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_11');
    }

    public function day12Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_12');
    }

    public function day13Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_13');
    }

    public function day14Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_14');
    }

    public function day15Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_15');
    }

    public function day16Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_16');
    }

    public function day17Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_17');
    }

    public function day18Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_18');
    }

    public function day19Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_19');
    }

    public function day20Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_20');
    }

    public function day21Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_21');
    }

    public function day22Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_22');
    }

    public function day23Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_23');
    }

    public function day24Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_24');
    }

    public function day25Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_25');
    }

    public function day26Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_26');
    }

    public function day27Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_27');
    }

    public function day28Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_28');
    }

    public function day29Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_29');
    }

    public function day30Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_30');
    }

    public function day31Brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'day_31');
    }
}
