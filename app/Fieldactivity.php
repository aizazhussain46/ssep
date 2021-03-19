<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fieldactivity extends Model
{
    protected $guarded = [];


    protected $with = [
        'user:id,name,email,role_id,cnic,mobile_no,department_id,district_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getImagesAttribute($value)
    {
        return $this->attributes['images'] = json_decode($value);
    }

    public function setImagesAttribute($value)
    {
        return $this->attributes['images'] = json_encode($value);
    }

    public function getAttendanceSheetAttribute($value)
    {
        return $this->attributes['attendance_sheet'] = json_decode($value);
    }

    public function setAttendanceSheetAttribute($value)
    {
        return $this->attributes['attendance_sheet'] = json_encode($value);
    }
}
