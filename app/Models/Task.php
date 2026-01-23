<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
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

    public function assignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'task_assignments');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_assignments');
    }
}
