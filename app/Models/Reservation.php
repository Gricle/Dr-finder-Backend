<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tourist_id',
        'room_id',
        'check_in',
        'check_out',
        'total_price',
    ];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public static function isRoomAvailable($roomId, $checkIn, $checkOut)
    {
        return !self::where('room_id', $roomId)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($query) use ($checkIn, $checkOut) {
                          $query->where('check_in', '<=', $checkIn)
                                ->where('check_out', '>=', $checkOut);
                      });
            })->exists();
    }
    protected function calculateTotalPrice($roomId, $checkIn, $checkOut)
    {
        $room = Room::find($roomId);
        $days = (new \Carbon\Carbon($checkIn))->diffInDays(new \Carbon\Carbon($checkOut));
        return $room->price * $days;
    }
}