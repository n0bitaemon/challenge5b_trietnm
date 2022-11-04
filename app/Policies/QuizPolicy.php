<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class QuizPolicy
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

    public function answer(User $user, Quiz $quiz){
        return !$user->is_teacher && !QuizAnswer::where([
            ['quiz_id', '=', $quiz->id],
            ['user_id', '=', $user->id]
            ])->exists();
    }

    public function seeAnswer(User $user, Quiz $quiz){
        //Return true when user is teacher
        if($user->is_teacher === 1){
            return 1;
        }

        //Return true when user is student and his answer exists
        return QuizAnswer::where([
            ['quiz_id', '=', $quiz->id],
            ['user_id', '=', $user->id]
            ])->exists();
    }

    public function seeGift(User $user, Quiz $quiz){
        //Return true when user is teacher
        if($user->is_teacher === 1){
            return 1;
        }

        //Return true when user is student and his answer is correct
        $answer = QuizAnswer::where([
            ['quiz_id', '=', $quiz->id],
            ['user_id', '=', $user->id]
            ])->first();
        return $answer !== null ? $answer->answer === $quiz->getFileName(true) : 0;
    }
}
