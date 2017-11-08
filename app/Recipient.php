<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_name', 'email'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recipient_groups';


}
