<?php

namespace BamboleeDigital\EventUserManager\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function view($user, $event)
    {
        return $user->id === $event->user_id;
    }

    public function update($user, $event)
    {
        return $user->id === $event->user_id;
    }

    public function delete($user, $event)
    {
        return $user->id === $event->user_id;
    }
}