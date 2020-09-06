<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OrdersMongo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'user_requests';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
