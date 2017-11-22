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
        , 'employee_points'
        , 'dashboard_permissions'
        , 'employees_permissions'
        , 'employers_permissions'
        , 'payout_permissions'
        , 'job_permissions'
        , 'reports_permissions'
        , 'push_permissions'
        , 'recipient_permissions'
        , 'settings_permissions'
        , 'employer'
    ];

    protected $casts = [
        'dashboard_permissions' => 'array',
        'employees_permissions' => 'array',
        'employers_permissions' => 'array',
        'payout_permissions' => 'array',
        'job_permissions' => 'array',
        'reports_permissions' => 'array',
        'push_permissions' => 'array',
        'recipient_permissions' => 'array',
        'settings_permissions' => 'array',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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
     * Relationship with Users
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipient()
    {
        return $this->hasMany('\App\RecipientGroup');
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

    /**
     * Multiple Update
     */
    public function multiUpdate($multiId)
    {
        $user = DB::table('users')->wherein('id', $multiId)
        ->update(['employee_status' => 'approved']);

        return $user;
    }

    /**
     * Multiple delete
     */
    public function multiDelete($multiId)
    {
        $user = db::table('users')->whereIn('id', $multiId)
            ->delete();

        return $user;
    }

    /**
     * @return $this
     */
    public function assignJobs()
    {
        return $this->belongsToMany('\App\AssignJob')->withPivot('is_assigned', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_users');
    }

    /**
     * Checks if User has access to $permissions.
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     */
    public function inRole(string $roleSlug)
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    /**
     * Has Many Employer
     */
    public function employer()
    {
        return $this->hasMany('App\Employer');
    }

}
