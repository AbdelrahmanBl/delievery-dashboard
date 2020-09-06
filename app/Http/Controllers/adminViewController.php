<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use App\Models\UserRequest;
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
use Exception;
use DB;

class adminViewController extends Controller
{
    public function __construct()
    { 
        $this->middleware('guest:admin');
    } 
    public function dashboard()
    {
    	try{
    	$User 					= User::get();
    	$Provider 				= Provider::where('provider_status','Online')->get();
    	$UserRequest 			= UserRequest::get();
    	$CompletedUserRequest	= 0;
    	$BestPriceUserRequest	= 0;
    	$CancelledUserRequest	= 0;
    	$ScheduledUserRequest	= 0;
    	foreach( $UserRequest as $Request ){
    		if($Request->status == 'COMPLETED')
    			$CompletedUserRequest++;
    		else if($Request->status == 'CANCELLED')
    			$CancelledUserRequest++;
    		else if($Request->status == 'SCHEDULED')
    			$ScheduledUserRequest++;
    		if($Request->is_best_price == 'YES')	
    			$BestPriceUserRequest++;	
    	}
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
    	return view('Admin.dashboard')->with([
    		'CurrentOrders'   		=>  count($UserRequest),
    		'Online_Users'			=>  count($User),
    		'Online_Providers'		=>  count($Provider),
    		'Total_Income'			=>  20,
    		'Completed_Orders'		=>  $CompletedUserRequest,
    		'Best_Price_Orders'		=>  $BestPriceUserRequest,
    		'Canceled_Orders'		=>  $CancelledUserRequest,
    		'Scheduled_Orders'		=>  $ScheduledUserRequest,
    		'Orders' 				=>  $Orders,
    	]);
    }catch(Exception $e){
    	return $e->getMessage();
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
        foreach($Orders as $Order) {
            if($Order->status == 'SEARCHING' || $Order->status == 'ACCEPTED' || $Order->status == 'STARTED')
            $Current_count++;
            else if($Order->status == 'SCHEDULED')
            $Scheduled_count++;   
            else if($Order->status == 'CANCELLED')
            $Canceled_count++;    
        }
        foreach($Completed as $Order) {
            if($Order->is_best_price == 'YES')
            $Best_Price_count++; 
        }
        $CurrentOrders = OrdersMongo::whereIn('status',['SEARCHING','ACCEPTED','STARTED'])->get();
        return view('Admin.orders')->with([
            'CurrentOrders'         =>  $CurrentOrders,
            'Orders'                =>  $Orders,
            'Completed'             =>  $Completed,
            'Current_count'         =>  $Current_count,
            'Completed_count'       =>  count($Completed),
            'Scheduled_count'       =>  $Scheduled_count,
            'Best_Price_count'      =>  $Best_Price_count,
            'Canceled_count'        =>  $Canceled_count,
        ]);
        }catch(Exception $e){
        return $e->getMessage();
      }
    }
    public function delieveryOrders()
    {
      try{
        $Orders = DelieveryMongo::get();
        $Current_count = 0;
        $Completed_count = 0;
        $Canceled_count = 0;
        foreach($Orders as $Order) {
            if($Order->status == 'SEARCHING' || $Order->status == 'ACCEPTED' || $Order->status == 'STARTED')
            $Current_count++;   
            else if($Order->status == 'COMPLETED')
            $Completed_count++;    
            else if($Order->status == 'CANCELLED')
            $Canceled_count++;    
        }
        return view('Admin.delievery_orders')->with([
            'Orders'                =>  $Orders,
            'Current_count'         =>  $Current_count,
            'Completed_count'       =>  $Completed_count,
            'Canceled_count'        =>  $Canceled_count,
        ]);
        }catch(Exception $e){
        return $e->getMessage();
      } 
    }
    public function categorySearch()
    {
        try{
            $categorySearch = categorySearch::orderBy('_id', 'DESC')->get();
            $Categories = Category::get();
            return view('Admin.categorySearch')->with([
                'Services'    => $categorySearch,
                'Categories'  => $Categories
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function wordSearch()
    {
        try{
            $wordSearch = wordSearch::orderBy('_id', 'DESC')->get();
            $Categories = Category::get();
            return view('Admin.wordSearch')->with([
                'Services'    => $wordSearch,
                'Categories'  => $Categories
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function users()
    {
    	try{
    	$Users = User::get();
    	$Orders = array();
    	foreach($Users as $User){
    		$UserRequests = UserRequest::where('user_id',$User->id)->get();
    		$COMPLETED = 0;
    		$CANCELLED = 0;
    		foreach($UserRequests as $UserRequest){
    			if($UserRequest->status == 'COMPLETED')
    				$COMPLETED++;
    			else if($UserRequest->status == 'CANCELLED')
    				$CANCELLED++;
    		}
    		$Order = new Order();
            $Order->user_id             = $User->id ;
    		$Order->user_first_name    	= $User->first_name ;
    		$Order->user_last_name    	= $User->last_name ;
    		$Order->user_mobile    		= $User->mobile ;
    		$Order->user_wallet_balance = $User->wallet_balance ;
    		$Order->Completed_Orders    = $COMPLETED ;
    		$Order->Canceled_Orders     = $CANCELLED ;
    		$Orders[] = $Order;
    	}
    	return view('Admin.users')->with([
    		'Orders' 				=>  $Orders,
    	]);
    	}catch(Exception $e){
    	return $e->getMessage();
      }
    }
    public function providers()
    {
    	try{
    	$Providers = Provider::get();
    	$Orders = array();
    	foreach($Providers as $Provider){
    		$UserRequests = UserRequest::where('provider_id',$Provider->id)->get();
    		$COMPLETED = 0;
    		$CANCELLED = 0;
    		foreach($UserRequests as $UserRequest){
    			if($UserRequest->status == 'COMPLETED')
    				$COMPLETED++;
    			else if($UserRequest->status == 'CANCELLED')
    				$CANCELLED++;
    		}
    		$Order = new Order();
            $Order->provider_id             = $Provider->id ;
    		$Order->provider_first_name    	= $Provider->first_name ;
    		$Order->provider_last_name    	= $Provider->last_name ;
    		$Order->provider_mobile    		= $Provider->mobile ;
    		$Order->provider_wallet_balance = $Provider->wallet_balance ;
    		$Order->provider_rate 			= $Provider->rating ;
    		$Order->provider_status			= $Provider->status ;
    		$Order->provider_online			= $Provider->provider_status ;
    		$Order->Completed_Orders    	= $COMPLETED ;
    		$Order->Canceled_Orders     	= $CANCELLED ;
    		$Orders[] = $Order;
    	}
    	return view('Admin.providers')->with([
    		'Orders' 				=>  $Orders,
    	]);
    	}catch(Exception $e){
    	return $e->getMessage();
      }
    }
    public function chats()
    {
        try{
            return view('Admin.chats');
        }catch(Exception $e){
        return $e->getMessage();
      }
    }
    public function clients()
    {
        try{
            $Users = UserMongo::get();
            return view('Admin.clients')->with([
                'Users'     =>  $Users
            ]);
        }catch(Exception $e){
        return $e->getMessage();
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
    		$Order->markerter_name    			= $Markerter->name ;
    		$Order->markerter_code    			= $Markerter->code ;
            $Order->customer_discount           = ($Promocode)?$Promocode->percentage:0 ;
    		$Order->markerter_commission_per    = $Markerter->commission_per ;
    		$Order->markerter_commission        = $Markerter->commission ;
    		$Order->markerter_mobile    		= $Markerter->mobile ;
    		$Order->markerter_wallet_balance 	= $Markerter->wallet_balance ;
    		$Order->markerter_orders 			= count($UserRequests) ;
    		$Order->markerter_status 			= ($Promocode)?$Promocode->status:'NOT FOUND';
    		$Orders[] = $Order;
    	}
    	return view('Admin.partners')->with([
    		'Orders' 				=>  $Orders,
    	]);
    	}catch(Exception $e){
    	return $e->getMessage();
      }
    }
    public function documents()
    {
        try{
            $Documents = Document::get();
            return view('Admin.documents')->with([
                'Documents'    => $Documents
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function services()
    {
        try{
            $Services = serviceType::get();
            return view('Admin.services')->with([
                'Services'    => $Services
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function categories()
    {
        try{
            $categories = Category::orderBy('_id','DESC')->get();
            return view('Admin.categories')->with([
                'Services'    => $categories
            ]);
        }catch(Exception $e){
            return $e->getMessage();
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
            return view('Admin.promocodes')->with([
                'Promocodes'    => $PromocodesArr
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function payroll()
    {
        try{
            return view('Admin.payroll')->with([
                'Promocodes'    => 'sdcsdc'
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function settings()
    {
        try{
            $Settings = Setting::get();
            return view('Admin.settings')->with([
                'Settings'    => $Settings
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function getProvider($id)
    {
        try{
            $Provider = Provider::where('id',$id)->first();
			if(!$Provider)
                return "This Provider Not Found";
			$Orders = UserRequest::where('provider_id',$id)->get();
			$ProviderDocuments = ProviderDocument::where('provider_id',$id)->join('documents','provider_documents.document_id','documents.id')
			->select('provider_documents.*','documents.name as doc_name')->get();
			$COMPLETED  = 0;
            $SCHEDULED  = 0;
			$CANCELLED  = 0;
			$services = serviceType::where(array(
				'status'  => 1
			))->get();
			$serviceType = array();
			$serviceTypeSmart = array();
			foreach($services as $service){
				if($service->type == 'SMART'){
					$Order = new Order();
					$Order->id			= $service->id;
					$Order->name		= $service->name;
					$CHKService = ProviderService::where(array(
						'provider_id'		=> $Provider->id, 
						'service_type_id'	=> $service->id,
					))->first();
					($CHKService)? $Order->status = $CHKService->status : $Order->status = 'OFF' ;
					$serviceTypeSmart[] = $Order;
				}
				else $serviceType[] =  $service;
			}
            foreach( $Orders as $Order ){
                if($Order->status == 'SCHEDULED')
                    $SCHEDULED++;
                else if($Order->status == 'CANCELLED')
                    $CANCELLED++;
                else if($Order->status == 'COMPLETED')
                    $COMPLETED++;
            }
            $ProviderService = ProviderService::where('provider_id',$id)->join('service_types','provider_services.service_type_id','service_types.id')->select('service_types.name')->get();
            return view('Admin.providerInfo')->with([
                'Provider'          =>  $Provider ,
                'ProviderDocuments' =>  $ProviderDocuments,
                'COMPLETED'         =>  $COMPLETED ,
                'SCHEDULED'         =>  $SCHEDULED ,
				'CANCELLED'         =>  $CANCELLED ,
				'serviceType' 		=>  $serviceType,
				'serviceTypeSmart'  =>  $serviceTypeSmart,
				'provider_id' 		=>  $Provider->id,
                'ProviderService'   =>  $ProviderService,
            ]);
        }catch(Exception $e){
            return $e->getMessage();
        }
	}
}
