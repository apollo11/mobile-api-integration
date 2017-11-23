<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AssignJob extends Model
{
    protected $table = 'assign_job_job';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function userForAssignJob()
    {
        $assign =  DB::table('users')
            ->select(
                 'id'
                , 'name'
            )
            ->get();

        return $assign;

    }

    /**
     * @return mixed
     */
    public function assignedJobs()
    {
        $job = DB::table('jobs')
            ->join('users', 'users.id', '=', 'jobs.user_id')
            ->leftJoin('assign_job_job', 'jobs.id', '=', 'assign_job_job.job_id')
            ->select(
                'jobs.id'
                , 'jobs.user_id'
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.employee_status as status'
                , 'users.business_manager'
                , 'users.employee_points'
                , 'jobs.description as job_description'
                , 'jobs.status'
                , 'jobs.location'
                , 'jobs.no_of_person'
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
            )
            ->whereNull('assign_job_job.id')
            ->get();

        return $job;
    }

    public function ifDataExist($userId, $jobId)
    {
        $result = DB::table('assign_job_job')
            ->where('user_id',$userId)
            ->where('assign_job_id', $jobId)
            ->first();

        return $result;

    }



}
