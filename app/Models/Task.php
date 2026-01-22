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
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];
}
