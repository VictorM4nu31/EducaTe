<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GroupPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Group $group): bool
    {
        return $user->id === $group->teacher_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Group $group): bool
    {
        return $user->id === $group->teacher_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Group $group): bool
    {
        return $user->id === $group->teacher_id;
    }

    /**
     * Determine whether the user can regenerate the code for the group.
     */
    public function regenerateCode(User $user, Group $group): bool
    {
        return $user->id === $group->teacher_id;
    }

    /**
     * Determine whether the user can remove a student from the group.
     */
    public function removeStudent(User $user, Group $group): bool
    {
        return $user->id === $group->teacher_id;
    }
}
