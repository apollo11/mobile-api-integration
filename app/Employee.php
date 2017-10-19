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
            ->leftJoin('additional_infos', 'additional_infos.user_id', '=', 'users.id')
            ->select(
                  'users.id'
                , 'users.name'
                , 'users.nric_no'
                , 'users.mobile_no'
                , 'users.employee_status'
                , 'users.business_manager'
                , 'users.employee_status as status'
                , 'additional_infos.gender'
                , 'additional_infos.birthdate'
                , 'users.created_at as joined'
                , 'users.updated_at as updated'
            )
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
