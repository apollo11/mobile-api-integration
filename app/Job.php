<?php

namespace App;

use Carbon\Carbon;
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
        'business_manager_id',
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
        'job_status',
        'latitude',
        'longitude',
        'geolocation_address',
        'zip_code',
        'recipient_group'
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
     * Assign jobs
     */
    public function assignJobs()
    {
        return $this->belongsToMany('\App\AssignJob')->withPivot('is_assigned', 'assign_job_id', 'user_id');
    }

    /**
     * Filter by limit, start date, end date
     */
    public function filterByLimitStartEnd($limit = 20, array $param)
    {

        $jobs = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->when(!empty($param['user_id']), function ($query) use ($param) {
                return $query->leftJoin('job_schedules', function ($join) use ($param) {
                    $join->on('job_schedules.job_id', '=', 'jobs.id')
                        ->where('job_schedules.user_id', '=', $param['user_id']);
                });
            })
            ->when(!empty($param['user_id']), function ($query) use ($param) {
                return $query->leftJoin('assign_job_job as assign', function ($join) use ($param) {
                    $join->on('assign.job_id', '=', 'jobs.id')
                        ->where('assign.user_id', '=', $param['user_id']);
                });
            })
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id as user_id'
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
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.rate as employer_rate'
                , 'users.employee_status as status'
                , 'users.employee_points'
                , 'users.id as employer_id'
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
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'
                , 'jobs.contact_person'
                , 'assign.is_assigned'
                , 'assign.id as id_assigned'

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
                    "' THEN jobs.created_at > '" . $param['created'] .
                    "' ELSE jobs.job_date >= '" . $param['start'] . "' END");

            })
            ->whereNull('job_schedules.job_status')
            ->where('jobs.job_date', '>=', Carbon::now())
            ->where('jobs.status', '=', 'active')
            ->distinct('jobs.id')
            ->orderBy('jobs.job_date', 'asc')
            ->orderBy('jobs.created_at', 'asc')
            ->limit($limit)
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
            ->leftJoin('assign_job_job as assign', 'assign.job_id', '=', 'jobs.id')
            ->select(
                'jobs.id'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id as user_id'
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
                , 'jobs.job_title'
                , 'jobs.job_status'
                , 'jobs.location'
                , 'jobs.location_id'
                , 'jobs.industry'
                , 'jobs.industry_id'
                , 'jobs.job_date as start_date'
                , 'jobs.created_at'
                , 'jobs.end_date'
                , 'jobs.contact_person'
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
                , 'jobs.business_manager as job_manager'
                , 'jobs.business_manager_id as job_manager_id'
                , 'assign.is_assigned'
                , 'assign.id as id_assigned'
            )
            ->where('jobs.id', '=', $id)
            ->first();

        return $jobDetails;
    }

    /**
     * Filter by limit, start date, end date
     */
    public function jobList(array $param)
    {
        $jobs = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->leftJoin('assign_job_job as assign', 'assign.job_id', '=', 'jobs.id')
            ->select(
                'jobs.id'
                , 'jobs.user_id'
                , 'users.company_description'
                , 'users.company_name'
                , 'users.profile_image_path'
                , 'users.rate as employer_rate'
                , 'users.employee_status as status'
                , 'users.business_manager'
                , 'users.id as employer_id'
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
                , 'assign.is_assigned'
                , 'assign.id as id_assigned'
                , 'jobs.business_manager as job_manager'
                , 'jobs.business_manager_id as job_manager_id'

            )
            ->when(!empty($param['status']), function ($query) use ($param) {
                return $query->where('jobs.status', $param['status']);
            })
            ->when(!empty($param['userid']), function ($query) use ($param) {
                return $query->where('jobs.user_id', $param['userid']);
            })
            ->orderBy('jobs.id', 'DESC')
            ->get();

        return $jobs;
    }

    public function jobAdminDetails($id)
    {
        $jobDetails = DB::table('users as employer')
            ->leftJoin('jobs', 'jobs.user_id', '=', 'employer.id')
            ->leftJoin('assign_job_job as assign', 'assign.job_id', '=', 'jobs.id')
            ->select(
                'jobs.id'
                , 'employer.id as user_id'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.employee_status as status'
                , 'employer.business_manager'
                , 'employer.id as employer_id'
                , 'employer.rate as employer_rate'
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
                , 'jobs.zip_code'
                , 'jobs.business_manager as job_manager'
                , 'jobs.business_manager_id as job_manager_id'
                , 'assign.is_assigned'
                , 'assign.id as id_assigned'
            )
            ->where('jobs.id', '=', $id)
            ->first();

        return $jobDetails;
    }


    /**
     *get Unemployed candidates
     */
    public function getUnemployed()
    {
        $emp = DB::table('users')
            ->where("role_id","=","2")
            ->get();
        return $emp;
    }

    /**
     *Count active jobs
     */
    public function countJobs()
    {
        $job = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->count();

        return $job;
    }

    /**
     * @return mixed
     */
    public function countJobRequest()
    {
        $job = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
     //       ->whereIn('jobs.status', ['draft mode', 'inactive'])
            ->count();

        return $job;
    }


    /**
     * count inactive jobs
     */
    public function countInactiveJobs()
    {
        $job = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->where('jobs.status', 'inactive')
            ->count();

        return $job;
    }

    /**
     * CheckIn count
     */
    public function checkInCount()
    {
        $job = DB::table('users')
            ->join('job_schedules', 'users.id', '=', 'job_schedules.user_id')
            ->whereNotNull('job_schedules.checkin_datetime')
            ->where('users.role_id','=', 2)
            ->count();

        return $job;
    }

    /**
     * CheckIn count
     */
    public function checkOutCount()
    {
        $job = DB::table('users')
            ->join('job_schedules', 'users.id', '=', 'job_schedules.user_id')
            ->whereNotNull('job_schedules.checkout_datetime')
            ->where('users.role_id','=', 2)
            ->count();

        return $job;
    }

    /**
     * Count Approved Job
     */
    public function approvedJob()
    {
        $job = DB::table('users')
            ->join('jobs', 'users.id', '=', 'jobs.user_id')
            ->where('jobs.status', 'active')
            ->count();

        return $job;
    }


    /**
     * @return mixed
     */
    public function unAssignedJobs()
    {
        $job = DB::table('jobs')
            ->leftJoin('assign_job_job', 'jobs.id', '=', 'assign_job_job.job_id')
            ->whereNull('assign_job_job.id')
            ->count();

        return $job;
    }


    /**
     * @return mixed
     */
    public function cancelledJobs()
    {
        $job = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->select('job_schedules.job_status')
            ->where('job_schedules.job_status', '=', 'cancelled')
            ->count();

        return $job;
    }

    /**
     * Registered employers from mobile
     */
    public function registeredEmployersviaMobile()
    {
        $job = DB::table('users')
        ->whereIn('platform',['ios', 'android'])
        ->where('role_id', '=', 1)
        ->count();

        return $job;
    }

    /**
     * Multiple Update
     */

    public function multiUpdateActive($multiId)
    {
        $user = DB::table('jobs')->wherein('id', $multiId)
            ->update(['status' => 'active']);

        return $user;
    }

    /**
     * Multiple Update
     */

    public function multiUpdateInactive($multiId)
    {
        $user = DB::table('jobs')->wherein('id', $multiId)
            ->update(['status' => 'inactive']);

        return $user;
    }

    /**
     * Multiple delete
     */
    public function multiDelete($multiId)
    {
        $user = db::table('jobs')->whereIn('id', $multiId)
            ->delete();

        return $user;
    }

    /**
     * Age Lists
     */
    public function ageList()
    {
        $age = [
            '16-20'
            , '21-30'
            , '41-50'
            , '50'
        ];

        return $age;
    }

    /**
     * list of gender
     */
    public function gender()
    {
        $gender = [
            'male'
            , 'female'
            , 'both'

        ];

        return $gender;
    }

    public function getReportData($startdate,$stopdate,$keyword=''){
        $result = DB::table('jobs')
            ->leftjoin('users','users.id','=','jobs.user_id')
            ->leftJoin('job_schedules', function($join)
             {
                $join->on('job_schedules.job_id', '=', 'jobs.id')
                     ->wherein('job_schedules.job_status', ['completed','approved']);
             })
            ->select(DB::raw("jobs.business_manager,jobs.user_id, sum(jobs.no_of_person) as request,count(jobs.id), date(jobs.job_date) as jobdate, users.company_name as employer_name, count(job_schedules.id) as actual"))
            ->whereBetween(DB::raw("date(jobs.job_date)"),[$startdate->format('Y-m-d'),$stopdate->format('Y-m-d')])
            ->when(!empty($keyword), function ($query) use ($keyword) {
                return $query->where(function($q) use($keyword) {
                          $q->where(DB::raw('lower(jobs.business_manager)'),'LIKE', '%'.strtolower($keyword).'%' )
                            ->orWhere(DB::raw('lower(users.company_name)'),'LIKE', '%'.strtolower($keyword).'%' );
                      });

            })
            ->groupBy('jobs.business_manager')
            ->groupBy('jobs.user_id')
            ->groupBy('jobdate')
            ->orderBy('jobs.business_manager', 'asc')
            ->orderBy('users.company_name', 'asc')
            ->orderBy('jobs.user_id', 'asc')
            // ->orderBy('jobs.job_date', 'asc')
            ->get();

        return $result;
    }
}
