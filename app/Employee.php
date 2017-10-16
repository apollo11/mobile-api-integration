<?php
namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function user()
    {
        return $this->belongsTo('YYJobs\User');
    }

    public function schedule()
    {
        return $this->hasMany('YYJobs\Schedule');
    }

    public function employeeLists()
    {
        $employee = DB::table('users')
//            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
//            ->leftJoin('job_schedules', function ($join) use ($userId) {
//                $join->on('job_schedules.job_id', '=', 'jobs.id')
//                    ->where('job_schedules.user_id', '=', $userId);
//            })

            ->select(
                  'users.id'
                , 'users.name'
                , 'users.nric_no'
                , 'users.mobile_no'
                , 'users.date_of_birth'
                , 'users.employee_status'
                , 'users.business_manager'
                , 'users.employee_status as status'
                , 'created_at as joined'
                , 'updated_at as updated'
            )
            ->where('users.role_id', '=', 2)
            ->orderBy('users.id', 'asc')
            ->distinct()
            ->get();

        return $employee;

    }






}
