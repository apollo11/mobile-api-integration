<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = ['group_name', 'email'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_notifications';

    public function pushNotificationList()
    {
        // $employee = DB::table('recipient_groups')
        //     ->select(
        //         'id'
        //         ,'group_name'
        //         , 'created_at'
        //         , 'email'
        //     )
        //     ->orderBy('id', 'DESC')
        //     ->get();


        $pushnotification[0] = array("id"=>1,"job_id"=>"abc","is_read"=>true, "type"=>"abc", "title"=>"title", "message"=>"message", "user_id"=>"2", "created_at"=>"2018-01-14 12:02:41", "updated_at"=>"2018-01-14 12:02:41");

        return $pushnotification;
    }


    public function getCreatedAtAttribute($value) {
        $phpdate = strtotime( $value );
        return date("m/d/Y", $phpdate);
    }

}
