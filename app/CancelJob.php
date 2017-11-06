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
            ->select(
//                'jobs.id'
//                , 'employer.id as user_id'
//                , 'employer.company_description'
//                , 'employer.company_name'
//                , 'employer.profile_image_path'
//                , 'employer.employee_status as status'
//                , 'employer.business_manager'
//                , 'employer.id as employer_id'
//                , 'jobs.description as job_description'
//                , 'jobs.job_title'
//                , 'jobs.status'
//                , 'jobs.location'
//                , 'jobs.location_id'
//                , 'jobs.industry'
//                , 'jobs.industry_id'
//                , 'jobs.job_date as start_date'
//                , 'jobs.created_at'
//                , 'jobs.end_date'
//                , 'jobs.contact_no'
//                , 'jobs.rate'
//                , 'jobs.no_of_person'
//                , 'jobs.contact_person'
//                , 'jobs.contact_no'
//                , 'jobs.job_image_path'
//                , 'jobs.nationality'
//                , 'jobs.choices as gender'
//                , 'jobs.description'
//                , 'jobs.min_age'
//                , 'jobs.max_age'
//                , 'jobs.role'
//                , 'jobs.notes'
//                , 'jobs.language'
//                , 'jobs.choices'
//                , 'jobs.job_requirements'
//                , 'jobs.latitude'
                 'job_id'
                , 'cancel_status'
                , 'cancel_file_path'
                , 'cancel_reason'

            )
            ->where('job_schedules.job_id' ,$jobId)
            //->where('job_schedules.user_id', $userId)
            ->first();

        return $cancelledJob;
    }

}
