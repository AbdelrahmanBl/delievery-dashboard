<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
	protected $fillable = [
    'provider_id','service_type_id','service_number','service_model','status'
	];
}
