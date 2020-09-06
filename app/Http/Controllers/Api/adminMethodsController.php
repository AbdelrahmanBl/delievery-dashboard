<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models\Document;
use App\Models\ProviderDocument;
use App\Models\serviceType;
use App\Models\ProviderService;
use App\Models\Promocode;
use App\Models\Setting;
use App\Models\Provider;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\ProviderWallet;
use App\Models\SellerWallet;
use App\Models\MarketerWallet;
use App\Models\UserRequestPayment;
use App\Models\categorySearch;
use App\Models\wordSearch;
use App\Models\Category;
use App\Models\DelieveryMongo;
use App\Models\Markerter;
use App\Models\Admin;
use App\Models\mainMongo;
use App\Models\Seller;
use App\Models\tatxProduct;
use App\Models\SubMainFilters;
use App\Models\PaystackPaymentSeller;
use App\Models\PaystackPaymentProvider;
use App\Models\Ad;
use App\Models\Offer;
use App\Models\Manager;

use App\Helper;
use Auth;
use validate;
use Validator;
use Artisan;
use Hash;
use Mail;

class adminMethodsController extends Controller
{
    public function logout(Request $req)
    {
        $where = array(
            'id' => $req->get('id'),
        );
        $User = Admin::where($where);

        Helper::loginUsingId($User);
        return Helper::return([]);
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
    public function deleteProviderDocument(Request $req)
    {
        try{
            $provider_id = $req->input('provider_id');
            $req->validate([
                'provider_id'        => 'required',
                'document_id'        => "required|exists:provider_documents,id,provider_id,{$provider_id}",
            ]);

            $id   = $req->input('document_id');
            $model = ProviderDocument::where('id',$id);
            $status = Helper::disable($model,'status','ACTIVE','ASSESSING','ACTIVE','ASSESSING');

            return Helper::return([
                'status'   => $status,
            ]);
        }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
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
    public function blockProvider(Request $req)
    {
        try{
            $req->validate([
                'provider_id'   => 'required|exists:providers,id',
            ]);
            $provider_id = $req->input('provider_id');
            $Provider = Provider::where('id',$provider_id)->update([
                'status'    =>  'banned'
            ]);
          return Helper::return([]);
        }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateProviderDocExpiry(Request $req)
    {
        try{
            $date = date('Y-m-d');
            $provider_id = $req->input('provider_id');
            $req->validate([
                'provider_id'  => 'required',
                'document_id'           => "required|exists:provider_documents,id,provider_id,{$provider_id}",
                'expires_at'   => "required|date|date_format:Y-m-d|after:{$date}",
            ]);
            $id = $req->input('document_id');
            $expires_at  = $req->input('expires_at');
            $Provider = ProviderDocument::where('id',$id)->update([
                'expires_at'    =>  $expires_at
            ]);
          return Helper::return([]);
        }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function approveProvider(Request $req)
    {
        try{
            $req->validate([
                'provider_id'    => 'required|exists:providers,id',
            ]);
            $provider_id = $req->input('provider_id');
            $ProviderService = ProviderService::where(array(
                'provider_id'     => $provider_id,
                'status'          => 'ON'
            ))->first();
        /*----------------------------------------------*/
            if(!$ProviderService)
                return Helper::returnError(Lang::get('messages.no_provider_services'));
        /*----------------------------------------------*/
            $allDocs        = Document::where('status','ON')->count();
            $providerDocs   = ProviderDocument::where(array(
                'provider_id'     => $provider_id,
                'status'          => 'ACTIVE'
            ))->count();
            if($allDocs != $providerDocs)
                return Helper::returnError(Lang::get('messages.remaining_docs').($allDocs - $providerDocs));
        /*----------------------------------------------*/
        Provider::where('id',$provider_id)->update([
            'status'    => 'approved'
        ]);
        return Helper::return([]);
        }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
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
        $req->validate([
            'unique_id'             => 'required|exists:sellers,uniqueID',
            'search'                => 'required|string|max:100',
            'category_english'      => 'required|string|max:50|exists:mongodb.categories',
            'sub_category_english'  => 'required|string|max:50|exists:mongodb.categories,subCategory_english',
        ]);
        $unique_id            = $req->input('unique_id');
        $search               = $req->input('search');
        $category_english     = $req->input('category_english');
        $sub_category_english = $req->input('sub_category_english');

        $CHK = categorySearch::where(array(
            'name'         => $search,
            'uniqueID'     => $unique_id
        ))->first();
        if($CHK)
            return Helper::returnError(Lang::get('auth.redundancy'));

        $Category            = Category::where('category_english',$category_english)->first();
        $sub_cat_inedx       = array_search($sub_category_english, $Category->subCategory_english);
        $sub_category_arabic = $Category->subCategory_arabic[$sub_cat_inedx];
        $category_arabic     = $Category->category_arabic;

        $en = new categorySearch();
        $en->name          = $search;
        $en->category      = $category_english;
        $en->sub_category  = $sub_category_english;
        $en->uniqueID      = $unique_id;
        $en->language      = 'en';
        $en->status        = true;
        $en->created_at    = date('Y-m-d H:i:s');

        $ar = new categorySearch();
        $ar->name          = $search;
        $ar->category      = $category_arabic;
        $ar->sub_category  = $sub_category_arabic;
        $ar->uniqueID      = $unique_id;
        $ar->language      = 'ar';
        $ar->status        = true;
        $ar->created_at    = date('Y-m-d H:i:s');

        $en->save();
        $ar->save();
        return Helper::return([
            'id_en'      =>  $en->_id,
            'id_ar'      =>  $ar->_id,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteCategorySearch(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:mongodb.category_search,_id',
        ]);
        $id   = $req->input('id');
        $model = categorySearch::where('_id',$id);
        $category_search_status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $category_search_status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteMain(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:mongodb.main_categories,_id',
        ]);
        $id   = $req->input('id');
        $model = mainMongo::where('_id',$id);
        $main_status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $main_status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function disableMainProduct(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:mongodb.main_categories,_id',
        ]);
        $id   = $req->input('id');
        $model = mainMongo::where('_id',$id);
        $main_status = Helper::disable($model,'has_product',true,false,'YES','NO');
    return Helper::return([
            'status'   => $main_status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function disableSellersProduct(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:sellers,id',
        ]);
        $id   = $req->input('id');
        $model = Seller::where('id',$id);
        $main_status = Helper::disable($model,'has_product',true,false,'YES','NO');
    return Helper::return([
            'status'   => $main_status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addMain(Request $req)
    {
        try{
        $req->validate([
            'icon'          => 'required|image|mimes:jpeg,png,jpg|max:2000',
            'name_en'       => 'required|string|min:3|max:100|unique:mongodb.main_categories',
            'name_ar'       => 'required|string|min:3|max:100|unique:mongodb.main_categories',
            'desc_en'       => 'required|string|min:3|max:100',
            'desc_ar'       => 'required|string|min:3|max:100',
            'has_product'   => 'required|bool',
            'is_collect'    => 'required|bool',
            'is_scheduled'  => 'required|bool',
            'type'          => 'required|exists:service_types',
        ]);
        $icon           = $req->file('icon');
        $name_en        = $req->input('name_en');
        $name_ar        = $req->input('name_ar');
        $desc_en        = $req->input('desc_en');
        $desc_ar        = $req->input('desc_ar');
        $has_product    = (bool)$req->input('has_product');
        $is_collect     = (bool)$req->input('is_collect');
        $is_scheduled   = (bool)$req->input('is_scheduled');
        $type           = $req->input('type');

        $mainMongo = new mainMongo();
        $mainMongo->icon        = Helper::image($icon,'add','delievery/main_icons');
        $mainMongo->name_en     = $name_en;
        $mainMongo->name_ar     = $name_ar;
        $mainMongo->desc_en     = $desc_en;
        $mainMongo->desc_ar     = $desc_ar;
        $mainMongo->sub_main    = array();
        $mainMongo->has_product = $has_product;
        $mainMongo->is_collect  = $is_collect;
        $mainMongo->is_scheduled = $is_scheduled;
        $mainMongo->type        = $type;
        $mainMongo->status      = 'ON';
        $mainMongo->save();
    return Helper::return([
            'id'   => $mainMongo->_id,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function add_sellers_manager(Request $req)
    {
        try{
        $manager_id        = $req->input('manager_id');
        $req->validate([
            'manager_id'       => 'required|numeric|exists:managers,id',
            'sellers_id'       => 'nullable|array|max:50',
            'removes_id'       => 'nullable|array|max:50',
            'sellers_id.*'     => 'required|numeric|exists:sellers,id',
            'removes_id.*'     => "required|numeric|exists:sellers,id,manager_id,{$manager_id}",
        ]);
        $sellers_id        = $req->input('sellers_id');
        $removes_id        = $req->input('removes_id');

        $adding    = Seller::whereIn('id',$sellers_id);
        $removing  = Seller::whereIn('id',$removes_id);
        $adding->update(['manager_id'  => $manager_id]);
        $removing->update(['manager_id'  => NULL]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteIsScheduledMain(Request $req)
    {
        try{
        $req->validate([
            'id'  => 'required|exists:mongodb.main_categories,_id',
        ]);
        $id    = $req->input('id');
        $model = mainMongo::where('_id',$id);
        $seller_status = Helper::disable($model,'is_scheduled',true,false,'YES','NO');
    return Helper::return([
            'status'   => $seller_status,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
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
        $uniqueID = $req->get('uniqueID');
        if(!$uniqueID)
        $uniqueID =  $req->input('unique_id');

        if(!$uniqueID)
            return Helper::returnError(Lang::get('messages.required_uniqueID'));
        $req->validate([
            'category_english'  => 'required|string|min:3|max:30|unique:mongodb.categories,category_english,null,_id,uniqueID,'.$uniqueID,
            'category_arabic'   => 'required|string|min:3|max:30|unique:mongodb.categories,category_arabic,null,_id,uniqueID,'.$uniqueID,
            'unique_id'         => 'nullable|exists:mongodb.categories,uniqueID',
        ]);
        $category_english   = $req->input('category_english');
        $category_arabic    = $req->input('category_arabic');
        $Category = new Category();
        $Category->category_english   = $category_english;
        $Category->category_arabic    = $category_arabic;
        $Category->subCategory_english= array();
        $Category->subCategory_arabic = array();
        $Category->uniqueID = $uniqueID;
        $Category->created_at         = date('Y-m-d H:i:s');
        $Category->status             = 'ON';
        $Category->save();
        return Helper::return([
            'id'        => $Category->id
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function addSeller(Request $req)
    {
        try{
        $req->validate([
            'icon'              => 'required|image|mimes:jpeg,png,jpg|max:2000',
            'name_en'           => 'required|unique:sellers|max:50',
            'name_ar'           => 'required|unique:sellers|max:50',
            'delievery_us'      => 'required|bool',
            'delievery_fees'        => 'required|numeric|between:0,9999',
            'delievery_ratio'       => 'required|numeric|between:0,100',
            'min_ratio'             => 'required|numeric|min:0|max:9999',
            'min_order'             => 'required|numeric|min:0|max:99999',
            'has_product'       => 'required|bool',
            'main_color'        => 'required|string|max:10',
            'commision_per'     => 'required|numeric|between:0,100',
            'next_deilevery'    => 'required|string|max:20',
            'duration_from'     => 'required|numeric|between:0,999',
            'duration_to'       => 'required|numeric|between:0,999',
            // 'location'          => 'nullable|array|size:3',
            'address'               => 'nullable|string|min:3|max:100',
            'latitude'              => 'nullable|numeric',
            'longitude'             => 'nullable|numeric',
            /////////////////////////////////////////////////////
            'type'              => 'required|string|max:30',
            'email'             => 'required|email|max:100|unique:sellers',
            'password'          => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'verify_password'  => 'required|same:password',
            'module'            => 'required|exists:mongodb.modules',
        ]);
        $image             = $req->file('icon');
        $name_en           = $req->input('name_en');
        $name_ar           = $req->input('name_ar');
        $uniqueID          = time();
        $delievery_fees    = (double)$req->input('delievery_fees');
        $delievery_ratio   = (double)$req->input('delievery_ratio');
        $min_ratio         = (double)$req->input('min_ratio');
        $min_order         = (double)$req->input('min_order');
        $delievery_us      = $req->input('delievery_us');
        $has_product       = $req->input('has_product');
        $main_color        = $req->input('main_color');
        $commision_per     = $req->input('commision_per');
        $next_deilevery    = $req->input('next_deilevery');
        $duration_from     = $req->input('duration_from');
        $duration_to       = $req->input('duration_to');
        $address           = $req->input('address');
        $longitude         = $req->input('longitude');
        $latitude          = $req->input('latitude');
        //////////////////////////////////////////////////
        $type              = $req->input('type');
        $email             = $req->input('email');
        $password          = $req->input('password');
        $module            = $req->input('module');
        $image    = Helper::image($image,'add','delievery/main_icons');


        $Seller = new Seller([
        "image"              => $image,
        "name_en"            => $name_en,
        "name_ar"            => $name_ar,
        "uniqueID"           => $uniqueID,
        "delievery_us"       => $delievery_us,
        "delievery_fees"     => $delievery_fees,
        "delievery_ratio"    => $delievery_ratio,
        "min_ratio"          => $min_ratio,
        "min_order"          => $min_order,
        "has_product"        => $has_product,
        "main_color"         => $main_color,
        "commision_per"      => $commision_per,
        "next_deilevery"     => $next_deilevery,
        "duration_from"      => $duration_from,
        "duration_to"        => $duration_to,
        "address"            => $address,
        "latitude"           => $latitude,
        "longitude"          => $longitude,
        "type"               => $type,
        "email"              => $email,
        "password"           => Hash::make($password),
        "module"             => $module,
        ]);
        $Seller->save();

        return Helper::return([
            'id'        => $Seller->id
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteCategory(Request $req)
    {
        try{
        $req->validate([
            'id'  => 'required|exists:mongodb.categories,_id',
            'unique_id'         => 'nullable|exists:mongodb.categories,uniqueID',
        ]);
        $id = $req->input('id');
        $uniqueID = $req->get('uniqueID');
        if(!$uniqueID)
        $uniqueID =  $req->input('unique_id');

        if(!$uniqueID)
            return Helper::returnError(Lang::get('messages.required_uniqueID'));

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $model = Category::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $category_status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $category_status,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteSeller(Request $req)
    {
        try{
        $req->validate([
            'id'  => 'required|exists:sellers,id',
        ]);
        $id = $req->input('id');
        $model = Seller::where('id',$id);
        $seller_status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $seller_status,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function addSubCategory(Request $req)
    {
        try{
        $uniqueID = $req->get('uniqueID');
        if(!$uniqueID)
        $uniqueID =  $req->input('unique_id');

        if(!$uniqueID)
            return Helper::returnError(Lang::get('messages.required_uniqueID'));
        $req->validate([
            'id'                   => 'required|exists:mongodb.categories,_id',
            'subCategory_english'  => 'required|string|min:3|max:30|unique:mongodb.categories,subCategory_english,null,_id,uniqueID,'.$uniqueID,
            'subCategory_arabic'   => 'required|string|min:3|max:30|unique:mongodb.categories,subCategory_arabic,null,_id,uniqueID,'.$uniqueID,
            'unique_id'         => 'nullable|exists:mongodb.categories,uniqueID',
        ]);
        $id                    = $req->input('id');
        $subCategory_english   = $req->input('subCategory_english');
        $subCategory_arabic    = $req->input('subCategory_arabic');

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $push = array(
            'subCategory_english' => $subCategory_english,
            'subCategory_arabic' => $subCategory_arabic
        );
        $model = Category::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $model->push($push);
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateSubCategory(Request $req)
    {
        try{
        $id                    = $req->input('id');
        $uniqueID = $req->get('uniqueID');
        if(!$uniqueID)
        $uniqueID =  $req->input('unique_id');
        if(!$uniqueID)
            return Helper::returnError(Lang::get('messages.required_uniqueID'));
        $req->validate([
            'id'                   => 'required|exists:mongodb.categories,_id',
            'old_subCategory_english'  => 'required|exists:mongodb.categories,subCategory_english|string|max:30',
            'subCategory_english'  => 'required|string|min:3|max:30|unique:mongodb.categories,subCategory_english,'.$id.',_id,uniqueID,'.$uniqueID,
            'subCategory_arabic'   => 'required|string|min:3|max:30|unique:mongodb.categories,subCategory_arabic,'.$id.',_id,uniqueID,'.$uniqueID,
            'unique_id'         => 'nullable|exists:mongodb.categories,uniqueID',
        ]);

        $subCategory_english   = $req->input('subCategory_english');
        $subCategory_arabic    = $req->input('subCategory_arabic');
        $old_subCategory_english = $req->input('old_subCategory_english');

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $model = Category::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        Helper::update_category_array($model,$old_subCategory_english,$subCategory_english,$subCategory_arabic);
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteSubCategory(Request $req)
    {
        try{
        $req->validate([
            'id'                   => 'required|exists:mongodb.categories,_id',
            'subCategory_english'  => 'required|exists:mongodb.categories|string|max:30',
            'subCategory_arabic'   => 'required|exists:mongodb.categories|string|max:30',
            'unique_id'         => 'nullable|exists:mongodb.categories,uniqueID',
        ]);
        $id                    = $req->input('id');
        $subCategory_english   = $req->input('subCategory_english');
        $subCategory_arabic    = $req->input('subCategory_arabic');
        $uniqueID = $req->get('uniqueID');
        if(!$uniqueID)
        $uniqueID =  $req->input('unique_id');

        if(!$uniqueID)
            return Helper::returnError(Lang::get('messages.required_uniqueID'));

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $pull = array(
            'subCategory_english' => $subCategory_english,
            'subCategory_arabic' => $subCategory_arabic
        );
        $model = Category::where($where);
        if(!$model->first())
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $model->pull($pull);
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateSeller(Request $req)
    {
        try{
        $id = $req->input('id');
        $req->validate([
            'id'                => 'required|exists:sellers,id',
            'name_en'           => 'required|unique:sellers,name_en,'.$id.',id|string|max:20',
            'name_ar'           => 'required|unique:sellers,name_ar,'.$id.',id|string|max:20',
            'delievery_fees'        => 'required|numeric|min:0|max:99',
            'delievery_ratio'       => 'required|numeric|min:0|max:999',
            'min_ratio'             => 'required|numeric|min:0|max:9999',
            'min_order'             => 'required|numeric|min:0|max:99999',
            'main_color'        => 'required|string|max:10',
            'commision_per'     => 'required|numeric|between:0,100',
            'next_deilevery'    => 'required|string|max:20',
            'duration_from'     => 'required|numeric|between:0,500',
            'duration_to'       => 'required|numeric|between:0,500',
            'type'              => 'required|string|max:20',
            'module'            => 'required|exists:mongodb.modules',
            'address'               => 'nullable|string|min:3|max:100',
            'latitude'              => 'nullable|numeric',
            'longitude'             => 'nullable|numeric',
        ]);
        $model = Seller::where('id',$id);
        $model->update( $req->all(['address'  , 'latitude' , 'longitude','module','name_en','name_ar','main_color','commision_per','next_deilevery','duration_from','duration_to','type','delievery_fees','delievery_ratio','min_ratio','min_order']) );
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateSellerIcon(Request $req)
    {
        try{
        $req->validate([
            'id'                => 'required|exists:sellers,id',
            'icon'              => 'required|image|mimes:jpeg,png,jpg|max:2000',
        ]);
        $id = $req->input('id');
        $icon = $req->file('icon');

        $model = Seller::where('id',$id);
        $filepath = $model->first()->image;
        $icon_url = Helper::image($icon,'update','delievery/seller_icons',$filepath);
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
    public function updateSellerLocation(Request $req)
    {
        try{
        $req->validate([
            'id'                => 'required|exists:sellers,id',
            'address'           => 'required|string|max:100',
            'latitude'          => 'required|numeric',
            'longitude'         => 'required|numeric',
        ]);
        $id = $req->input('id');
        $address = $req->input('address');
        $latitude = $req->input('latitude');
        $longitude = $req->input('longitude');

        $location = array();
        $location['address']    = $address;
        $location['latitude']   = $latitude;
        $location['longitude']  = $longitude;
        $model = Seller::where('id',$id);
        $model->update([
            'location'   => $location
        ]);
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateCategory(Request $req)
    {
        try{
        $id                 = $req->input('id');
        $category_english   = $req->input('category_english');
        $category_arabic    = $req->input('category_arabic');
        $uniqueID = $req->get('uniqueID');
        if(!$uniqueID)
        $uniqueID =  $req->input('unique_id');

        if(!$uniqueID)
            return Helper::returnError(Lang::get('messages.required_uniqueID'));
        $req->validate([
            'id'                => 'required|exists:mongodb.categories,_id',
            'category_english'  => 'required|string|min:3|max:30|unique:mongodb.categories,category_english,'.$id.',_id,uniqueID,'.$uniqueID,
            'category_arabic'   => 'required|string|min:3|max:30|unique:mongodb.categories,category_arabic,'.$id.',_id,uniqueID,'.$uniqueID,
            'unique_id'         => 'nullable|exists:mongodb.categories,uniqueID',
        ]);

        $where = array(
            '_id' => $id,
            'uniqueID' => $uniqueID
        );
        $model = Category::where($where);
        $model_select = $model->first();
        if(!$model_select)
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $model->update($req->all(["category_english","category_arabic"]));
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateMain(Request $req)
    {
        try{
        $id       = $req->input('id');
        $req->validate([
            'id'                => 'required|exists:mongodb.main_categories,_id',
            'name_en'  => 'required|unique:mongodb.main_categories,name_en,'.$id.',_id|string|max:20',
            'name_ar'   => 'required|unique:mongodb.main_categories,name_ar,'.$id.',_id|string|max:20',
            'desc_en'   => 'required|string|min:3|max:100',
            'desc_ar'   => 'required|string|min:3|max:100',
            'type'   => 'required|string|max:20',
        ]);

        $model = mainMongo::where('_id',$id);
        $model->update($req->all(['name_en','name_ar','type','desc_en','desc_ar']));
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateMainIcon(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:mongodb.main_categories,_id',
            'icon'      => 'required|image|mimes:jpeg,png,jpg|max:2000',
        ]);
        $id       = $req->input('id');
        $icon     = $req->file('icon');

        $model = mainMongo::where('_id',$id);
        $filepath = $model->first()->icon;
        $icon_url = Helper::image($icon,'update','delievery/main_icons',$filepath);
        $model->update([
            'icon'   => $icon_url
        ]);
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function addSubMain(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:mongodb.main_categories,_id',
            'sub_main'  => 'required|unique:mongodb.main_categories|string|max:30',
        ]);
        $id       = $req->input('id');
        $sub_main = $req->file('sub_main');

        $model = mainMongo::where('_id',$id);
        $model->push($req->all('sub_main'));
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function updateSubMain(Request $req)
    {
        try{
        $id       = $req->input('id');
        $req->validate([
            'id'        => 'required|exists:mongodb.main_categories,_id',
            'sub_main' => 'required|exists:mongodb.main_categories,NULL,_id,'.$id,
            'new_sub_main'  => 'required|unique:mongodb.main_categories,sub_main,NULL,id,_id,'.$id.'|string|max:30',
        ]);

        $sub_main = $req->input('sub_main');
        $new_sub_main = $req->input('new_sub_main');

        $model = mainMongo::where('_id',$id);
        $model_data = $model->first();

        $index = array_search($sub_main, $model_data->sub_main);
        $arr = array(
            'sub_main.'.$index => $new_sub_main,
        );
        $model->update($arr);
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function deleteSubMain(Request $req)
    {
        try{
        $id       = $req->input('id');
        $req->validate([
            'id'        => 'required|exists:mongodb.main_categories,_id',
            'sub_main'  => 'required|exists:mongodb.main_categories,NULL,_id,'.$id.'|string|max:30',
        ]);
        $model = mainMongo::where('_id',$id);
        $model->pull($req->all('sub_main'));
    return Helper::return([]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
      }
    }
    public function getSubCategories(Request $req)
    {
        try{
        $req->validate([
            'category_english'  => 'required|exists:mongodb.categories',
        ]);
        $category_english    = $req->input('category_english');
        $subCategory_english = Category::where('category_english',$category_english)->first()->subCategory_english;
        return Helper::return([
           'sub_categories' => $subCategory_english,
        ]);
      }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
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
    public function delieveryUs(Request $req)
    {
        try{
        $req->validate([
            'id'     => 'required|exists:sellers,id',
        ]);
        $id   = $req->input('id');
        $model = Seller::where('id',$id);
        $status = Helper::disable($model,'delievery_us',true,false,'YES','NO');

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
    public function deleteUser(Request $req)
    {
        try{
        $req->validate([
            'id'       => 'required|exists:users',
        ]);
        $id   = $req->input('id');

        $model = new User();
        $model = $model::where('id',$id);
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
    public function deleteMarkerter(Request $req)
    {
        try{
        $req->validate([
            'id'       => 'required|exists:markerters',
        ]);
        $id   = $req->input('id');

        $model = new Markerter();
        $model = $model::where('id',$id);
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
    public function deleteProvider(Request $req)
    {
        try{
        $req->validate([
            'id'       => 'required|exists:providers',
        ]);
        $id   = $req->input('id');

        $model = new Provider();
        $model = $model::where('id',$id);
        $model_data = $model->first();
        if(!in_array($model_data->status, ['approved','banned']))
            return Helper::returnError(Lang::get('messages.expected_status_provider').$model_data->status);
        $status = Helper::disable($model,'status','approved','banned','approved','banned');
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
    public function createSubMainFilters(Request $req)
    {
        try{
        $req->validate([
            'icon'        => 'required|mimes:jpeg,png,jpg|max:2000',
            'name_en'     => "required|string|min:3|max:50|unique:mongodb.sub_main_filters",
            'name_ar'     => "required|string|min:3|max:50|unique:mongodb.sub_main_filters",
            'module'      => 'required|exists:mongodb.modules',
        ]);
        $icon      = $req->file('icon');
        $name_en   = $req->input('name_en');
        $name_ar   = $req->input('name_ar');
        $module    = $req->input('module');

        $icon  = Helper::image($icon,'add','delievery/submain_icons');
        $model = new SubMainFilters();
        $model->icon        = $icon;
        $model->name_en     = $name_en;
        $model->name_ar     = $name_ar;
        $model->uniqueIDs   = [];
        $model->conditions  = [];
        $model->module      = $module;
        $model->status      = 'OFF';
        $model->save();
    return Helper::return([
        'id'  => $model->_id
    ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateSubMainFilters(Request $req)
    {
        try{
        $id        = $req->input('id');
        $req->validate([
            'id'          => "required|exists:mongodb.sub_main_filters,_id",
            'name_en'     => "required|string|min:3|max:50|unique:mongodb.sub_main_filters,name_en,{$id},_id",
            'name_ar'     => "required|string|min:3|max:50|unique:mongodb.sub_main_filters,name_en,{$id},_id",
            'module'      => 'required|exists:mongodb.modules',
        ]);
        $name_en   = $req->input('name_en');
        $name_ar   = $req->input('name_ar');
        $module    = $req->input('module');

        $model = SubMainFilters::where('_id',$id);
        $model->update([
            'module'      => $module,
            'name_en'     => $name_en,
            'name_ar'     => $name_ar,
        ]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteSubMainFilters(Request $req)
    {
        try{
        $req->validate([
            'id'          => "required|exists:mongodb.sub_main_filters,_id",
        ]);
        $id        = $req->input('id');
        $model = SubMainFilters::where('_id',$id);
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
    public function addSubMainFiltersCondition(Request $req)
    {
        try{
        $req->validate([
            'id'          => "required|exists:mongodb.sub_main_filters,_id",
            'key'         => "required|string|min:1|max:50",
            'rule'        => "required|string|min:1|max:50",
            'value'       => "required|string|min:1|max:50",
        ]);
        $id      = $req->input('id');
        $key     = $req->input('key');
        $rule    = $req->input('rule');
        $value   = $req->input('value');

        $model = SubMainFilters::where('_id',$id);
        $model_select = $model->first();
        if(count($model_select->uniqueIDs) > 0)
            return returnError(Lang::get('messages.not_allowed'));

        $conditions = [
            'key'   => $key,
            'rule'  => $rule,
            'value' => $value,
        ];

        $model->push('conditions',$conditions);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateSubMainFiltersCondition(Request $req)
    {
        try{
        $req->validate([
            'id'          => "required|exists:mongodb.sub_main_filters,_id",
        ]);
        $id      = $req->input('id');
        $model = SubMainFilters::where('_id',$id);
        $count = $model->first()->conditions;
        $count = count($count) - 1;

        $req->validate([
            'key'         => "required|string|min:1|max:50",
            'rule'        => "required|string|min:1|max:50",
            'value'       => "required|string|min:1|max:50",
            'option_number' => "required|numeric|min:0|max:{$count}",
        ]);

        $key     = $req->input('key');
        $rule    = $req->input('rule');
        $value   = $req->input('value');
        $option_number = $req->input('option_number');

        $conditions = [
            'key'   => $key,
            'rule'  => $rule,
            'value' => $value,
        ];
        $model->update(["conditions.{$option_number}" => $conditions]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteSubMainFiltersCondition(Request $req)
    {
        try{
        $req->validate([
            'id'          => "required|exists:mongodb.sub_main_filters,_id",
        ]);
        $id      = $req->input('id');
        $model = SubMainFilters::where('_id',$id);
        $count = $model->first()->conditions;
        $count = count($count) - 1;

        $req->validate([
            'option_number' => "required|numeric|min:0|max:{$count}",
        ]);

        $option_number = $req->input('option_number');

        $model->unset("conditions.{$option_number}",1)->pull('conditions',null);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateSubMainFiltersImage(Request $req)
    {
        try{
        $req->validate([
            'id'          => "required|exists:mongodb.sub_main_filters,_id",
            'icon'        => 'required|mimes:jpeg,png,jpg|max:2000',
        ]);
        $id      = $req->input('id');
        $icon    = $req->file('icon');

        $model = SubMainFilters::where('_id',$id);
        $url = Helper::image($icon,'update','delievery/submain_icons',$model->first()->icon);
        $model->update(['icon' => $url]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function payroll(Request $req)
    {
        DB::beginTransaction();
        try {
            $pay_count = count($req->input('pay'));
            $req->validate([
            'pay'         => 'required|array|max:100',
            'type'        => 'required|in:SELLER,PROVIDER',
            'reference'   => "required|array|size:{$pay_count}",
            'paid_at'     => 'required|string|max:30',
        ]);
            $insert = array();
            $insert_wallet = array();
            $type   = $req->input('type');
            $pay    = $req->input('pay');
            $reference = $req->input('reference');
            $paid_at = $req->input('paid_at');
            $counter = 0;
            $to_paid_orders_ids=[];
            switch ($type) {
            case 'SELLER':
                $req->validate([
                    'pay.*'       => 'required|exists:sellers,id',
                    'reference.*' => "required|unique:paystack_payment_sellers,reference",
                ]);
                $model = new PaystackPaymentSeller;
                $model_wallet = new SellerWallet;
                $sellers = Seller::with('unpaid_seller_payments')->whereIn('id', $pay)->get(['id','wallet_balance']);

                foreach ($pay as $seller_id) {
                    $current_seller = $sellers->where('id', $seller_id)->first();
                    $total_pay = $current_seller->wallet_balance;
                    $total = $current_seller->unpaid_seller_payments->sum('seller_products_price');
                    $orders =$current_seller->unpaid_seller_payments->transform(function ($value) use (&$to_paid_orders_ids) {
                        $to_paid_orders_ids[] = $value->id;
                        return ['booking_id'=>$value->booking_id,'fees'=>$value->seller_products_price];
                    });

                    if ($total_pay <= 0) {
                        return Helper::returnError(Lang::get('messages.total').$seller_id);
                    }

                    if ($total < $total_pay) {
                        return Helper::returnError(Lang::get('messages.seller_total_msg').$seller_id);
                    }


                    $transaction_id = time() + $counter;

                    $insert[] = [
                    'transaction_id' => $transaction_id,
                    'reference' => $reference[$counter],
                    'seller_id' => $seller_id,
                    'total_pay' => $total_pay,
                    'total'=>$total,
                    'discount'=>($total_pay - $total),
                    'currency_en' => 'sar',
                    'currency_ar' => 'ريال',
                    'paid_at' => $paid_at,
                    'paid_orders'=>json_encode($orders),
                ];
                    $insert_wallet[] = [
                    'seller_id'    => $seller_id,
                    'transaction_id' => $transaction_id,
                    'type'           => 'C',
                    'amount'         => $total_pay,
                ];
                }
                break;

            case 'PROVIDER':
                $req->validate([
                    'pay.*'       => 'required|exists:providers,id',
                    'reference.*' => "required|unique:paystack_payment_providers,reference",
                ]);
                $model = new PaystackPaymentProvider;
                $model_wallet = new ProviderWallet;
                $providers = Provider::whereIn('id', $pay)->get(['id','wallet_balance']);
                foreach ($pay as $provider_id) {
                    $total = $providers->where('id', $provider_id)->first()->wallet_balance;
                    if ($total <= 0) {
                        return Helper::returnError(Lang::get('messages.total').$provider_id);
                    }
                    $transaction_id = time() + $counter;
                    $insert[] = [
                    'transaction_id' => $transaction_id,
                    'reference' => $reference[$counter],
                    'provider_id' => $provider_id,
                    'total' => $total,
                    'currency_en' => 'sar',
                    'currency_ar' => 'ريال',
                    'paid_at' => $paid_at,
                ];
                    $insert_wallet[] = [
                    'provider_id'    => $provider_id,
                    'transaction_id' => $transaction_id,
                    'type'           => 'C',
                    'amount'         => $total,
                ];
                    $counter++;
                }
                break;
        }

            $model->insert($insert);
            $model_wallet->insert($insert_wallet);

            if ($type=='SELLER') {
                UserDelieveryPayments::whereIn('id', $to_paid_orders_ids)->update(['paid'=>1]);
            }

            DB::commit();
            return Helper::return([]);
        } catch (Exception $e) {
            DB::rollback();
            if ($e instanceof ValidationException) {
                throw $e;
            }
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function addDocument(Request $req)
    {
        try{
        $req->validate([
            'name'        => 'required|string|max:30',
            'type'        => 'required|in:DRIVER,VEHICLE',
        ]);
        $model = new Document($req->all('name','type'));
        $model->save();
    return Helper::return([
            'id'   => $model->id,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateDocument(Request $req)
    {
        try{
        $req->validate([
            'id'          => 'required|exists:documents',
            'name'        => 'required|string|max:30',
            'type'        => 'required|in:DRIVER,VEHICLE',
        ]);
        $id   = $req->input('id');
        $model = Document::where('id',$id);
        $model->update($req->all('name','type'));
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteDocument(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:documents',
        ]);
        $id   = $req->input('id');
        $model = Document::where('id',$id);
        $status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addService(Request $req)
    {
        try{
        $req->validate([
            'image'             => 'required|mimes:jpeg,png,jpg|max:2000',
            'type'              => 'required|string|max:15',
            'name'              => 'required|string|max:12',
            'description'       => 'nullable|string|max:50',
            'price_fixed'       => 'required|numeric|between:0,9999',
            'price_distance'    => 'required|numeric|between:0,99.99',
            'price_minute'      => 'required|numeric|between:0,99.99',
            'capacity'          => 'required|numeric|between:0,9',
        ]);
        $image    =   $req->file('image');

        $my_array              = $req->all(['type','name','description','price_fixed','price_distance','price_minute','capacity']);
        $my_array['image']     = Helper::image($image,'add','documents/service_types');
        $model = new serviceType($my_array);
        $model->save();

    return Helper::return([
            'id'   => $model->id,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateServiceImage(Request $req)
    {
        try{
        $req->validate([
            'id'           => 'required|exists:service_types',
            'image'        => 'required|mimes:jpeg,png,jpg|max:2000',
        ]);
        $id       = $req->input('id');
        $image    = $req->file('image');
        $model = serviceType::where('id',$id);
        $model_data = $model->first();
        $url = Helper::image($image,'update','documents/service_types',$model_data->image);
        $model->update(['image' => $url]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateService(Request $req)
    {
        try{
        $req->validate([
            'id'                => 'required|exists:service_types',
            'type'              => 'required|string|max:15',
            'name'              => 'required|string|max:12',
            'description'       => 'nullable|string|max:50',
            'price_fixed'       => 'required|numeric|between:0,9999',
            'price_distance'    => 'required|numeric|between:0,99.99',
            'price_minute'      => 'required|numeric|between:0,99.99',
            'capacity'          => 'required|numeric|between:0,9',
        ]);
        $id  = $req->input('id');
        $my_array              = $req->all(['type','name','description','price_fixed','price_distance','price_minute','capacity']);
        $model =serviceType::where('id',$id);
        $model->update($my_array);

    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteService(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:service_types',
        ]);
        $id   = $req->input('id');
        $model = serviceType::where('id',$id);
        $status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addSetting(Request $req)
    {
        try{
        $req->validate([
            'key'              => 'required|string|max:100',
            'value'            => 'nullable|string|max:255',
        ]);
        $key     = $req->input('key');
        $value   = $req->input('value');

        $my_array   = $req->all(['key','value']);
        $model = new Setting($my_array);
        $model->save();

    return Helper::return([
            'id'   => $model->id,
        ]);
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
        $id = $req->get('admin_id');
        $req->validate([
            'name'           => 'required|string|max:50',
            'email'          => "required|unique:admins,email,{$id},id|email|max:64",
            'mobile'         => 'required|string|max:15',
            'language'       => 'required|string|in:en,ar',
            'currency'       => 'required|string|in:sar',
        ]);

        $my_array   = $req->all(['name','email','mobile','language','currency']);
        $model = Admin::where('id',$id)->update($my_array);

    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateImage(Request $req)
    {
        try{
        $id = $req->get('admin_id');
        $req->validate([
            'image'           => 'required|mimes:jpeg,png,jpg|max:2000',
        ]);
        $image         = $req->file('image');

        $model = Admin::where('id',$id);
        $model_data = $model->first();
        if($model_data->picture)
            $url = Helper::image($image,'update','admin_prictures',$model_data->picture);
        else {
            $url = Helper::image($image,'add','admin_prictures');
        }
        $model->update(['picture' => $url]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updatePassword(Request $req)
    {
        try{
        $req->validate([
            'old_password'     => 'required',
            'password'     => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'verify_password'  => 'required|same:password',
        ]);
        $id   = $req->get('admin_id');
        $old_password   = $req->input('old_password');
        $new_password   = $req->input('password');

        $model = Admin::where('id',$id);
        $model_select = $model->first();

        if($model_select->failed_try >= 20)
            return Helper::returnError(Lang::get('auth.blocked'));
        if( !Hash::check($old_password, $model_select->password) ){
            $model->increment('failed_try');
            return Helper::returnError(Lang::get('auth.password'));
            }
            $model->update([
                'password'   => Hash::make($new_password)
            ]);
        return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateSetting(Request $req)
    {
        try{
        $req->validate([
            'id'               => 'required|exists:settings',
            'key'              => 'required|string|max:100',
            'value'            => 'nullable|string|max:255',
        ]);
        $id      = $req->input('id');
        $key     = $req->input('key');
        $value   = $req->input('value');

        $my_array   = $req->all(['key','value']);
        $model = Setting::where('id',$id);
        $model->update($my_array);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addAd(Request $req)
    {
        try{
        $date = date('Y-m-d H:i:s');
        $req->validate([
            'image'           => 'required|mimes:jpeg,png,jpg|max:2000',
            'page'            => 'required|in:MAIN,SUB_MAIN',
            'type'            => 'required|in:product,seller,category',
            'expired_at'      => "required|after_or_equal:{$date}",
        ]);
        $image         = $req->file('image');
        $page          = $req->input('page');
        $type          = $req->input('type');
        $expired_at    = $req->input('expired_at');

        $main_id       = NULL;
        if($page == 'SUB_MAIN'){
            $req->validate([
                'main_id' => 'required|exists:mongodb.main_categories,_id',
            ]);
            $main_id = $req->input('main_id');
        }
        $my_array   = $req->all(['page','type','expired_at']);
        switch ($type) {
            case 'product':
                $req->validate([
                    'product_id'  => 'required|string|exists:mongodb.tatx_products,_id'
                ]);
                $my_array['product_id'] = $req->input('product_id');
                break;
            case 'seller':
                $req->validate([
                    'seller_id'  => 'required|numeric|exists:sellers,id'
                ]);
                $my_array['seller_id'] = $req->input('seller_id');
                break;
            case 'category':
                $req->validate([
                    'category_id'  => 'required|string|exists:mongodb.sub_main_filters,_id'
                ]);
                $my_array['category_id'] = $req->input('category_id');
                break;
        }
        $my_array['main_id']   = $main_id;
        $my_array['image'] = Helper::image($image,'add','advs');
        $model = new Ad($my_array);
        $model->save();

    return Helper::return([
            'id'   => $model->id,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function addOffer(Request $req)
    {
        try{
        $admin_per      = (double)$req->input('admin_per');
        $seller_per     = (double)$req->input('seller_per');
        $seller_max     = 100 - $admin_per ;
        $from           = $req->input('from');
        $date = date('Y-m-d H:i:s');
        $req->validate([
            'image'           => 'required|mimes:jpeg,png,jpg|max:2000',
            "promo_code"      => 'required|string|max:16|unique:offers',
            "type"            => 'required|string|in:FROM_TOTAL,TO_WALLET',
            "offer_by"        => 'required|string|in:CATEGORY,SELLER,PRODUCT',
            "payment_type"    => 'nullable|string|in:CASH,VISA,WALLET',
            "amount"          => 'required|numeric|max:99999',
            "amount_per"      => 'required|numeric|between:0,100',
            "admin_per"       => 'required|numeric|between:0,100',
            "seller_per"      => "required|numeric|min:{$seller_max}|max:{$seller_max}",
            "min"             => 'required|numeric|max:99999',
            "max"             => 'required|numeric|max:99999',
            "max_use"         => 'required|numeric|max:99',
            "from"            => "required|after_or_equal:{$date}",
            "to"              => "required|after:{$from}",
        ]);
        $image          = $req->file('image');
        $promo_code     = $req->input('promo_code');
        $type           = $req->input('type');
        $offer_by       = $req->input('offer_by');
        $payment_type   = $req->input('payment_type');
        $amount         = $req->input('amount');
        $amount_per     = (double)$req->input('amount_per');
        $min            = (double)$req->input('min');
        $max            = (double)$req->input('max');
        $max_use        = (int)$req->input('max_use');
        $to             = $req->input('to');

        $my_array   = $req->all(['promo_code','type','offer_by','payment_type','amount','amount_per','admin_per','seller_per','min','max','max_use','category_id','seller_id','product_id','from','to']);
        switch ($offer_by) {
            case 'CATEGORY':
                $req->validate([
                   'category_id'  => 'required|exists:mongodb.sub_main_filters,_id'
                ]);
                $my_array['category_id'] = $req->input('category_id');
                break;
            case 'SELLER':
                $req->validate([
                    'seller_id'  => 'required|exists:sellers,id'
                ]);
                $my_array['seller_id'] = $req->input('seller_id');
                break;
            case 'PRODUCT':
                $req->validate([
                    'product_id'  => 'required|exists:mongodb.tatx_products,_id'
                ]);
                $my_array['product_id'] = $req->input('product_id');
                break;
        }
        $my_array['image'] = Helper::image($image,'add','offers');
        $model = new Offer($my_array);
        $model->save();

    return Helper::return([
            'id'   => $model->id,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateOffer(Request $req)
    {
        try{
        $offer_id       = (int)$req->input('offer_id');
        $admin_per      = (double)$req->input('admin_per');
        $seller_per     = (double)$req->input('seller_per');
        $seller_max     = 100 - $admin_per ;
        $from           = $req->input('from');
        $date = date('Y-m-d H:i:s');
        $req->validate([
            "offer_id"        => 'required|numeric|exists:offers,id',
            "promo_code"      => "required|string|max:16|unique:offers,id,{$offer_id}",
            "type"            => 'required|string|in:FROM_TOTAL,TO_WALLET',
            "offer_by"        => 'required|string|in:CATEGORY,SELLER,PRODUCT',
            "payment_type"    => 'nullable|string|in:CASH,VISA,WALLET',
            "amount"          => 'required|numeric|max:99999',
            "amount_per"      => 'required|numeric|between:0,100',
            "admin_per"       => 'required|numeric|between:0,100',
            "seller_per"      => "required|numeric|min:{$seller_max}|max:{$seller_max}",
            "min"             => 'required|numeric|max:99999',
            "max"             => 'required|numeric|max:99999',
            "max_use"         => 'required|numeric|max:99',
            "from"            => "required|after_or_equal:{$date}",
            "to"              => "required|after:{$from}",
        ]);
        $promo_code     = $req->input('promo_code');
        $type           = $req->input('type');
        $offer_by       = $req->input('offer_by');
        $payment_type   = $req->input('payment_type');
        $amount         = $req->input('amount');
        $amount_per     = (double)$req->input('amount_per');
        $min            = (double)$req->input('min');
        $max            = (double)$req->input('max');
        $max_use        = (int)$req->input('max_use');
        $to             = $req->input('to');

        $my_array   = $req->all(['promo_code','type','offer_by','payment_type','amount','amount_per','admin_per','seller_per','min','max','max_use','category_id','seller_id','product_id','from','to']);
        switch ($offer_by) {
            case 'CATEGORY':
                $req->validate([
                   'category_id'  => 'required|exists:mongodb.sub_main_filters,_id'
                ]);
                $my_array['category_id'] = $req->input('category_id');
                break;
            case 'SELLER':
                $req->validate([
                    'seller_id'  => 'required|exists:sellers,id'
                ]);
                $my_array['seller_id'] = $req->input('seller_id');
                break;
            case 'PRODUCT':
                $req->validate([
                    'product_id'  => 'required|exists:mongodb.tatx_products,_id'
                ]);
                $my_array['product_id'] = $req->input('product_id');
                break;
        }
        $my_array['is_expired'] = 0;
        Offer::where('id',$offer_id)->update($my_array);

    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateAdImage(Request $req)
    {
        try{
        $req->validate([
            'id'              => 'required|exists:ads',
            'image'           => 'required|mimes:jpeg,png,jpg|max:2000',
        ]);
        $id            = $req->input('id');
        $image         = $req->file('image');

        $model = Ad::where('id',$id);
        $model_data = $model->first();
        $url = Helper::image($image,'update','advs',$model_data->image);
        $model->update(['image' => $url]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateOfferImage(Request $req)
    {
        try{
        $req->validate([
            'id'              => 'required|exists:offers',
            'image'           => 'required|mimes:jpeg,png,jpg|max:2000',
        ]);
        $id            = $req->input('id');
        $image         = $req->file('image');

        $model = Offer::where('id',$id);
        $model_data = $model->first();
        $url = Helper::image($image,'update','offers',$model_data->image);
        $model->update(['image' => $url]);
    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateAd(Request $req)
    {
        try{
        $date = date('Y-m-d H:i:s');
        $req->validate([
            'id'              => 'required|exists:ads',
            'page'            => 'required|in:MAIN,SUB_MAIN',
            'type'            => 'required|in:product,seller,category',
            'expired_at'      => "required|after_or_equal:{$date}",
        ]);
        $id            = $req->input('id');
        $page          = $req->input('page');
        $type          = $req->input('type');
        $expired_at    = $req->input('expired_at');
        $my_array = new Helper();
        switch ($type) {
            case 'product':
                $req->validate([
                    'product_id'  => 'required|string|exists:mongodb.tatx_products,_id'
                ]);
                $my_array->product_id = $req->input('product_id');
                break;
            case 'seller':
                $req->validate([
                    'seller_id'  => 'required|numeric|exists:sellers,id'
                ]);
                $my_array->seller_id = $req->input('seller_id');
                break;
            case 'category':
                $req->validate([
                    'category_id'  => 'required|string|exists:mongodb.sub_main_filters,_id'
                ]);
                $my_array->category_id = $req->input('category_id');
                break;
        }
        $my_array->page         = $req->input('page');
        $my_array->type         = $req->input('type');
        $my_array->expired_at   = $req->input('expired_at');

        $model = Ad::where('id',$id);
        $model->update($my_array->toArray());

    return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteAd(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:ads',
        ]);
        $id   = $req->input('id');
        $model = Ad::where('id',$id);
        $status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function deleteOffer(Request $req)
    {
        try{
        $req->validate([
            'id'        => 'required|exists:offers',
        ]);
        $id   = $req->input('id');
        $model = Offer::where('id',$id);
        $status = Helper::disable($model,'status','ON','OFF','ON','OFF');
    return Helper::return([
            'status'   => $status,
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function updateProviderService(Request $req)
    {
        try{
        $req->validate([
            'service_type_id'   => 'required|numeric|exists:service_types,id',
            'provider_id'       => 'required|numeric|exists:providers,id',
            'service_model'     => 'required|string|max:50',
            'service_number'    => 'required|string|max:50|unique:provider_services',
        ]);
        $model = ProviderService::where($req->all(['service_type_id','provider_id']));
        $model_data = $model->first();;

        if($model_data)
            return Helper::returnError(Lang::get('messages.service_exist'));

            $my_array              = $req->all(['service_type_id','provider_id','service_model','service_number']);
            $ProviderService = new ProviderService($my_array);
            $ProviderService->save();


          return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function approve_manager(Request $req)
    {
        try{
        $req->validate([
            'manager_id'        => 'required|numeric|exists:managers,id',
        ]);
        $manager_id = $req->post('manager_id');
        $manager = Manager::where('id',$manager_id);
        $model_data = $manager->first();
        if($model_data->status != 'PENDING' || $model_data->contract == NULL)
            return Helper::returnError(Lang::get('messages.not_allowed'));

        $manager->update(['status' => 'ON']);
        return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function add_manager(Request $req)
    {
        try{
        $req->validate([
            'first_name'        => 'required|string|min:3|max:20',
            'last_name'         => 'required|string|min:3|max:20',
            'email'             => 'required|email|max:64|unique:managers',
            'commision_per'     => 'required|numeric|between:0,100',
            'company_name'      => 'required|string|min:3|max:50',
            'company_register_no'=> 'required|string|min:3|max:50',
            'company_register_date'=> 'required|date',
            //'password'          => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
           // 'verify_password'   => 'required|same:password',
            'mobile'            => 'required|string|max:20|unique:managers',
         //   'gender'            => 'required|string|in:M,F,U',
        ]);
        $insert = $req->all('first_name','last_name','email','mobile','commision_per','company_name','company_register_no','company_register_date');
        $password = rand(111111,999999);
        $insert['password'] = Hash::make($password);
        $insert['newpass'] = $password;
        $manager = new Manager($insert);
        $manager->save();

        Mail::send('emails.info', $insert, function($message) use ( $manager) {
            $message->to($manager->email)
            ->subject('Tatx Registeration');
            $message->from(env('MAIL_USERNAME'),"Tatx");
        });

        return Helper::return([
            'id'  => $manager->id
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function update_manager(Request $req)
    {
        try{
        $manager_id = $req->input('manager_id');
        $req->validate([
            'manager_id'        => 'required|numeric|exists:managers,id',
            'first_name'        => 'required|string|min:3|max:20',
            'last_name'         => 'required|string|min:3|max:20',
            'email'             => "required|email|max:64|unique:managers,email,{$manager_id},id",
            // 'password'          => 'required|string|min:8|max:16|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            // 'verify_password'   => 'required|same:password',
            'mobile'            => "required|string|max:20|unique:managers,mobile,{$manager_id},id",
        //    'gender'            => 'required|string|in:M,F,U',
        'commision_per'     => 'required|numeric|between:0,100',
        'company_name'      => 'required|string|min:3|max:50',
        'company_register_no'=> 'required|string|min:3|max:50',
        'company_register_date'=> 'required|date',
        ]);
        $insert = $req->all('first_name','last_name','email','mobile','commision_per','company_name','company_register_no','company_register_date');
        // $insert['password'] = Hash::make($req->get('password'));
        $manager = Manager::where('id',$manager_id);
        $manager->update($insert);
        return Helper::return([]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function delete_manager(Request $req)
    {
        try{
        $req->validate([
            'manager_id'        => 'required|numeric|exists:managers,id',
        ]);
        $manager_id = $req->input('manager_id');
        $manager = Manager::where('id',$manager_id);
        $model_data = $manager->first();
        if(!in_array($model_data->status, ['ON','OFF']))
            return Helper::returnError(Lang::get('messages.not_allowed'));
        $status = Helper::disable($manager,'status','ON','OFF','ON','OFF');

        return Helper::return([
            'status' => $status
        ]);
    }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
}
