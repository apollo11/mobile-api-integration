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
        'age'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * List of users for homepage
     */

    public function jobLists($limit)
    {
        $jobLists = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $jobLists;

    }

    /**
     * Filtered jobs by industry
     * @return mixed
     */
    public function filterJobsByIndustry(array $id, $limit)
    {
        $value = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereIn('industry_id', $id)
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $value;
    }

    /**
     * Filtered jobs by location
     */
    public function filterJobsByLocation(array $id, $limit)
    {
        $value = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereIn('location_id', $id)
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $value;
    }

    /**
     * Filtered by date
     */
    public function filterByDate($date, $limit)
    {
        $value = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereDate('job_date', date($date))
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        return $value;
    }

    /**
     * Filter by location, date and jobs
     */
    public function multipleFilter($location, $industry, $date, $limit)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereDate('job_date', date($date))
            ->whereIn('industry_id', $industry)
            ->whereIn('location_id', $location)
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $jobs;
    }

    /**
     * Filter by location and industry
     */

    public function filterbyLocationAndIndustry($location, $industry, $limit)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereIn('industry_id', $industry)
            ->whereIn('location_id', $location)
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $jobs;
    }


    /**
     * Filter by industry and date
     */
    public function filterByLocationDate($location, $date, $limit)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'created_at'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereIn('location_id', $location)
            ->whereDate('job_date', $date)
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $jobs;

    }

    /**
     * Filter by indutry and date
     */
    public function filterByIndustryDate($industry, $date, $limit)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'created_at'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->whereIn('industry_id', $industry)
            ->whereDate('job_date', date($date))
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $jobs;
    }

    /**
     * Filter by limit, start date, end date
     */
    public function filterByLimitStartEnd($limit = 20, array $param)
    {

        $jobs = DB::table('jobs')
            ->select('id'
                , 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'created_at'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age')
            ->when(!empty($param['industries']), function($query) use ($param) {

                return $query->whereIn('industry_id', $param['industries']);
            })
            ->when(!empty($param['locations']), function($query) use ($param) {

                return $query->whereIn('location_id', $param['locations']);
            })
            ->when(!empty($param['date_from']) && !empty($param['date_to']) , function($query) use ($param) {

                return $query->whereBetween('job_date', [$param['date_from'], $param['date_to']]);
            })
            ->when(!empty($param['start']) && !empty($param['created']), function($query) use ($param) {

                return  $query->whereRaw("CASE WHEN job_date = '" . $param['start'].
                    "' THEN created_at < '" . $param['created'] .
                    "' ELSE job_date <= '" . $param['start'] . "' END");

            })
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return $jobs;
    }


    /**
     * Job Details
     */
    public function jobDetails($id)
    {
        $jobDetails = DB::table('jobs')
            ->select('id'
                , 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'created_at'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path'
                , 'nationality'
                , 'choices as gender'
                , 'age'
            )
            ->where('id', '=', $id)
            ->get();

        return $jobDetails;
    }

}
