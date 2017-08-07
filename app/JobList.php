<?php

namespace YYJobs;

use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    public function employerJobList()
    {
        return $this->belongsTo('YYJobs\Employer');

    }
}
