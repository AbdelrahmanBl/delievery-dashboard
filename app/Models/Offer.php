<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
    	'promo_code','type','offer_by','payment_type','image','amount','amount_per','admin_per','seller_per','min','max','max_use','category_id','seller_id','product_id','from','to'
    ];
}
