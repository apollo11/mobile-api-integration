<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'day'
        , 'start_time'
        , 'end_time'
    ];

    /**
     * The table associated with the model
     */
    protected $table = 'availabilities';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    /**
     * Print users availability
     */
    public function userAvailability($userId)
    {
        $availability = DB::table('availabilities')
            ->select(
                  'day'
                , 'start_time'
                , 'end_time'
            )
            ->where('user_id', '=', $userId)
            ->get();

        return $availability;
    }

}
