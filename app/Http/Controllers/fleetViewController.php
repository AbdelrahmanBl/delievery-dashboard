<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class fleetViewController extends Controller
{
    public function __construct()
    { 
        $this->middleware('guest:fleet');
    } 
    public function dashboard()
    {
    	//
    }
}
