<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exercise;
use App\Models\ExerciseAnswer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ExercisePolicy
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

    public function answer(User $user, Exercise $exercise){
        $answer = ExerciseAnswer::where([
            ['user_id', '=', $user->id],
            ['exercise_id', '=', $exercise->id]
        ])->first(['is_done']);

        if($answer === null){
            return !$user->is_teacher;
        }else{
            return !$user->is_teacher && !$answer->is_done;
        }
    }

    public function cancleAnswer(User $user, Exercise $exercise){
        $answer = ExerciseAnswer::where([
            ['user_id', '=', $user->id],
            ['exercise_id', '=', $exercise->id]
        ])->first(['is_done']);

        if($answer !== null){
            return $answer->is_done === 1;
        }
        return 0;
    }
}
