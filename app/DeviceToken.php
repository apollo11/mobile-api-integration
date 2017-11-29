<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = [
        'device_token'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_push_notification_tokens';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    /**
     * List of device token from users
     */
    public function listDeviceToken()
    {
        $deviceToken = DB::table('user_push_notification_tokens')
            ->select('id','device_token')
            ->get();

        return $deviceToken;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getDeviceTokenByUserId($userId)
    {
        $token = DB::table('user_push_notification_tokens')
            ->select('id', 'device_token', 'user_id')
            ->where('user_id', $userId)
            ->get();

        return $token;
    }

}
