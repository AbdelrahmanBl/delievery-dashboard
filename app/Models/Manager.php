<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $fillable = [
    	'first_name','last_name','email','password','mobile','commision_per'
    	,'company_name','company_register_no','company_register_date'
    ];

    protected $hidden = [
    	'password'
    ];
}
