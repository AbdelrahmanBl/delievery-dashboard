<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $fillable = [
        'provider_id','service_type_id','user_id', 'payment_mode','travel_distance_km','s_address','s_latitude','s_longitude','d_address','d_latitude','d_longitude','is_scheduled','booking_id','status','promocode_id','schedule_at','is_best_price','travel_time_minute'
    ];
    /*protected $hidden = [
    	'travel_time',
    	'assigned_at',
    	'schedule_at',
    	'started_at',
    	'finished_at',
    	'deleted_at',
        'created_at',
        'updated_at',
    ];*/
}
