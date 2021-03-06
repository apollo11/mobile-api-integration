<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class JobSchedule extends Model
{
    protected $fillable = [
          'name'
        , 'job_id'
        , 'is_assigned'
        , 'job_status'
        , 'cancel_status'
        , 'cancel_file_path'
        , 'cancel_reason'
        , 'payment_status'
        , 'checkin_datetime'
        , 'checkin_location'
        , 'checkout_datetime'
        , 'checkout_location'
        , 'working_hours'
        , 'job_salary'
        , 'process_date'
        , 'payment_methods'
        , 'applied_date'
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
            ->when(!empty($param['id']), function ($query) use ($param) {
                return $query->leftJoin('assign_job_job as assign', function ($join) use ($param) {
                    $join->on('assign.job_id', '=', 'jobs.id')
                        ->where('assign.user_id', '=', $param['id']);
                });
            })
            ->join('users as employer', 'employer.id', '=', 'jobs.user_id')
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
               // , 'job_schedules.is_assigned'
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
                , 'jobs.contact_person'
                , 'jobs.job_requirements'
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.contact_person'
                , 'jobs.geolocation_address'
                , 'assign.is_assigned'

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
            ->where('job_schedules.job_status', '=', 'accepted')
            ->where(function ($query) {
                // Job must have no check in time
                $query->whereNull('job_schedules.checkin_datetime');
                // Checking in is allow as long as the the job's end date has not ended yet
                $query->where('jobs.end_date', '>', Carbon::now());
            })
            ->orderBy('jobs.job_date', 'asc')
            ->orderBy('jobs.created_at', 'asc')
            ->limit($param['limit'])
            ->get();

        return $jobs;
    }

    /**
     * Implementation of job schedule via user
     */
    public function getJobScheduleDetails($id, $columName)
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->join('users as employer', 'employer.id', '=', 'jobs.user_id')
            ->leftJoin('assign_job_job as assign', 'assign.job_id', '=' ,'jobs.id')
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                //, 'job_schedules.is_assigned'
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
                , 'employer.id as employer_id'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.employee_status as status'
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
                ,'jobs.job_requirements'
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'
                , 'jobs.geolocation_address'
                , 'jobs.contact_person'
                , 'assign.is_assigned'

            )
            ->where($columName , '=', $id)
            ->first();

        return $jobs;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAvailJobsByUser($id,$employer_id='')
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->leftJoin('users as employee', 'employee.id', '=', 'jobs.user_id')
            ->leftJoin('job_ratings', function($join)
                 {
                     $join->on('job_schedules.id', '=', 'job_ratings.job_schedule_id');
                     $join->on('job_schedules.user_id','=','job_ratings.employee_id');
                 })
            ->select(
                  'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.job_status as schedule_status'
                , 'jobs.created_at'
                , 'jobs.job_title'
                , 'jobs.rate'
                , 'jobs.job_date as start_date'
                , 'jobs.id as jobid'
                , 'jobs.contact_person'
                , 'employee.company_name'
                , 'employee.nric_no'
                , 'employee.name'
                , 'employee.contact_no'
                , 'users.employee_points'
                , 'jobs.rate'
                , 'jobs.id'
                , 'jobs.geolocation_address'
                , 'job_ratings.rating_point'
                , 'job_ratings.rating_comment'
            )
            ->where('users.id' , '=', $id)
            ->when(!empty($employer_id), function ($query) use ($employer_id) {
                return $query->where('jobs.user_id', $employer_id);
            })
            ->whereIn('job_schedules.job_status',[
                'accepted'
                , 'cancelled'
                , 'completed'
                , 'rejected'
                , 'auto_complete'
                , 'auto_cancelled'
                , 'pending'
            ])
            ->get();

        return $jobs;
    }

    /**
     * @param $user_id
     * @param $job_id
     * @return mixed
     */
    public function getJobByUser($user_id,$job_id)
    {
        $jobs = DB::table('job_schedules')
        ->join('users','job_schedules.user_id', '=', 'users.id')
        ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
        ->leftJoin('users as employer', 'employer.id', '=', 'jobs.user_id')
        ->leftJoin('job_ratings', function($join)
                 {
                     $join->on('job_schedules.id', '=', 'job_ratings.job_schedule_id');
                     $join->on('job_schedules.user_id','=','job_ratings.employee_id');
                 })
        ->select(
                'job_schedules.job_status as schedule_status'
                , 'job_schedules.checkin_datetime'
                , 'job_schedules.checkout_datetime'
                , 'jobs.job_title'
                , 'jobs.job_date'
                , 'jobs.location'
                , 'jobs.job_date as start_date'
                , 'jobs.id as jobid'
                , 'jobs.contact_person'
                , 'employer.company_name'
                , 'job_ratings.rating_point'
                , 'job_ratings.rating_comment'
            )
        ->where('job_schedules.user_id' , '=', $user_id)
        ->where('job_schedules.id' , '=', $job_id)
        ->whereIn('job_schedules.job_status',[
                'accepted'
                , 'cancelled'
                , 'completed'
                , 'rejected'
                , 'auto_complete'
                , 'auto_cancelled'
                , 'pending'
            ])
            ->first();

        return $jobs;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getRelatedCandidates($id)
    {
        $jobs = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->leftJoin('additional_infos as info', 'info.user_id', '=', 'users.id')
            ->leftJoin('users as employee', 'employee.id', '=', 'jobs.user_id')
            ->select(
                'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.job_status as schedule_status'
                , 'jobs.created_at'
                , 'jobs.job_title'
                , 'jobs.job_date as start_date'
                , 'jobs.id as jobid'
                , 'jobs.geolocation_address'
                , 'jobs.contact_person'
                , 'users.company_name'
                , 'users.nric_no'
                , 'users.name'
                , 'users.contact_no'
                , 'users.mobile_no'
                , 'users.id as userid'
                , 'users.email'
                // , 'additional_infos.rate'
                // , 'jobs.rate as job_rate'
                , 'jobs.id'
                , 'info.gender'
                , 'info.birthdate'
                , 'info.religion'
                , 'info.nationality'
                , 'info.rate'

            )
            ->where('job_schedules.job_id' , '=', $id)
            ->get();

        return $jobs;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function countAppliedJobs($id)
    {
        $count = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->where('users.id' , '=', $id)
            ->whereIn('job_schedules.job_status',[
                'accepted'
            ])
            ->count();

        return $count;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function countCompletedJobs($id)
    {
        $count = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->where('users.id' , '=', $id)
            ->whereIn('job_schedules.job_status',[
                'completed'
            ])
            ->count();

        return $count;

    }

    /**
     * @param $jobId
     * @param $userId
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function schedConflict($userId, $startDate, $endDate)
    {
        $sched = DB::table('job_schedules')
            ->select('job_schedules.job_id as schedId' ,'job_schedules.job_status')
            ->join('users', 'users.id', '=', 'job_schedules.user_id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($query) use ($startDate) {
                    $query->where('jobs.job_date', '<=', $startDate);
                    $query->where('jobs.end_date', '>=', $startDate);
                });
                 $query->orWhere(function ($query) use ($endDate){
                        $query->where('jobs.job_date', '<=', $endDate);
                        $query->where('jobs.end_date', '>=', $endDate);
                });
            })
            ->whereIn('job_schedules.job_status', ['accepted','pending'])
            ->where('job_schedules.user_id', $userId)
            ->first();

        return $sched;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function listofDatebyId($id, $userId)
    {
        $job = DB::table('jobs')
            ->leftJoin('assign_job_job as assign', function ($join) use ($id, $userId) {
                    $join->on('assign.job_id', '=', 'jobs.id')
                        ->where('assign.user_id', '=', $userId);
                })
            ->select('jobs.id', 
                'jobs.job_date', 
                'jobs.end_date', 
                'assign.is_assigned',
                'jobs.choices'
            )
            ->where('jobs.id', $id)
            ->first();

        return $job;

    }

    /**
     * @param $userId
     * @return mixed
     */
    public function userPoints($userId)
    {
        $points = DB::table('users')
           ->leftJoin('additional_infos', 'additional_infos.user_id', '=', 'users.id')
           ->select('users.id', 'additional_infos.points as employee_points')
            ->where('users.id', $userId)
            ->first();

        return $points;
    }


    public function getCandidatesLocation($job_id){
        $results = DB::table('job_schedules')
        ->leftjoin('users','users.id','=','job_schedules.user_id')
        ->select(
                'job_schedules.id',
                'job_schedules.user_id',
                'job_schedules.employee_current_lat',
                'job_schedules.employee_current_long',
                'users.name'
                )
        ->where('job_schedules.job_id',$job_id)
        ->whereIn('job_schedules.job_status', ['accepted','completed','approved'])
        ->get();

        return $results;
    }
}
