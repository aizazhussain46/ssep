<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'task_title', 
        'nature_of_task', 
        'deliverables', 
        'district_id', 
        'status_id', 
        'created_by',
        'assigned_to',
        'department_id', 
        'attachment',
        '_from',
        '_to'
    ];

    public function created_by_user()
    {
        return $this->belongsTo('App\User','created_by');
    }

    public function assigned_to_user()
    {
        return $this->belongsTo('App\User','assigned_to');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function revisions()
    {
        return $this->hasMany('App\Revision');
    }

    protected $casts = [
//        'deliverables' => 'array',
        // '_from' => 'datetime:d-M-y',
        // '_to' => 'datetime:d-M-y'
    ];
}
