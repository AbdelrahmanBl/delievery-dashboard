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
use App\Models\Manager;
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
class managerController extends Controller
{
	public function getProfile(Request $req)
    {
        try{
            $manager_id = $req->get('manager_id');
            $where = array(
                'id'    =>  $manager_id           
                 );
            $manager = Manager::where($where)->first();
            $where = array(
                'manager_id'    =>  $manager_id,
                'status'        =>  'ON'         
                 );
            $sellers = Seller::where($where)->get(['id','image','name_en','name_ar']);
            return Helper::return([
                'manager'    => $manager,
                'sellers'    => $sellers,
                'image_url' => env('APP_URL')
            ]);
        }catch(Exception $e){
            return Helper::returnError(Helper::returnException($e));
        }
    }
    public function upload_contract(Request $req)
    {
        try{
            $req->validate([
                'file' => 'required|mimes:pdf|max:10000'
            ]);
            $file = $req->file('file');
            $manager_id = $req->get('manager_id');
            $where = array(
                'id'    =>  $manager_id           
                 );
            $manager = Manager::where($where);
            $model_data = $manager->first();
            if($model_data->status != 'CONTRACT')
                return Helper::returnError(Lang::get('messages.not_allowed'));
            if($model_data->contract)
                $url = Helper::image($file,'update','contracts',$model_data->contract);
            else $url = Helper::image($file,'add','contracts');

            $manager->update(['contract' => $url,'status' => 'PENDING']);
            return Helper::return([
                'image_url' => env('APP_URL'),
                'contract'  => $url
            ]);
        }catch(Exception $e){
            if($e instanceof ValidationException) {
             throw $e;
          }
            return Helper::returnError(Helper::returnException($e));
        }
    }  
}
