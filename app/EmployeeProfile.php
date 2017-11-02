<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $table = 'users';

    public function getEmployeeDetails($id)
    {
        $details = DB::table('users')
            ->select(
                'id'
                , 'name'
                , 'email'
                , 'mobile_no'
                , 'nric_no'
                , 'school'
                , 'date_of_birth'
                , 'contact_no'
                ,'employee_status'
                , 'created_at'
                , 'updated_at'
                 )
            ->where('users.id','=', $id)
            ->first();

        return $details;
    }

}
