<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Room;

class RoomPolicy
{
    /**
     * Handle all authorization checks before any other methods.
     */
    public function before(User $user)
    {
        // If the user is an admin, grant access to all actions
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
    public function view(User $user, Room $room)
    {
        return $user->hotel_id === $room->hotel_id;
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
    public function update(User $user, Room $room)
    {
        return $user->hotel_id === $room->hotel_id;
    }

    /**
     * Determine if the user can delete the room.
     */
    public function delete(User $user, Room $room)
    {
        return $user->hotel->id === $room->hotel_id;
    }
}