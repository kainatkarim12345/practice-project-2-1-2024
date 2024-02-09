<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\NotificationSendController;
use App\Http\Controllers\LangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::group(
//     [
//         'prefix' => LaravelLocalization::setLocale(),
//         'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
//     ], function(){ //...
    
//     /** Localized Routes here **/
//     // Route::get('/', function(){
//     //     return view("welcome");
//     // });
//     Route::get('/', [ShopController::class, 'index']);

//     Route::get('/test', function(){
//         return view("test");
//     });

//     Route::get('/es', function(){
//         return view("welcome");
//     });
    
//     });
    

Route::get('lang/home',[LangController::class,'index']);
Route::get('lang/change',[LangController::class,'change'])->name('changeLang');


Route::group(['middleware' => 'isAdmin'],function(){
    Route::get('add_product', [ProductController::class, 'index'])->name('home');
    Route::get('all_products', [ProductController::class, 'all_products'])->name('all_products');
    Route::get('all_categories', [ProductController::class, 'all_categories'])->name('all_categories');
    Route::get('all_orders', [ProductController::class, 'all_orders'])->name('all_orders');
    Route::get('orderDetail/{id}', [ProductController::class, 'orderDetail'])->name('orderDetail');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::post('orderStatusChange', [ProductController::class, 'orderStatusChange'])->name('orderStatusChange');
    Route::post('addcategory', [AjaxController::class, 'addcategory'])->name('addcategory');
    Route::post('/store-token', [NotificationSendController::class, 'updateDeviceToken'])->name('store.token');
    Route::post('/send-web-notification', [NotificationSendController::class, 'sendNotification'])->name('send.web-notification');
});


Route::get('/', [ShopController::class, 'index']);
Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
Route::post('/addtToCart', [ShopController::class, 'addtToCart'])->name('addtToCart');
Route::post('/add_order_process', [ShopController::class, 'add_order_process'])->name('add_order_process');
Route::get('/success', [ShopController::class, 'success'])->name('success');
Route::get('/cart_item_remove', [ShopController::class, 'cart_item_remove'])->name('cart_item_remove');
Route::get('productDetail/{id}', [ShopController::class, 'productDetail'])->name('productDetail');
Route::get('productCategory/{id}', [ShopController::class, 'productCategory'])->name('productCategory');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop');
Route::get('/testinomial', [ShopController::class, 'testinomial'])->name('testinomial');
Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout');
Route::get('category_product/{id}', [ShopController::class, 'category_product'])->name('category_product');