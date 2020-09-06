<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SubSeller extends Authenticatable
{ 
    protected $fillable = [
        'seller_id','name','email','password','failed_try'
    ];
    protected $hidden = [
        'password'
      ];
    public $timestamps = true;
}

