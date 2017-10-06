<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    protected $fillable = [
        'name'
        , 'gender'
        , 'birthdate'
        , 'religion'
        , 'address'
        , 'email'
        , 'contact_no'
        , 'school'
        , 'school_pass_expiry_date'
        , 'front_ic_path'
        , 'back_ic_path'
        , 'emergency_name'
        , 'emergency_contact_no'
        , 'emergency_relationship'
        , 'emergency_address'
        , 'contact_method'
        , 'criminal_record'
        , 'medication'
        , 'is_uploaded'
        , 'language'
        , 'signature_file_path'
        , 'bank_statement'
    ];

    /**
     * The table associated with the model
     */
    protected $table = 'additional_infos';

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function userInfo($id)
    {
        $additionalInfo = DB::table('users')
            ->leftJoin('additional_infos as info', 'info.user_id', '=', 'users.id')
            ->select(
                'users.id'
                , 'users.name as userName'
                , 'users.email as userEmail'
                , 'users.mobile_no as userMobile'
                , 'users.nric_no'
                , 'users.school as userSchool'
                , 'users.date_of_birth'
                , 'users.contact_no'
                , 'users.created_at'
                , 'users.updated_at'
                , 'users.employee_status'
                , 'users.social_google_id'
                , 'users.social_fb_id'
                , 'users.profile_image_path as profile_photo'
                , 'info.id as profile_id'
                , 'info.gender'
                , 'info.birthdate'
                , 'info.religion'
                , 'info.address'
                , 'info.email'
                , 'info.school'
                , 'info.school_pass_expiry_date'
                , 'info.front_ic_path'
                , 'info.back_ic_path'
                , 'info.emergency_name'
                , 'info.emergency_contact_no'
                , 'info.emergency_relationship'
                , 'info.emergency_address'
                , 'info.contact_method'
                , 'info.criminal_record'
                , 'info.medication'
                , 'info.language'
                , 'info.bank_statement'
                , 'info.is_uploaded'
            )
            ->where('users.id', '=', $id)
            ->first();

        return $additionalInfo;

    }

    public function countPendingJobs($userid)
    {
        $count = DB::table('users')
            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->where('users.id', '=',  $userid)
            ->where('job_schedules.job_status', '=', 'accepted')
            ->count();

        return $count;
    }

    public function isUserExist($id)
    {
        $profileExist = DB::table('additional_infos as info')
            ->where('info.user_id', '=', $id)
            ->first();

        return $profileExist;

    }

    public function countCompletedJobs($userid)
    {
        $count = DB::table('users')
            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->where('users.id', '=',  $userid)
            ->where('job_schedules.job_status', '=', 'completed')
            ->count();

        return $count;
    }

    public function countEarnedJobs($userid)
    {
        $count = DB::table('users')
            ->join('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->join('jobs', 'jobs.id', '=', 'job_schedules.job_id')
           ->where('job_schedules.job_status', '=', 'completed')
            ->where('job_schedules.payment_status', '=', 'Completed')
            ->where('users.id', '=', $userid)
            ->sum('jobs.rate');

        return $count;
    }

}
