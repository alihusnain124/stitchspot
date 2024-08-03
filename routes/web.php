<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\admin\AdminController;
use  App\Http\Controllers\admin\CategoryController;
use  App\Http\Controllers\admin\CouponController;
use  App\Http\Controllers\admin\SizeController;
use  App\Http\Controllers\admin\ColorController;
use  App\Http\Controllers\admin\TaxController;
use  App\Http\Controllers\admin\ProductController;
use  App\Http\Controllers\admin\BrandController;
use  App\Http\Controllers\admin\CustomerController;
use  App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\HomeBannerController;

use  App\Http\Controllers\front\FrontController;
use  App\Http\Controllers\front\StripePaymentController;
/*

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

  ////front
  // Route::get('/',function(){
  //   return view('welcome');
  // });
  Route::get('/',[FrontController::class,'index']);
  Route::get('/registration',[FrontController::class,'registration']);
  Route::post('/registration_process',[FrontController::class,'registration_process']);
  Route::get('/login',[FrontController::class,'login'])->name('login');
  Route::post('/login_process',[FrontController::class,'login_process']);
  Route::get('/profile/{id}',[FrontController::class,'profile']);
  Route::get('/products',[FrontController::class,'products']);
  Route::get('/product-details/{id}',[FrontController::class,'product_details']);
  Route::get('/search',[FrontController::class,'search']);
  Route::get('/cart',[FrontController::class,'cart']);
  Route::post('/add_to_cart',[FrontController::class,'add_to_cart']);
  Route::post('/update_cart',[FrontController::class,'update_cart']);
  Route::post('/delete_cart',[FrontController::class,'delete_cart']);
  Route::get('/checkout',[FrontController::class,'checkout']);
  Route::post('/add_to_cart_product',[FrontController::class,'add_to_cart_product']);
  Route::get('/category/{slug}',[FrontController::class,'categories']);
  Route::get('/contact',[FrontController::class,'contact']);
  Route::get('/order_process',[FrontController::class,'order_process']);
  Route::get('/order_placed',[FrontController::class,'order_placed']);
  Route::get('/contact_process',[FrontController::class,'contact_process']);
  Route::get('/form',[FrontController::class,'form']);
  Route::post('/add_service',[FrontController::class,'add_service']);
  Route::get('/edit_profile/{id}',[FrontController::class,'editprofile']);
  Route::get('/customers_dashboard',[FrontController::class,'dashboard']);
  Route::get('/services',[FrontController::class,'services']);
  Route::get('/service-details/{id}',[FrontController::class,'service_details']);
  Route::post('/change_product/{id}',[FrontController::class,'change_product']);
  Route::get('/search_service',[FrontController::class,'search_service']);
  Route::get('/recommended_products',[FrontController::class,'get_products']);
  Route::get('/account_no',[FrontController::class,'account_no']);
  
  


    ///orders

Route::post('/user_order',[FrontController::class,'user_order']);
Route::post('/action',[FrontController::class,'action']);
Route::get('/order_details/{id}',[FrontController::class,'order_details']);
Route::post('/complete',[FrontController::class,'complete']);




  ////payment gateway
  Route::get('stripe', [StripePaymentController::class, 'stripe'])->name('stripe');
  Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

  /////payment for user tailor's order

  Route::get('stripe_pay/{id}/{price}', [StripePaymentController::class, 'stripe_pay'])->name('stripe_pay');
  Route::post('stripe_pay', [StripePaymentController::class, 'stripePost_pay'])->name('stripe_pay.post');

  /////tailor payment from admin

  Route::get('stripe_pay_tailor/{id}/{user_id}/{price}', [StripePaymentController::class, 'stripe_pay_tailor'])->name('stripe_pay_tailor');
  Route::post('stripe_pay_tailor', [StripePaymentController::class, 'stripePost_pay_tailor'])->name('stripe_pay_tailor.post');
     

                 ///rating and review

 Route::post('/rating',[FrontController::class,'rating']);
 Route::get('/user_review/{id}',[FrontController::class,'user_review']);
 Route::post('/review',[FrontController::class,'review']);

  Route::get('/logout',function(){
     session()->forget('FRONT_USER_LOGIN');
     session()->forget('FRONT_USER_NAME');
     session()->forget('FRONT_USER_EMAIL');
     session()->forget('FRONT_USER_MOBILE');
     session()->forget('IS_TAILOR');
     session()->forget('FRONT_USER_TYPE','Reg');
     return redirect('/');

  });

      ////Admin
    Route::get('/admin/login',[AdminController::class,'index']);
    Route::post('/admin/auth',[AdminController::class,'auth'])->name('admin.auth');
 
    Route::group(["middleware"=>"admin_auth"],function(){
    Route::get('/admin/dashboard',[AdminController::class,'dashboard']);
    Route::get('/admin/logout', function () {
        session()->forget('admin_login');
        session()->forget('admin_id');
        session()->flash('error','Logout Successfully');
        return redirect('admin/login');
    });
                 /////Category
    Route::get('/admin/category',[CategoryController::class,'index']);
    Route::get('/admin/category/add_category',[CategoryController::class,'add_cat']);
    Route::post('/admin/category/add_cat_process',[CategoryController::class,'manage_cat_process'])->name('category.manage_process');
    Route::get('/admin/category/delete/{id}',[CategoryController::class,'delete'])->name('category.delete');
    Route::get('/admin/category/add_category/{id}',[CategoryController::class,'add_cat'])->name('category.manage');
    Route::get('/admin/category/status/{status}/{id}',[CategoryController::class,'status'])->name('category.status');

                /////Coupons
    Route::get('/admin/coupon',[CouponController::class,'index']);
    Route::get('/admin/coupon/add_coupon',[CouponController::class,'add_coupon']);
    Route::post('/admin/coupon/add_coupon_process',[CouponController::class,'manage_coupon_process'])->name('coupon.manage_process');
    Route::get('/admin/coupon/delete/{id}',[CouponController::class,'delete'])->name('coupon.delete');
    Route::get('/admin/coupon/add_coupon/{id}',[CouponController::class,'add_coupon'])->name('coupon.manage');
    Route::get('/admin/coupon/status/{status}/{id}',[CouponController::class,'status'])->name('coupon.statsu');

                  ////Size
    Route::get('/admin/size',[SizeController::class,'index']);
    Route::get('/admin/size/add_size',[SizeController::class,'add_size']);
    Route::post('/admin/size/add_size_process',[SizeController::class,'manage_size_process'])->name('size.manage_process');
    Route::get('/admin/size/delete/{id}',[SizeController::class,'delete'])->name('size.delete');
    Route::get('/admin/size/add_size/{id}',[SizeController::class,'add_size'])->name('size.manage');
    Route::get('/admin/size/status/{status}/{id}',[SizeController::class,'status'])->name('size.statsu');

                  /////color
    Route::get('/admin/color',[ColorController::class,'index']);
    Route::get('/admin/color/add_color',[ColorController::class,'add_color']);
    Route::post('/admin/color/add_color_process',[ColorController::class,'manage_color_process'])->name('color.manage_process');
    Route::get('/admin/color/delete/{id}',[ColorController::class,'delete'])->name('color.delete');
    Route::get('/admin/color/add_color/{id}',[ColorController::class,'add_color'])->name('color.manage');
    Route::get('/admin/color/status/{status}/{id}',[ColorController::class,'status'])->name('color.statsu');        



                   /////Taxs
    Route::get('/admin/tax',[TaxController::class,'index']);
    Route::get('/admin/tax/add_tax',[TaxController::class,'add_tax']);
    Route::post('/admin/tax/add_tax_process',[TaxController::class,'manage_tax_process'])->name('tax.manage_process');
    Route::get('/admin/tax/delete/{id}',[TaxController::class,'delete'])->name('tax.delete');
    Route::get('/admin/tax/add_tax/{id}',[TaxController::class,'add_tax'])->name('tax.manage');
    Route::get('/admin/tax/status/{status}/{id}',[TaxController::class,'status'])->name('tax.statsu');        

                   /////product
    Route::get('/admin/product',[ProductController::class,'index']);
    Route::get('/admin/product/add_product',[ProductController::class,'add_product']);
    Route::post('/admin/product/add_product_process',[ProductController::class,'manage_product_process'])->name('product.manage_process');
    Route::get('/admin/product/delete/{id}',[ProductController::class,'delete'])->name('product.delete');
    Route::get('/admin/product/product_attr_delete/{paid}/{pid}',[ProductController::class,'product_attr_delete'])->name('product_attr.delete');
    Route::get('/admin/product/product_img_delete/{piid}/{pid}',[ProductController::class,'product_img_delete'])->name('product_img.delete');
    Route::get('/admin/product/add_product/{id}',[ProductController::class,'add_product'])->name('product.manage');
    Route::get('/admin/product/status/{status}/{id}',[ProductController::class,'status'])->name('product.status');   
    
    

              /////brands
    Route::get('/admin/brand',[BrandController::class,'index']);
    Route::get('/admin/brand/add_brand',[BrandController::class,'add_brand']);
    Route::post('/admin/brand/add_brand_process',[BrandController::class,'manage_brand_process'])->name('brand.manage_process');
    Route::get('/admin/brand/delete/{id}',[BrandController::class,'delete'])->name('brand.delete');
    Route::get('/admin/brand/add_brand/{id}',[BrandController::class,'add_brand'])->name('brand.manage');
    Route::get('/admin/brand/status/{status}/{id}',[BrandController::class,'status'])->name('brand.statsu');    


              /////customer
    Route::get('/admin/customer',[CustomerController::class,'index']);
    Route::get('/admin/customer/view/{id}',[CustomerController::class,'view'])->name('customer.manage');
    Route::get('/admin/customer/status/{status}/{id}',[CustomerController::class,'status'])->name('customer.statsu');    



                   /////HomeBannner
    Route::get('/admin/banner',[HomeBannerController::class,'index']);
    Route::get('/admin/banner/add_banner',[HomeBannerController::class,'add_banner']);
    Route::post('/admin/banner/add_banner_process',[HomeBannerController::class,'manage_banner_process'])->name('banner.manage_process');
    Route::get('/admin/banner/delete/{id}',[HomeBannerController::class,'delete'])->name('banner.delete');
    Route::get('/admin/banner/add_banner/{id}',[HomeBannerController::class,'add_banner'])->name('banner.manage');
    Route::get('/admin/banner/status/{status}/{id}',[HomeBannerController::class,'status'])->name('banner.status');



               ///Ordersss
    
     Route::get('/admin/order',[OrderController::class,'index']);
     Route::get('/admin/order_details/{id}',[OrderController::class,'order_details']);
     Route::post('/admin/update_status',[OrderController::class,'update_status']);

      ////tailor Orders

      Route::get('/admin/tailor_order',[OrderController::class,'tailor_order']);
    //   Route::get('/admin/order_details/{id}',[OrderController::class,'order_details']);
    //   Route::post('/admin/update_status',[OrderController::class,'update_status']);
    

    
});


//    Route::get('/admin/update',[AdminController::class,'updatepassword']);
//Route::get('/update',[FrontController::class,'updatepassword']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
