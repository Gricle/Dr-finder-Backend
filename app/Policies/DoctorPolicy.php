<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Doctor;

class DoctorPolicy
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

    public function view(User $user, Doctor $doctor)
    {
        return $user->id === $doctor->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Doctor $doctor)
    {
        return $user->id === $doctor->user_id;
    }

    public function delete(User $user, Doctor $doctor)
    {
        return $user->id === $doctor->user_id;
    }
}