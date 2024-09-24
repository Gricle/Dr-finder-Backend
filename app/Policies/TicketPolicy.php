<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
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

    public function view(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->tourist_id;
    }

    public function create(User $user)
    {
        return !is_null($user->tourist);
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->tourist_id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->tourist_id;
    }
}