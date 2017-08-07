<?php

namespace YYJobs;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function user()
    {
        return $this->belongsTo('YYJobs\User');
    }

    public function schedule()
    {
        return $this->hasMany('YYJobs\Schedule');
    }
}
