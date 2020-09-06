<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class wordSearch extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'word_search';

    protected $fillable = [
        
    ];

    public $timestamps = false;
}

