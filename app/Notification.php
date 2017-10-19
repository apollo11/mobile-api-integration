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

    public function notificationByUser($userId)
    {
        $notif = DB::table('user_notifications')
            ->select(
                  'id'
                , 'title'
                , 'message'
                , 'type'
                , 'job_id'
                , 'created_at'
                , 'updated_at'
            )
            ->where('user_id', '=', $userId)

            ->get();

        return $notif;
    }

    public function deviceTokenList($userId)
    {
        $token = DB::table('user_push_notification_tokens')
            ->select('device_token')
            ->where('user_id', '=', $userId)
            ->get();

        return $token;
    }

}
