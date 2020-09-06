<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Seller extends Model
{
    protected $fillable = [
		"image","name_en","name_ar","uniqueID","is_busy","is_open","delievery_us","delievery_fees","delievery_ratio","min_ratio","min_order","has_product","main_color","commision_per","next_deilevery","duration_from","duration_to","type","email","password","remember_token","failed_try","is_first","module","status","address","latitude","longitude"      
    ];
    protected $hidden = [
      'password'
    ];
    public $timestamps = true;


    public function unpaid_seller_payments()
    {
        return $this->hasMany(UserDelieveryPayments::class,'seller_id')->where('paid',0);
    }

}
