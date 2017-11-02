<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $table = 'users';

    public function getEmployeeDetails($id)
    {
        $details = DB::table('users')
            ->select(
                'id'
                , 'name'
                , 'email'
                , 'mobile_no'
                , 'nric_no'
                , 'school'
                , 'date_of_birth'
                , 'contact_no'
                ,'employee_status'
                , 'created_at'
                , 'updated_at'
                 )
            ->where('users.id','=', $id)
            ->first();

        return $details;
    }

    public function countPendingJobs($userid)
    {
        $count = DB::table('users')
            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->where('users.id', '=',  $userid)
           ->where('job_schedules.job_status', '=', 'accepted')
            ->where(function ($query) {
                // Job must have no check in time
                $query->whereNull('job_schedules.checkin_datetime');
                // Checking in is allow as long as the the job's end date has not ended yet
                $query->where('jobs.end_date', '>', Carbon::now());
            })
            ->count();

        return $count;
    }

}
