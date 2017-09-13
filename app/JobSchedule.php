<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class JobSchedule extends Model
{
    protected $fillable = [
        'name'
        , 'job_id'
    ];

    /**
     * The table associated with the model
     */
    protected $table = 'job_schedules';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Implement has many through relationship related to jobs nd users
     */
    public function jobScheduleLists()
    {
        return $this->belongsTo('\App\User');
    }

    /**
     * Implementation of job schedule via user
     */
    public function getJobByUserSchedule(array $param)
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->select(
                'jobs.id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.is_assigned'
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.employee_status as status'
                , 'jobs.description as job_description'
                , 'jobs.location'
                , 'jobs.job_status'
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
                    "' THEN jobs.created_at < '" . $param['created'] .
                    "' ELSE jobs.job_date <= '" . $param['start'] . "' END");

            })
            ->when(!empty($param['id']), function ($query) use ($param) {

                $query->where('users.id', '=', $param['id']);
            })
            ->when(empty($param['limit']), function ($query) use ($param) {

                $query->limit(20);
            })
            ->orderBy('jobs.job_date', 'desc')
            ->orderBy('jobs.created_at', 'desc')
            ->get();

        return $jobs;
    }

    /**
     * Implementation of job schedule via user
     */
    public function getJobScheduleDetails($id)
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->select(
                'jobs.id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.is_assigned'
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.employee_status as status'
                , 'jobs.job_status'
                , 'jobs.description as job_description'
                , 'jobs.location'
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
            ->where('jobs.id', '=', $id)
            ->first();

        return $jobs;
    }


}
