<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SubMainFilters extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'sub_main_filters';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
