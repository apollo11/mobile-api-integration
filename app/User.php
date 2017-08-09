<?php

namespace App;

use Laravel\Passport\HasApiTokens;
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

    public function employeeProfile()
    {
        return $this->hasOne('YYJobs\Employee');
    }


    public function employerProfile()
    {
        return $this->hasOne('YYJobs\Employer');
    }
}
