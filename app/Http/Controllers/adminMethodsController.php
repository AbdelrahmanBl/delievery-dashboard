<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ProviderDocument;
use App\Models\serviceType;
use App\Models\ProviderService;
use App\Models\Promocode;
use App\Models\Setting;
use App\Models\Provider;
use App\Models\UserWallet;
use App\Models\ProviderWallet;
use App\Models\MarketerWallet;
use App\Models\UserRequestPayment;
use App\Models\categorySearch;
use App\Models\wordSearch;
use App\Models\Category;
use App\Models\DelieveryMongo;
use App\Models\Markerter;

use Auth;
use validate;
use Validator;
use Exception;
use Artisan;

class adminMethodsController extends Controller
{
    public function __construct()
    { 
        $this->middleware('guest:admin');
    }
    public function addDoc(Request $req)
    {
    	$validator = Validator::make($req->all(),[
			'service_name'		=> 'required|string|max:30',
			'service_type'		=> 'required|in:DRIVER,VEHICLE',
			]);
    	if(!$validator->passes())
    	return [
    		'status'    => 1,
    		'error'		=> $validator->errors()->first(),
    	];
    	$service_name   = $req->service_name;
    	$service_type   = $req->service_type;
    	$Document = new Document([
    		'name'		=>	$service_name,
    		'type'		=>	$service_type,
    	]);
    	$Document->save();
    	return [
    		'status'    => 0,
    		'result'	=> 'Document Added Successfully',
    		'id'        => $Document->id
    	];
    }
    public function deleteDoc(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:documents',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        Document::where('id',$id)->delete();
        return [
            'status'    => 0,
            'result'    => 'Document Deleted Successfully',
        ];
    }
    public function deleteService(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:service_types',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        $status = serviceType::where('id',$id)->first()->status;
        if($status == 1){
        serviceType::where('id',$id)->update([
            'status'    => 0
        ]);
        return [
            'status'    => 0,
            'result'    => 'LOCKED',
        ];
    }else{
            serviceType::where('id',$id)->update([
            'status'    => 1
        ]);
        return [
            'status'    => 0,
            'result'    => 'AVAILABLE',
        ];
        }
    }catch(Exception $e){
        return $e->getMessage();
    }
    }
    public function updateMarkerterStatus(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:markerters',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        $status = Markerter::where('id',$id)->first()->status;
        
        if($status == 1){
        serviceType::where('id',$id)->update([
            'status'    => 0
        ]);
        return [
            'status'    => 0,
            'result'    => 'LOCKED',
        ];
    }else{
            serviceType::where('id',$id)->update([
            'status'    => 1
        ]);
        return [
            'status'    => 0,
            'result'    => 'AVAILABLE',
        ];
        }
    }catch(Exception $e){
        return ['error' => $e->getMessage()];
    }
    }
    public function deletePromocode(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:promocodes',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        $status = Promocode::where('id',$id)->first()->status;
        if($status == 'ADDED'){
        Promocode::where('id',$id)->update([
            'status'    => 'APPROVED'
        ]);
        return [
            'status'    => 0,
            'result'    => 'APPROVED',
        ];
        }else{
            Promocode::where('id',$id)->update([
            'status'    => 'ADDED'
        ]);
        return [
            'status'    => 0,
            'result'    => 'ADDED',
        ];
        }
    }catch(Exception $e){
        return $e->getMessage();
    }
    }
    public function addSetting(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'key'        => 'required|string|max:30',
            'value'      => 'required|string|max:255',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $key        = $req->key;
        $value      = $req->value;
        $Setting = new Setting([
            'key'        =>  $key,
            'value'      =>  $value,
        ]);
        $Setting->save();
        return [
            'status'    => 0,
            'result'    => 'Document Added Successfully',
            'id'        => $Setting->id
        ];
    }
    public function deleteSetting(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:settings',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        Setting::where('id',$id)->delete();
        return [
            'status'    => 0,
            'result'    => 'Document Deleted Successfully',
        ];
    }catch(Exception $e){
        return $e->getMessage();
    }
    }
    public function addService(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'image'             => 'required|mimes:jpeg,png,jpg|max:2000',
            'type'              => 'required|in:DRIVER,VEHICLE',
            'name'              => 'required|string|max:30',
            'description'       => 'required|string|max:50',
            'price_fixed'       => 'required|numeric|between:0,9999',
            'price_distance'    => 'required|numeric|between:0,99.99',
            'price_minute'      => 'required|numeric|between:0,99.99',
            'capacity'          => 'required|numeric|between:0,9',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $image              =   $req->file('image');
        $imageName          =   Auth::guard('admin')->user()->id . time() .'.'.$image->getClientOriginalExtension();
        $destinationPath    =   "documents/serviceTypes";
        $url                =   $destinationPath . '/' . $imageName;
        
        $my_array              = $req->except(['image','_token']);
        $my_array['image']     = $url;
        $serviceType = new serviceType($my_array);
        $serviceType->save();
        $image->move($destinationPath, $imageName);
        return [
            'status'    => 0,
            'result'    => 'Service Added Successfully',
            'id'        => $serviceType->id
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function deleteProviderDocument(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'id'        => 'required|exists:provider_documents',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $id   = $req->id;
            $status = ProviderDocument::where('id',$id)->first()->status;
            
            if($status == 'ACTIVE'){
                ProviderDocument::where('id',$id)->update([
                'status'    => 'ASSESSING'
                ]);
                return [
                    'status'    => 0,
                    'result'    => 'ASSESSING',
                ];
            }else{
                ProviderDocument::where('id',$id)->update([
                    'status'    => 'ACTIVE'
                ]);
                return [
                    'status'    => 0,
                    'result'    => 'ACTIVE',
                ];
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function changeSmartService(Request $req)
	{
		try{
            $validator = Validator::make($req->all(),[
                'provider_id'        => 'required',
                'service_id'         => 'required',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $provider_id   = $req->provider_id;
            $service_id    = $req->service_id;
            $ProviderService = ProviderService::where(array(
                'provider_id'        => $provider_id,
                'service_type_id'    => $service_id
            ))->first();
            if($ProviderService){
                if($ProviderService->status == 'ON'){
                ProviderService::where(array(
                    'provider_id'        => $provider_id,
                    'service_type_id'    => $service_id,
                ))->update([
                    'status'   =>  'OFF'
                ]);
                return [
                    'status'    => 0,
                    'result'    => 'OFF',
                ];
            }
                else {
                ProviderService::where(array(
                    'provider_id'        => $provider_id,
                    'service_type_id'    => $service_id,
                ))->update([
                    'status'   => 'ON'
                ]);
            return [
                    'status'    => 0,
                    'result'    => 'ON',
                ]; 
            }
          }/* else{
            $ProviderService = new ProviderService([
                'status'   => 'ON'
            ]);
            $ProviderService->save();
        return [
                'status'    => 0,
                'result'    => 'ON',
            ];
          } */
          return [
            'status'    => 0,
            'result'     => 'OFF',
        ];
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function updateService(Request $req){
        try{
            $validator = Validator::make($req->all(),[
                'service_type_id'   => 'required',
                'provider_id'       => 'required',
                'service_model'     => 'required',
                'service_number'    => 'required|unique:provider_services',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $ProviderService = ProviderService::where( $req->all(['service_type_id','provider_id']) )->first();
            if($ProviderService)
            return [
                'status'    => 1,
                'error'     => 'This Service Is Exist To The User',
            ];
            $my_array              = $req->except(['_token']);
            $my_array['status']    = 'ON';
            $ProviderService = new ProviderService($my_array);
            $ProviderService->save();
          return [
            'status'    => 0,
            'result'    => 'UPDATED Successfully',
        ];
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function blockProvider(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'provider_id'   => 'required|exists:providers,id',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $Provider = Provider::where('id',$req->provider_id)->update([
                'status'    =>  'banned'
            ]);
          return [
            'status'    => 0,
            'result'    => 'UPDATED Successfully',
        ];
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function updateExpiry(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'id'           => 'required|exists:provider_documents',
                'expires_at'   => 'required|date|date_format:Y-m-d',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $Provider = ProviderDocument::where('id',$req->id)->update([
                'expires_at'    =>  $req->expires_at
            ]);
          return [
            'status'    => 0,
            'result'    => 'UPDATED Successfully',
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
    public function loadWalletUser(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'user_id'    => 'required|exists:user_wallets',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => 'There Is No Wallet To This User',
            ];
            $User = UserWallet::where('user_id',$req->user_id)->get();
          return [
            'status'    => 0,
            'result'    => $User,
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
    public function loadWalletProvider(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'user_id'    => 'required|exists:provider_wallets,provider_id',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => 'There Is No Wallet To This User',
            ];
            $User = ProviderWallet::where('provider_id',$req->user_id)->get();
          return [
            'status'    => 0,
            'result'    => $User,
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
    public function loadWalletMarkerter(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'user_id'    => 'required|exists:marketer_wallets,marketer_id',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => 'There Is No Wallet To This User',
            ];
            $User = MarketerWallet::where('marketer_id',$req->user_id)->get();
          return [
            'status'    => 0,
            'result'    => $User,
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
    public function approveProvider(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'provider_id'    => 'required|exists:providers,id|exists:provider_documents',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => 'There Is No Documents For This User',
            ];
            $provider_id = $req->provider_id;
            $ProviderService = ProviderService::where(array(
                'provider_id'     => $provider_id,
                'status'          => 'ON'
            ))->first();
        /*----------------------------------------------*/    
            if(!$ProviderService)
            return [
                'status'    => 1,
                'error'     => 'There Is No Provider Service For This User',
            ]; 
        /*----------------------------------------------*/       
            $allDocs        = count(Document::get());
            $providerDocs   = count(ProviderDocument::where(array(
                'provider_id'     => $provider_id,
                'status'          => 'ACTIVE'
            ))->get());
            if($allDocs != $providerDocs)
            return [
                'status'    => 1,
                'error'     => 'Documents Is Not Approved',
            ];
        /*----------------------------------------------*/
        Provider::where('id',$provider_id)->update([
            'status'    => 'approved'
        ]);
          return [
            'status'    => 0,
            'result'    => '',
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
    public function resetService(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'service_id'        => 'required|exists:service_types,id',
            'image'             => 'nullable|mimes:jpeg,png,jpg|max:2000',
            'type'              => 'required|in:DRIVER,VEHICLE',
            'name'              => 'required|string|max:30',
            // 'description'       => 'required|string|max:50',
            'price_fixed'       => 'required|numeric|between:0,9999',
            'price_distance'    => 'required|numeric|between:0,99.99',
            'price_minute'      => 'required|numeric|between:0,99.99',
            'capacity'          => 'required|numeric|between:0,9',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $image              =   $req->file('image');
        $imageName = NULL;
        if($image){
        $imageName          =   serviceType::where('id',$req->input('service_id'))->first()->image;
        $destinationPath    =   "documents/serviceTypes";
        // $url                =   $destinationPath . '/' . $imageName;
        // $my_array['image']     = $url;
        }
        $my_array              = $req->except(['image','_token','service_id']);
        $serviceType = serviceType::where('id',$req->input('service_id'))->update($my_array);
        if($image){
            $image->move($destinationPath, $imageName);
        }
        return [
            'status'    => 0,
            'result'    => 'Service Updated Successfully',
            'url'       =>  $imageName,
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function updatePromocode(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'promocode_id'    => 'required|exists:promocodes,id',
            'expiration'      => 'required|date|date_format:Y-m-d',
            'percentage'      => 'required|numeric|between:0,99.99',
            'max_amount'      => 'required|numeric|between:0,99999.99',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $my_array              = $req->except(['_token','promocode_id']);
        $serviceType = Promocode::where('id',$req->input('promocode_id'))->update($my_array);
        return [
            'status'    => 0,
            'result'    => 'Promocode Updated Successfully',
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function showInvoice(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'payment_id'    => 'required|exists:user_request_payments',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $invoice = UserRequestPayment::where('payment_id',$req->payment_id)->first();
          return [
            'status'    => 0,
            'result'    => $invoice,
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
    public function addCategorySearch(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'uniqueID'              => 'required|in:tamimi,carfour,panda,extra_stores,jarir_bookstore,virgin_megastore,nahdi_pharmacy,kunooz_pharmacy,aldawaa_pharmacy',
            'name'                  => 'required',
            'category_english'      => 'required',
            'sub_category_english'  => 'required',
            'category_arabic'       => 'required',
            'sub_category_arabic'   => 'required',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $CHK = categorySearch::where(array(
            'name'         => $req->input('name'),
            'uniqueID'     => $req->input('uniqueID')
        ))->first();
        if($CHK)
            return [
            'status'    => 1,
            'error'     => 'This Data Has Been Entered Before' ,
        ];
        categorySearch::insert([
            [
                'name'          => $req->input('name') ,
                'category'      => $req->input('category_english'),
                'sub_category'  => $req->input('sub_category_english'),
                'uniqueID'      => $req->input('uniqueID'),
                'language'      => 'en',
                'status'        => true,
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => $req->input('name') ,
                'category'      => $req->input('category_arabic'),
                'sub_category'  => $req->input('sub_category_arabic'),
                'uniqueID'      => $req->input('uniqueID'),
                'language'      => 'ar',
                'status'        => true,
                'created_at'    => date('Y-m-d H:i:s'),
            ]
        ]);        
        return [
            'status'    => 0,
            'result'    => 'Added Successfully',
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function deleteCategorySearch(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:mongodb.category_search,_id',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        $status = categorySearch::where('_id',$id)->first()->status;
        if($status == true){
        categorySearch::where('_id',$id)->update([
            'status'    => false
        ]);
        return [
            'status'    => 0,
            'result'    => 'OFF',
        ];
    }else{
            categorySearch::where('_id',$id)->update([
            'status'    => true
        ]);
        return [
            'status'    => 0,
            'result'    => 'ON',
        ];
        }
    }catch(Exception $e){
        return ['error' => $e->getMessage()];
    }
    }
    public function addWordSearch(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'nameEn'                => 'required|unique:mongodb.word_search,name',
            'category_english'      => 'required',
            'sub_category_english'  => 'required',
            'nameAr'                => 'required|unique:mongodb.word_search,name',
            'category_arabic'       => 'required',
            'sub_category_arabic'   => 'required',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        wordSearch::insert([
            [
                'name'          => $req->input('nameEn') ,
                'category'      => $req->input('category_english'),
                'sub_category'  => $req->input('sub_category_english'),
                'language'      => 'en',
                'status'        => true,
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name'          => $req->input('nameAr') ,
                'category'      => $req->input('category_arabic'),
                'sub_category'  => $req->input('sub_category_arabic'),
                'language'      => 'ar',
                'status'        => true,
                'created_at'    => date('Y-m-d H:i:s'),
            ]
        ]);        
        return [
            'status'    => 0,
            'result'    => 'Added Successfully',
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function deleteWordSearch(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'        => 'required|exists:mongodb.word_search,_id',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id   = $req->id;
        $status = wordSearch::where('_id',$id)->first()->status;
        if($status == true){
        wordSearch::where('_id',$id)->update([
            'status'    => false
        ]);
        return [
            'status'    => 0,
            'result'    => 'OFF',
        ];
    }else{
            wordSearch::where('_id',$id)->update([
            'status'    => true
        ]);
        return [
            'status'    => 0,
            'result'    => 'ON',
        ];
        }
    }catch(Exception $e){
        return ['error' => $e->getMessage()];
    }
    }
    public function addCategory(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'category_english'  => 'required|unique:mongodb.categories',
            'category_arabic'   => 'required|unique:mongodb.categories',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $Category = new Category();
        $Category->category_english   = $req->input('category_english');
        $Category->category_arabic    = $req->input('category_arabic');
        $Category->subCategory_english= array();
        $Category->subCategory_arabic = array();
        $Category->created_at         = date('Y-m-d H:i:s');
        $Category->status             = true;
        $Category->save();
        return [
            'status'    => 0,
            'result'    => 'Added Successfully',
            'id'        => $Category->id
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function addSubCategory(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'category_id'     => 'required|exists:mongodb.categories,_id',
            'subCategoryEn'   => 'required',
            'subCategoryAr'   => 'required',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $subCategoryEn = $req->input('subCategoryEn');
        $subCategoryAr = $req->input('subCategoryAr');
        $Category = Category::where('_id',$req->input('category_id'))->first();
        $subCategory_english    = $Category->subCategory_english;
        $subCategory_arabic     = $Category->subCategory_arabic;
        if(in_array($subCategoryEn, $subCategory_english))
            return [
            'status'    => 1,
            'error'     => 'Sub Category English Exist',
        ];
        if(in_array($subCategoryAr, $subCategory_arabic))
            return [
            'status'    => 1,
            'error'     => 'Sub Category Arabic Exist',
        ];
        array_push($subCategory_english, $subCategoryEn);
        array_push($subCategory_arabic, $subCategoryAr);
        Category::where('_id',$req->input('category_id'))->update([
            'subCategory_english'    => $subCategory_english,
            'subCategory_arabic'     => $subCategory_arabic,
        ]);
        return [
            'status'        => 0,
            'result'        => 'Added Successfully',
            'subEnCount'    => count($subCategory_english),
            'subArCount'    => count($subCategory_arabic),
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function getCategorySub(Request $req)
    {
        try{
        $validator = Validator::make($req->all(),[
            'id'     => 'required|exists:mongodb.categories,_id',
            ]);
        if(!$validator->passes())
        return [
            'status'    => 1,
            'error'     => $validator->errors()->first(),
        ];
        $id = $req->input('id');
        $subCategory_english = '';
        $subCategory_arabic = '';
        $Category = Category::where('_id',$id)->first();
        if(count($Category->subCategory_english) == 0)
            return [
            'status'    => 1,
            'error'     => 'No Sub Category Added',
        ];
        foreach ($Category->subCategory_english as $item ) {
           $subCategory_english .= $item . ',';
        }
        foreach ($Category->subCategory_arabic as $item ) {
           $subCategory_arabic .= $item . ',';
        }      
        return [
            'status'        => 0,
            'result'        => 'Added Successfully',
            'subEn'         => $subCategory_english,
            'subAr'         => $subCategory_arabic,
            'categoryAr'    => $Category->category_arabic,
            'categoryEn'    => $Category->category_english,
        ];
      }catch(Exception $e){
        return [ 'error' => $e->getMessage()];
      }
    }
    public function XMLCategory()
    {
    try{
      Artisan::call('xmlCategory:cron');
    return [
            'status'        => 0,
            'result'        => 'DONE !',
        ];
    }catch(Exception $e){
    return ['error'  => $e->getMessage()];
    }
    }
    public function XMLWord()
    {
    try{
      Artisan::call('xmlWord:cron');
    return [
            'status'        => 0,
            'result'        => 'DONE !',
        ];
    }catch(Exception $e){
    return ['error'  => $e->getMessage()];
    }
    }
    public function loadOrderDetails(Request $req)
    {
        try{
            $validator = Validator::make($req->all(),[
                'order_id'    => 'required|exists:mongodb.user_delieveries,_id',
                ]);
            if(!$validator->passes())
            return [
                'status'    => 1,
                'error'     => $validator->errors()->first(),
            ];
            $invoice = DelieveryMongo::where('_id',$req->order_id)->first();
          return [
            'status'    => 0,
            'result'    => $invoice,
        ];
        }catch(Exception $e){
            return ['error' => $e->getMessage()];
        }
    }
}
