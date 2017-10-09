<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    /**
     * Implementation of job schedule via user
     */
    public function getCheckInJob(array $param)
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->join('users as employer', 'employer.id', '=', 'jobs.user_id')
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.is_assigned'
                , 'job_schedules.job_status as schedule_status'
                , 'job_schedules.payment_status'
                , 'job_schedules.checkin_datetime'
                , 'job_schedules.checkin_location'
                , 'job_schedules.checkout_datetime'
                , 'job_schedules.checkout_location'
                , 'job_schedules.working_hours'
                , 'job_schedules.job_salary'
                , 'job_schedules.process_date'
                , 'job_schedules.payment_methods'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.employee_status as status'
                , 'jobs.description as job_description'
                , 'jobs.location'
                , 'jobs.job_title'
                , 'jobs.location_id'
                , 'jobs.industry'
                , 'jobs.industry_id'
                , 'jobs.job_date as start_date'
                , 'jobs.created_at'
                , 'jobs.end_date'
                , 'jobs.contact_no'
                , 'jobs.rate'
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
                ,'jobs.job_requirements'
            )

            ->where('job_schedules.user_id', '=', $param['id'])
            ->where('job_schedules.job_status', '=', 'accepted')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereNotNull('job_schedules.checkin_datetime');
                    $query->whereNull('job_schedules.checkout_datetime');

                });

                $query->orWhere(function ($query) {
                    $query->whereNull('job_schedules.checkin_datetime');
                    //$query->whereRaw("jobs.job_date BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY ) AND NOW()");
                    $query->whereRaw("TIMEDIFF(NOW(), jobs.job_date) < '24:00:00'");
                });

            })
            ->orderBy('jobs.job_date', 'asc')
            ->orderBy('jobs.created_at', 'asc')
            ->first();

        return $jobs;
    }

}
