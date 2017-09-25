<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalInfo extends Model
{
    protected $fillable = [
        'name'
        , 'gender'
        , 'birthdate'
        , 'religion'
        , 'address'
        , 'email'
        , 'contact_no'
        , 'school'
        , 'school_pass_expiry_date'
        , 'front_ic_path'
        , 'back_ic_path'
        , 'emergency_name'
        , 'emergency_contact_no'
        , 'emergency_relationship'
        , 'emergency_address'
        , 'contact_method'
        , 'criminal_record'
        , 'medication'
    ];

    /**
     * The table associated with the model
     */
    protected $table = 'additional_infos';

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

}
