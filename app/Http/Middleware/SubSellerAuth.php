<?php

namespace App\Http\Middleware;
use App\Models\Seller;
use App\Models\SubSeller;
use Closure;
use Crypt;
use Exception;
use App\Helper;

class SubSellerAuth
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
        // $access_token     = Crypt::decrypt($request->header('access-token'));
        $where = array(
            'sellers.status'         => 'ON',
            'sub_sellers.email'      => $email,
            // 'sub_sellers.remember_token'  => $access_token,
        );
        $select = array(
            'sellers.id',
            'sellers.uniqueID',
            'sellers.name_en',
            'sellers.name_ar',
            'sellers.module',
            'sub_sellers.status',
            'sub_sellers.failed_try',
            'sub_sellers.id as sub_seller_id'
        );
        $model = SubSeller::where($where)->join('sellers','sellers.id','sub_sellers.seller_id')->select($select)->first();
        if(!$model){
            return Helper::notFound('Not Authenicated !');
        }

        if($model->status == 'OFF'){
            return Helper::notFound('admin close connection');
        }

        if($model->failed_try >= 20)
            return Helper::notFound('Found But Closed');
        
        $request->attributes->add([
            'id'         => $model->id,
            'uniqueID'   => $model->uniqueID,
            'seller_en'  => $model->name_en,
            'seller_ar'  => $model->name_ar,
            'seller_module'  => $model->module,
            'sub_seller_id' => $model->sub_seller_id,
        ]);

        return $next($request);
        }catch(Exception $e){
         return Helper::notFound('Not Authenicated !');
        }
    }
}
