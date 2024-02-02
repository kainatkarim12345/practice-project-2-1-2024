<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->user_role_id == 1)
        {
            return view("home");
        }
        else if(Auth::user()->user_role_id == 2)
        {
            dd('customer');
             return view("home");
        }
        else{
            return view('home');
        }
        
    }
    
}
