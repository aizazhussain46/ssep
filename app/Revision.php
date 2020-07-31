<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $fillable = [
        's_id', 'r_id', 'job_id', 'msg'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-M-y',
    ];
}
