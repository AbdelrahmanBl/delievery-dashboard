<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CancelReason extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'cancel_reasons';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
