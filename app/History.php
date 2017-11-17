<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    public function getCompletedCancelledJobs(array $param)
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
                , 'employer.id as employer_id'
                , 'employer.rate as employer_rate'
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
                , 'jobs.job_requirements'
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'

            )
            ->when(!empty($param['industries']), function ($query) use ($param) {

                return $query->whereIn('jobs.industry_id', $param['industries']);
            })
            ->when(!empty($param['locations']), function ($query) use ($param) {

                return $query->whereIn('jobs.location_id', $param['locations']);
            })
            ->when(!empty($param['date_from']) && !empty($param['date_to']), function ($query) use ($param) {

                return $query->whereBetween('jobs.job_date', [$param['date_from'], $param['date_to']]);
            })
            ->when(!empty($param['payment_statuses']) && empty($param['job_statuses']), function ($query) use ($param) {
                // If payment_statuses has value, return null. Job with payment statuses must be in the earned job list.
                return $query->whereIn('job_schedules.job_status', []);
            })
            ->when(empty($param['payment_statuses']) && empty($param['job_statuses']), function ($query) use ($param) {

                return $query->whereIn('job_schedules.job_status', ['cancelled', 'completed', 'auto_completed', 'auto_cancelled', 'rejected']);
            })
            ->when(!empty($param['job_statuses']), function ($query) use ($param) {

                return $query->whereIn('job_schedules.job_status', $param['job_statuses']);
            })
            ->when(!empty($param['start']) && !empty($param['created']), function ($query) use ($param) {

                return $query->whereRaw("CASE WHEN jobs.job_date = '" . $param['start'] .
                    "' THEN jobs.created_at < '" . $param['created'] .
                    "' ELSE jobs.job_date <= '" . $param['start'] . "' END");
            })
            ->when(!empty($param['id']), function ($query) use ($param) {

                $query->where('users.id', '=', $param['id']);
            })
            ->whereNull('job_schedules.payment_status')
            ->limit($param['limit'])
            ->orderBy('jobs.job_date', 'desc')
            ->orderBy('jobs.created_at', 'desc')
            ->get();

        return $jobs;
    }

    public function getEarnedJobs(array $param)
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
                , 'employer.id as employer_id'
                , 'employer.rate as employer_rate'
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
                , 'jobs.job_requirements'
                , 'jobs.geolocation_address'
                , 'jobs.latitude'
                , 'jobs.longitude'
            )
            ->when(!empty($param['industries']), function ($query) use ($param) {

                return $query->whereIn('jobs.industry_id', $param['industries']);
            })
            ->when(!empty($param['locations']), function ($query) use ($param) {

                return $query->whereIn('jobs.location_id', $param['locations']);
            })
            ->when(!empty($param['date_from']) && !empty($param['date_to']), function ($query) use ($param) {

                return $query->whereBetween('jobs.job_date', [$param['date_from'], $param['date_to']]);
            })
            ->when(!empty($param['job_statuses']) && empty($param['payment_statuses']), function ($query) use ($param) {
                // If job_statuses has value, return null. Job with job statuses must be in the completed job list.
                return $query->whereIn('job_schedules.payment_status', []);
            })
            ->when(empty($param['payment_statuses']) && empty($param['job_statuses']), function ($query) use ($param) {

                return $query->whereIn('job_schedules.payment_status', ['pending', 'processed']);
            })
            ->when(!empty($param['payment_statuses']), function ($query) use ($param) {

                return $query->whereIn('job_schedules.payment_status', $param['payment_statuses']);
            })
            ->when(!empty($param['start']) && !empty($param['created']), function ($query) use ($param) {

                return $query->whereRaw("CASE WHEN jobs.job_date = '" . $param['start'] .
                    "' THEN jobs.created_at < '" . $param['created'] .
                    "' ELSE jobs.job_date <= '" . $param['start'] . "' END");
            })
            ->when(!empty($param['id']), function ($query) use ($param) {

                $query->where('users.id', '=', $param['id']);
            })
            ->where('job_schedules.job_status', '=', 'approved')
            ->limit($param['limit'])
            ->orderBy('jobs.job_date', 'desc')
            ->orderBy('jobs.created_at', 'desc')
            ->get();

        return $jobs;
    }

    /**
     * Implementation of job schedule via user
     */
    public function getHistoryDetails($id, $columName)
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
                , 'employer.id as employer_id'
                , 'employer.rate as employer_rate'
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
                , 'jobs.job_requirements'
                , 'jobs.geolocation_address'
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'

            )
            ->where($columName, '=', $id)
            ->first();

        return $jobs;
    }

    public function countCompletedJobs($userid)
    {
        $count = DB::table('users')
            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->where('users.id', '=', $userid)
            ->whereIn('job_schedules.job_status', ['cancelled', 'completed', 'auto_completed', 'auto_cancelled', 'rejected'])
            ->whereNull('job_schedules.payment_status')
            ->count();

        return $count;
    }


    public function countEarnedJobs($userid)
    {
        $count = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->where('job_schedules.job_status', '=', 'approved')
            ->where('users.id', '=', $userid)
            ->sum('jobs.rate');

        return $count;
    }

}
