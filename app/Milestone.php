<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'milestone_title', 'description', 'duration', 'status_id', 'created_by', 'job_id'
    ];
}
