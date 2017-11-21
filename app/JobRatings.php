<?php

namespace App;

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
}
