<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Brand extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'brands';

    protected $fillable = [
        
    ];

    public $hidden = [
    	'uniqueID'
    ];
    public $timestamps = false;
}


