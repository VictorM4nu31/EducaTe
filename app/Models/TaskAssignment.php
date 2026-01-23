<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    protected $fillable = [
        'task_id',
        'group_id',
        'user_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
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
