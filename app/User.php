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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employeeProfile()
    {
        return $this->hasOne('YYJobs\Employee');
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
