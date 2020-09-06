<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Admin;
use App\Models\Provider;
use App\Models\UserRequest;
use App\Models\UserRequestPayment;
use App\Models\Markerter;
use App\Models\Promocode;
use App\Models\Document;
use App\Models\serviceType;
use App\Models\Setting;
use App\Models\ProviderDocument;
use App\Models\ProviderService;
use App\Models\categorySearch;
use App\Models\wordSearch;
use App\Models\Order;
use App\Models\OrdersMongo;
use App\Models\DelieveryMongo;
use App\Models\Category;
use App\Models\UserMongo;
use App\Models\mainMongo;
use App\Models\Seller;
use App\Models\Manager;
use App\Models\SubMainFilters;
use App\Models\Module;
use App\Models\Rules;
use App\Models\UserWallet;
use App\Models\ProviderWallet;
use App\Models\MarketerWallet;
use App\Models\Ad;
use App\Models\Offer;
use App\Models\tatxProduct;

use App\Helper;
use Exception;
use DB;
use validate;

class adminViewController extends Controller
{
    public function dashboard()
    {
        try{
        $User                   = User::count();
        $Provider               = Provider::where('provider_status','Online')->count();
        $UserRequest            = new UserRequest();//::get();
        $total_income           = UserRequestPayment::sum('total');
        $BestPriceUserRequest   = $UserRequest->where('is_best_price','YES')->count();
        $CompletedUserRequest   = $UserRequest->where('status','COMPLETED')->count();
        $CancelledUserRequest   = $UserRequest->where('status','CANCELLED')->count();
        $ScheduledUserRequest   = $UserRequest->where('status','SCHEDULED')->count();
        $select = array(
            'user_requests.booking_id',
            'user_requests.created_at',
            'user_requests.status',
            'users.first_name as user_first_name',
            'users.last_name as user_last_name',
            'users.mobile as user_mobile',
            'providers.first_name as provider_first_name',
            'providers.last_name as provider_last_name',
            'providers.mobile as provider_mobile'
        );
        $Orders = UserRequest::join('users','user_requests.user_id','users.id')->join('providers','user_requests.provider_id','providers.id')->select($select)->get();
        return Helper::return([
            'current_orders'        =>  $UserRequest->count(),
            'online_users'          =>  $User,
            'online_providers'      =>  $Provider,
            'total_income'          =>  round($total_income),
            'completed_orders'      =>  $CompletedUserRequest,
            'best_price_orders'     =>  $BestPriceUserRequest,
            'canceled_orders'       =>  $CancelledUserRequest,
            'scheduled_orders'      =>  $ScheduledUserRequest,
            'orders'                =>  $Orders,
        ]);
    }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function orders()
    {
      try{
        $select = array(
            'user_requests.booking_id',
            'user_requests.created_at',
            'user_requests.status',
            'user_requests.payment_mode',
            'user_requests.schedule_at',
            'user_requests.is_best_price',
            'user_requests.cancelled_by',
            'user_requests.cancel_reason',
            'users.first_name as user_first_name',
            'users.last_name as user_last_name',
            'users.mobile as user_mobile',
            'providers.first_name as provider_first_name',
            'providers.last_name as provider_last_name',
            'providers.mobile as provider_mobile'
        );
        $Orders = UserRequest::where('user_requests.status','!=','COMPLETED')->join('users','user_requests.user_id','users.id')->join('providers','user_requests.provider_id','providers.id')->select($select)->get();
        $select[] = 'user_request_payments.total';
        $Completed = UserRequest::where('user_requests.status','COMPLETED')->join('user_request_payments','user_requests.id','user_request_payments.request_id')->join('users','user_requests.user_id','users.id')->join('providers','user_requests.provider_id','providers.id')->select($select)->get();
        $Current_count = 0;
        $Completed_count = 0;
        $Scheduled_count= 0;
        $Best_Price_count = 0;
        $Canceled_count = 0;
        $scheduled      = array();
        $canceled       = array();
        $best_price     = array();
        foreach($Orders as $Order) {
            if($Order->status == 'SCHEDULED'){
            $scheduled[]  =  $Order;
            $Scheduled_count++;
            }
            else if($Order->status == 'CANCELLED'){
            $canceled[]  =  $Order;
            $Canceled_count++;
            }
        }
        foreach($Completed as $Order) {
            if($Order->is_best_price == 'YES'){
            $best_price[]  =  $Order;
            $Best_Price_count++;
            }
        }
        $CurrentOrders = OrdersMongo::whereIn('status',['SEARCHING','ACCEPTED','STARTED'])->get();
        return Helper::return([
            'current_count'         =>  count($CurrentOrders),
            'completed_count'       =>  count($Completed),
            'scheduled_count'       =>  $Scheduled_count,
            'best_price_count'      =>  $Best_Price_count,
            'canceled_count'        =>  $Canceled_count,

            'current'               =>  $CurrentOrders,
            'completed'             =>  $Completed,
            'scheduled'             =>  $scheduled,
            'best_price'            =>  $best_price,
            'canceled'              =>  $canceled,
        ]);
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function delieveryOrders()
    {
      try{
        $Orders = DelieveryMongo::get();
        $current_count = 0;
        $completed_count = 0;
        $canceled_count = 0;
        $current    = array();
        $completed  = array();
        $canceled   = array();
        foreach($Orders as $Order) {
            if($Order->status == 'SEARCHING' || $Order->status == 'ACCEPTED' || $Order->status == 'STARTED'){
            $current[] = $Order;
            $current_count++;
            }
            else if($Order->status == 'COMPLETED'){
            $completed[] = $Order;
            $completed_count++;
            }
            else if($Order->status == 'CANCELLED'){
            $canceled[] = $Order;
            $canceled_count++;
            }
        }
        return Helper::return([
            'current'               =>  $current,
            'completed'             =>  $completed,
            'canceled'              =>  $canceled,
            'current_count'         =>  $current_count,
            'completed_count'       =>  $completed_count,
            'canceled_count'        =>  $canceled_count,
        ]);
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function categorySearch()
    {
        try{
            $categorySearch = categorySearch::orderBy('_id', 'DESC')->get();
            $Categories = Category::get();
            return Helper::return([
                'services'    => $categorySearch,
                'categories'  => $Categories
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function profile(Request $req)
    {
        try{
            $id = $req->get('admin_id');
            $model = Admin::where('id',$id)->first();

            return Helper::return([
                'profile'    => $model
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function wordSearch()
    {
        try{
            $wordSearch = wordSearch::orderBy('_id', 'DESC')->get();
            $Categories = Category::get();
            return Helper::return([
                'services'    => $wordSearch,
                'categories'  => $Categories
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function users()
    {
        try{
        $Users = User::get();
        $Orders = array();
        foreach($Users as $User){
            $UserRequests = UserRequest::where('user_id',$User->id);
            $COMPLETED = $UserRequests->where('status','COMPLETED')->count();
            $CANCELLED = $UserRequests->where('status','CANCELLED')->count();

            $Order = new Order();
            $Order->user_id             = $User->id ;
            $Order->user_first_name     = $User->first_name ;
            $Order->user_last_name      = $User->last_name ;
            $Order->user_mobile         = $User->mobile ;
            $Order->user_wallet_balance = $User->wallet_balance ;
            $Order->user_status         = $User->status ;
            $Order->Completed_Orders    = $COMPLETED ;
            $Order->Canceled_Orders     = $CANCELLED ;
            $Orders[] = $Order;
        }
        return Helper::return([
            'orders'                =>  $Orders,
        ]);
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function providers()
    {
        try{
        $Providers = Provider::get();
        $Orders = array();
        foreach($Providers as $Provider){
            $UserRequests = UserRequest::where('provider_id',$Provider->id)->get();
            $COMPLETED = $UserRequests->where('status','COMPLETED')->count();
            $CANCELLED = $UserRequests->where('status','CANCELLED')->count();

            $Order = new Order();
            $Order->provider_id             = $Provider->id ;
            $Order->provider_first_name     = $Provider->first_name ;
            $Order->provider_last_name      = $Provider->last_name ;
            $Order->provider_mobile         = $Provider->mobile ;
            $Order->provider_wallet_balance = $Provider->wallet_balance ;
            $Order->provider_rate           = $Provider->rating ;
            $Order->provider_status         = $Provider->status ;
            $Order->provider_online         = $Provider->provider_status ;
            $Order->Completed_Orders        = $COMPLETED ;
            $Order->Canceled_Orders         = $CANCELLED ;
            $Orders[] = $Order;
        }
        return Helper::return([
            'orders'                =>  $Orders,
        ]);
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function chats()
    {
        try{
            return view('Admin.chats');
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function clients()
    {
        try{
            $Users = UserMongo::get();
            return Helper::return([
                'users'     =>  $Users
            ]);
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function partners()
    {
        try{
        $Markerters = Markerter::get();
        $Orders = array();
        foreach($Markerters as $Markerter){
            $UserRequests = Promocode::where('promo_code',$Markerter->code)->join('user_requests','promocodes.id','user_requests.promocode_id')->select('promocodes.status','user_requests.id')->get();
            $Promocode =  Promocode::where('promo_code',$Markerter->code)->first();
            $Order = new Order();
            $Order->markerter_id                = $Markerter->id ;
            $Order->markerter_name              = $Markerter->name ;
            $Order->markerter_code              = $Markerter->code ;
            $Order->customer_discount           = ($Promocode)?$Promocode->percentage:0 ;
            $Order->markerter_commission_per    = $Markerter->commission_per ;
            $Order->markerter_commission        = $Markerter->commission ;
            $Order->markerter_mobile            = $Markerter->mobile ;
            $Order->markerter_wallet_balance    = $Markerter->wallet_balance ;
            $Order->markerter_status            = $Markerter->status ;
            $Order->markerter_orders            = count($UserRequests) ;
            $Orders[] = $Order;
        }
        return Helper::return([
            'orders'                =>  $Orders,
        ]);
        }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
      }
    }
    public function documents()
    {
        try{
            $Documents = Document::get();
            return Helper::return([
                'documents'    => $Documents
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function services()
    {
        try{
            $Services = serviceType::get();
            return Helper::return([
                'services'    => $Services,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function ads()
    {
        try{
            $model = Ad::get();
            return Helper::return([
                'ads'    => $model,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function offers()
    {
        try{
            $model = Offer::paginate(10);
            return Helper::return([
                'offers'    => $model,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function offers_search(Request $req)
    {
        try{
            $req->validate([
                'offer_by'    => 'required|string|in:CATEGORY,SELLER,PRODUCT',
                'search'      => 'required|string|max:200',
            ]);
            $offer_by = $req->get('offer_by');
            $search   = $req->get('search');
            $lang = $req->header('language');
            $where = array();
            $where[] = ['status','ON'];
            switch ($offer_by) {
                case 'CATEGORY':
                    $col = ($lang == 'ar')? 'name_ar' : 'name_en';
                    $where[] = [$col,'LIKE',"%{$search}%"];
                    $collection = SubMainFilters::where($where)->select('_id',$col)->limit(5)->get();
                    $model_data = $collection->transform(function ($value) use ($col){
                    $map['id']     = $value['_id'];
                    $map['name']   = $value[$col];
                    return $map;
                    });
                    break;
                case 'SELLER':
                    $col = ($lang == 'ar')? 'name_ar' : 'name_en';
                    $where[] = [$col,'LIKE',"%{$search}%"];
                    $collection = Seller::where($where)->select('id',$col)->limit(5)->get();
                    $model_data = $collection->transform(function ($value) use ($col){
                    $map['id']     = $value['id'];
                    $map['name']   = $value[$col];
                    return $map;
                    });
                    break;
                case 'PRODUCT':
                    $col = "{$lang}.name";
                    $seller = "{$lang}.seller";
                    $where[] = [$col,'LIKE',"%{$search}%"];
                    $collection = tatxProduct::where($where)->select('_id',$col,$seller)->limit(5)->get();
                    $model_data = $collection->transform(function ($value) use ($col,$seller){
                    $map['id']     = $value['_id'];
                    $map['name']   = $value[$col];
                    $map['seller'] = $value[$seller];
                    return $map;
                    });
                    break;
            }
            $model = Offer::get();
            return Helper::return([
                'data'    => $model_data
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function categories()
    {
        try{
            $categories = Category::orderBy('_id','DESC')->get();
            return Helper::return([
                'categories'    => $categories
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function subMain_filters()
    {
        try{
            $SubMainFilters = SubMainFilters::orderBy('_id','DESC')->get();
            return Helper::return([
                'filters'    => $SubMainFilters
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function promocodes()
    {
        try{
            $PromocodeData = Promocode::join('markerters','promocodes.promo_code','markerters.code')->select('promocodes.*','promocodes.id as ID','markerters.*')->get();
            foreach($PromocodeData as $Promocode){
                $Count = count(UserRequest::where('promocode_id',$Promocode->ID)->get());
                $Promocodes = new Promocode();
                $Promocodes->promo_code     = $Promocode->promo_code ;
                $Promocodes->name           = $Promocode->name ;
                $Promocodes->mobile         = $Promocode->mobile ;
                $Promocodes->image          = $Promocode->logo ;
                $Promocodes->percentage     = $Promocode->percentage ;
                $Promocodes->max_amount     = $Promocode->max_amount ;
                $Promocodes->expiration     = $Promocode->expiration ;
                $Promocodes->status         = $Promocode->status ;
                $Promocodes->used           = $Count ;
                $Promocodes->id             = $Promocode->ID;
                $PromocodesArr[] = $Promocodes;
            }
            return Helper::return([
                'promocodes'    => $PromocodesArr,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function payroll()
    {
        try{
            return Helper::return([
                'promocodes'    => 'sdcsdc'
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function settings()
    {
        try{
            $Settings = Setting::get();
            return Helper::return([
                'settings'    => $Settings
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function main()
    {
        try{
            $main = mainMongo::get();
            return Helper::return([
                'main'    => $main,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function sellers()
    {
        try{
            $Seller = Seller::get();
            return Helper::return([
                'sellers'   => $Seller,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function select_sellers(Request $req)
    {
        try{
            $req->validate([
                'manager_id'    => 'required|numeric|exists:managers,id'
            ]);
            $where = array(
                'manager_id'    => (int)$req->get('manager_id')
            );
            $Seller = Seller::where($where)->orWhere('manager_id',NULL)->get(['id','name_en','name_ar','manager_id']);
            return Helper::return([
                'sellers'   => $Seller,
            ]);
        }catch(Exception $e){
            if($e instanceof ValidationException) {
             throw $e;
            }
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function managers()
    {
        try{
            $managers = Manager::get(['id','first_name','last_name','mobile','email','mobile','commision_per','status','company_name','company_register_no','company_register_date','contract']);
            return Helper::return([
                'image_url' => env('APP_URL'),
                'managers'   => $managers
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function payments(Request $req)
    {
        try{
            $req->validate([
                'type'  => 'required|in:SELLER,DRIVERS'
            ]);
            $type = $req->get('type');
            switch ($type) {
                case 'SELLER':
                    $model = new Seller();
                    $select = array('id','image','name_en','name_ar','module','wallet_balance','email','status');
                    break;
                case 'DRIVERS':
                    $model = new Provider();
                    $select = array('id','avatar','first_name','last_name','wallet_balance','email','status');
                    break;
            }
            $where = array(
                ['wallet_balance','>',0]
            );
            $model_select = $model->where($where)->get($select);
            return Helper::return([
                'payments'   => $model_select,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function payments_total(Request $req)
    {
        try{
            $where = array(
                ['wallet_balance','>',0]
            );
            $provider = Provider::where($where);
            $seller   = Seller::where($where)->get();

            $driver_total      = $provider->sum('wallet_balance');
            $restaurant_total  = $seller->where('type','restaurant')->sum('wallet_balance');
            $supermarket_total = $seller->where('type','supermarket')->sum('wallet_balance');

            return Helper::return([
                'driver_total'       => $driver_total,
                'restaurant_total'   => $restaurant_total,
                'supermarket_total'  => $supermarket_total,
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function uniqueID()
    {
        try{
            $Seller = Seller::where('status','ON')->select('name_en','uniqueID')->get();
            return Helper::return([
                'sellers'   => $Seller
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function wallet(Request $req)
    {
        try{
            $req->validate([
                'type'  => 'required|in:USER,PROVIDER,PARTNER'

            ]);
            $type = $req->get('type');
            $id   = $req->get('id');
            switch ($type) {
                case 'USER':
                    $req->validate([
                        'id'  => 'required|exists:users'
                    ]);
                    $model = new UserWallet();
                    $col = 'user_id';
                    break;
                case 'PROVIDER':
                    $req->validate([
                        'id'  => 'required|exists:providers'
                    ]);
                    $model = new ProviderWallet();
                    $col = 'provider_id';
                    break;
                case 'PARTNER':
                    $req->validate([
                        'id'  => 'required|exists:markerters'
                    ]);
                    $model = new MarketerWallet();
                    $col = 'marketer_id';
                    break;
            }
            $select = array('transaction_id','type','amount','open_balance','close_balance','created_at');
            $model_wallet = $model::where($col,$id)->orderBy('id','DESC')->select($select)->paginate(10);
            return Helper::return([
                'wallet'   => $model_wallet
            ]);
        }catch(Exception $e){
            if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
        }
    }
    public function modules()
    {
        try{
            $Modules = Module::get();
            return Helper::return([
                'modules'   => $Modules
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function rules()
    {
        try{
            $rules = Rules::get();
            return Helper::return([
                'rules'   => $rules
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function getProvider($id)
    {
        try{
            $Provider = Provider::where('id',$id)->first();
            if(!$Provider)
                return "This Provider Not Found";
            $Orders_model = UserRequest::where('provider_id',$id);
            $Orders       = $Orders_model->get();
            $ProviderDocuments = ProviderDocument::where('provider_id',$id)->join('documents','provider_documents.document_id','documents.id')
            ->select('provider_documents.*','documents.name as doc_name')->get();
            $COMPLETED  = $Orders_model->where('status','COMPLETED')->count();
            $SCHEDULED  = $Orders_model->where('status','COMPLETED')->count();
            $CANCELLED  = $Orders_model->where('status','COMPLETED')->count();
            $services = serviceType::where(array(
                'status'  => 1
            ))->get();
            $serviceType = array();
            $serviceTypeSmart = array();
            foreach($services as $service){
                if($service->type == 'SMART'){
                    $Order = new Order();
                    $Order->id          = $service->id;
                    $Order->name        = $service->name;
                    $CHKService = ProviderService::where(array(
                        'provider_id'       => $Provider->id,
                        'service_type_id'   => $service->id,
                    ))->first();
                    ($CHKService)? $Order->status = $CHKService->status : $Order->status = 'OFF' ;
                    $serviceTypeSmart[] = $Order;
                }
                else $serviceType[] =  $service;
            }
            $ProviderService = ProviderService::where('provider_id',$id)->join('service_types','provider_services.service_type_id','service_types.id')->select('service_types.name')->get();
            return Helper::return([
                'provider'          =>  $Provider ,
                'provider_documents' =>  $ProviderDocuments,
                'completed'         =>  $COMPLETED ,
                'scheduled'         =>  $SCHEDULED ,
                'canceled'         =>  $CANCELLED ,
                'service_type'      =>  $serviceType,
                'service_type_smart'  =>  $serviceTypeSmart,
                'provider_id'       =>  $Provider->id,
                'provider_service'   =>  $ProviderService,
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
}
