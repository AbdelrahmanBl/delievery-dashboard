<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDelieveryRating extends Model
{
    protected $fillable = ["booking_id","seller_rating","seller_comment","provider_rating","provider_comment"];
}
