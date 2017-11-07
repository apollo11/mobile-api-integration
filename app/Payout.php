<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public function payout(array $param)
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->leftJoin('users as employer', 'employer.id', '=', 'jobs.user_id')
            ->select(
                'users.name'
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
                , 'users.nric_no'
                , 'users.contact_no'
                , 'users.employee_points'
                , 'employer.company_name'
                , 'employer.business_manager'
                , 'job_schedules.payment_status'
            )
            ->when(!empty($param['payment_status']), function ($query) use ($param) {

                $query->where('job_schedules.payment_status', $param['payment_status']);
            })

            ->where('job_schedules.job_status', 'approved')
            ->where('users.role_id', 2)
            ->get();

        return $jobs;

    }

    public function approveJob($id, $userId)
    {
        $approved = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'approved', 'payment_status' => 'pending']);

        return $approved;
    }

    public function processedJob($id, $userId)
    {
        $processed = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'approved', 'payment_status' => 'processed']);

        return $processed;
    }

    public function rejectJob($id, $userId)
    {
        $processed = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'rejected']);

        return $processed;
    }


}
