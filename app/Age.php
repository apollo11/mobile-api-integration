<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    /**
     * The attribues are mass assignable
     */

    protected $fillable = ['max_age','min_age', 'name'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ages';
}
