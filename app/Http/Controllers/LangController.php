<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function index(){
        return view('lang');
    }

    // public function change(REQUEST $request){
    //     // dd($request);
    //     App::setLocale($request->lang);
    //     session()->put('locale', $request->lang);
    //     return redirect()->back();
    // }
    public function change(Request $request){
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        
        $viewContent = view('index')->render();
        // dd($viewContent);
        
        return response()->json($viewContent);
    }
    
}
