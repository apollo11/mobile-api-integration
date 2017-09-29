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
            ->when(!empty($param['industries']), function ($query) use ($param) {

                return $query->whereIn('jobs.industry_id', $param['industries']);
            })
            ->when(!empty($param['locations']), function ($query) use ($param) {

                return $query->whereIn('jobs.location_id', $param['locations']);
            })
            ->when(!empty($param['start']) && !empty($param['created']), function ($query) use ($param) {

                return $query->whereRaw("CASE WHEN jobs.job_date = '" . $param['start'] .
                    "' THEN jobs.created_at > '" . $param['created'] .
                    "' ELSE jobs.job_date >= '" . $param['start'] . "' END");

            })
            ->when(!empty($param['id']), function ($query) use ($param) {

                $query->where('users.id', '=', $param['id']);
            })
            ->limit($param['limit'])
            ->where('job_schedules.job_status', '=', 'accepted')
            ->orderBy('jobs.job_date', 'asc')
            ->orderBy('jobs.created_at', 'asc')
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
            ->when(!empty($param['industries']), function ($query) use ($param) {

                return $query->whereIn('jobs.industry_id', $param['industries']);
            })
            ->when(!empty($param['locations']), function ($query) use ($param) {

                return $query->whereIn('jobs.location_id', $param['locations']);
            })
            ->when(!empty($param['start']) && !empty($param['created']), function ($query) use ($param) {

                return $query->whereRaw("CASE WHEN jobs.job_date = '" . $param['start'] .
                    "' THEN jobs.created_at > '" . $param['created'] .
                    "' ELSE jobs.job_date >= '" . $param['start'] . "' END");

            })
            ->when(!empty($param['id']), function ($query) use ($param) {

                $query->where('users.id', '=', $param['id']);
            })
            ->limit($param['limit'])
            ->where('job_schedules.job_status', '=', 'accepted')
            ->orderBy('jobs.job_date', 'asc')
            ->orderBy('jobs.created_at', 'asc')
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
            ->where($columName , '=', $id)
            ->first();

        return $jobs;
    }

}
