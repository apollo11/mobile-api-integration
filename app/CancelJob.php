<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CancelJob extends Model
{
    /**
     * Update users point when cancelled
     */
    public function cancelJob($userId, $deduction)
    {
        DB::table('user')
            ->where('id', $userId)->decrement('employee_points', 25);

    }

    /**
     * public function detectJob
     */
    /**
     * Filter by limit, start date, end date
     */
    public function jobValidateDate($jobId)
    {
        $jobs = DB::table('jobs')
            ->join('job_schedules', 'job_schedules.job_id', '=', 'jobs.id')
            ->select(
                'jobs.id'
                , 'jobs.user_id'
                , 'jobs.job_date as start_date'
                , 'jobs.created_at'
                , 'jobs.end_date'
            )
            ->where('job_schedules.id', $jobId)
            ->first();

        return $jobs;
    }

}
