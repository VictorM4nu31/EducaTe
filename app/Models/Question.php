<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasSlug;

    protected $fillable = [
        'exam_id',
        'question_text',
        'slug',
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

    protected $slugSourceField = 'question_text';

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
