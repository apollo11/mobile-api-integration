<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CancelJob extends Model
{
    /**
     * Update users point when cancelled
     */
    public function validSched($schedId, $userId)
    {
        $validate = DB::table('job_schedules')
            ->where('job_schedules.id', $schedId)
            ->where('job_schedules.user_id', $userId)
            ->first();

        return $validate;
    }

    /**
     * Deduction of points
     */
    public function deductionsPoints($userId, $subtract)
    {
        $user = DB::table('users')
            ->where('users.id', $userId)
            ->decrement('users.employee_points', $subtract);

        return $user;
    }

    /**
     * Filter by limit, start date, end date
     */
    public function jobValidateDate($jobId)
    {
        $jobs = DB::table('job_schedules')
            ->leftJoin('jobs','jobs.id', '=', 'job_schedules.job_id')
            ->select(
                'job_schedules.id'
                , 'job_schedules.user_id'
                , 'jobs.job_date as start_date'
                , 'job_schedules.job_id'
            )
            ->where('job_schedules.id', $jobId)
            ->first();

        return $jobs;
    }

}
