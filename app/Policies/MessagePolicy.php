<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Message $msg){
        return $user->id === $msg->from_id;
    }

    public function delete(User $user, Message $msg){
        return $user->id === $msg->from_id;
    }
}
