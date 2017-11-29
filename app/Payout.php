<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    public function payout(array $param)
    {
        $jobs = DB::table('job_schedules')
            ->join('users', 'job_schedules.user_id', '=', 'users.id')
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
                , 'users.rate as user_hourly_rate'
                , 'jobs.job_date as start_date'
                , 'jobs.job_title'
                , 'jobs.geolocation_address'
                , 'users.nric_no'
                , 'users.contact_no'
                , 'users.employee_points'
                , 'employer.company_name as company_name' 
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

    public function payoutDetails($id)
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
                , 'jobs.geolocation_address'
                , 'users.nric_no'
                , 'users.contact_no'
                , 'users.employee_points'
                , 'employer.company_name'
                , 'employer.business_manager'
                , 'job_schedules.payment_status'
            )
            ->where('job_schedules.id', $id)
            ->first();

        return $jobs;

    }

    /**
     * Approve job via user
     *
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function approveJob($id, $userId)
    {
        $approved = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'approved', 'payment_status' => 'pending']);

        return $approved;
    }

    /**
     * Change status to processed
     *
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function processedJob($id, $userId)
    {
        $processed = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'approved', 'payment_status' => 'processed']);

        return $processed;
    }

    /**
     * Multitple update processed
     *
     * @param $id
     * @return mixed
     */
    public function multipleProcessed($id)
    {
        $processed = DB::table('job_schedules')
            ->whereIn('id', $id)
            ->update(['job_status' => 'approved', 'payment_status' => 'processed']);

        return $processed;
    }

    /**
     * Rejecting Job
     *
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function rejectJob($id, $userId)
    {
        $processed = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'rejected']);

        return $processed;
    }

    /**
     * Updating working hours
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateWorkingHours($id, $data)
    {
        $processed = DB::table('job_schedules')
            ->where('id', $id)
            ->update(['working_hours' => $data]);

        return $processed;
    }

    /**
     * accepting Job
     *
     * @param $id
     * @param $userId
     * @return mixed
     */
    public function changeStatustoAccepted($id, $userId)
    {
        $accept = DB::table('job_schedules')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update(['job_status' => 'accepted']);

        return $accept;
    }



}
