<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Fleet extends Authenticatable
{
   use Notifiable;

   protected $guard = 'fleet';

   protected $fillable = [
            'name', 'email', 'password',
   ];

   protected $hidden = [
            'password', 'remember_token',
   ];
}