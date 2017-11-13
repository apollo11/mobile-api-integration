<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['settings'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    public function allSettings()
    {
        $settings = DB::table('settings')->first();

        return $settings;
    }

}
