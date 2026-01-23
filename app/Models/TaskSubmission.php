<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'file_path',
        'file_name',
        'notes',
        'status',
        'grade',
        'feedback',
        'is_early',
        'is_late',
        'ac_earned',
        'is_excellent',
        'submitted_at',
        'graded_at',
    ];

    protected $casts = [
        'grade' => 'decimal:2',
        'ac_earned' => 'decimal:2',
        'is_early' => 'boolean',
        'is_late' => 'boolean',
        'is_excellent' => 'boolean',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
