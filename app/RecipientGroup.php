<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RecipientGroup extends Model
{
    /**
     * Agent Name List
     */
    public function agentList()
    {
        $agent = DB::table('users')
            ->select('id'
                , 'business_manager'
                , 'company_name'
            )
            ->where('role_id', 1)
            ->get();

        return $agent;
    }

    /**
     * Employee List
     */
    public function employeeList($param)
    {
        $employee = DB::table('users')
            ->join('additional_infos as info', 'info.user_id', '=', 'users.id')
            ->join('job_schedules as sched', 'sched.user_id', '=', 'info.user_id')
            ->join('jobs', 'jobs.id', '=', 'sched.job_id')
            ->select(
                'users.id'
                , 'users.name'
                , 'users.mobile_no'
                , 'users.nric_no'
                , 'users.created_at'
                , 'info.nationality'
                , 'info.birthdate'
                , 'info.gender'
                , 'jobs.employer'
                , 'jobs.business_manager'
            )
            ->when(!empty($param['agent']), function ($query) use ($param) {

                return $query->whereIn('jobs.business_manager', $param['agent']);
            })

            ->distinct()
            ->where('users.role_id', 2)
            ->get();

        return $employee;

    }


}
