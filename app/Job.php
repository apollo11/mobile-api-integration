<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attribues are mass assignable
     */

    protected $fillable = [
        'job_title',
        'description',
        'role',
        'choices',
        'location',
        'job_image_path',
        'no_of_person',
        'contact_person',
        'contact_no',
        'business_manager',
        'employer',
        'language',
        'job_date',
        'rate',
        'notes',
        'status',
        'industry',
        'industry_id',
        'location',
        'location_id',
        'end_date',
        'job_id',
        'nationality',
        'min_age',
        'max_age',
        'job_requirements',
        'employee_status',
        'job_status'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * Relationship with jobs
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany('\App\User')->withTimestamps();
    }

    /**
     * job schedule
     */
    public function jobSchedule()
    {
        return $this->hasMany('\App\JobSchedule');
    }

    /**
     * Filter by limit, start date, end date
     */
    public function filterByLimitStartEnd($limit = 20, array $param)
    {

        $jobs = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->leftJoin('job_schedules','job_schedules.job_id', '=', 'jobs.id')
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id as user_id'
                , 'job_schedules.job_status as schedule_status'
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.employee_status as status'
                , 'jobs.description as job_description'
                , 'jobs.job_status'
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
            ->when(!empty($param['start']) && !empty($param['created']), function ($query) use ($param) {

                return $query->whereRaw("CASE WHEN jobs.job_date = '" . $param['start'] .
                    "' THEN jobs.created_at < '" . $param['created'] .
                    "' ELSE jobs.job_date <= '" . $param['start'] . "' END");

            })
            ->orderBy('jobs.job_date', 'desc')
            ->orderBy('jobs.created_at', 'desc')
            ->limit($limit)
            ->distinct()
            ->get();

        return $jobs;
    }


    /**
     * Get job details with
     * @param $id
     * @return mixed
     */
    public function jobDetails($id, $userId)
    {
        $jobDetails = DB::table('users as employer')
            ->join('jobs', 'jobs.user_id', '=', 'employer.id')
            ->leftJoin('job_schedules', function ($join) use ($userId) {
                $join->on('job_schedules.job_id', '=', 'jobs.id')
                    ->where('job_schedules.user_id', '=', $userId);
            })
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id as user_id'
                , 'job_schedules.job_status as schedule_status'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.employee_status as status'
                , 'jobs.description as job_description'
                , 'jobs.job_title'
                , 'jobs.job_status'
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
                , 'jobs.job_requirements'
            )
            ->where('jobs.id', '=', $id)
            ->first();

        return $jobDetails;
    }

}
