<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{
    /**
     * @return mixed
     */
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
            ->whereIn('role', ['business_manager', 'admin'])
            ->orderby('id', 'DESC')
            ->get();

        return $userMgtList;
    }

    /**
     * Multiple delete
     * @param $multiId
     * @return mixed
     */
    public function multiDelete($multiId)
    {
        $delete = DB::table('users')->whereIn('id', $multiId)
            ->delete();

        return $delete;
    }

    public function deleteUserMgt($id)
    {
        $delete = DB::table('users')->where('id', $id)
            ->delete();

        return $delete;

    }

}
