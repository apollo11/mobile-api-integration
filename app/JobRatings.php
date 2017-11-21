<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class JobRatings extends Model
{
    //
       /**
     * The table associated with the model
     */
    protected $table = 'job_ratings';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function getUserAvgRatings($user_id){
        $avg_ratings = DB::table('job_ratings')
                ->where('employee_id', $user_id)
                ->avg('rating_point');
        return $avg_ratings;
    }
}
