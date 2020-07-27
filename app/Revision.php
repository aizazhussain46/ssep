<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $fillable = [
        'sender_id', 'reciever_id', 'job_id', 'message'
    ];
}
