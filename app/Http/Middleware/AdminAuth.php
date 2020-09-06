<?php

namespace App\Http\Middleware;
use App\Models\Admin;
use Closure;
use Crypt;
use Exception;
use App\Helper;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {try{
        $email            = $request->header('email');

        $model = Admin::where('email',$email);
        $data = $model->first();

        if(!$data) 
            return Helper::notFound('Not Authenicated !');
        
        if($data->failed_try >= 20)
            return Helper::notFound('Found But Closed');
        
        // $access_token     = Crypt::decrypt($request->header('access-token'));
        // if($data->remember_token != $access_token){
        //     $model->increment('failed_try');
        //     return Helper::notFound('Not Authenicated !');
        // }
       
        $request->attributes->add([
            'admin_id'       => $data->id
        ]);
        return $next($request);
        }catch(Exception $e){
         return Helper::notFound('Not Authenicated !');
        }
    }
}
