<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'task_title', 'nature_of_task', 'brief', 'deliverables', 'timelines', 'district_id', 
        'status_id', 'created_by'
    ];
}
