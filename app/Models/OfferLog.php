<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLog extends Model
{
    protected $fillable = [
    	'user_id','offer_id','seller_id','paid','total'
    ];
}
