<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class mainMongo extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'main_categories';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
