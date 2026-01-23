<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'exam_id',
        'question_text',
        'type',
        'points',
        'order',
        'options',
        'correct_answer',
        'explanation',
    ];

    protected $casts = [
        'options' => 'array',
        'points' => 'decimal:2',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
