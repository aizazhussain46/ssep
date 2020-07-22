<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'task_title', 'nature_of_task', 'brief', 'deliverables', 'from', 'to', 'district_id', 
        'status_id', 'created_by', 'dept_id', 'attachment'
    ];

    protected $casts = [
        'deliverables' => 'array',
        'from' => 'datetime:Y-m-d',
        'to' => 'datetime:Y-m-d',
    ];
}
