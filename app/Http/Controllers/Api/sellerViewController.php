<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models\Seller;
use App\Models\DelieveryMongo;
use App\Models\Category;
use App\Models\tatxProduct;
use App\Models\Brand;
use App\Models\CancelReason;
use App\Models\Provider;
use App\Models\UserDelieveryRating;
use App\Models\UserDelieveryPayments;
use App\Models\SubMainFilters;
use App\Models\SubSeller;
use App\Models\PaystackPaymentSeller;
use App\Models\SellerWallet;

use App\Helper;
use validate;
use DateTime;
class sellerViewController extends Controller
{ 
    public $current_status = ['SEARCHING','CONFIRMED','PREPAIRING','DELIEVERING'];
    public function getProfile(Request $req)
    {
        try{
            $uniqueID = $req->get('uniqueID');
            $where = array(
                'uniqueID'    =>  $uniqueID           
                 );
            $Seller = Seller::where($where)->first(["image","name_en","name_ar","uniqueID","is_busy","is_open","delievery_us","type","status","email","address","latitude","longitude","duration_from","duration_to",'wallet_balance']);
            return Helper::return([
                'seller'    => $Seller,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function getSubSellerProfile(Request $req)
    {
        try{
            $sub_seller_id = $req->get('sub_seller_id');
            $where = array(
                'sub_sellers.id'    =>  $sub_seller_id           
                 );
            $select = array(
                'sellers.image',
                'sub_sellers.name',
                'sub_sellers.email',
                'sub_sellers.remember_token'
            );
            $Seller = SubSeller::where($where)->join('sellers','sub_sellers.seller_id','sellers.id')->select($select)->first();
            return Helper::return([
                'seller'    => $Seller,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function getRates(Request $req)
    {
        try{
            $id = $req->get('id');
            $select = array(
                'user_delievery_payments.booking_id',
                'seller_rating',
                'seller_comment',
                'user_delievery_ratings.created_at',
            );
            $rated_order = UserDelieveryPayments::where('seller_id',$id)->join('user_delievery_ratings','user_delievery_payments.booking_id','user_delievery_ratings.booking_id')->select($select)->orderBy('created_at','desc')->limit(24)->get();
            
            return Helper::return([
                'rated_order'    => $rated_order
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function getSubSellers(Request $req)
    {
        try{
            $id = $req->get('id');
            $select = array(
                'sellers.image',
                'sub_sellers.id',
                'sub_sellers.status',
                'sub_sellers.name',
                'sub_sellers.email',
                'sub_sellers.remember_token',
            );
            $model = Seller::where('sellers.id',$id)->join('sub_sellers','sellers.id','sub_sellers.seller_id')->select($select)->orderBy('sellers.created_at','desc')->get();
            
            return Helper::return([
                'sellers'    => $model,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function getBrands(Request $req)
    {
        try{
            $uniqueID = $req->get('uniqueID');
            $where = array(
                'uniqueID'    =>  $uniqueID           
                 );
            $Brands = Brand::where($where)->get();
            return Helper::return([
                'brands'    => $Brands
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function categories(Request $req)
    {
        try{
            $uniqueID = $req->get('uniqueID');
            $where = array(
                'uniqueID'    =>  $uniqueID           
                 );
            $categories = Category::where($where)->select('category_english','category_arabic','subCategory_english','subCategory_arabic','status')->orderBy('created_at','desc')->get();
            return Helper::return([
                'categories'    => $categories
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function products(Request $req)
    {
        try{
            $uniqueID     = $req->get('uniqueID');
            $category     = $req->get('category');
            $sub_category = $req->get('sub_category');
            $language     = $req->header('language');
            $where = array(
                'uniqueID'    =>  $uniqueID,
                'bundle_product' => [],
                // 'status'      => 'ON'
            );
            if($category)
                $where[] = [$language.'.category',$category];
            if($sub_category)
                $where[] = [$language.'.sub_category',$sub_category];
            $products = tatxProduct::where($where)->orderBy('created_at','desc')->paginate(12);
            return Helper::return([
                'products'    => $products,
                'image_url'   => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function bundleProducts(Request $req)
    {
        try{
            $uniqueID = $req->get('uniqueID');
            $where = array(
                ['uniqueID'        , $uniqueID],
                ['bundle_product'  ,'!=', [] ],
                // ['status'          , 'ON']
            );
            $products = tatxProduct::where($where)->orderBy('created_at','desc')->get();
            return Helper::return([
                'products'    => $products,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function bundleSomeProducts(Request $req)
    {
        try{
            $uniqueID = $req->get('uniqueID');
            $req->validate([
                'bundle_id'  => "required|exists:mongodb.tatx_products,_id,uniqueID,{$uniqueID}",
            ]); 
            $bundle_id   = $req->get('bundle_id');
            $IDs = array();
            $where = array(
                ['uniqueID'        , $uniqueID],
                ['bundle_product'  , [] ],
                // ['status'          , 'ON']
            );
            $bundle = tatxProduct::where('_id',$bundle_id)->first(['bundle_product'])->bundle_product;
            foreach($bundle as $item){
                $IDs[] = $item['id'];
            }
            $products = tatxProduct::where($where)->whereIn('_id',$IDs)->get(['en.name','ar.name','en.currency','ar.currency','image','price']);
            return Helper::return([
                'products'    => $products,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function searchForBundleProducts(Request $req)
    {
        try{
            $uniqueID = $req->get('uniqueID');
            $req->validate([
                'search'  => 'required|string|max:60',
            ]);
            $search = $req->get('search');
            $language = $req->header('language');

            $where = array(
                ['uniqueID'        , $uniqueID],
                ['bundle_product'  , [] ],
                // ['status'          , 'ON'],
            );
            $where[] =  ($language == 'en')? ['en.name'     , 'like', "%{$search}%"]
            : ['ar.name'     , 'like', "%{$search}%"] ;

            $products = tatxProduct::where($where)->limit(10)->get(['image','en.name','ar.name','price']);
            return Helper::return([
                'products'    => $products,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function dashboard(Request $req)
    {
        try{ 
            $uniqueID = $req->get('uniqueID');
            $model = new DelieveryMongo();
            $model_select = $model::where('uniqueID',$uniqueID)->select('status','created_at')->get();
            $current = 0;    
            $cancelled = 0;
            $completed = 0;
            $current_today = 0;    
            $cancelled_today = 0;
            $completed_today = 0;
            $current_yesterday = 0;    
            $cancelled_yesterday = 0;
            $completed_yesterday = 0;
            $total_income = 0;
            foreach($model_select as $select){
                $datetime1 = new DateTime(explode(' ',$select->created_at)[0]);
                $datetime2 = new DateTime(date('Y-m-d'));
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');//now do whatever you like with $days

                if(in_array($select->status, $this->current_status )){
                    if($days == 0)
                        $current_today++;
                    else if($days == 1)
                        $current_yesterday++;
                    $current++;
                }
                else if($select->status == 'CANCELLED'){
                    if($days == 0)
                        $cancelled_today++;
                    else if($days == 1)
                        $cancelled_yesterday++;
                    $cancelled++;
                }
                else if($select->status == 'COMPLETED'){
                    if($days == 0)
                        $completed_today++;
                    else if($days == 1)
                        $completed_yesterday++;
                    $completed++;
                }
            }
            return Helper::return([
                'current_all'           => $current,
                'cancelled_all'         => $cancelled,
                'completed_all'         => $completed,
                'current_today'           => $current_today,
                'cancelled_today'         => $cancelled_today,
                'completed_today'         => $completed_today,
                'current_yesterday'           => $current_yesterday,
                'cancelled_yesterday'         => $cancelled_yesterday,
                'completed_yesterday'         => $completed_yesterday,
                'total_income'      => $total_income,
            ]); 
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function currentOrders(Request $req)
    {
        try{ 
            $uniqueID = $req->get('uniqueID');
            $model = new DelieveryMongo();
            $model_select = $model::where('uniqueID',$uniqueID)->whereIn('status',$this->current_status)->orderBy('created_at','desc')->get();
            return Helper::return([
                'current'            => count($model_select),
                'current_orders'     => $model_select,
                'start'              => date('d-m-Y H:i:s'),
                'image_url'          => env('APP_URL')
            ]); 
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function sales(Request $req)
    { 
        try{ 
            $uniqueID = $req->get('uniqueID');
            $status = $req->get('status');
            $model = new DelieveryMongo();
            $where = array();
            $where[] = ['uniqueID',$uniqueID];
            $where[] = ['status',$status];
            $model_select = $model::where($where)->orderBy('created_at','desc')->paginate(10);

            // $unpaid = 0;
            // $unpaid_orders = array();
            // $cancelled = 0;
            // $cancelled_orders = array();
            // $completed = 0;
            // $completed_orders = array(); 

            // foreach($model_select as $select){
            //     return $select;
            //     if($select->status == 'CANCELLED'){
            //         $cancelled++;
            //         $cancelled_orders[] = $select;
            //     }
            //     else if($select->status == 'COMPLETED'){
            //         $completed++;
            //         $completed_orders[] = $select;
            //     }
            // }
            return Helper::return([
                'orders'               => $model_select,
                // 'unpaid'            => $unpaid,
                // 'cancelled'         => $cancelled,
                // 'completed'         => $completed,
                // 'unpaid_orders'     => $unpaid_orders,
                // 'cancelled_orders'  => $cancelled_orders,
                // 'completed_orders'  => $completed_orders,
            ]); 
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function paystackPayments(Request $req)
    {
        try{ 
            $id = $req->get('id');
            $payments = PaystackPaymentSeller::where('seller_id',$id)->orderBy('created_at','desc')->select(['transaction_id','reference','total','currency_en','currency_ar','paid_at'])->paginate(10);
            return Helper::return([
                'payments'               => $payments,
            ]); 
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function wallet(Request $req)
    {
        try{ 
            $id = $req->get('id');
            $payments = SellerWallet::where('seller_id',$id)->orderBy('created_at','desc')->select(['transaction_id','transaction_desc','type','amount','open_balance','close_balance','created_at'])->paginate(10);
            return Helper::return([
                'payments'               => $payments,
            ]); 
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function viewOrderDetails(Request $req)
    {
        try{
        $uniqueID           = $req->get('uniqueID');
        $booking_id         = $req->get('booking_id');
        $where = array(
            'booking_id' => $booking_id,
            'uniqueID' => $uniqueID
        );
        $model = DelieveryMongo::where($where);
        $model_select = $model->first(['payment','delievery_us','total','d_address','d_latitude','d_longitude','products','user_mobile','desc','products_view','status','created_at']);
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        return Helper::return([
            'request'   => $model_select,
            'image_url' => env('APP_URL')
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function viewProductsDetails(Request $req)
    { 
        try{
        $uniqueID           = $req->get('uniqueID');
        $booking_id         = $req->get('booking_id');
        $where = array(
            'booking_id' => $booking_id,
            'uniqueID' => $uniqueID
        );
        $model = DelieveryMongo::where($where);
        $model_select = $model->select('products')->first();
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $products_id = array();
        foreach($model_select->products as $product){
            $products_id[] = $product['product_id'];
        }   
        $tatxProduct = tatxProduct::whereIn('_id',$products_id)->get();
        $products = array();
        $i = 0;
        foreach($model_select->products as $product){
            $Helper = new Helper();
            $Helper->note           = $product['note'];
            $Helper->options_reply  = $product['options_reply'];
            $Helper->qty            = $product['qty'];
            $Helper->product        = $tatxProduct[$i];
            $products[] = $Helper;
            $i++;
        }
        return Helper::return([
            'products'   => $products
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function viewProviderDetails(Request $req)
    { 
        try{
        $provider_id         = $req->get('provider_id');
        $model = Provider::select('first_name','last_name','mobile','avatar','latitude','longitude')->find($provider_id);
        if(!$model)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        
        return Helper::return([
            'provider'   => $model
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function getCancelReasons(Request $req)
    { 
        try{
        $model = new CancelReason();
        $model_select = $model->get();
        return Helper::return([
            'reasons'   => $model_select,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function subMain_filters(Request $req)
    {
        try{
        $module   = $req->get('seller_module');
        $uniqueID = $req->get('uniqueID');
        $model = new SubMainFilters();
        $where = array(
            ['conditions',[]],
            ['status','ON'],
            ['module', $module ]
        );
        $model_select = $model::where($where)->get();
        $data = array();
        foreach($model_select as $row){
            $Helper = new Helper();
            $Helper->_id      = $row->_id;
            $Helper->icon     = $row->icon;
            $Helper->name_en  = $row->name_en;
            $Helper->name_ar  = $row->name_ar;
            if(in_array($uniqueID, $row['uniqueIDs']))
                $Helper->is_subscribe  = true;
            else $Helper->is_subscribe  = false;
            $data[] = $Helper;
        }
        return Helper::return([
            'filters'   => $data,
            'image_url' => env('APP_URL')
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
}
