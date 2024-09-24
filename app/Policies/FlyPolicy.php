<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Fly;

class FlyPolicy
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

    public function view(User $user, Fly $fly)
    {
        return $user->airport_id === $fly->airport_id;
    }

    public function create(User $user)
    {
        return !is_null($user->airport);
    }

    public function update(User $user, Fly $fly)
    {
        return $user->airport->id === $fly->airport_id;
    }

    public function delete(User $user, Fly $fly)
    {
        return $user->airport->id === $fly->airport_id;
    }
}