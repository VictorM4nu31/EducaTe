<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamAssignment extends Model
{
    protected $fillable = [
        'exam_id',
        'group_id',
        'user_id',
        'available_from',
        'available_until',
        'time_limit',
    ];

    protected $casts = [
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
