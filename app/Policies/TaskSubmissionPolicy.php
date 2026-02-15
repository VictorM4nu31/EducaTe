<?php

namespace App\Policies;

use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskSubmissionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaskSubmission $taskSubmission): bool
    {
        // Teacher can view if they created the task
        return $user->id === $taskSubmission->task->created_by;
    }

    /**
     * Determine whether the user can grade the submission.
     */
    public function grade(User $user, TaskSubmission $taskSubmission): bool
    {
        return $user->id === $taskSubmission->task->created_by;
    }
}
