<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Rules extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'rules';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
