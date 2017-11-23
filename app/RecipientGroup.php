<?php

namespace App;

use Validtor;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RecipientGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_name', 'email'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipient_groups';

    /**
     * Has may relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRecipientGroup()
    {
        return $this->hasMany('\App\UserRecipientGroup');
    }

    /**
     * Belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    /**
     * Agent Name List
     */
    public function agentList()
    {
        $agent = DB::table('users')
            ->select('id'
                , 'name'
                , 'company_name'
                , 'business_manager'
            )
            ->where('role', 'business_manager')
            ->get();

        return $agent;
    }

    /**
     * Employer List
     */
    public function employerList()
    {
        $agent = DB::table('users')
            ->select(
                'id'
                , 'name'
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
                , 'jobs.job_title'
            )
            ->when(!empty($param['agent']), function ($query) use ($param) {

                return $query->whereIn('jobs.business_manager', $param['agent']);
            })
            ->when(!empty($param['employer']), function ($query) use ($param) {

                return $query->whereIn('jobs.employer', $param['employer']);
            })
            ->distinct()
            ->where('users.role_id', 2)
            ->get();

        return $employee;

    }

    public function recipientList()
    {
        $employee = DB::table('recipient_groups')
            ->select(
                'id'
                , 'group_name'
                , 'created_at'
                , 'email'
            )
            ->orderBy('id', 'DESC')
            ->get();


        return $employee;
    }


    /**
     * Multiple delete
     * @param $multiId
     * @return mixed
     */
    public function multiDelete($multiId)
    {
        $delete = DB::table('recipient_groups')->whereIn('id', $multiId)
            ->delete();

        return $delete;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteRecipientGroup($id)
    {
        $delete = DB::table('recipient_groups')->where('id', $id)
            ->delete();

        return $delete;
    }

    /**
     * Details for recipient group
     */
    public function groupDetails($id)
    {
        $select = DB::table('recipient_groups')->where('id', $id)
            ->first();

        return $select;
    }



}
