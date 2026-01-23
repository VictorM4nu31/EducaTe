<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title',
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

    public function assignments()
    {
        return $this->hasMany(ExamAssignment::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'exam_assignments');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'exam_assignments');
    }
}
