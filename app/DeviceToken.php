<?php

namespace App;

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

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

}
