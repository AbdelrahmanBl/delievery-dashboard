<?php

namespace App\Http\Middleware;
use App\Models\Setting;
use Closure;
use Crypt;
use Exception;
use App\Helper;
use App;

class AuthKey
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
        /*$token1     = $request->header('header-key');
        $token2     = Crypt::decrypt($request->header('oath-key'));
        $header_key = Setting::where('key','HEADER_ADMIN_KEY')->first()->value;
        $oath_key   = Setting::where('key','OATH_ADMIN_KEY')->first()->value;
        if($token1 != $header_key || $token2 != $oath_key){
            return Helper::notFound('Not Authenicated !');
        }*/
        $language         = $request->header('language');
        if(!in_array($language, ['en','ar']))
            $request->headers->set('language', 'ar');
        App::setlocale($language);
        return $next($request);
    }catch(Exception $e){
        return Helper::notFound('Not Authenicated !');
    }
    }
}
