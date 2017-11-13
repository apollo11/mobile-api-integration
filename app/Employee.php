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

    public function employeeLists(array $param)
    {
        $employee = DB::table('users')
            ->leftJoin('additional_infos', 'additional_infos.user_id', '=', 'users.id')
            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->select(
                  'users.id'
                , 'users.name'
                , 'users.nric_no'
                , 'users.mobile_no'
                , 'users.employee_status'
                , 'users.business_manager'
                , 'users.employee_status as status'
                , 'users.employee_points'
                , 'additional_infos.gender'
                , 'additional_infos.birthdate'
                , 'users.created_at as joined'
                , 'users.updated_at as updated'
            )
            ->when(!empty($param['checkin']), function ($query) use ($param) {

                return $query->whereNotNull('job_schedules.checkin_datetime');
            })
            ->when(!empty($param['checkout']), function ($query) use ($param) {

                return $query->whereNotNull('job_schedules.checkout_datetime');
            })
            ->when(!empty($param['job_status']), function ($query) use ($param) {

                return $query->where('job_schedules.job_status', $param['job_status']);
            })
            ->where('users.role_id', '=', 2)
            ->orderBy('users.id', 'asc')
            ->distinct()
            ->get();

        return $employee;

    }

    public function updateInfo($data)
    {
        $employee = DB::table('users')
            ->leftJoin('additional_infos', 'additional_infos.user_id', '=', 'users.id')
            ->where('users.id', '=', $data['id']);

        return $employee;

    }

}
