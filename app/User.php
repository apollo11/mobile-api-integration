<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
        , 'email'
        , 'password'
        , 'role_id'
        , 'role'
        , 'platform'
        , 'nric_no'
        , 'business_name'
        , 'school'
        , 'mobile_no'
        , 'status'
        , 'profile_image_path'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    protected $dateFormat = 'U';

    public function job()
    {
       return  $this->hasMany('\App\Job');
    }

    /**
     * job schedule
     */
    public function jobSchedule()
    {
        return $this->hasMany('\App\JobSchedule');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function additionalInfo()
    {
        return $this->hasOne('\App\AdditionalInfo');
    }

    /**
     * Has one relationship availability
     */
    public function availability()
    {
        return $this->hasOne('\App\Availability');
    }

    /**
     * Has many lists
     */
    public function userNotification()
    {
        return $this->hasMany('\App\Notification');
    }

    /**
     * Has many deviceToken
     */
    public function deviceToken()
    {
        return $this->hasMany('\App\DeviceToken');
    }


    /**
     * @param $mobile
     * @return mixed
     */
    public function getUserDetailsByMobileNo($mobile)
    {
        $user = DB::table('users')->select('id', 'email', 'mobile_no', 'password', 'nric_no')
            ->where('mobile_no', $mobile)
            ->get();

        return $user;

    }

    /**
     * @param $nric
     * @return array
     */
    public function getUserDetails($nric)
    {
       $user =  DB::table('users')->where('nric_no', $nric)->first();

       return (array) $user;

    }


}
