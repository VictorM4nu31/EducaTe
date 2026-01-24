<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    protected $fillable = [
        'teacher_id',
        'name',
        'code',
        'description',
        'subject',
        'grade',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($group) {
            // Generar código único de 8 caracteres si no existe
            if (!$group->code) {
                $group->code = strtoupper(Str::random(8));
            }
        });
    }

    /**
     * El profesor que creó la clase
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Estudiantes en la clase
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'group_user')
            ->withPivot('joined_at')
            ->withTimestamps();
    }

    /**
     * Verificar si un usuario está en la clase
     */
    public function hasStudent(User $user): bool
    {
        return $this->students()->where('user_id', $user->id)->exists();
    }

    /**
     * Agregar estudiante a la clase
     */
    public function addStudent(User $user): void
    {
        if (!$this->hasStudent($user)) {
            $this->students()->attach($user->id, ['joined_at' => now()]);
        }
    }

    /**
     * Remover estudiante de la clase
     */
    public function removeStudent(User $user): void
    {
        $this->students()->detach($user->id);
    }

    /**
     * Obtener el número de estudiantes
     */
    /**
     * Tareas asignadas a la clase
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_assignments')->withTimestamps();
    }

    public function getStudentCountAttribute(): int
    {
        return $this->students()->count();
    }
}
