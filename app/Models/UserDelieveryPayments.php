<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDelieveryPayments extends Model
{
    protected $fillable = [
		"booking_id","user_id","provider_id","seller_id","shoper_id","promocode_id","payment_mode","distance","minute","delievery_fees","delievery_to_pay","delievery_per","products_price","commision_per","service_cost","service_per","discount","discount_per","discount_type","vat","vat_per","delievery_us","take_by_user","total","created_at","updated_at",      
    ];
 
    public $timestamps = true;
}
