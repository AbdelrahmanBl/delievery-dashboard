<?php

namespace App\Http\Middleware;
use App\Models\Seller;
use Closure;
use Crypt;
use Exception;
use App\Helper;

class SellerAuth
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
        
        $where = array(
            'email'           => $email,
        ); 
        $model = Seller::where($where);
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
        
        $request->attributes->add([
            'id'             => $data->id,
            'uniqueID'       => $data->uniqueID,
            'seller_en'      => $data->name_en,
            'seller_ar'      => $data->name_ar,
            'seller_module'  => $data->module,
        ]);

        return $next($request);
        }catch(Exception $e){
         return Helper::notFound('Not Authenicated !');
        }
    }
}
