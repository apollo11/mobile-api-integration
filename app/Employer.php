<?php

namespace App;

use Illuminate\Support\Facades\DB;
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

    public function employerList()
    {
        $jobDetails = DB::table('users as employer')
            ->leftJoin('jobs', 'jobs.user_id', '=', 'employer.id')
            ->select(
                'jobs.id'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.employee_status as status'
                , 'employer.business_manager'
                , 'jobs.description as job_description'
                , 'jobs.job_title'
                , 'jobs.location'
                , 'jobs.industry'
                , 'jobs.rate'
            )
            ->where('employer.role_id', '=', 1)
            ->get();

        return $jobDetails;
    }

    /**
     * Multiple Update
     */

    public function multiUpdateApprove($multiId)
    {
        $user = DB::table('users')->wherein('id', $multiId)
            ->update(['status' => '1' ]);

        return $user;
    }

    /**
     * Multiple Update
     */

    public function multiUpdateReject($multiId)
    {
        $user = DB::table('users')->wherein('id', $multiId)
            ->update(['status' => '3' ]);

        return $user;
    }

    /**
     * Multiple delete
     */
    public function multiDelete($multiId)
    {
        $user = db::table('users')->whereIn('id', $multiId)
            ->delete();

        return $user;
    }



}
