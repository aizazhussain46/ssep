<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiaryreferralform extends Model
{
    protected $guarded = [];

    protected $with = [
        'user:id,name,email,role_id,cnic,mobile_no,department_id,district_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
