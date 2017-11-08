<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RecipientGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_name'];

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
            ->when(!empty($param['employer']), function ($query) use ($param) {

                return $query->whereIn('jobs.employer', $param['employer']);
            })
            ->distinct()
            ->where('users.role_id', 2)
            ->get();

        return $employee;

    }


}
