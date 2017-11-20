<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{

    public function userMgtList()
    {
        $userMgtList = DB::table('users')
            ->select(
                  'id'
                , 'name'
                , 'role'
                , 'email'
                , 'mobile_no'
                , 'employer'
                , 'dashboard_permissions'
                , 'employees_permissions'
                , 'employers_permissions'
                , 'payout_permissions'
                , 'job_permissions'
                , 'reports_permissions'
                , 'push_permissions'
                , 'recipient_permissions'
                , 'settings_permissions'
            )
            ->whereIn('role', ['business_manager', 'admin', 'Administrator'])
            ->get();

        return $userMgtList;
    }
}
