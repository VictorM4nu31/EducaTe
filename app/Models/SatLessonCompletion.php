<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatLessonCompletion extends Model
{
    protected $fillable = [
        'user_id',
        'sat_lesson_id',
        'score',
        'earned_ac',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(SatLesson::class, 'sat_lesson_id');
    }
}
