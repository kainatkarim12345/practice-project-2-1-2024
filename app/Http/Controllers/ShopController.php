<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\City;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\Method;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use App\Mail\SendMail;
use App\Mail\SendMessageToEndUser;
use Mail;
use App\Mail\DemoMail;
use Stripe\Exception\ApiErrorException;

class ShopController extends Controller
{
    public function index()
    {
        try {
            $data['categories'] = Category::all();
            
            $data['products'] = DB::table('category_products')
                                    ->join('products', 'products.id', '=' , 'category_products.product_id')
                                    ->join('categories', 'categories.id', '=' , 'category_products.category_id')
                                    ->where('products.status' ,'=', 'active')
                                    ->get();
                                    

            return view('index', $data);
        } catch (\Exception $e) {
            \Log::error("Exception in addcategory: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
    public function category_product($categoryId)
    {
        try {
            $data["category_product"] = DB::table('category_products')
                                ->join('products', 'products.id', '=' , 'category_products.product_id')
                                ->join('categories', 'categories.id', '=' , 'category_products.category_id')
                                ->where('category_products.category_id' ,'=', $categoryId)
                                ->get();
                
            return view('index', $data);

        } catch (\Exception $e) {
            \Log::error("Exception in addcategory: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
    public function addtToCart(Request $request)
    {
        try {
            $quantity = $request->input('quantity', 1);

            $quantity = max(1, $quantity);

            $product_id = $request->input('product_id');

            if (!$request->session()->has('cart')) {
                $request->session()->put('cart', []);
            }

            $cart = $request->session()->get('cart');
            $productIndex = array_search($product_id, array_column($cart, 'product_id'));
            print_r($cart);

            if ($productIndex !== false) {
                // print_r($productIndex);
                $cart[$productIndex]['quantity'] += $quantity;
                if ($request->input('newQuantity')) {
                    $cart[$productIndex]['quantity'] = $request->input('newQuantity');
                }

            } else {
                $cart[] = [
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ];
                // print_r($cart);
                // $productIndex = count($cart) - 1;
            }

            $request->session()->put('cart', $cart);

            return redirect()->to("/")->with('status','Product added to cart successfully'); 

        } catch (\Exception $e) {
            \Log::error("Exception in addtToCart: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
    public function cart()
    {
        $cart = session('cart');
        // dd($cart);
        if ($cart) {
            $productData = [];

            foreach ($cart as $item) {
                $id = $item['product_id'];

                $productInfo = DB::table('category_products')
                    ->join('products', 'products.id', '=', 'category_products.product_id')
                    ->join('categories', 'categories.id', '=', 'category_products.category_id')
                    ->where('category_products.product_id', '=', $id)
                    ->get();

                foreach ($productInfo as $product) {
                    $product->quantity = $item['quantity'];
                }

                $productData[] = $productInfo;
                
            }
            $data['productData'] = $productData;
        }else{
            $data['productData'] = '';
        }
        
        return view('cart' , $data);
    }
    
    public function cart_item_remove(Request $request)
    {
        try {
            $cart = $request->session()->get('cart');

            if ($cart) {
            
                $productIndex = array_search($request->input('product_id'), array_column($cart, 'product_id'));

                if ($productIndex !== false) {
                    
                    unset($cart[$productIndex]);
                    
                    $request->session()->put('cart', $cart);

                    $data["message"] = "Product removed from cart successfully";
                    return $data;
                }
            }else{
                $data["message"] = "cart empty";
                return $data;
            }

        } catch (\Exception $e) {
            \Log::error("Exception in removeFromCart: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }

    public function productDetail($id)
    {
        $data["product"] =  DB::table('category_products')
                            ->join('products', 'products.id', '=' , 'category_products.product_id')
                            ->join('categories', 'categories.id', '=' , 'category_products.category_id')
                            ->where('category_products.product_id' ,'=', $id)
                            ->get();
        
        $data['categories'] = DB::table('category_products')
                            ->join('products', 'products.id', '=', 'category_products.product_id')
                            ->join('categories', 'categories.id', '=', 'category_products.category_id')
                            ->select('categories.id', 'categories.category', DB::raw('COUNT(products.id) as product_count'))
                            ->groupBy('categories.id', 'categories.category')
                            ->get();

        return view('productDetail', $data);
    }
    public function shop()
    {
        return view('shop');
    }
    public function checkout()
    {
        $data['cities'] = City::all();
        $data['methods'] = Method::all();
        $data['countries'] = Country::all();
        $cart = session('cart');

        if ($cart) {
            $productData = [];

            foreach ($cart as $item) {
                $id = $item['product_id'];

                $productInfo = DB::table('category_products')
                    ->join('products', 'products.id', '=', 'category_products.product_id')
                    ->join('categories', 'categories.id', '=', 'category_products.category_id')
                    ->where('category_products.product_id', '=', $id)
                    ->get();

                foreach ($productInfo as $product) {
                    $product->quantity = $item['quantity'];
                }

                $productData[] = $productInfo;
                
            }
            $data['productData'] = $productData;
        }else{
            $data['productData'] = '';
        }

        return view('checkout' , $data);
    }

    public function add_order_process(REQUEST $request){
        try{
                $sessionCart = session('cart');
                $validator = $this->validate($request, [
                    'email' => 'required',
                    'mobile_number' => 'required',
                    'zip_code' => 'required',
                    'city_id' => 'required',
                    'country_id' => 'required',
                    'billing_address' => 'required',
                    'last_name' => 'required',
                    'first_name' => 'required'
                ], [
                    'email.required' => 'The email is required.',
                    'mobile_number.required' => 'The mobile numberis required.',
                    'zip_code.required' => 'The zip code is required.',
                    'city_id.required' => 'The city is required.',
                    'country_id.required' => 'The country is required.',
                    'billing_address.required' => 'The billing address is required.',
                    'last_name.required' => 'The last name is required.',
                    'first_name.required' => 'The first name is required.'
                ]);

                // \Stripe\Stripe::setApiKey(config('stripe.sk'));

                // if ($cart) {
                //     // foreach($cart as $key){
                        
                //     //     $product_id = $key['product_id'];
                //     //     $data["product"] = DB::table('category_products')
                //     //                 ->join('products', 'products.id', '=', 'category_products.product_id')
                //     //                 ->join('categories', 'categories.id', '=', 'category_products.category_id')
                //     //                 ->where('category_products.product_id', '=', $product_id)
                //     //                 ->select('products.product', 'products.price')
                //     //                 ->get();

                //         $p = 'hhh';
                //         $t = '56';
                //         $total_price = $request->input('total');
                //         $q = '56';
                //         $total_amount = $t*$q;
                //         $two0 = "00";
                //         $total = "$total_price$two0";
                //         $session = \Stripe\Checkout\Session::create([
                //             'line_items' => [
                //                 [
                //                     'price_data' => [
                //                         'currency' => 'USD',
                //                         'product_data' => [
                //                             'name' => $p,
                //                         ],
                //                         'unit_amount' => $t,
                //                     ],
                //                     'quantity' => $q,
                //                 ],
                //             ],
                //             'mode' => 'payment',
                //             'success_url' => route('success'),
                //             'cancel_url' => route('checkout'),
                //         ]);
                //         dd("session",$session);

                //         $stripeSessionId = $session->id;
                //         $paymentIntentId = $session->payment_intent;

                //         return redirect()->away(route('success', [
                //             'session_id' => $stripeSessionId,
                //             'payment_intent_id' => $paymentIntentId,
                //         ]));
                //     // }
                // }

                $user = new User();
                $user->user_role_id = '2';
                $user->name = $request->input('first_name').' '.$request->input('last_name');
                $user->email = $request->input('email');
                $user->mobile_number = $request->input('mobile_number');
                $user->address = $request->input('billing_address');
                $user->city_id = $request->input('city_id');
                $user->country_id = $request->input('country_id');
                $user->zip_code = $request->input('zip_code');
                $user->password = '111';

                $user->save();
                $insertedUserId = $user->id;
                $userEmail = $user->email;

                $cart = new Cart();
                $cart->user_id = $insertedUserId;
                $cart->save();
                $insertedCartId = $cart->id;
                
                $inserted_cart_product_id = [];
                if ($sessionCart) {
                    foreach($sessionCart as $key){
                        
                        $product_id = $key['product_id'];
                        $quantity = $key['quantity'];
                        
                        $cart_product = new CartProduct();
                        $cart_product->quantity = $quantity;
                        $cart_product->product_id = $product_id;
                        $cart_product->cart_id = $insertedCartId;
                        $cart_product->save();
                    }
  
                        $order = new Order();
                        $order->billing_address = $request->input('billing_address');
                        if($request->input('shipping_address')){
                            $order->shipping_address = $request->input('shipping_address');
                        }else{
                            $order->shipping_address = $request->input('billing_address');
                        }
                        $length = 6;
                        $order_number = '#';

                        for ($i = 0; $i < $length; $i++) {
                            $order_number .= mt_rand(0, 9); 
                        }

                        $order->cart_id = $insertedCartId;
                        $order->city_id = $request->input('city_id');
                        $order->order_number = $order_number;
                        $order->method_id = '1';
                        $order->save();
                        $orderId = $order->id;

                        session()->forget('cart');

                        $mailData = [
                            'title' => 'Your Order Number#'.' '.$orderId,
                            'body' => 'Thank you for your recent purchase. We are honored to gain you as a customer and hope to serve you for a long time.'
                        ];
                         
                        Mail::to($request->input('email'))->send(new DemoMail($mailData));
                           
                        return redirect()->to("/")->with(['orderstatus' => 'Order Confirmed Successfully', 'orderId' => $orderId]);
                     
                }
               
        } catch (exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
    public function success(Request $request)
    {
        try {
    
            $session_id = $request->input('session_id');
    
            if (empty($session_id) || !is_string($session_id)) {
                return redirect()->action([ShopController::class, 'index'])->with('msg', 'Invalid Session ID');
            }
    
            \Stripe\Stripe::setApiKey(config('stripe.sk'));
    
            $session = \Stripe\Checkout\Session::retrieve($session_id);
    
            $payment_status = $session->payment_status;
            $payment_amount = $session->amount_total;
            $payment_currency = $session->currency;
            $stripeSessionId = $session->id;
            $paymentIntentId = $session->payment_intent;
    
            dd($session);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->action([ShopController::class, 'index'])->with('msg', 'Stripe API Error: ' . $e->getMessage());
        }
    }
    public function testinomial()
    {
        return view('testinomial');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
