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
        'job_id'
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

    public function jobLists()
    {
        $jobLists =  DB::table('jobs')
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
                , 'job_image_path')
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
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
                , 'job_image_path')
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
                , 'job_image_path')
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
                , 'job_image_path')
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
    public function multipleFilter($location,$industry, $date,$limit)
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
                , 'job_image_path')
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
                , 'job_image_path')
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
    public function filterByLocationDate($location, $date)
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
                , 'job_image_path')
            ->whereIn('location_id', $location)
            ->whereDate('job_date', date($date))
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $jobs;

    }

    /**
     * Filter by indutry and date
     */
    public function filterByIndustryDate(array $industry, $date)
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
                , 'job_image_path')
            ->whereIn('industry_id', $industry)
            ->whereDate('job_date', date($date))
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $jobs;
    }

    /**
     * Filter by limit, start date, end date
     */
    public function filterByLimitStartEnd($limit, $start, $created)
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
                , 'job_image_path')
            ->where('job_date','<=', date($start))
            ->where('created_at','<=' ,date($created))
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $jobs;
    }

    /**
     * Limit of job lists
     */
    public function limitJobLists($limit)
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
                , 'job_image_path')
            ->limit($limit)
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $jobs;

    }

    /**
     * List of users for homepage
     */

    public function listWithoutLimit()
    {
        $jobLists =  DB::table('jobs')
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
                , 'job_image_path')
            ->orderBy('job_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $jobLists;

    }

}
