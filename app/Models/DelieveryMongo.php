<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class DelieveryMongo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'user_delieveries';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
