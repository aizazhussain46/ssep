<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    protected $fillable = ['job_id', 'user_id', 'status_id'];
}
