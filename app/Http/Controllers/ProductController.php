<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\CategoryProduct;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data['categories'] = DB::table('categories')->orderBy('id','desc')->get()->toArray();
        
        return view('admin.add_product',$data);
    }
    public function all_products()
    {
        $data['products'] = DB::table('category_products')
                        ->join('products', 'products.id', '=', 'category_products.product_id')
                        ->join('categories', 'categories.id', '=', 'category_products.category_id')
                        ->select('products.*', 'categories.category as category', 'categories.id as category_id', 'products.created_at')
                        ->orderBy('products.id', 'desc')
                        ->get();

        return view('admin.all_products', $data);
    }
    public function all_categories()
    {
        $data['all_categories'] = DB::table('categories')->orderBy('id','desc')->get()->toArray();

        return view('admin.all_categories', $data);
    }
    public function all_orders()
    {
        $data["orders"]=DB::table("orders")
                ->select('orders.id as order_id', 'users.*', 'orders.*' , 'methods.method', 'cities.city')
                ->join("carts","carts.id","=","orders.cart_id")
                ->join("users","users.id","=","carts.user_id")
                ->join("cities","cities.id","=","orders.city_id")
                ->join("methods","methods.id","=","orders.method_id")
                ->get()
                ->toArray();
               
        return view('admin.all_orders', $data);
    }
    public function orderDetail($id)
    {
        $data["orderDetail"] =  DB::table('cart_products')
                            ->select('orders.*', 'orders.id as order_id','products.*', 'cities.*' , 'countries.*', 'users.*' ,'methods.*', 'cart_products.*')
                            ->join('products', 'products.id', '=' , 'cart_products.product_id')
                            ->join('carts', 'carts.id', '=' , 'cart_products.cart_id')
                            ->join('users', 'users.id', '=' , 'carts.user_id')
                            ->join('cities', 'cities.id', '=' , 'users.city_id')
                            ->join('countries', 'countries.id', '=' , 'users.country_id')
                            ->join('orders', 'orders.cart_id', '=' , 'carts.id')
                            ->join('methods', 'methods.id', '=' , 'orders.method_id')
                            ->where('cart_products.cart_id' ,'=', $id)
                            ->get()
                            ->toArray();
        // dd($data);
        return view('admin.orderDetail', $data);
    }
    public function orderStatusChange(REQUEST $request){
        try{
            $validator = $this->validate($request, [
                'order_status' => 'required',
            ]);

            $data=[
                "order_status"=>$request->input("order_status"),
            ];
             $order_status= Order::where("id", "=", $request->input("order_id"))->update($data);       
             
             return redirect()->to("/orderDetail"."/".$request->input("order_id"))->with('status','Order Status Changed.');      

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    public function store(REQUEST $request){
        try {
         
            $validator = $this->validate($request, [
                'name' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'description' => 'required',
                'category' => 'required',
                'image' => 'required',
            ]);
    
            $product = new Product();
            $product->product = $request->input('name');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->description = $request->input('description');
            $product->status = $request->input('status');
            
            
            if ($request->has('discount')) {
                $product->discount = $request->input('discount');
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->storeAs('images', $imageName, 'public'); 
                $product->feature_image = $imageName;

            }
        
            $product->save();
            $lastInsertedId = $product->id;
            if($lastInsertedId > 0){
                $data = [	
                    "product_id" => $lastInsertedId,
                    "category_id" => $request->input("category"),
                ];
                DB::table('category_products')->insert($data);
            }
            
            return redirect()->to("/home")->with('status','Product created successfully.');  
            
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
