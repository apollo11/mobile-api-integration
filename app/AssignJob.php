<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AssignJob extends Model
{
    protected $table = 'assign_job_job';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function userForAssignJob()
    {
        $assign =  DB::table('users')
            ->select(
                 'id'
                , 'name'
            )
            ->get();

        return $assign;

    }



}
