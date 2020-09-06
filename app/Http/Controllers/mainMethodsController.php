<?php

 namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Fleet;
use validate;
use Hash;
use Auth;

class mainMethodsController extends Controller
{
    public function __construct()
    { 
        $this->middleware('guest:main')->except('logout');
    }
    public function login(Request $req)
    {
        $req->validate([
            'email'         => 'required|email',
            'password'      => 'required',
            'status'        => 'required|in:ADMIN,FLEET'
        ]);
        $email      = $req->input('email');
        $password   = $req->input('password');
        $status = $req->input('status');
        if($status == 'ADMIN'){
        $req->validate([
            'email'         => 'exists:admins',
        ]);
            $Admin = Admin::where('email',$email)->first();
            if( !Hash::check($password, $Admin->password) )
            return back()->with([
                'login'  => 'Email or Password is incorrect', 
                'email'  => $email,
                'status' => $status,
            ]);
            Auth::guard('admin')->loginUsingId($Admin->id,true);
        }
            
        else if($status == 'FLEET'){
        $req->validate([
            'email'         => 'exists:fleets',
        ]);  
            $Fleet = Fleet::where('email',$email)->first();
            if( !Hash::check($password, $Fleet->password) )
            return back()->with([
                'login'  => 'Email or Password is incorrect', 
                'email'  => $email,
                'status' => $status,
            ]);
            Auth::guard('fleet')->loginUsingId($Fleet->id,true);
        }
        return redirect('dashboard');      
    }
    public function register(Request $req)
    {
    	$req->validate([
            'name'          => 'required|string|max:30',
            'email'         => 'required|email|unique:fleets',
            'password'      => 'required|string',  
        ]);
        $name           = $req->input('name');
        $email          = $req->input('email');
        $password       = $req->input('password');
        $Fleet = new Fleet([
            'name'      => $name,
            'email'     => $email, 
            'password'  => Hash::make($password),
        ]);
        $Fleet->save();
        //Auth::guard('fleet')->loginUsingId($Fleet->id,true);
        die('Your Account Will Be Approved Later');
    }
    public function forgot()
    {
    	return 'OK';
    }
    public function logout()
    {
        if(Auth::guard('admin')->check())
            Auth::guard('admin')->logout();
        else if(Auth::guard('fleet')->check())
            Auth::guard('fleet')->logout();
        
        return redirect('login');
    }
}
