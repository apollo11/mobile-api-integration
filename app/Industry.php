<?php

namespace App;

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

}
