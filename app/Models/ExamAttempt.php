<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    protected $fillable = [
        'exam_id',
        'user_id',
        'hints_used',
        'grade',
        'final_grade',
        'answers',
        'metadata',
        'started_at',
        'submitted_at',
        'is_completed',
        'is_annulled',
        'ac_earned',
    ];

    protected $casts = [
        'hints_used' => 'integer',
        'grade' => 'decimal:2',
        'final_grade' => 'decimal:2',
        'ac_earned' => 'decimal:2',
        'answers' => 'array',
        'metadata' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'is_completed' => 'boolean',
        'is_annulled' => 'boolean',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
