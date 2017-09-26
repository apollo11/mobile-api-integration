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

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

}
