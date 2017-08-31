<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['industry'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'industries';

    public function industryLists()
    {
        $industry = DB::table('industries')->select('id', 'name')->get();

        return $industry;
    }

}
