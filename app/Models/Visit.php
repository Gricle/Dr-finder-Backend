<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tourist_id',
        'doctor_id',
        'visit_date',
        'price'
    ];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public static function isDoctorBusy($doctorID, $visitDate)
    {
        $startTime = $visitDate->copy()->subMinutes(30);
        $endTime = $visitDate->copy()->addMinutes(30);
    
        return self::where('doctor_id', $doctorID)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('visit_date', [$startTime, $endTime]);
            })
            ->exists();
    }

    public static function getVisitPriceById($doctorID)
    {
        $doctor = Doctor::findOrFail($doctorID);

        return $doctor ? $doctor->visit_price : null;
    }
}
