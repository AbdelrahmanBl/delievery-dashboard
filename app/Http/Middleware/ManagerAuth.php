<?php

namespace App\Http\Middleware;
use App\Models\Manager;
use App\Models\Seller;
use Closure;
use Crypt;
use Exception;
use App\Helper;

class ManagerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try{
        $email            = $request->header('email');
        $seller_id        = $request->header('seller-id');
        $where = array(
            'email'           => $email,
        ); 
        $model = Manager::where($where);
        $data  = $model->first();
        if(!$data){
            return Helper::notFound('Not Authenicated !');
        }
        if($data->failed_try >= 20)
            return Helper::notFound('Found But Closed');
    
        // $access_token     = Crypt::decrypt($request->header('access-token'));
        // if($data->remember_token != $access_token){
        //     $model->increment('failed_try');
        //     return Helper::notFound('Not Authenicated !');
        // }
        if($data->status == 'OFF'){
            return Helper::notFound('admin close connection');
        }
        
        $manager_id = $data->id;
        if($seller_id){
        $where = array(
            'manager_id'    => $manager_id,
            'id'            => $seller_id,
        );
        $data = Seller::where($where)->first();
        if(!$data){
            return Helper::notFound('Not Authenicated !');
        }
        if($data->status == 'OFF'){
            return Helper::notFound('admin close connection on seller');
        }
        }
        $request->attributes->add([
            'id'             => $data->id,
            'uniqueID'       => $data->uniqueID,
            'seller_en'      => $data->name_en,
            'seller_ar'      => $data->name_ar,
            'seller_module'  => $data->module,
            'manager_id'     => $manager_id,
        ]);

        return $next($request);
        }catch(Exception $e){
         return Helper::notFound('Not Authenicated !');
        }
    }
}

