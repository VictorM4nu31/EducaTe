<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'ac_reward_bonus',
        'created_by',
        'is_active',
        'time_limit',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * Clases a las que está asignado el examen.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'exam_group_assignments')
            ->withPivot(['available_from', 'available_until', 'time_limit'])
            ->withTimestamps();
    }

    /**
     * Estudiantes a los que se les asigna el examen de forma individual.
     */
    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'exam_user_assignments')
            ->withPivot(['available_from', 'available_until', 'time_limit'])
            ->withTimestamps();
    }

    /**
     * ¿El examen está asignado a una clase concreta?
     */
    public function isAssignedToGroup(Group $group): bool
    {
        return $this->groups()->whereKey($group->id)->exists();
    }

    /**
     * ¿El examen está asignado de forma individual a un estudiante?
     */
    public function isAssignedToUser(User $user): bool
    {
        return $this->assignedUsers()->whereKey($user->id)->exists();
    }

    /**
     * ¿El examen está disponible para un estudiante (por clase o de forma directa)?
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
