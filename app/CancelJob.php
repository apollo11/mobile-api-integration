<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CancelJob extends Model
{
    /**
     * Update users point when cancelled
     */
    public function validSched($schedId, $userId)
    {
        $validate = DB::table('job_schedules')
            ->where('job_schedules.id', $schedId)
            ->where('job_schedules.user_id', $userId)
            ->first();

        return $validate;
    }

    /**
     * Deduction of points
     */
    public function deductionsPoints($userId, $subtract)
    {
        $user = DB::table('users')
            ->where('users.id', $userId)
            ->decrement('users.employee_points', $subtract);

        return $user;
    }

    /**
     * Filter by limit, start date, end date
     */
    public function jobValidateDate($jobId)
    {
        $jobs = DB::table('job_schedules')
            ->leftJoin('jobs','jobs.id', '=', 'job_schedules.job_id')
            ->select(
                'job_schedules.id'
                , 'job_schedules.user_id'
                , 'jobs.job_date as start_date'
                , 'job_schedules.job_id'
            )
            ->where('job_schedules.id', $jobId)
            ->first();

        return $jobs;
    }

    public function cancelJobDetails($userId, $jobId)
    {
        $cancelledJob = DB::table('job_schedules')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->leftJoin('assign_job_job as assign', function ($join) use ($userId) {
                $join->on('assign.job_id', '=', 'jobs.id')
                    ->where('assign.user_id', '=', $userId);
            })
            ->select(
                'jobs.id'
                , 'jobs.description as job_description'
                , 'jobs.job_title'
                , 'jobs.status'
                , 'jobs.location'
                , 'jobs.location_id'
                , 'jobs.industry'
                , 'jobs.industry_id'
                , 'jobs.job_date as start_date'
                , 'jobs.created_at'
                , 'jobs.end_date'
                , 'jobs.contact_no'
                , 'jobs.rate'
                , 'jobs.no_of_person'
                , 'jobs.contact_person'
                , 'jobs.contact_no'
                , 'jobs.job_image_path'
                , 'jobs.nationality'
                , 'jobs.choices as gender'
                , 'jobs.description'
                , 'jobs.min_age'
                , 'jobs.max_age'
                , 'jobs.role'
                , 'jobs.notes'
                , 'jobs.language'
                , 'jobs.choices'
                , 'jobs.job_requirements'
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'
                , 'job_schedules.job_id'
                , 'job_schedules.cancel_status'
                , 'job_schedules.cancel_file_path'
                , 'job_schedules.cancel_reason'
                , 'jobs.contact_person'
                , 'assign.is_assigned'
                , 'assign.id as id_assigned'

            )
            ->where('job_schedules.job_id' ,$jobId)
            ->where('job_schedules.user_id', $userId)
            ->first();

        return $cancelledJob;
    }

}
