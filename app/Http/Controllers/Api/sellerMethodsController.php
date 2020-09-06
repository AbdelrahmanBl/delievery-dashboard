<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

use App\Events\callDriver;
use App\Events\userNotify;

use App\Models\Seller;
use App\Models\DelieveryMongo;
use App\Models\Category;
use App\Models\tatxProduct;
use App\Models\UserDelieveryPayments;
use App\Models\Brand;
use App\Models\SubMainFilters;
use App\Models\SubSeller;
 
use App\Helper;
use validate;
use Hash;
class sellerMethodsController extends Controller
{
    public $max_options_count = 20;
    public function logout(Request $req)
    { 
        $where = array(
            'id' => $req->get('id'),
        );
        $User = Seller::where($where);
 
        Helper::loginUsingId($User);
        return Helper::return([]);
    }
    public function updatePassword(Request $req)
    {
        try{
        $req->validate([
            'old_password'     => 'required', 
            'password'     => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'verify_password'  => 'required|same:password',
        ]);
        $id   = $req->get('id');
        $old_password   = $req->input('old_password');
        $new_password   = $req->input('password');

        $model = Seller::where('id',$id);
        $model_select = $model->first();

        if($model_select->failed_try >= 20)
            return Helper::returnError(Lang::get('auth.blocked'));
        if( !Hash::check($old_password, $model_select->password) ){
            $model->increment('failed_try');
            return Helper::returnError(Lang::get('auth.password'));
            }
            $model->update([
                'password'   => Hash::make($new_password),
                'is_first'   => 0
            ]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function subscribeSubMainFilters(Request $req)
    {
        try{
        $req->validate([
            'id'     => 'required|exists:mongodb.sub_main_filters,_id',
        ]);
        $id        = $req->input('id');
        $uniqueID  = $req->get('uniqueID');
        $model = SubMainFilters::where('_id',$id);
        $model_select = $model->first();
        if(in_array($uniqueID, $model_select['uniqueIDs'])){
            $model->pull('uniqueIDs',$uniqueID);
            $is_subscribe = false;
        }
        else{
            $model->push('uniqueIDs',$uniqueID);
            $is_subscribe = true;
        }
    return Helper::return([
        'is_subscribe'  => $is_subscribe
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addDiscount(Request $req)
    {
        try{
        $req->validate([
            'id'            => 'required|exists:mongodb.tatx_products,_id',
            'percentage'    => 'required|numeric|between:0,100',            
        ]);
        $id         = $req->input('id');
        $percentage = $req->input('percentage');
        $uniqueID   = $req->get('uniqueID');
        $where = array(
            '_id'      => $id,
            'uniqueID' => $uniqueID,
        );
        $model = tatxProduct::where($where);
        $model_select = $model->first();
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $discount = Helper::calculate_discount($model_select->old_price,$percentage,$model_select->price);
        $model->update([
            'dicount_percentage' => $discount['dicount_percentage'],
            'old_price'          => $discount['old_price'],
            'price'              => $discount['price'] 
        ]);
        
        return Helper::return([
            'dicount_percentage' => $discount['dicount_percentage'],
            'old_price'          => $discount['old_price'],
            'price'              => $discount['price'] 
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updatePicture(Request $req)
    {
        try{
        $id   = $req->get('id');
        $req->validate([
            'icon'            => 'required|image|mimes:jpeg,png,jpg|max:2000',
             
        ]);
        $image     = $req->file('icon');
        $model = Seller::where('id',$id);
        $model_select = $model->first();
        
        $icon_url = Helper::image($image,'update','delievery/seller_icons',$model_select->image);
        $model->update([
            'image'   => $icon_url
        ]);
        return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateProfile(Request $req)
    {
        try{
        $id   = $req->get('id');
        $req->validate([
            'name_en'               => "required|string|min:3|max:30|unique:sellers,name_en,{$id},id",
            'name_ar'               => "required|string|min:3|max:30|unique:sellers,name_en,{$id},id",
            'address'               => 'required|string|min:3|max:100',
            'latitude'              => 'required|numeric',
            'longitude'             => 'required|numeric',
            'address'               => 'required|string|min:3|max:100',
            'email'                 => "required|string|min:3|max:64|unique:sellers,name_en,{$id},id",
            'duration_from'         => 'required|numeric|between:0,9999',
            'duration_to'           => 'required|numeric|between:0,9999',
        ]);
        $name_en         = $req->input('name_en');
        $name_ar         = $req->input('name_ar');
        $address         = $req->input('address');
        $latitude        = $req->input('latitude');
        $longitude       = $req->input('longitude');
        $email           = $req->input('email');
        $duration_from   = $req->input('duration_from');
        $duration_to     = $req->input('duration_to');

        $model = Seller::where('id',$id);        
        $model->update($req->all('name_en','name_ar','address','latitude','longitude','email','duration_from','duration_to'));
    
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function busyUnbusy(Request $req)
    {
        try{
        $id   = $req->get('id');
        $model = Seller::where('id',$id);
        $status = Helper::disable($model,'is_busy',true,false,'YES','NO');
            
    return Helper::return([
        'status'  => $status
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function openClose(Request $req)
    {
        try{
        $id   = $req->get('id');
        $model = Seller::where('id',$id);
        $status = Helper::disable($model,'is_open',true,false,'YES','NO');
            
    return Helper::return([
        'status'  => $status
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateOrder(Request $req)
    {
        try{
        $req->validate([
            'booking_id'   => 'required|exists:mongodb.user_delieveries',
            'status'       => 'required|in:CONFIRMED,PREPAIRING,DELIEVERING,COMPLETED',
        ]);
        $unique_id        =  $req->get('uniqueID');
        $booking_id       =  $req->input('booking_id');
        $status           =  $req->input('status');
        $Pay = new UserDelieveryPayments();
        $status_arr       =  ["SEARCHING","CONFIRMED","PREPAIRING","DELIEVERING","COMPLETED"];
        
        $where = array(
            ['booking_id',$booking_id],
            ['uniqueID',$unique_id],
        );
        $model = DelieveryMongo::where($where);
        $pending = $model->first();
        if(!$pending)
            return Helper::returnError(Lang::get('messages.not_allowed')); 
        
        if($Pay::where('booking_id',$booking_id)->first() )
                return Helper::returnError(Lang::get('messages.paid'));
        if($pending->status == 'CANCELLED')
            return Helper::returnError(Lang::get('messages.cancelled'));   
        if($pending->delievery_us == 1 && in_array($status, array('DELIEVERING','COMPLETED') ))
            return Helper::returnError(Lang::get('messages.not_allowed'));    
        
        $db_index     = array_search($pending->status,$status_arr);
        $input_index  = array_search($status,$status_arr);
        $expected     = $status_arr[$db_index+1];
        if( $db_index != ($input_index-1))
            return Helper::returnError(Lang::get("messages.expected").strtolower($expected));  
        
        if($pending->delievery_us == 0 && $status == 'COMPLETED'){  
            $Pay = Helper::Pay($Pay,$pending);
            $Pay->save();
        }
        $prepared_time = NULL;
        if($status == 'PREPAIRING'){
            $prepared_time = Helper::calculate_preparedTime($pending);
        }
        $model->update([
            'status'   => $status,
            'prepared_time' => $prepared_time,
        ]);
        broadcast(new userNotify($booking_id,$status,$pending->user_id));
    return Helper::return([
        'start'   => date('d-m-Y H:i:s'),
        'end'      => $prepared_time,
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function snoozeOrder(Request $req)
    {
        try{
        $req->validate([
            'booking_id'   => 'required|exists:mongodb.user_delieveries',
        ]);
        $unique_id        =  $req->get('uniqueID');
        $booking_id       =  $req->input('booking_id');

        $where = array(
            ['booking_id',$booking_id],
            ['uniqueID',$unique_id],
            ['status','PREPAIRING']
        );
        $model = DelieveryMongo::where($where);
        $pending = $model->first();
        if(!$pending)
            return Helper::returnError(Lang::get('messages.not_allowed')); 
        
        $prepared_time = Helper::calculate_preparedTime($pending);
        $model->update([
            'prepared_time' => $prepared_time,
        ]);

    return Helper::return([
        'start'   => date('d-m-Y H:i:s'),
        'end'      => $prepared_time,
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function cancelOrder(Request $req)
    {
        try{
        $req->validate([
            'booking_id'   => 'required|exists:mongodb.user_delieveries',
            'reason_en'    => 'required|exists:mongodb.cancel_reasons,en',
            'reason_ar'    => 'required|exists:mongodb.cancel_reasons,ar',
        ]);
        $unique_id        =  $req->get('uniqueID');
        $booking_id       =  $req->input('booking_id');
        $reason_en        =  $req->input('reason_en');
        $reason_ar        =  $req->input('reason_ar');
        
        $where = array(
            ['booking_id',$booking_id],
            ['uniqueID',$unique_id],
        );
        $model = DelieveryMongo::where($where);
        $pending = $model->first();
        if(!$pending)
            return Helper::returnError(Lang::get('messages.not_allowed')); 
        if($pending->status != 'SEARCHING' )
            return Helper::returnError(Lang::get('messages.not_allowed'));    
        
        $model->update([
            'status'       => 'CANCELLED',
            'reason_en'    => $reason_en,
            'reason_ar'    => $reason_ar,
        ]);

    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function callDriver(Request $req)
    {
        try{
        $req->validate([
            'booking_id'   => 'required|exists:mongodb.user_delieveries'
        ]);
        $unique_id        =  $req->get('uniqueID');
        $booking_id       =  $req->input('booking_id');
        
        $where = array(
            ['booking_id',$booking_id],
            ['uniqueID',$unique_id],
        );
        $model = DelieveryMongo::where($where);
        $pending = $model->first();
        if(!$pending && $pending->take_by_user == 1)
            return Helper::returnError(Lang::get('messages.not_allowed')); 
        if($pending->status != 'PREPAIRING' || $pending->delievery_us == 0 )
            return Helper::returnError(Lang::get('messages.not_allowed'));    
        
        broadcast(new callDriver($pending->booking_id));
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addProduct(Request $req)
    {
        try{
        $uniqueID           = $req->get('uniqueID');
        $req->validate([
            'icon'            => 'required|image|mimes:jpeg,png,jpg|max:2000',
            'icons.*'         => 'nullable|image|mimes:jpeg,png,jpg|max:2000',
            'price'           => 'required|numeric|between:0,100000',
            'prepared_time'   => 'nullable|numeric|between:0,'.(72*60),

            'name_en'         => "required|unique:mongodb.tatx_products,en.name,null,_id,uniqueID,{$uniqueID}|string|min:3|max:50",
            'brand_en'        => "nullable|string|exists:mongodb.brands,brand_en,uniqueID,{$uniqueID}",
            'category_en'     => "nullable|exists:mongodb.categories,category_english,uniqueID,{$uniqueID}",
            'sub_category_en' => "nullable|exists:mongodb.categories,subCategory_english,uniqueID,{$uniqueID}",
            'desc_en'         => 'nullable|string|min:3|max:255',
            // 'currency_en'     => 'required|string|min:2|max:6',

            'name_ar'         => "required|unique:mongodb.tatx_products,ar.name,null,_id,uniqueID,{$uniqueID}|string|min:3|max:50",
            'brand_ar'        => "nullable|string|exists:mongodb.brands,brand_ar,uniqueID,{$uniqueID}",
            'category_ar'     => "nullable|exists:mongodb.categories,category_arabic,uniqueID,{$uniqueID}",
            'sub_category_ar' => "nullable|exists:mongodb.categories,subCategory_arabic,uniqueID,{$uniqueID}",
            'desc_ar'         => 'nullable|string|min:3|max:255',
            // 'currency_ar'     => 'required|string|min:2|max:6',
        ]);

        
        $icon               = $req->file('icon');
        $icons              = $req->file('icons');
        $price              = (double)$req->input('price');
        $prepared_time      = (double)$req->input('prepared_time');

        $brand_en           = $req->input('brand_en');
        $name_en            = $req->input('name_en');
        $category_en        = $req->input('category_en');
        $sub_category_en    = $req->input('sub_category_en');
        $seller_en          = $req->get('seller_en');
        $desc_en            = $req->input('desc_en');
        $currency_en        = 'sar';//$req->input('currency_en');

        $brand_ar           = $req->input('brand_ar');
        $name_ar            = $req->input('name_ar');
        $category_ar        = $req->input('category_ar');
        $sub_category_ar    = $req->input('sub_category_ar');
        $seller_ar          = $req->get('seller_ar');
        $desc_ar            = $req->input('desc_ar');
        $currency_ar        = 'ريال';
    
        $folder = 'delievery/products/'.$uniqueID;
        $image = Helper::image($icon,'add',$folder);
        $counter = 1;
        $images = array();
        if($icons){
        foreach($icons as $pic){
            if($counter == 3)
                break;
            $images[] = Helper::image($pic,'add',$folder,'',$counter);
            $counter++;
        }
        }
        $Card = new tatxProduct();
        $Card->en = [
            "name" =>  $name_en,
            "brand" => $brand_en,
            "category" => $category_en,
            "sub_category" => $sub_category_en,
            "seller" => $seller_en,
            "currency" => $currency_en,
            "desc"  => $desc_en,
        ];
        $Card->ar = [
            "name" =>  $name_ar,
            "brand" => $brand_ar,
            "category" => $category_ar,
            "sub_category" => $sub_category_ar,
            "seller" => $seller_ar,
            "currency" => $currency_ar,
            "desc"  => $desc_ar,
        ];
        $Card->uniqueID = $uniqueID;
        $Card->image = $image;
        $Card->images = $images;  
        $Card->bundle_product = array();
        $Card->options = array();
        $Card->price = $price;
        $Card->old_price =  0 ;
        $Card->dicount_percentage = 0;
        $Card->prepared_time = $prepared_time;
        $Card->is_outOfStock = false; 
        $Card->status = "ON";
        $Card->created_at = date('Y-m-d H:i:s');
        
        $Card->save();
        return Helper::return([
            'id'        => $Card->_id,
            'icon'      => $Card->image,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateProduct(Request $req)
    {
        try{
        $id                 = $req->input('id');
        $uniqueID           = $req->get('uniqueID');
        $req->validate([
            'id'              => 'required|exists:mongodb.tatx_products,_id',
            'price'           => 'required|numeric|between:0,100000',
            'prepared_time'   => 'nullable|numeric|between:0,'.(72*60),
 
            'name_en'         => "required|unique:mongodb.tatx_products,en.name,{$id},_id,uniqueID,{$uniqueID}|string|min:3|max:50",
            'brand_en'        => "nullable|string|exists:mongodb.brands,brand_en,uniqueID,{$uniqueID}",
            'category_en'     => 'nullable|exists:mongodb.categories,category_english',
            'sub_category_en' => 'nullable|exists:mongodb.categories,subCategory_english',
            'desc_en'         => 'nullable|string|min:3|max:255',
 
            'name_ar'         => "required|unique:mongodb.tatx_products,ar.name,{$id},_id,uniqueID,{$uniqueID}|string|min:3|max:50",
            'brand_ar'        => "nullable|string|exists:mongodb.brands,brand_ar,uniqueID,{$uniqueID}",
            'category_ar'     => 'nullable|exists:mongodb.categories,category_arabic',
            'sub_category_ar' => 'nullable|exists:mongodb.categories,subCategory_arabic',
            'desc_ar'         => 'nullable|string|min:3|max:255',
        ]);
        
        $price              = (double)$req->input('price');
        $prepared_time      = (double)$req->input('prepared_time');

        $brand_en           = $req->input('brand_en');
        $name_en            = $req->input('name_en');
        $category_en        = $req->input('category_en');
        $sub_category_en    = $req->input('sub_category_en');
        $desc_en            = $req->input('desc_en');

        $brand_ar           = $req->input('brand_ar');
        $name_ar            = $req->input('name_ar');
        $category_ar        = $req->input('category_ar');
        $sub_category_ar    = $req->input('sub_category_ar');
        $desc_ar            = $req->input('desc_ar');
    
        $where = array(
            '_id'       => $id,
            'uniqueID'  => $uniqueID,
        );
        $Card = tatxProduct::where($where);
        if(!$Card->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $Card->update([
            "price"             => $price,
            "prepared_time"     => $prepared_time,

            "en.name"           => $name_en,
            "en.brand"          => $brand_en,
            "en.category"       => $category_en,
            "en.sub_category"   => $sub_category_en,
            "en.desc"           => $desc_en,

            "ar.name"           => $name_ar,
            "ar.brand"          => $brand_ar,
            "ar.category"       => $category_ar,
            "ar.sub_category"   => $sub_category_ar,
            "ar.desc"           => $desc_ar,
        ]);
        return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateBundleProducts(Request $req)
    {
        try{
        $uniqueID           = $req->get('uniqueID');
        $req->validate([
            'id'              => "required|exists:mongodb.tatx_products,_id,uniqueID,{$uniqueID}",
            'bundle_product'  => 'nullable|array|max:30',
            'bundle_product.*.id'  => "nullable|exists:mongodb.tatx_products,_id,uniqueID,{$uniqueID}",
            'bundle_product.*.qty' => 'nullable|numeric|min:1|max:999',
        ]);

        $id                 = $req->input('id');
        $bundle_product     = $req->input('bundle_product');
        $where = array(
            '_id'       => $id,
            'uniqueID'  => $uniqueID,
        );
        $model = tatxProduct::where($where);
        $model_select = $model->first(['price','old_price','dicount_percentage']);
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $total = Helper::calculate_total_products($bundle_product,$where);
        $discount = Helper::calculate_discount(0,$model_select->dicount_percentage,$total);
        $model->update([
            "bundle_product"        => $bundle_product,
            "price"                 => $discount['price'],
            "old_price"             => $discount['old_price'],
            "dicount_percentage"    => $discount['dicount_percentage'],
        ]);
        return Helper::return([
            "price"                 => $discount['price'],
            "old_price"             => $discount['old_price'],
            "dicount_percentage"    => $discount['dicount_percentage'],
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateProductImage(Request $req)
    {
        try{
        $req->validate([
            'id'              => 'required|exists:mongodb.tatx_products,_id',
            'icon'            => 'required|image|mimes:jpeg,png,jpg|max:2000',
        ]);

        $id                 = $req->input('id');
        $image              = $req->file('icon');
        $uniqueID           = $req->get('uniqueID');
    
        $where = array(
            '_id'       => $id,
            'uniqueID'  => $uniqueID,
        );
        $model = tatxProduct::where($where);
        $model_select = $model->first();
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $filepath = $model_select->image;
        if($filepath)
            $url =  Helper::image($image,'update','delievery/products/'.$uniqueID,$filepath,0);
        else{
            $url = Helper::image($image,'add','delievery/products/'.$uniqueID);
        }
        $model->update(['image' => $url]);
        return Helper::return([
            'url'  => $url
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    } 
    public function updateProductImages(Request $req)
    {
        try{
        $req->validate([
            'id'              => 'required|exists:mongodb.tatx_products,_id',
            'icons.*'         => 'required|image|mimes:jpeg,png,jpg|max:2000',
        ]);

        $id                 = $req->input('id');
        $images             = $req->file('icons');
        $uniqueID           = $req->get('uniqueID');
        if(!$images)
            return Helper::returnError(Lang::get('messages.required_icons'));
        $where = array( 
            '_id'       => $id,
            'uniqueID'  => $uniqueID,
        );
        $model = tatxProduct::where($where);
        $model_select = $model->first();
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $counter = 0;
        $images_mongo = $model_select->images;
        $count_images = count($images_mongo);
        foreach($images as $id => $image){
            if($counter == 2 || !in_array($id, [0,1])  ){
                return Helper::returnError(Lang::get('messages.required_icons'));
                break;
            }
        if(isset($images_mongo[$id])){
        $url = Helper::image($image,'update','delievery/products/'.$uniqueID,$images_mongo[$id],0);
            $push = array(
            "images.{$id}" => $url,
            );
            $model->update($push);
        }
        else{ 
           $url = Helper::image($image,'add','delievery/products/'.$uniqueID,NULL,$counter);
           $push = array(
            'images' => $url,
            );
           $model->push($push);
        }
        $counter++;
        }
        return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteProduct(Request $req)
    {
        try{
        $req->validate([
            'id'              => 'required|exists:mongodb.tatx_products,_id',
        ]);

        $id                 = $req->input('id');
        $uniqueID           = $req->get('uniqueID');
    
        $where = array(
            '_id'       => $id,
            'uniqueID'  => $uniqueID,
        );
        $model = tatxProduct::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $status = Helper::disable($model,"status","ON","OFF","ON","OFF");
        return Helper::return([
            'status'    => $status
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function changeProductStock(Request $req)
    {
        try{
        $req->validate([
            'id'              => 'required|exists:mongodb.tatx_products,_id',
        ]);

        $id                 = $req->input('id');
        $uniqueID           = $req->get('uniqueID');
    
        $where = array(
            '_id'       => $id,
            'uniqueID'  => $uniqueID,
        );
        $model = tatxProduct::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $status = Helper::disable($model,"is_outOfStock",true,false,"YES","NO");
        return Helper::return([
            'status'    => $status
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function addProductOptions(Request $req)
    {
        try{
        $req->validate([
            'id'            => 'required|exists:mongodb.tatx_products,_id',
            'question_en'   => 'required|string:min:3|max:100',
            'question_ar'   => 'required|string:min:3|max:100',
            'responds_en.*' => 'required|string|min:3|max:50',
            'responds_ar.*' => 'required|string|min:3|max:50',
            'prices.*'      => 'required|numeric|min:0|max:999999',
            'responds_en'   => 'required|array|min:1|max:'.$this->max_options_count,
            'responds_ar'   => 'required|array|min:1|max:'.$this->max_options_count,
            'prices'        => 'required|array|min:1|max:'.$this->max_options_count,
            'type'          => 'required|in:1,0',
            'is_required'   => 'required|in:1,0',
        ]);

        $uniqueID           = $req->get('uniqueID');
        $id                 = $req->input('id');
        $question_en        = $req->input('question_en');
        $question_ar        = $req->input('question_ar');
        $responds_en        = $req->input('responds_en');
        $responds_ar        = $req->input('responds_ar');
        $prices             = $req->input('prices');
        $type               = $req->input('type');
        $is_required        = $req->input('is_required');

        if( count($responds_en) != count($responds_ar) || count($responds_en) != count($prices) )
            return Helper::returnError(Lang::get('messages.assinging'));

        $push = array();
        $push['en'] = [
            'question'  => $question_en,
            'responds'  => $responds_en,
        ];
        $push['ar'] = [
            'question'  => $question_ar,
            'responds'  => $responds_ar,
        ];
        $push['prices'] = $prices;
        $push['type']  = $type;
        $push['is_required']  = $is_required;

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $Card = tatxProduct::where($where);
        if(!$Card->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $Card->push('options',$push);
        return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateProductOptions(Request $req)
    {
        try{
         $req->validate([
            'id'            => 'required|exists:mongodb.tatx_products,_id',
        ]);
        $uniqueID           = $req->get('uniqueID');
        $id                 = $req->input('id');
        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $Card = tatxProduct::where($where);
        if(!$Card->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $count = $Card->first()->options;
        $count = count($count) - 1;

        $req->validate([
            'option_number' => 'required|numeric|min:0|max:'.$count,
            'question_en'   => 'required|string|min:3|max:100',
            'question_ar'   => 'required|string|min:3|max:100',
            'responds_en'   => 'required|array|min:1|max:'.$this->max_options_count,
            'responds_ar'   => 'required|array|min:1|max:'.$this->max_options_count,
            'prices'        => 'required|array|min:1|max:'.$this->max_options_count,
            'type'          => 'required|in:1,0',
            'is_required'   => 'required|in:1,0',
        ]);

        $option_number      = (int)$req->input('option_number');
        $question_en        = $req->input('question_en');
        $question_ar        = $req->input('question_ar');
        $responds_en        = $req->input('responds_en');
        $responds_ar        = $req->input('responds_ar');
        $prices             = $req->input('prices');
        $type               = $req->input('type');
        $is_required        = $req->input('is_required');

        $push = array();
        $push['en'] = [
            'question'  => $question_en,
            'responds'  => $responds_en,
        ];
        $push['ar'] = [
            'question'  => $question_ar,
            'responds'  => $responds_ar,
        ];
        $push['prices'] = $prices;
        $push['type']  = $type;
        $push['is_required']  = $is_required;

        $Card->update([
            'options.'.$option_number =>  $push
        ]);
        return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteProductOptions(Request $req)
    {
        try{
         $req->validate([
            'id'            => 'required|exists:mongodb.tatx_products,_id',
        ]);
        $uniqueID           = $req->get('uniqueID');
        $id                 = $req->input('id');
        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $Card = tatxProduct::where($where);
        if(!$Card->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $count = $Card->first()->options;
        $count = count($count) - 1;

        $req->validate([
            'option_number' => 'required|numeric|min:0|max:'.$count,
        ]);

        $option_number      = (int)$req->input('option_number');

        $Card->unset('options.'.$option_number,1)->pull('options',null);
        return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function addBrand(Request $req)
    {
        try{
        $uniqueID           = $req->get('uniqueID');
         $req->validate([
            'brand_en'            => 'required|string|min:3|max:30|unique:mongodb.brands,brand_en,null,_id,uniqueID,'.$uniqueID,
            'brand_ar'            => 'required|string|min:3|max:30|unique:mongodb.brands,brand_ar,null,_id,uniqueID,'.$uniqueID,
        ]);
        $brand_en  = $req->input('brand_en');
        $brand_ar  = $req->input('brand_ar');
        
        $Brand = new Brand();
        $Brand->brand_en    = $brand_en;
        $Brand->brand_ar    = $brand_ar;
        $Brand->uniqueID    = $uniqueID;
        $Brand->status      = 'ON';
        $Brand->save();
        
        return Helper::return([
            'id'   => $Brand->_id
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateBrand(Request $req)
    {
        try{
        $id                 = $req->input('id');    
        $uniqueID           = $req->get('uniqueID');
         $req->validate([
            'id'                  => 'required|exists:mongodb.brands,_id',
            'brand_en'            => 'required|string|min:3|max:30|unique:mongodb.brands,brand_en,'.$id.',_id,uniqueID,'.$uniqueID,
            'brand_ar'            => 'required|string|min:3|max:30|unique:mongodb.brands,brand_ar,'.$id.',_id,uniqueID,'.$uniqueID,
        ]);
        $brand_en  = $req->input('brand_en');
        $brand_ar  = $req->input('brand_ar');

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );

        $Brand = new Brand();
        $Brand = $Brand::where($where);
        if(!$Brand->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        
        
        $Brand->update([
            'brand_en'   => $brand_en,
            'brand_ar'   => $brand_ar,
        ]);
        
        return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteBrand(Request $req)
    {
        try{
         $req->validate([
            'id'                  => 'required|exists:mongodb.brands,_id',
        ]);
        $id                 = $req->input('id');    
        $uniqueID           = $req->get('uniqueID');

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );

        $Brand = new Brand();
        $Brand = $Brand::where($where);
        if(!$Brand->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));

        $model = $Brand;
        $status = Helper::disable($model,'status','ON','OFF','ON','OFF');
            
    return Helper::return([
        'status'  => $status
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteSubSeller(Request $req)
    {
        try{
         $req->validate([
            'id'           => 'required|exists:sub_sellers',
        ]);
        $id          = $req->input('id');    
        $seller_id   = $req->get('id');

        $where = array(
            'id' => $id,
            'seller_id' => $seller_id
        );

        $SubSeller = new SubSeller();
        $SubSeller = $SubSeller::where($where);
        if(!$SubSeller->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));

        $model = $SubSeller;
        $status = Helper::disable($model,'status','ON','OFF','ON','OFF');
            
    return Helper::return([
        'status'  => $status
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addSubSeller(Request $req)
    {
        try{
         $req->validate([
            'email'             => 'required|email|max:100|unique:sub_sellers',
            'name'              => 'required|string|max:50',
            'password'          => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'verify_password'  => 'required|same:password',
        ]);
        $email        = $req->input('email');    
        $name         = $req->input('name');    
        $password     = $req->input('password');    
        $seller_id    = $req->get('id');

        $model = new SubSeller();
        $model_count = $model::where('seller_id',$seller_id)->count();
        if($model_count > 6)
            return Helper::returnError(Lang::get('messages.email_limit').'6');
        $model->email        = $email;
        $model->name         = $name;
        $model->password     = Hash::make($password);
        $model->seller_id    = $seller_id;
        $model->save();
    return Helper::return([
        'id'  => $model->id
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function changeSubSellerPassword(Request $req)
    {
        try{
         $req->validate([
            'id'                => 'required|exists:sub_sellers',
            'password'          => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'verify_password'  => 'required|same:password',
        ]);
        $id          = $req->input('id');    
        $password    = $req->input('password');    
        $seller_id   = $req->get('id');

        $where = array(
            'id' => $id,
            'seller_id' => $seller_id
        );

        $model = new SubSeller();
        $model = $model::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));

        $model->update([
            'password'  => Hash::make($password)
        ]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
}
