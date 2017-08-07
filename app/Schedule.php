<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function employee()
    {
        return $this->belongsToMany('YYJobs\Employee');
    }

    public function employer()
    {
        return $this->belongsToMany('YYJobs\Employer');
    }



}
