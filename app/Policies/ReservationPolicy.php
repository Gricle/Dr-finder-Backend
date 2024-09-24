<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reservation;

class ReservationPolicy
{
    public function before(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->tourist_id;
    }

    public function create(User $user)
    {
        return !is_null($user->tourist);
    }

    public function update(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->tourist_id;
    }

    public function delete(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->tourist_id;
    }
}