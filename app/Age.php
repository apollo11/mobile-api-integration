<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
class Age extends Model
{
    /**
     * The attribues are mass assignable
     */

    protected $fillable = ['max_age','min_age', 'name'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ages';

    public function getAgeByJob($jobid){
        return DB::table('ages')
        ->select('name')
        ->where('job_id','=',$jobid)->get();
    }
}
