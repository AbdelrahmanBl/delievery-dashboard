<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models\Setting;
use App\Models\Admin;
use App\Models\Seller;
use App\Models\Manager;
use App\Models\SubSeller;
use App\Models\Fleet;
use App\Models\Category;
use App\Models\mainMongo;
use App\Models\tatxProduct;
use App\Models\categorySearch;

use App\Imports\CsvImport;
use App\Helper;
use Hash;
use validate;
use Crypt;
use Mail;
class mainMethodsController extends Controller
{
    public function connection(Request $req)
    {try{
        $header_key = Setting::where('key','HEADER_ADMIN_KEY')->first()->value;
        $oath_key   = Setting::where('key','OATH_ADMIN_KEY')->first()->value;
        return Helper::return([
            'key1'     => $header_key,
            'key2'     => $oath_key,
        ]);
    }catch(Exception $e){
      return Helper::returnError(Helper::returnException($e));
    }
    }
    public function excel(Request $req)
    {try{
        // tatxProduct::where('uniqueID','panda')->delete();
        /*foreach($req->input('data') as $item){
            $tatxProduct = new tatxProduct();
            $tatxProduct::insert($item);
        }
        return 0;*/
        $import = Excel::toArray(new CsvImport, $req->file('file'));
        array_shift($import[0]);
        $arr = array();
        for($i = 0 ; $i < count($import[0]) ; $i++){
        $Card = new tatxProduct();
        $Card->en = [
            "name" => $import[0][$i][8] . ' ' . $import[0][$i][2],
            "brand" => $import[0][$i][8],
            "category" => $import[0][$i][15],
            "sub_category" => $import[0][$i][11],
            "seller" => 'farm markets',
            "currency" => 'sar',
            "desc"  => $import[0][$i][21],
        ];
        $Card->ar = [
            "name" => $import[0][$i][7] . ' ' . $import[0][$i][1],
            "brand" => $import[0][$i][7],
            "category" => $import[0][$i][14],
            "sub_category" => $import[0][$i][10],
            "seller" => 'اسواق المزرعة',
            "currency" => 'ريال',
            "desc"  => $import[0][$i][20],
        ];
        $Card->uniqueID = '1594998041';
        $Card->image = NULL;
        $Card->images = array();
        $Card->bundle_product = array();
        $Card->options = array();
        $Card->price = $import[0][$i][22];
        $Card->old_price =  0 ;
        $Card->dicount_percentage = 0;
        $Card->prepared_time = 0;
        $Card->is_outOfStock = false;
        $Card->status = "ON";
        $Card->created_at = date('Y-m-d H:i:s');
        return $Card;
        $Card->save();
        }
        return Helper::return([]);
    }catch(Exception $e){
      return Helper::returnError(Helper::returnException($e));
    }
    }
    public function login(Request $req)
    {try{
        $req->validate([
            'email'         => 'required|email',
            'password'      => 'required',
            'status'        => 'required|in:ADMIN,SELLER,SUB_SELLER,MANAGER',
        ]);
        $email      = $req->input('email');
        $password   = $req->input('password');
        $status     = $req->input('status');

        switch($status){
            case 'ADMIN':
                $model      = new Admin();
                break;
            case 'SELLER':
                $model      = new Seller();
                break;
            case 'SUB_SELLER':
                $model      = new SubSeller();
                break;
            case 'MANAGER':
                $model      = new Manager();
                break;
        }
            $model_select  = $model->where('email',$email);
            $model_data    = $model_select->first();
            if(!$model_data)
                return Helper::returnError(Lang::get('auth.failed'));
            if(in_array($status,['SELLER','SUB_SELLER','MANAGER']))
                if($model_data->status == 'OFF')
                    return Helper::returnError(Lang::get('auth.deactivate'));
            if($model_data->failed_try >= 20)
                return Helper::returnError(Lang::get('auth.blocked'));
            if( !Hash::check($password, $model_data->password) ){
            $model_select->increment('failed_try');
            return Helper::returnError(Lang::get('auth.failed'));
            }

            $token    = Helper::loginUsingId($model_select);
            $is_first = ($model_data->is_first)? $model_data->is_first : 0 ;
            // $return_data = $model_data->status =='CONTRACT' ? $model_data : NULL;

        return Helper::return([
            'access_token'   => $token,
            'is_first'       => $is_first,
            // 'data'          =>$return_data,
        ]);
       }catch(Exception $e){
          if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
        }
    }
    public function register(Request $req)
    {try{
    	$req->validate([
            'icon'              => 'required|image|mimes:jpeg,png,jpg|max:2000',
            'name_en'           => 'required|unique:sellers|max:50',
            'delievery_us'      => 'required|bool',
            'email'             => 'required|email|max:100|unique:sellers',
            'module'            => 'required|exists:mongodb.modules',
        ]);
        $image             = $req->file('icon');
        $name_en           = $req->input('name_en');
        $delievery_us      = $req->input('delievery_us');
        $email             = $req->input('email');
        $module            = $req->input('module');
        $uniqueID          = time();
        $image             = Helper::image($image,'add','delievery/main_icons');

        $Seller = new Seller([
        "image"              => $image,
        "name_en"            => $name_en,
        "name_ar"            => '',
        "uniqueID"           => $uniqueID,
        "delievery_us"       => $delievery_us,
        "delievery_fees"     => 0,
        "delievery_ratio"    => 0,
        "min_ratio"          => 0,
        "min_order"          => 0,
        "has_product"        => 1,
        "main_color"         => '',
        "commision_per"      => 0,
        "next_deilevery"     => '',
        "duration_from"      => 0,
        "duration_to"        => 0,
        "address"            => '',
        "latitude"           => 0,
        "longitude"          => 0,
        "type"               => '',
        "email"              => $email,
        "password"           => Hash::make('123456'),
        "status"             => 'OFF',
        "module"             => $module,
        ]);
        $Seller->save();
        return Helper::return([
            'message'   => Lang::get('messages.registered')
        ]);
        }catch(Exception $e){
        if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
    }
    }
    public function send_email(Request $req)
    {try{
        $req->validate([
            'first_name'         => 'required|string|max:25',
            'last_name'          => 'required|string|max:25',
            'phone'              => 'required|string|max:15',
            'email'              => 'required|email|max:64',
            'store_name'         => 'required|string|max:64',
            'store_type'         => 'required|string|exists:mongodb.main_categories,type',
            'store_address'      => 'required|string|max:255',
            'code'               => 'required|string|max:255',

        ]);

        $data = $req->all('first_name','last_name','phone','email','store_name','store_type','store_address','code');
        $email = $req->input('email');
        try{
        Mail::send('emails.welcome', $data, function($message) use ( $email) {
            $message->to($email)
            ->subject('Tatx Welcome Message');
            $message->from(env('MAIL_USERNAME'),"Tatx");
        });
        Mail::send('emails.message', $data, function($message) use ( $email) {
            $message->to(env('MAIL_USERNAME'))
            ->subject('Tatx New Seller');
            $message->from(env('MAIL_USERNAME'),"Tatx");
        });
      }catch(Exception $e){
        return Helper::returnError(Helper::returnException($e));
    }
        return Helper::return([]);
       }catch(Exception $e){
          if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
        }
    }
    public function get_website(Request $req)
    {try{

        return Helper::return([
            'google_play' => Setting::where('key','google_play')->first()->value,
            'app_store'   => Setting::where('key','app_store')->first()->value,
            'sections' => mainMongo::where('status','ON')->get(['icon','name_en','name_ar','desc_en','desc_ar','type']),
        ]);
       }catch(Exception $e){
          if($e instanceof ValidationException) {
             throw $e;
          }
         return Helper::returnError(Helper::returnException($e));
        }
    }
    public function forgot()
    {
    	return 'OK';
    }
}
