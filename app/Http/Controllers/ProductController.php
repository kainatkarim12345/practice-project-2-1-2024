<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\CategoryProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        $data['categories'] = DB::table('categories')->orderBy('id','desc')->get()->toArray();
        
        return view('admin.add_product',$data);
    }
    public function all_products()
    {
        $data['products'] = DB::table('category_products')
            ->join('products', 'products.id', '=' , 'category_products.product_id')
            ->join('categories', 'categories.id', '=' , 'category_products.category_id')
            ->orderBy('products.id','desc')
            ->get();
           
            
            return view('admin.all_products', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
