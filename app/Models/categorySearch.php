<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class categorySearch extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'category_search';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}
