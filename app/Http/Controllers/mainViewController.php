<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Auth;
class mainViewController extends Controller
{
    public function __construct()
    { 
        $this->middleware('guest:main');
    } 
    public function login()
    {
    	try{
    		return view('Main.login');
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }
    public function register()
    {
    	try{
    		return view('Main.register');
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }
    public function forgot()
    {
    	try{
    		return view('Main.forgot');
    	}catch(Exception $e){
    		return $e->getMessage();
    	}
    }
}
