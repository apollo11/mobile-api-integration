<?php
namespace App;

use Illuminate\Support\Facades\DB;
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

    public function employeeLists()
    {
        $employee = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->join('users as employer', 'employer.id', '=', 'jobs.user_id')
            ->select(
                    'users.id'
                , 'users.name'
                , 'users.nric_no'
                , 'users.mobile_no'
                , 'users.date_of_birth'
                , 'users.employee_status'
                , 'employer.business_manager'
                , 'employer.employee_status as status'
            )
            ->where('job_schedules.job_status', '=', 'accepted')
            ->orderBy('users.id', 'asc')
            ->distinct()
            ->get();

        return $employee;

    }






}
