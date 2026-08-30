<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'difficulty',
        'ac_reward',
        'due_date',
        'created_by',
        'is_active',
        'instructions',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    /**
     * Clases a las que está asignada la tarea.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'task_group_assignments')->withTimestamps();
    }

    /**
     * Estudiantes a los que se les asigna la tarea de forma individual.
     */
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_user_assignments')->withTimestamps();
    }

    /**
     * ¿La tarea está asignada a una clase concreta?
     */
    public function isAssignedToGroup(Group $group): bool
    {
        return $this->groups()->whereKey($group->id)->exists();
    }

    /**
     * ¿La tarea está asignada de forma individual a un estudiante?
     */
    public function isAssignedToUser(User $user): bool
    {
        return $this->assignedUsers()->whereKey($user->id)->exists();
    }

    /**
     * ¿La tarea está disponible para un estudiante (por clase o de forma directa)?
     */
    public function isAvailableTo(User $user): bool
    {
        foreach ($user->groups as $group) {
            if ($this->isAssignedToGroup($group)) {
                return true;
            }
        }

        return $this->isAssignedToUser($user);
    }
}
