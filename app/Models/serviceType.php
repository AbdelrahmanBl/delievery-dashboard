<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class serviceType extends Model
{
    protected $fillable = [
        'name', 'type', 'image','capacity','price_fixed','price_minute','price_distance','description','address','latitude','longitude'
    ];
}
