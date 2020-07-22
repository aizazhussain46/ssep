<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passon extends Model
{
    protected $fillable = [
        'passed_by', 'passed_to', 'job_id'
    ];
}
