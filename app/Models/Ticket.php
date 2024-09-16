<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'tourist_id',
        'fly_id',
        'seat_number',
    ];

    public function tourist():BelongsTo
    {
        return $this->belongsTo(Tourist::class);
    }
    
    public function fly():BelongsTo
    {
        return $this->belongsTo(Fly::class);
    }

    public static function isFlyFull($flyID)
    {
        $fly = Fly::findOrFail($flyID);

        if ($fly->taken_seats == $fly->seats)
        {
            return true;
        }else{
            return false;
        }
    }

}
