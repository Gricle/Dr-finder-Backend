<?php

namespace App\Policies;

use App\Models\Airport;
use App\Models\User;
use App\Models\Room;

class AirportPolicy
{
    /**
     * Handle all authorization checks before any other methods.
     */
    public function before(User $user)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine if the user can view any rooms.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine if the user can view a specific room.
     */
    public function view(User $user, Airport $airport)
    {
        return $user->airport_id === $airport->user_id;
    }

    /**
     * Determine if the user can create rooms.
     */
    public function create(User $user)
    {
        return !is_null($user->hotel);
    }

    /**
     * Determine if the user can update the room.
     */
    public function update(User $user, Airport $airport)
    {
        return $user->airport_id === $airport->user_id;
    }

    /**
     * Determine if the user can delete the room.
     */
    public function delete(User $user,  Airport $airport)
    {
        return $user->airport_id === $airport->user_id;
    }
}