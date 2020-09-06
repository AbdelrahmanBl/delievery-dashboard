<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaystackPaymentProvider extends Model
{
    protected $fillable = [
        'transaction_id', 'reference', 'provider_id','total','currency_en','currency_ar','paid_at'
   ];

   public $timestamps = true;
}
