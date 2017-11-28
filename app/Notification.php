<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
          'type'
        , 'title'
        , 'message'
        , 'job_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_notifications';

    /**
     * Belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function notificationByUser($userId, array $param)
    {
        $notif = DB::table('user_notifications as notif')
            ->leftJoin('jobs', 'jobs.id', '=', 'notif.job_id')
            ->leftJoin('job_schedules', function ($join) use ($userId) {
                            $join->on('job_schedules.job_id', '=', 'jobs.id')
                           ->where('job_schedules.user_id', '=', $userId);
                    })
            ->leftJoin('assign_job_job as assign', function ($join) use ($userId) {
                $join->on('assign.job_id', '=', 'jobs.id')
                    ->where('assign.user_id', '=', $userId);
            })
            ->join('users as employer', 'employer.id', '=', 'jobs.user_id')
            ->select(
                  'notif.id'
                , 'notif.title'
                , 'notif.message'
                , 'notif.type'
                , 'notif.job_id'
                , 'notif.created_at'
                , 'notif.updated_at'
                , 'jobs.id as jobid'
                , 'jobs.description as job_description'
                , 'jobs.job_status'
                , 'jobs.location'
                , 'jobs.job_title'
                , 'jobs.location_id'
                , 'jobs.industry'
                , 'jobs.industry_id'
                , 'jobs.job_date as start_date'
                , 'jobs.created_at'
                , 'jobs.end_date'
                , 'jobs.contact_no'
                , 'jobs.contact_person'
                , 'jobs.rate'
                , 'jobs.job_image_path'
                , 'jobs.nationality'
                , 'jobs.choices as gender'
                , 'jobs.description'
                , 'jobs.min_age'
                , 'jobs.max_age'
                , 'jobs.role'
                , 'jobs.notes'
                , 'jobs.language'
                , 'jobs.choices'
                , 'jobs.job_requirements'
                , 'jobs.latitude'
                , 'jobs.longitude'
                , 'jobs.geolocation_address'
                , 'job_schedules.id as schedule_id'
                , 'job_schedules.user_id'
                , 'job_schedules.job_id'
                , 'job_schedules.is_assigned'
                , 'job_schedules.job_status as schedule_status'
                , 'job_schedules.payment_status'
                , 'job_schedules.checkin_datetime'
                , 'job_schedules.checkin_location'
                , 'job_schedules.checkout_datetime'
                , 'job_schedules.checkout_location'
                , 'job_schedules.working_hours'
                , 'job_schedules.job_salary'
                , 'job_schedules.process_date'
                , 'job_schedules.payment_methods'
                , 'jobs.contact_person'
                , 'employer.company_description'
                , 'employer.company_name'
                , 'employer.profile_image_path'
                , 'employer.employee_status as status'
                , 'employer.id as employer_id'
                , 'employer.rate as employer_rate'
                , 'assign.is_assigned'
                , 'assign.id as id_assigned'

            )
            ->when(!empty($param['last_notification_id']) , function ($query) use ($param) {

                return $query->where('notif.id', '<', $param['last_notification_id']);
            })
            ->where('notif.user_id', '=', $userId)
            ->orderBy('notif.id', 'DESC')
            ->limit($param['limit'])
            ->get();

        return $notif;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function deviceTokenList($userId)
    {
        $token = DB::table('user_push_notification_tokens')
            ->select('device_token')
            ->where('user_id', '=', $userId)
            ->get();

        return $token;
    }

    /**
     * Count notification list via user
     * @param $userId
     * @return mixed
     */
    public function countNotifByUser($userId)
    {
        $count = DB::table('user_notifications')
            ->where('is_read', false)
            ->where('user_id', $userId)
            ->count();

        return $count;

    }


}
