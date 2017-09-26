<?php

namespace App;

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
    public function userAvailability($id)
    {
        $availability = DB::table('availabilities')
            ->select(
                'id'
                , 'day'
                , 'start_time'
                , 'end_time'
                , 'user_id'
            )
            ->where('user_id', '=', $id)
            ->get();

        return $availability;
    }



}
