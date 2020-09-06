<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
    	'image','page','type','expired_at','product_id','seller_id','category_id','main_id'
    ];
}
