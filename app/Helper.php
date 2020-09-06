<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File; 

use App\Models\Setting;
use App\Models\Admin;
use App\Models\Fleet;
use App\Models\tatxProduct;

class Helper extends Model
{
    public static function return($result)
    {
    return [
        'error_flag' => 0,
        'message' => 'success',
        'result'=> $result
      ];
    }
    public static function returnError($result)
    {
    return [
        'error_flag'    => 1,
        'message'       => $result,
        'result'        => NULL,
      ];
    }
    public static function returnException($e)
    {
    $Exception = Setting::where('key','EXCEPTION')->first();
    ($Exception->value)? $msg = $e->getMessage() : $msg = 'Something Went Wrong . Please Try Again' ;
    return $msg;
    }
    public static function notFound($message)
    {
      return response()->json([
            'error_flag' => 404,
            'message' => $message,
            'result'=> NULL
        ]);
    }
    public static function loginUsingId($model)
    {
            $token = str_random(64);
            $model->update([
            'failed_try'       => 0,
            'remember_token'   => $token,
            ]); 
            return $token;
    }
    public static function calculate_preparedTime($pending)
    {
            $arr = array();
            foreach($pending->products_view as $item){
                $arr[] = $item['prepared_time'];
            }
            $max = max($arr);
            return date('d-m-Y H:i:s',strtotime("+{$max} minutes"));
    }
    public static function calculate_total_products($bundle_product,$where)
    {
        $arr = array();
        foreach($bundle_product as $bundle){
            $arr[] = $bundle['id'];
        }
        array_shift($where);
        $where[] = ['bundle_product' , []];
        $products = tatxProduct::where($where)->whereIn('_id',$arr)->get(['price']);
        $total = 0;
        foreach($bundle_product as $bundle){
            $pointer = $products->where('_id',$bundle['id'])->first();
            if(!$pointer)
                continue;
            $total += ($pointer->price * $bundle['qty']);
        }
        return $total;
    }
    public static function calculate_discount($model_old_price,$model_dicount_percentage,$model_price)
    {
        $old_price = $model_old_price;
        $percentage = $model_dicount_percentage;
        if($old_price != 0){
            $price      = $old_price;
            $update_old = $old_price;
        }else{
            $price      = $model_price;
            $update_old = $price;
        }
        if($percentage == 0)
            $update_old = 0;
        $dicount   = $price - ($price * ($percentage / 100));
        $discounts['price']               = $dicount;
        $discounts['old_price']           = $update_old;
        $discounts['dicount_percentage']  = $percentage;
        return $discounts;
    }
    public static function image($image,$mode,$destinationPath,$filepath = NULL,$counter = 0)
    {
        if( $mode == 'update'){
            /*$oldImageName = explode('/',$filepath);
            $oldImageName = $oldImageName[count($oldImageName)-1];
            $imageName    =  $oldImageName;*/

            if (File::exists( public_path().$filepath)) {
                File::delete(public_path().$filepath);
            }
        }
        // else 
        $imageName =  /*pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '_' .*/ (time() + $counter) .'.'.$image->getClientOriginalExtension();
        // $destinationPath = 'delievery/main_icons';
        $url = $destinationPath . '/' . $imageName;

        $image->move($destinationPath, $imageName);
        $access_url =  '/' . $url;
        return $access_url;
    }
    public static function disable($model,$col,$on,$off,$return_on,$return_off)
    {
        if($model->first()->$col == $on){
        $model->update([
            $col    => $off
        ]);
        $status = $return_off;
        }else{
        $model->update([
            $col    => $on
        ]);
        $status = $return_on;
        }
        return $status;
    }
    public static function Pay($model,$pending)
    {
        $model->booking_id         = $pending->booking_id ;   
        $model->user_id            = $pending->user_id ; 
        $model->provider_id        = $pending->provider_id ;
        $model->seller_id          = $pending->seller_id ;     
        $model->shoper_id          = $pending->shoper_id ;  
        $model->promocode_id       = $pending->promocode_id ;                   
        $model->payment_mode       = $pending->payment ;                   
        $model->distance           = $pending->travel_distance_km ;               
        $model->minute             = $pending->travel_time_minute ;             
        $model->delievery_fees     = $pending->delievery_fees ;                     
        $model->delievery_to_pay   = $pending->delievery_to_pay ;                       
        $model->delievery_per      = $pending->delievery_per ;                    
        $model->products_price     = $pending->products_price ;                     
        $model->commision_per      = $pending->commision_per ;                    
        $model->service_cost       = $pending->service_cost ;                   
        $model->service_per        = $pending->service_per ;                  
        $model->discount           = $pending->discount ;               
        $model->discount_per       = $pending->discount_per ;                   
        $model->discount_type      = $pending->discount_type ;                    
        $model->vat                = $pending->vat ;          
        $model->vat_per            = $pending->vat_per ;              
        $model->delievery_us       = $pending->delievery_us ;                   
        $model->total              = $pending->total ;            
        return $model;
    }
    public static function update_category_array($row_model,$word,$new_en,$new_ar)
    {
        $model_data = $row_model->first();

        $index = array_search($word, $model_data->subCategory_english);
        $arr = array(
            'subCategory_english.'.$index => $new_en,
            'subCategory_arabic.'.$index => $new_ar
        );
        $row_model->update($arr);
    }
    public static function generate_object($array,$type)
    {
        // $array = explode('%$%', $str);
        if($type == 'location'){
            $obj = array();
            $obj['address']    =  $array[0];
            $obj['latitude']   =  (double)$array[1];
            $obj['longitude']  =  (double)$array[2];
        }
        return $obj;
    }
}
