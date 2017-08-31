<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['location'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

    public function locationLists()
    {
        $location = DB::table('locations')->select('id', 'name')->get();

        return $location;

    }

}
