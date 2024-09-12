<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fly extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'airport_id',
        'origin',
        'destination',
        'takeoff_time',
        'land_time',
    ];

    /**
     * Define the relationship with the Airport model.
     */
    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }
}

