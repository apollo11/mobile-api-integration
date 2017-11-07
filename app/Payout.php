<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public function payout(array $param)
    {
        $jobs = DB::table('users as employer')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'employer.id')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->leftJoin('users as employee', 'employee.id', '=', 'jobs.user_id')
            ->select(
                 'employer.company_name'
                , 'employee.name'
                , 'job_schedules.job_salary'
                , 'job_schedules.working_hours'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.job_status as schedule_status'
                , 'jobs.job_title'
                , 'jobs.rate'
                , 'jobs.job_date as start_date'
                , 'jobs.job_title'
                , 'employee.nric_no'
                , 'employee.contact_no'
                , 'users.employee_points'
                , 'jobs_schedules.payment_status'
            )
            ->when(!empty($param['pending']), function ($query) use ($param) {

                $query->where('job_schedules.payment_status', $param['pending']);
            })

            ->when(!empty($param['processed']), function ($query) use ($param) {

                $query->where('job_schedules.payment_status', $param['processed']);
            })
            ->where('job_schedules.job_status', 'approved')
            ->get();

        return $jobs;


    }
}
