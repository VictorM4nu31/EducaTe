<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskGroupAssignment extends Model
{
    protected $fillable = [
        'task_id',
        'group_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
