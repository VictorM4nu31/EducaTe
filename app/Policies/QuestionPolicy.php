<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    /**
     * Determine whether the user can modify the question.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->id === $question->exam->created_by;
    }

    /**
     * Determine whether the user can delete the question.
     */
    public function delete(User $user, Question $question): bool
    {
        return $user->id === $question->exam->created_by;
    }
}
