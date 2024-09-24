<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Hotel;

class HotelPolicy
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

    public function view(User $user, Hotel $hotel)
    {
        return $user->id === $hotel->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Hotel $hotel)
    {
        return $user->id === $hotel->user_id;
    }

    public function delete(User $user, Hotel $hotel)
    {
        return $user->id === $hotel->user_id;
    }
}