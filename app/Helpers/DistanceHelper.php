<?php

namespace App\Helpers;

class DistanceHelper
{
    public static function calculateDistance(float $doctor_lat, float $doctor_lon, float $hotel_lat, float $hotel_lon): float
    {
        $doctor_lat = deg2rad($doctor_lat);
        $doctor_lon = deg2rad($doctor_lon);
        $hotel_lat = deg2rad($hotel_lat);
        $hotel_lon = deg2rad($hotel_lon);

        $earthRadius = 6371;

        $dLat = $hotel_lat - $doctor_lat;
        $dLon = $hotel_lon - $doctor_lon;

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($doctor_lat) * cos($hotel_lat) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}