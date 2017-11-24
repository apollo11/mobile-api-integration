<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{

    protected $table = 'employers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('YYJobs\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobList()
    {
        return $this->hasMany('YYJobs\JobList');
    }

    /**
     * @return mixed
     */
    public function employerList()
    {
        $employer = DB::table('users as employer')
            ->leftJoin('employers as role', 'employer.id', '=', 'role.user_id')
            ->select(
                'employer.id'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path as company_logo'
                , 'employer.contact_person'
                , 'employer.contact_no'
                , 'employer.email'
                , 'employer.status as status'
                , 'employer.business_manager'
                , 'role.name'
            )
            ->where('employer.role_id', '=', 1)
            ->whereNull('employer.platform')
            ->get();

        return $employer;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function employerDetails($id)
    {
        $details = DB::table('users as employer')
            ->select(
                'employer.id'
                ,'employer.email'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.status'
                , 'employer.business_manager'
                , 'employer.contact_person'
                , 'employer.contact_no'
                , 'employer.rate'
            )
            ->where('employer.id', '=', $id)
            ->first();

        return $details;
    }

    /**
     * Multiple Update
     */
    public function multiUpdateApprove($multiId)
    {
        $user = DB::table('users')->wherein('id', $multiId)
            ->update(['status' => '1' ]);

        return $user;
    }

    /**
     * Multiple Update
     */
    public function multiUpdateReject($multiId)
    {
        $user = DB::table('users')->wherein('id', $multiId)
            ->update(['status' => '3' ]);

        return $user;
    }

    /**
     * Multiple delete
     */
    public function multiDelete($multiId)
    {
        $user = db::table('users')->whereIn('id', $multiId)
            ->delete();

        return $user;
    }

    /**
     * Count Job Posting by Employer
     */
    public function postedJobCounts($userId)
    {
        $count = DB::table('users as employer')
            ->join('jobs', 'jobs.user_id', '=','employer.id')
            ->where('employer.role_id', '=', 1)
            ->where('jobs.user_id', $userId)
            ->count();

        return $count;

    }

    /**
     * Count who applied for the job
     */
    public function candidates($userId)
    {
        $candid = DB::table('users as candid')
            ->join('job_schedules','job_schedules.user_id', '=', 'candid.id')
            ->join('users as employer', 'employer.id', '=', 'job_schedules.user_id')
            ->where('employer.role_id', '=', 2)
            ->where('job_schedules.job_status', '=', 'accepted')
            ->where('employer.id','=', $userId)
            ->count();

        return $candid;
    }

    /**
     * Related jobs
     */
    public function relatedJobs($userId)
    {

        $jobs = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->select(
                'jobs.id'
                , 'jobs.user_id'
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.employee_status as status'
                , 'users.employee_points'
                , 'users.business_manager'
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
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'

            )
            ->where('users.id', '=', $userId)
            ->where('users.role_id', '=', 1)
            ->orderBy('jobs.id', 'asc')
            ->get();

        return $jobs;
    }


    public function userByMobile()
    {
        $jobs = DB::table('users')
            ->select(
                'users.id'
                ,'users.name'
                , 'users.mobile_no'
                , 'users.business_name'
                , 'users.platform'
                , 'users.email'
            )
            ->whereIn('users.platform',['ios', 'android'])
            ->where('users.role_id', '=', 1)
            ->get();

        return $jobs;
    }

    public function countRegMobile()
    {
        $jobs = DB::table('users')
            ->select(
                'users.id'
                ,'users.name'
                , 'users.mobile_no'
                , 'users.business_name'
            )
            ->whereIn('users.platform',['ios', 'android'])
            ->where('users.role_id', '=', 1)
            ->count();

        return $jobs;
    }

    public function getEmployersList($id)
    {
        $employer = DB::table('employers')
            ->select('name')
            ->where('user_id', $id)
            ->get();

        return $employer;
    }




}
