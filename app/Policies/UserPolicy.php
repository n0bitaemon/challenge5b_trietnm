<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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

    public function access(User $user){
        return $user->is_teacher;
    }

    public function add(User $user){
        return $user->is_teacher;
    }

    public function update(User $userSession, User $userUpdate){
        if($userUpdate->is_teacher){
            return $userSession->id === $userUpdate->id;
        }

        return $userSession->is_teacher || $userSession->id === $userUpdate->id;
    }

    public function delete(User $userSession, User $userDelete){
        return $userSession->is_teacher && !$userDelete->is_teacher && $userSession->id !== $userDelete->id;
    }

    public function ignorePassword(User $userSession, User $userUpdate){
        return $userSession->is_teacher && !$userUpdate->is_teacher;
    }
}
