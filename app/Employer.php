<?php

namespace YYJobs;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    public function user()
    {
        return $this->belongsTo('YYJobs\User');
    }

    public function jobList()
    {
        return $this->hasMany('YYJobs\JobList');
    }
}
