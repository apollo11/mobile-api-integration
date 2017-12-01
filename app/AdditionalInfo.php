<?php

namespace App;

use Carbon\Carbon;
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
        , 'nationality'
        , 'points'
        , 'rate'
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
            // ->leftJoin('job_ratings','job_ratings.employee_id','=','users.id')
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
                , 'users.business_manager as agent_name'
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
                , 'info.is_uploaded'
                , 'info.signature_file_path'
                , 'info.nationality'
                , 'info.points as employee_points'
                , 'info.bank_statement as bank_account'
                , 'info.rate'
                , 'info.address'
                // , DB::raw( 'COALESCE( AVG( job_ratings.rating_point ),0) as avg_rating') 
            )
            ->where('users.id', '=', $id)
            // ->groupBy('users.id')
            ->first();
        return $additionalInfo;

    }

    public function countPendingJobs($userid)
    {
        $count = DB::table('users')
            ->leftJoin('job_schedules', 'job_schedules.user_id', '=', 'users.id')
            ->leftJoin('jobs', 'jobs.id', '=', 'job_schedules.job_id')
            ->where('users.id', '=', $userid)
            ->where('job_schedules.job_status', '=', 'accepted')
            ->where(function ($query) {
                // Job must have no check in time
                $query->whereNull('job_schedules.checkin_datetime');
                // Checking in is allow as long as the the job's end date has not ended yet
                $query->where('jobs.end_date', '>', Carbon::now());
            })
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

}
