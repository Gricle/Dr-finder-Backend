<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tourist;

class TouristPolicy
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

    public function view(User $user, Tourist $tourist)
    {
        return $user->id === $tourist->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Tourist $tourist)
    {
        return $user->id === $tourist->user_id;
    }

    public function delete(User $user, Tourist $tourist)
    {
        return $user->id === $tourist->user_id;
    }
}