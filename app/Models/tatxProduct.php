<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class tatxProduct extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'tatx_products';

    protected $fillable = [
    ];
    
    public $timestamps = false;
}

