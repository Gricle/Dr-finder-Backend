<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rating;

class RatingPolicy
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

    public function view(User $user, Rating $rating)
    {
        return $user->id === $rating->tourist_id;
    }

    public function create(User $user)
    {
        return !is_null($user->tourist);
    }

    public function update(User $user, Rating $rating)
    {
        return $user->id === $rating->tourist_id;
    }

    public function delete(User $user, Rating $rating)
    {
        return $user->id === $rating->tourist_id;
    }
}