<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function addcategory(Request $request)
    {
        try {
            $data = [	
                "category" => $request->input("category"),
            ];

            $category = DB::table('categories')->insert($data);
            $data['categories'] = DB::table('categories')->orderBy('id','desc')->get()->toArray();

            if ($category) {
                $data["message"] = "Category added successfully";
                $data["class"] = "alert alert-primary text-center";
            } else {
                $data["message"] = "Please Try Again";
                $data["class"] = "alert alert-danger text-center";
            }


            return $data;
        } catch (\Exception $e) {
            \Log::error("Exception in addcategory: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }


}
