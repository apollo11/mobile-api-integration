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
        'status'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'job_id');
    }

    /**
     * List of users for homepage
     */

    public function jobLists()
    {
        $joblist = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->orderBy('created_at', 'desc')
            ->orderBy('employer', 'asc')
            ->get();

        return $joblist;
    }

    /**
     * Filtered jobs by industry
     * @return mixed
     */
    public function filterJobsByIndustry(array $id)
    {
        $value = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->whereIn('industry_id', $id)
            ->orderBy('created_at', 'desc')
            ->orderBy('employer', 'asc')
            ->get();

        return $value;
    }

    /**
     * Filtered jobs by location
     */
    public function filterJobsByLocation(array $id)
    {
        $value = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->whereIn('location_id', $id)
            ->orderBy('created_at', 'desc')
            ->orderBy('employer', 'asc')
            ->get();

        return $value;
    }

    /**
     * Filtered by date
     */
    public function filterByDate($date)
    {
        $value = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->where('job_date', '>=', date($date))
            ->orderBy('created_at', 'desc')
            ->orderBy('employer', 'asc')
            ->get();
        return $value;
    }

    /**
     * Filter by location, date and jobs
     */
    public function multipleFilter($location, $industry, $date)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->whereIn('industry_id', $industry)
            ->whereIn('location_id', $location)
            ->where('job_date', '>=', date($date))
            ->orderBy('created_at', 'desc')
            ->get();

        return $jobs;
    }

    /**
     * Filter by location and industry
     */

    public function filterbyLocationAndIndustry($location, $industry)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->whereIn('industry_id', $industry)
            ->whereIn('location_id', $location)
            ->orderBy('created_at', 'desc')
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
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->whereIn('location_id', $location)
            ->where('job_date', '>=', date($date))
            ->orderBy('created_at', 'desc')
            ->orderBy('employer', 'asc')
            ->get();

        return $jobs;

    }

    /**
     * Filter by indutry and date
     */

    public function filterByIndustryDate($industry, $date)
    {
        $jobs = DB::table('jobs')
            ->select('id', 'employer'
                , 'location'
                , 'location_id'
                , 'industry'
                , 'industry_id'
                , 'job_date as start_date'
                , 'end_date'
                , 'contact_no'
                , 'rate'
                , 'job_image_path')
            ->whereIn('industry_id', $industry)
            ->where('job_date', '>=', date($date))
            ->orderBy('created_at', 'desc')
            ->orderBy('employer', 'asc')
            ->get();

        return $jobs;
    }


}
