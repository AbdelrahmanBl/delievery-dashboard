<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Module extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'modules';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
