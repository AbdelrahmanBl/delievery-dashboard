<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaystackPaymentSeller extends Model
{
    protected $fillable = [
        'transaction_id', 'reference', 'seller_id','total','currency_en','currency_ar','paid_at'
   ];

   public $timestamps = true;
}
