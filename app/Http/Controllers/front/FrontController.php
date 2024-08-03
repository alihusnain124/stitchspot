<?php

namespace App\Http\Controllers\front;
use App\Http\Controllers\controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Storage;
use Mail;
use Carbon\Carbon;


class FrontController extends Controller
{


    //  public function updatepassword(){

    //  DB::table('customers')
    // ->where('id', 12)
    // ->update(['password' => Hash::make('ali')]);
       
    // }

    ////for api 

    public function api(Request $req){
        $users=DB::table('customers')->get();
     
        return response()->json([
            'users'=>$users,
        ]);
    }
    public function index(Request $req){

        ///products

        $result['product']=DB::table('products')->where(['status'=>1])->inRandomOrder()->take(8)->get();
        foreach($result['product'] as $item1){
            $result['product_attr'][$item1->id]=DB::table('products_attr')
            ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
            ->leftJoin('colors','colors.id','=','products_attr.color_id')
            ->where(['products_attr.products_id'=>$item1->id])->get();

            // $result['rating'][$item1->id]=DB::table('rating')->where('product_id',$item1->id)->get();
            }

 
            

        ///Tranding


        $result['tranding_product']=DB::table('products')->where('status',1)->where('sold_count','>=',100)->get();
        foreach($result['tranding_product'] as $item1){
            $result['tranding_product_attr'][$item1->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
            ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item1->id])->get();
            }


                
        ///discounted

          
        $result['discounted_product']=DB::table('products')->where(['status'=>1,'is_discounted'=>1])->get();
        foreach($result['discounted_product'] as $item1){
            $result['discounted_product_attr'][$item1->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
            ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item1->id])->get();
            }

            ///latest product

         $tenDaysAgo = Carbon::now()->subDays(10);
        $result['latest_product']=DB::table('products')->where(['status'=>1])->where('created_at', '>=', $tenDaysAgo)->get();
        foreach($result['latest_product'] as $item1){
            $result['latest_product_attr'][$item1->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
            ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item1->id])->get();
            }

            if ($req->session()->has('FRONT_USER_LOGIN')) {
                $uid = $req->session()->get('FRONT_USER_LOGIN');
        
                // Retrieve user orders and order details
                $userOrders = DB::table('orders')
                    ->where('user_id', $uid)
                    ->pluck('id');
        
                if (!$userOrders->count() > 0) {
                    
                    if($req->session()->get('IS_TAILOR')=='yes'){
                        return redirect('/customers_dashboard');
                    }else{
                         return view('front.index', $result);
                    }
                   
                }
        
                $orderDetails = DB::table('order_details')
                    ->whereIn('order_id', $userOrders)
                    ->get();
        
                // Get all products and their related data
                $allProducts = DB::table('products')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->join('brands', 'products.brand', '=', 'brands.id')
                    ->join('products_attr', 'products.id', '=', 'products_attr.products_id')
                    ->select('products.*', 'categories.category_name as category', 'brands.brand_name as brand', 'products_attr.price', 'products_attr.mrp', 'products_attr.qty')
                    ->get();
        
                $productCategories = DB::table('categories')->pluck('category_name')->unique()->toArray();
                $productBrands = DB::table('brands')->pluck('brand_name')->unique()->toArray();
        
                $userProductIds = $orderDetails->pluck('product_id')->unique()->toArray();
                $userProductData = DB::table('products')
                    ->join('categories', 'products.category_id', '=', 'categories.id')
                    ->join('brands', 'products.brand', '=', 'brands.id')
                    ->join('products_attr', 'products.id', '=', 'products_attr.products_id')
                    ->whereIn('products.id', $userProductIds)
                    ->select('products.*', 'categories.category_name as category', 'brands.brand_name as brand', 'products_attr.price', 'products_attr.mrp', 'products_attr.qty')
                    ->get();
        
                $processedUserData = self::preprocessUserData($uid, $userProductData, $productCategories, $productBrands);
                $processedProductData = self::preprocessProductData($allProducts, $productCategories, $productBrands);
        
                $contentBasedModel = self::trainContentBasedModel($processedProductData, $processedUserData);
                $recommendedProducts = self::recommendProducts($contentBasedModel, $uid);
                
                $recommendedProductDetails = [];
                $similarityThreshold = 0.5; // Adjust this threshold as needed
                foreach ($recommendedProducts as $productId => $similarityScore) {
                   
                    $recommendedProduct = collect($allProducts)->where('id', $productId)->first();
                    if ($recommendedProduct && $similarityScore > $similarityThreshold) {
                        $recommendedProductDetails[] = [
                            'id' => $recommendedProduct->id,
                            'name' => $recommendedProduct->name,
                            'short_desc' => $recommendedProduct->short_desc,
                            'category' => $recommendedProduct->category,
                            'brand' => $recommendedProduct->brand,
                            'price' => $recommendedProduct->price,
                            'qty' => $recommendedProduct->qty,
                            'is_discounted' => $recommendedProduct->is_discounted,
                            'mrp' => $recommendedProduct->mrp,
                            'image' => $recommendedProduct->image,
                            'similarity_score' => $similarityScore,
                        ];
                    }
                }
        
                // return response()->json([
                //     'status' => 'success',
                //     'processedProductData' => $processedProductData,
                //     'processedUserData' => $processedUserData,
                //     'contentBasedModel' => $contentBasedModel,
                //     'recommendedProducts' => $recommendedProducts,
                //     'recommendedProductDetails' => $recommendedProductDetails,
                // ]);
            }


            if($req->session()->get('IS_TAILOR')=='yes'){
              
                return redirect('/customers_dashboard');
            }else{
                if(isset($recommendedProductDetails[0])){
                    return view('front.index',$result,['recommendedProducts' => $recommendedProductDetails]);
                }else{
                
                return view('front.index',$result);
                }
            }
        
       


    }

    public function registration(Request $req){


        if(session()->has('FRONT_USER_LOGIN')){
            return redirect('/');
        }
        return view('front.registration');

    }

    public function editprofile(Request $req,$id){

        $result['customer']=DB::table('customers')->where('id',$id)->get();
        return view('front.editprofile',$result);
       
    }
    public function registration_process(Request $req){
   


        $name=$req->post('name');
        $email=$req->post('email');
        $mobile=$req->post('mobile');
        $password=$req->post('password');
        $address=$req->post('address');
        $bio=$req->post('bio');
        $about=$req->post('about');
        $skills=$req->post('skills');
        $language=$req->post('language');
        $tailor=$req->post('tailor');

      
        
        $validator = Validator::make($req->all(), [
            'name' => 'required|unique:customers,name,' . $req->post('id'),
            'email' => 'required|email|unique:customers,email,' . $req->post('id'),
            'image' => 'required',
            'mobile' => 'required',
            'password' => [
                'required',
                'string',
                'min:8', 
                'regex:/[a-zA-Z]/', 
                'regex:/[0-9]/', 
            ],
            'about' => 'required',
            'language' => 'required',
            'tailor' => 'required',
        ]);  
    

      if(!$validator->passes()){
         return response()->json(['error'=>$validator->errors()->toArray()]);
      }else{

        if($req->hasFile('image')){
    
            $image=$req->file('image');
            $ext=$image->extension();
            $image_name=time().'.'.$ext;
            $image->storeAs('public/media/customer/',$image_name);          
           }
      
      

        $data=[
            'name'=>$name,
            'email'=>$email,
            'mobile'=>$mobile,
            'password'=>Hash::make($password),
            'address'=>$address,
            'bio'=>$bio,
            'skills'=>$skills,
            'about'=>$about,
            'language'=>$language,
            'tailor'=>$tailor,
            'image'=>$image_name,
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        if($req->post('id')){

            $query=DB::table('customers')->where('id',$req->post('id'))->update($data);
            $status='update';
            $msg='User Profile has been updated succcesfully';
            $id=$req->post('id');
        }else{
              $query=DB::table('customers')->insert($data);
              $status='add';
              $msg='User Registration successfully done';
              $id='';
        }

      


       
        if($query){
         
            return response()->json(['msg'=>$msg,'status'=>$status,'id'=>$id]);
        }
      }

   
    }

    public function login(Request $req){
    
       
     return view('front.login');
    }

    public function login_process(Request $req){

    
        $email=$req->post('login_email');
  
       $result=DB::table('customers')
         ->where(['email'=>$email])
         ->get();
       

       if(isset($result[0])){

        if($result[0]->status==0){
            return response()->json(['error'=>'Your account has been deactivated.','tailor'=>'']);
        }

        if(Hash::check($req->post('login_password'),$result[0]->password)){

          

            $req->session()->regenerate(); 
           
            $req->session()->put('FRONT_USER_LOGIN',$result[0]->id);
            $req->session()->put('FRONT_USER_NAME',$result[0]->name);
            $req->session()->put('FRONT_USER_EMAIL',$result[0]->email);
            $req->session()->put('FRONT_USER_MOBILE',$result[0]->mobile);
            $req->session()->put('IS_TAILOR',$result[0]->tailor);
            $req->session()->put('FRONT_USER_TYPE','Reg');


           

            $cart=DB::table('cart')
            ->where(['user_id'=>session()->get('USER_TEMP_ID')])
            ->where(['user_type'=>'Not Reg'])
            ->get();

            $cart_check=DB::table('cart')->where(['user_type'=>'Reg'])->get();

            
            if(isset($cart[0])){

           if(isset($cart_check[0])){
            if($cart[0]->product_id==$cart_check[0]->product_id){
                DB::table('cart')->where(['user_id'=>session()->get('USER_TEMP_ID'),'user_type'=>'Not Reg'])->delete();
              }else{
                 DB::table('cart')
                 ->update(['user_id'=>$result[0]->id,'user_type'=>'Reg']);
              }
            

           }else{
           
                 DB::table('cart')
                 ->update(['user_id'=>$result[0]->id,'user_type'=>'Reg']);
             
            
           }
                        
                
            }

       

            return response()->json(['msg'=>'Login successfully done','tailor'=>$result[0]->tailor]);
           
           
        }else{

            return response()->json(['error'=>'Password not match','tailor'=>'']);

        }
       }else{
        return response()->json(['error'=>'Email not register','tailor'=>'']);

       }



       

    }

    public function profile(Request $req,$id){

      
            $id=$id;
        
            if(!session()->has('FRONT_USER_LOGIN')){
              return redirect('/login');
            }
            $result['user']=DB::table('customers')->where('id',$id)->get();

            $date=$result['user'][0]->created_at;
            $result['formattedDate'] = Carbon::parse($date)->format('d-m-Y');
           

            foreach($result['user'] as $item){
                $result['services'][$item->id]=DB::table('services')->where('user_id',$item->id)->get();
            }

            foreach($result['user'] as $item){
                $result['orders']=DB::table('orders')->where('user_id',$item->id)->get();
            }

         
            $result['confirm_order']=DB::table('confirm_orders')->where('user_id',$id)->get();
            $cart=DB::table('cart')
            ->where(['user_id'=>session()->get('USER_TEMP_ID')])
            ->where(['user_type'=>'Not Reg'])
            ->get();

            $result['confirm_order_to_pay']=DB::table('confirm_orders')->where('user_id',$id)->where('is_paid','no')->get();
         
            $result['reviews']=DB::table('reviews')->where('service_user_id',$id)->get();
           
           
            foreach($result['reviews'] as $item){
       
               $result['user'][$item->id]=DB::table('customers')->where('id',$item->user_id)->get();

             
            }


            ////total rating
            $result['total_count']=totalCount($id);
            $result['rating_points']= getTotalUserReviews($id);
            $result['fullStars'] = floor(getTotalUserReviews($id)); 
            $result['halfStars'] = (getTotalUserReviews($id) - $result['fullStars']) >= 0.1 ? 1 : 0;
          
            ////check account no

           $result['account_no']=DB::table('account_no')->where('user_id',$id)->get();

        
        
        return view('front.profile',$result);
     
}

public function products(Request $req){

       ///products

       $result['product']=DB::table('products')->where(['status'=>1])->get();
       foreach($result['product'] as $item1){
           $result['product_attr'][$item1->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
           ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item1->id])->get();
           }


    return view('front.products',$result);
}



public function product_details(Request $req,$id){


   

    ///checking k using na product li ha ya nii..

    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
     
    }else{
        $user_id=0;
    }


    $result['order']=DB::table('orders')->where('user_id',$user_id)->get();

   

    foreach($result['order'] as $item){
        $result['order_details'][$item->id]=DB::table('order_details')->where('order_id',$item->id)->get();

        
    }

    // prx($result);

    $result['rating']=DB::table('rating')->where('product_id',$id)->get();
    foreach($result['rating'] as $item){
        $result['user'][$item->id]=DB::table('customers')->where('id',$item->user_id)->get();

        
    }
       ///total rating points

     $result['rating_points']= getTotalReviews($id);
     $result['fullStars'] = floor(getTotalReviews($id)); 
     $result['halfStars'] = (getTotalReviews($id) - $result['fullStars']) >= 0.2 ? 1 : 0;
    



    $result['product'] = DB::table('products')
    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
    ->where('products.status', 1)
    ->where('products.id', $id)
    ->select('categories.category_name', 'products.*')
    ->get();

   

    foreach($result['product'] as $item1){
        $result['product_attr'][$item1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$item1->id])
        ->select('products_attr.*','sizes.size','colors.color')
        ->get();
        }
     


 
    ////related products

    $result['related_product']=DB::table('products')->where(['status'=>1,'category_id'=>$result['product'][0]->category_id])->get();
 
    foreach($result['related_product'] as $item2){
       
        $result['related_product_attr'][$item2->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item2->id])->get();

       
        }


      
   return view('front.product-details',$result);
   
}

public function change_product(Request $req){

    $id=$req->post('prod_id');
    $size=$req->post('size_val');
    $color=$req->post('color_val');



 if($id=='' || $size=='' || $color==''){
    $req->session()->flash('message','Please select size and color');
    return redirect()->back();
 }else{

    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
     
    }else{
        $user_id=0;
    }


    $result['order']=DB::table('orders')->where('user_id',$user_id)->get();

    foreach($result['order'] as $item){
        $result['order_details'][$item->id]=DB::table('order_details')->where('order_id',$item->id)->get();

        
    }


    $result['rating']=DB::table('rating')->where('product_id',$id)->get();
    foreach($result['rating'] as $item){
        $result['user'][$item->id]=DB::table('customers')->where('id',$item->user_id)->get();

        
    }




    $result['product'] = DB::table('products')
    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
    ->where('products.status', 1)
    ->where('products.id', $id)
    ->select('categories.category_name', 'products.*')
    ->get();

   

    foreach($result['product'] as $item1){
        $result['product_attr'][$item1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$item1->id])
        ->select('products_attr.*','sizes.size','colors.color')
        ->get();
        }
     


 
    ////related products

    $result['related_product']=DB::table('products')->where(['status'=>1,'category_id'=>$result['product'][0]->category_id])->get();
 
    foreach($result['related_product'] as $item2){
       
        $result['related_product_attr'][$item2->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item2->id])->get();

       
        }

    $size_id=DB::table('sizes')->where('size',$size)->value('id');
$color_id=DB::table('colors')->where('color',$color)->value('id');

 $result['again_product'] = DB::table('products')
    ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
    ->where('products.status', 1)
    ->where('products.id', $id)
    ->select('categories.category_name', 'products.*')
    ->get();

    foreach($result['again_product'] as $item1){
        $result['again_product_attr'][$item1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$item1->id,'products_attr.size_id'=>$size_id,'products_attr.color_id'=>$color_id])
        ->select('products_attr.*','sizes.size','colors.color')
        ->get();
        }



           ///total rating points

     $result['rating_points']= getTotalReviews($id);
     $result['fullStars'] = floor(getTotalReviews($id)); 
     $result['halfStars'] = (getTotalReviews($id) - $result['fullStars']) >= 0.2 ? 1 : 0;

        return view('front.product-details',$result);


 }

 
 

      
 }



public function search(Request $req){

   $search_val=$req->input('search_val');

   $result['product']=DB::table('products')
   ->where('status', 1)
  ->where('name', 'like', '%'.$search_val.'%')
   ->orwhere('keyword','like','%'.$search_val.'%')
   ->get();

   foreach($result['product'] as $item1){
    $result['product_attr'][$item1->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
    ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item1->id])->get();
    }

    
   return view('front.search',$result);
}


public function search_service(Request $req){

    $search_val=$req->input('search_val');
 
    $result['service']=DB::table('services')
   ->where('title', 'like', '%'.$search_val.'%')
    ->orwhere('tags','like','%'.$search_val.'%')
    ->get();
 
    foreach($result['service'] as $item1){
     $result['customer'][$item1->id]=DB::table('customers')->where('id',$item1->user_id)->get();
     }
 

    return view('front.search_service',$result);
 }


 public function cart(Request $req){
    
    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }
    

    $result['cart']=DB::table('cart')
    ->leftJoin('products','products.id','=','cart.product_id')
    ->leftJoin('products_attr','products_attr.id','=','cart.product_attr_id')
     ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
     ->leftJoin('colors','colors.id','=','products_attr.color_id')
  
   ->where(['user_id'=>$user_id])
   ->where(['user_type'=>$user_type])
    ->select('cart.id','cart.product_qty','cart.product_name','cart.product_image','cart.product_price','products_attr.mrp','sizes.size','colors.color','products.slug','products.id as pid','products_attr.id as attr_id')
   ->get();

   if(count($result['cart'])<1){
    return redirect('/');
   }else{
    return view('front.cart',$result);
   }
 
    
 }

 public function add_to_cart(Request $req){

    $id=$req->input('id');

    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }
    $result['product']=DB::table('products')->where(['status'=>1,'id'=>$id])->get();
    foreach($result['product'] as $item1){
        
     
        $result['product_attr'][$item1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$item1->id])
        ->select('products_attr.*','sizes.size','colors.color')
        ->get();

    
        }
    
     $id=$item1->id;
     $name=$item1->name;
     $image=$item1->image;

     if($result['product_attr'][$item1->id][0]->price==0){
        $price=$result['product_attr'][$item1->id][0]->mrp;
     }else{
        $price=$result['product_attr'][$item1->id][0]->price;
     }
    
     $qty=1;
     $product_attr_id=$result['product_attr'][$item1->id][0]->id;

     $check_cart=DB::table('cart')->where(['product_id'=>$id,'user_id'=>$user_id])->get()->count();
     $check_qty=DB::table('products_attr')->where(['products_id'=>$id,'size_id'=>$result['product_attr'][$item1->id][0]->size_id,'color_id'=>$result['product_attr'][$item1->id][0]->color_id])->value('qty');

     
     if($check_cart>0){
    
        return response()->json(['status'=>1,'msg'=>'Product is already in the Cart']);
    }else{

      if($check_qty==0){

        return response()->json(['status'=>3,'msg'=>'Product is out of stock']);
      }else{

        

        $cart=DB::table('cart')->insert([

            'product_id'=>$id,
            'user_id'=>$user_id,
            'user_type'=>$user_type,
            'product_name'=>$name,
            'product_price'=>$price,
            'product_qty'=>$qty,
            'product_image'=>$image,
            'product_attr_id'=>$product_attr_id,
            'added_on'=>date('Y-m-d h:i:s')
        ]);
      
        if($cart){
            $total=$result['product_attr'][$item1->id][0]->qty-$qty;
            if($total){
                DB::table('products_attr')->where(['products_id'=>$id])->update(['qty'=>$total]);
            }
            // return redirect()->back()->with('cart_msg', 'Product is added to the Cart');
            return response()->json(['status'=>2,'msg'=>'Product is added to the Cart']);
        }

      }
    }
 }

 public function update_cart(Request $req){

    $product_id=$req->post('id');
    $product_qty=$req->post('qty');
    $product_attr_id=$req->post('product_attr_id');

    // $cart_qty['qty']=DB::table('cart')
    // ->where('product_id', $product_id)
    // ->get();

    // $total_qty=$product_qty-$cart_qty['qty'][0]->product_qty;


    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }
    $result['product']=DB::table('products')->where(['status'=>1,'id'=>$product_id])->get();

  
    foreach($result['product'] as $item1){
        
     
        $result['product_attr'][$item1->id]=DB::table('products_attr')
        ->leftJoin('sizes','sizes.id','=','products_attr.size_id')
        ->leftJoin('colors','colors.id','=','products_attr.color_id')
        ->where(['products_attr.products_id'=>$item1->id])
        ->select('products_attr.*','sizes.size','colors.color')
        ->get();

    
        }
  
     $id=$item1->id;
     $qty=$product_qty;
     $cart_qty=DB::table('cart')->where(['product_id'=>$id,'user_id'=>$user_id,'product_attr_id'=>$product_attr_id])->get();
     $check_qty=DB::table('products_attr')->where(['products_id'=>$id,'size_id'=>$result['product_attr'][$item1->id][0]->size_id,'color_id'=>$result['product_attr'][$item1->id][0]->color_id])->value('qty');

      
     if ($qty < $cart_qty[0]->product_qty) {

        $diff_qty = $cart_qty[0]->product_qty - $qty ;
        DB::table('products_attr')
            ->where('products_id', $id)
            ->where('id', $product_attr_id)
            ->increment('qty', $diff_qty); // Increment by $diff_qty
    } else {

            if($check_qty==0){

                return response()->json(['status'=>false,'message'=>'Sorry, Product is out of stock']);

            } else{

                $diff_qty =  $qty - $cart_qty[0]->product_qty ;
                    DB::table('products_attr')
                        ->where('products_id', $id)
                        ->where('id', $product_attr_id)
                        ->decrement('qty', $diff_qty); // Decrement by $diff_qty
                }
                
                
              

              

            }   
            $cart = DB::table('cart')
            ->where('product_id', $id)
            ->where('product_attr_id', $product_attr_id)
            ->update(['product_qty' => $qty]);
            
                if($cart){
                
                    return response()->json([
                        'message' => 'Product updated successfully',
                        'status' => true
                    ]);
                }    
                    
    
   
 }

 public function delete_cart(Request $req){
    $id = $req->post('id');
    $attr_id = $req->post('attr_id');
    $cart_item = DB::table('cart')->where(['product_id'=> $id,'product_attr_id'=>$attr_id])->get();
    $cart = DB::table('cart')->where(['product_id'=> $id,'product_attr_id'=>$attr_id])->delete();
  
    if ($cart > 0) { 

        $total_qty=$cart_item[0]->product_qty;
        DB::table('products_attr')
            ->where('products_id', $id)
            ->where('id', $attr_id)
            ->increment('qty', $total_qty);

        return response()->json([

            'message' => 'Product deleted successfully',
            'status' => true
        ]);
    } else {
        return response()->json([
            'message' => 'Product not found or already deleted',
            'status' => false
        ]);
    }
}


public function checkout(Request $req){
    $result['user']=DB::table('customers')->where('id',$req->session()->get('FRONT_USER_LOGIN'))->get();
  
    if(isset($result['user'][0])){
        $id=$result['user'][0]->id;
        $result['cart']=DB::table('cart')->where('user_id',$id)->get();
        return view('front.checkout',$result);
    }else{
        return redirect('/login')->with('msg','Please login first');
    }
   
}


public function add_to_cart_product(Request $req){


    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }

  $product_id=$req->post('id');
  $size=$req->post('size');
  $color=$req->post('color');
  $product_qty=$req->post('qty');


  $size_id=DB::table('sizes')->where('size',$size)->value('id');
  $color_id=DB::table('colors')->where('color',$color)->value('id');
  $product_attr_id=DB::table('products_attr')->where(['size_id'=>$size_id,'color_id'=>$color_id])->value('id');
  $product_image=DB::table('products_attr')->where(['size_id'=>$size_id,'color_id'=>$color_id])->value('attr_image');



  if(!is_numeric($size_id) || !is_numeric($color_id)){
    return response()->json([
        'message' => "Please select it's color and size",
        'status' => 'false'
    ]);

  }


  

  $result['product']=DB::table('products')->where(['status'=>1,'id'=>$product_id])->get();



 $product_name=$result['product'][0]->name;
  

  $result['product_attr']=DB::table('products_attr')
  ->where(['color_id'=>$color_id,'size_id'=>$size_id,'products_id'=>$product_id])
  ->get();

  $product_attr_id=$result['product_attr'][0]->id;

  if($result['product_attr'][0]->price==0){
    $product_price=$result['product_attr'][0]->mrp;

  }else{
    $product_price=$result['product_attr'][0]->price;

  }
  
 


 $cart = DB::table('cart')->where(['product_id'=>$product_id,'product_attr_id'=>$product_attr_id])->get();
 $check_qty=DB::table('products_attr')->where(['products_id'=>$product_id,'id'=>$product_attr_id])->value('qty');
  
 if(isset($cart[0])){

    if($check_qty==0){

        return response()->json([
            'message' => "Out of Stock",
            'status' => false
        ]);
    }
     
        DB::table('products_attr')
            ->where('products_id', $product_id)
            ->where('id', $product_attr_id)
            ->decrement('qty', $product_qty); 

          

     


    $qty=$cart[0]->product_qty+$product_qty;
    $cart = DB::table('cart')
    ->where('product_id', $product_id)
    ->where('product_attr_id', $product_attr_id)
    ->update(['product_qty' => $qty]);


    $msg='product Updated';

 }else{

    if($check_qty==0){

        return response()->json([
            'message' => "Out of Stock",
            'status' => false
        ]);
    }
    
    DB::table('products_attr')
    ->where('products_id', $product_id)
    ->where('id', $product_attr_id)
    ->decrement('qty', $product_qty); 


    $cart=DB::table('cart')->insert([

        'product_id'=>$product_id,
        'user_id'=>$user_id,
        'user_type'=>$user_type,
        'product_name'=>$product_name,
        'product_price'=>$product_price,
        'product_qty'=>$product_qty,
        'product_image'=>$product_image,
        'product_attr_id'=>$product_attr_id,
        'added_on'=>date('Y-m-d h:i:s')
    ]);

    $msg='Product Added';
  
 }



       
    return response()->json([
        'message' => $msg,
        'status' => 'true'
    ]);



 }


 public function categories(Request $req,$slug){
    
    $result['category']=DB::table('categories')->where(['status'=>1,'category_slug'=>$slug])->get();
     foreach($result['category'] as $item){

        $result['category_product']=DB::table('products')->where(['status'=>1,'category_id'=>$item->id])->get();

        foreach($result['category_product'] as $item1){
            $result['category_product_attr'][$item1->id]=DB::table('products_attr')->leftJoin('sizes','sizes.id','=','products_attr.size_id')
            ->leftJoin('colors','colors.id','=','products_attr.color_id')->where(['products_attr.products_id'=>$item1->id])->get();
        }
     }
    

    return view('front.category',$result);
 }


 public function contact(Request $req){
    if($req->session()->has('FRONT_USER_LOGIN')){
        return view('front.contact');
    }else{
        return redirect()->back()->with('cart_msg','Please login first for any Query');
    }
   
 }
 

 public function order_process(Request $req){

  

    
    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }

    $name=$req->input('name');
    $email=$req->input('email');
    $address=$req->input('address');
    $city=$req->input('city');
    $state=$req->input('state');
    $zip_code=$req->input('zip_code');
    $mobile_no=$req->input('mobile_no');
    $payment_method=$req->input('payment_method');
    $is_stitch=$req->input('is_stitch');

    if($name=='' || $email=='' || $address=='' || $city=='' || $state=='' || $zip_code=='' || $mobile_no=='' || $payment_method=='' || $is_stitch==''){
        $status='oops';
        $msg='All fields are required';
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }

    if($req->session()->has('FRONT_USER_LOGIN')){

    $order=DB::table('orders')->insertGetId([
        'user_id'=>$user_id,
        'name'=>$name,
        'email'=>$email,
        'address'=>$address,
        'city'=>$city,
        'state'=>$state,
        'zip_code'=>$zip_code,
        'mobile_no'=>$mobile_no,
        'payment_method'=>$payment_method,
        'payment_status'=>'panding',
        'added_on'=>date('Y-m-d h:i:s')

    ]);

    $order_id=$order;
    
    $cart = DB::table('cart')->where(['user_id'=>$user_id])->get();
    if(isset($cart[0])){

    $count=0;
    foreach($cart as $item){

        DB::table('products')
        ->where('id', $item->product_id)
        ->increment('sold_count', $item->product_qty);

       $count+=1;
       $order_details=DB::table('order_details')->insertGetId([
            'order_id'=>$order_id,
            'product_id'=>$item->product_id,
            'product_name'=>$item->product_name,
            'product_price'=>$item->product_price,
            'product_qty'=>$item->product_qty,
            'product_attr_id'=>$item->product_attr_id,
            'is_stitch'=>$is_stitch,    
            'added_on'=>date('Y-m-d h:i:s')

        ]);

        $req->session()->put('product_'.$count,$order_details);
       
    }
     
    $req->session()->put('ORDER_ID', $order_id);
    DB::table('cart')->where(['user_id'=>$user_id,'user_type'=>$user_type])->delete();
    $status='Success';
    $msg='Order has been placed';   
    } 

    else{
        $status='Error';
        $msg='Order has not been placed';   
     }
 }

else{

}

  
   return response()->json(['status'=>$status,'msg'=>$msg]);


}


public function order_placed(Request $req){
    if($req->session()->has('ORDER_ID')){
        return view('front.order_placed');
    }else{

    return redirect('/')->with('msg','Please add items to cart');
    }
}


public function contact_process(Request $req){

    $user_id=$req->session()->get('FRONT_USER_LOGIN');
    $name=$req->input('name');
    $email=$req->input('email');
    $subject=$req->input('subject');
    $message=$req->input('message');


    if($name==null || $email==null || $subject==null || $message==null){
        $status='Error';
        $msg='All fields are required';
        return response()->json(['status'=>$status,'msg'=>$msg]);
    }

   $contact=DB::table('contact')->insert([
        'user_id'=>$user_id,
        'name'=>$name,
        'email'=>$email,
        'subject'=>$subject,
        'message'=>$message,
        'added_on'=>date('Y-m-d h:i:s')
        
   ]);

   
   
   if(isset($contact)){

    $status='Success';
    $msg='Your message has been sent successfully';
   }else{
   
    $status='Error';
    $msg='Your message has not been sent';
   }

   return response()->json(['status'=>$status,'msg'=>$msg]);



}
public function form(Request $req){
    $result['category']=DB::table('categories')->where('status',1)->get();

    return view('front.multi-form',$result);
}
 

public function add_service(Request $req){

    
    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }



  $title=$req->input('service_title');
  $category=$req->input('category');
  $tags=$req->input('tags');
  $max_price=$req->input('max_price');
  $min_price=$req->input('min_price');
  $max_delivery_time=$req->input('max_delivery_time');
  $min_delivery_time=$req->input('min_delivery_time');
  $desc=$req->input('desc');
  $requirement=$req->input('requirement');

  if($req->hasfile('image')){

    $image=$req->file('image');
    $ext=$image->extension();
    $image_name=time().'.'.$ext;
    $image->storeAs('/public/media/services/',$image_name);
  
   }


   $data=[
    'user_id'=>$user_id,
    'title'=>$title,
    'category'=>$category,
    'tags'=>$tags,
    'max_price'=>$max_price,
    'min_price'=>$min_price,
    'max_delivery_time'=>$max_delivery_time,
    'min_delivery_time'=>$min_delivery_time,
    'image'=>$image_name,
    'desc'=>$desc,
    'requirement'=>$requirement


   ];

  $service_id=DB::table('services')->insertGetId($data);

  if(isset($service_id)){

    return redirect('/profile/'.$user_id)->with('msg','Service has been added successfully');

  }

}

public function dashboard(Request $req){


   
    if(session()->has('FRONT_USER_LOGIN')){
        $id=$req->session()->get('FRONT_USER_LOGIN');
        $result['user']=DB::table('customers')->where('id',$id)->get();

        $date=$result['user'][0]->created_at;
        $result['formattedDate'] = Carbon::parse($date)->format('d-m-Y');

        $result['total_completed_orders']=totalCompleteOrders($id);
        $result['total_earning']=totalEarning($id);
        $result['price_recieved']=DB::table('confirm_orders')->where('service_user_id',$id)->where('paid_tailor','yes')->sum('price');

       


    }

     $result['order_detail']=DB::table('user_orders')->where('service_user_id',$id)->where('action','waiting')->get();
     if(isset($result['order_detail'][0])){

        $user_id = $result['order_detail'][0]->user_id;
 
        $result['order_user_detail']=DB::table('customers')->where('id',$user_id)->get();
     }
    
  

     $result['active_orders']=DB::table('confirm_orders')->where(['service_user_id'=>$id,'is_paid'=>'yes','status'=>'processing'])->get();





    return view('front.dashboard',$result);     
}


public function services(Request $req){

$result['services']=DB::table('services')->get();

foreach($result['services'] as $item){

    $result['user'][$item->id]=DB::table('customers')->where('id',$item->user_id)->get();

}


return view('front.our_services',$result);
    
}

public function order_details(Request $req,$id){

    $result['order_details']=DB::table('order_details')->where('order_id',$id)->get();
    return view('front.order_details',$result);
    

}

public function rating(Request $req){

    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }


$rating_desc=$req->post('rating_desc');
$rating=$req->post('rating3');
$product_id=$req->post('prod_id');


$result=DB::table('rating')->insert([
    'product_id'=>$product_id,
    'user_id'=>$user_id,
    'rating_desc'=>$rating_desc,
    'rating_stars'=>$rating,
    'added_on'=>date('Y-m-d h:i:s')
]);


if($result){
    return response()->json(['status'=>'success','msg'=>'Review added']);
}else{
    return response()->json(['status'=>'error','msg'=>'Error']);
}
    

}


public function service_details(Request $req,$id){

    $result['services']=DB::table('services')->where('id',$id)->get();
   
    $user_id=$result['services'][0]->user_id;


    $result['user']=DB::table('customers')->where('id',$user_id)->get();


  return view('front.service_detail',$result);
    

}

public function user_order(Request $req){

  

   
    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }

    $order_prod_id=$req->post('product_order_id');
    $price=$req->post('price');
    $delivery_time=$req->post('time');
    $service_id=$req->post('id');
    $service_user_id=$req->post('user_id');

    if($order_prod_id=='' || $price=='' || $delivery_time==''){

        return response()->json(['status'=>'error','msg'=>'All fields are required']);
    }


    $order_id=DB::table('order_details')->where('id',$order_prod_id)->where('is_stitch','yes')->where('is_given_tailor','no')->get();

    if(isset($order_id[0])){

        $insert=DB::table('user_orders')->insert([
            'user_id'=>$user_id,
            'order_product_id'=>$order_prod_id,
            'service_user_id'=>$service_user_id,
            'service_id'=>$service_id,
            'price'=>$price,
            'delivery_time'=>$delivery_time,
            'action'=>'waiting',
            'added_on'=>date('Y-m-d h:i:s')
        ]);

        DB::table('order_details')->where('id',$order_prod_id)->update(['is_given_tailor'=>'yes']);

        if($insert){
            return response()->json(['status'=>'success','msg'=>'Order placed successfully']);
        }

    }else{
        return response()->json(['status'=>'error','msg'=>'Error!!There is no product available']);
    }
  
  }


  public function action(Request $req){

    $order_id=$req->post('id');
    $action=$req->post('action');

    if($order_id=='' || $action==''){

        return response()->json(['status'=>'error','msg'=>'All fields are required']);
    }else{

        if($action=='yes'){
           $result=DB::table('user_orders')->where('id',$order_id)->update(['action'=>'accepted']);

          $add=DB::table('user_orders')->where('id',$order_id)->get();
          DB::table('confirm_orders')->insert([
            'user_id'=>$add[0]->user_id,
            'order_product_id'=>$add[0]->order_product_id,
            'service_user_id'=>$add[0]->service_user_id,
            'service_id'=>$add[0]->service_id,
            'price'=>$add[0]->price,
            'delivery_time'=>$add[0]->delivery_time,
            'is_paid'=>'no',
            'status'=>'processing',
            'added_on'=>date('Y-m-d h:i:s')
          ]);
  
 
           if($result){
               return response()->json(['status'=>'success','msg'=>'Order accepted successfully']);
           }

        }else{
           $result=DB::table('user_orders')->where('id',$order_id)->update(['action'=>'rejected']);
           if($result){
               return response()->json(['status'=>'success','msg'=>'Order rejected successfully']);
           }
        }

       
    }

}


public function complete(Request $req){

    $order_id=$req->post('id');
    $action=$req->post('action');

    if($order_id=='' || $action==''){

        return response()->json(['status'=>'error','msg'=>'All fields are required']);
    }else{

        if($action=='yes'){
           $result=DB::table('confirm_orders')->where('id',$order_id)->update(['status'=>'completed']);
 
           if($result){
               return response()->json(['status'=>'success','msg'=>'Order completed successfully']);
           }

        }else{
          
                
               return response()->json(['status'=>'success','msg'=>'Error']);
          
        }

       
    }

}


public function user_review(Request $req,$id){

    $result['order_detail']=DB::table('confirm_orders')->where('id',$id)->get();
     
    return view('front.user_review',$result);

}
public function review(Request $req){
  
  
    if($req->session()->has('FRONT_USER_LOGIN')){
        $user_id=$req->session()->get('FRONT_USER_LOGIN');
        $user_type='Reg';

    }else{
        $user_id=getUserTempid();
        $user_type='Not Reg';

    }


$review_desc=$req->post('rating_desc');
$review_star=$req->post('rating3');
$service_user_id=$req->post('user_id');
$service_id=$req->post('service_id');


$result=DB::table('reviews')->insert([
    'user_id'=>$user_id,
    'service_user_id'=>$service_user_id,
    'service_id'=>$service_id,
    'review_desc'=>$review_desc,
    'review_star'=>$review_star,
    'added_on'=>date('Y-m-d h:i:s')
]);

if($result){
    return response()->json(['status'=>'success','msg'=>'Review added','user_id'=>$user_id]);
}else{
    return response()->json(['status'=>'error','msg'=>'Error','user_id'=>$user_id]);
}
   

}



/////recommendations

public function get_products(Request $req)
{
    if ($req->session()->has('FRONT_USER_LOGIN')) {
        $uid = $req->session()->get('FRONT_USER_LOGIN');

        // Retrieve user orders and order details
        $userOrders = DB::table('orders')
            ->where('user_id', $uid)
            ->pluck('id');

        if (!$userOrders->count() > 0) {
            return view('front.index', $result);
        }

        $orderDetails = DB::table('order_details')
            ->whereIn('order_id', $userOrders)
            ->get();

        // Get all products and their related data
        $allProducts = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand', '=', 'brands.id')
            ->join('products_attr', 'products.id', '=', 'products_attr.products_id')
            ->select('products.*', 'categories.category_name as category', 'brands.brand_name as brand', 'products_attr.price', 'products_attr.mrp', 'products_attr.qty')
            ->get();

        $productCategories = DB::table('categories')->pluck('category_name')->unique()->toArray();
        $productBrands = DB::table('brands')->pluck('brand_name')->unique()->toArray();

        $userProductIds = $orderDetails->pluck('product_id')->unique()->toArray();
        $userProductData = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('brands', 'products.brand', '=', 'brands.id')
            ->join('products_attr', 'products.id', '=', 'products_attr.products_id')
            ->whereIn('products.id', $userProductIds)
            ->select('products.*', 'categories.category_name as category', 'brands.brand_name as brand', 'products_attr.price', 'products_attr.mrp', 'products_attr.qty')
            ->get();

        $processedUserData = self::preprocessUserData($uid, $userProductData, $productCategories, $productBrands);
        $processedProductData = self::preprocessProductData($allProducts, $productCategories, $productBrands);

        $contentBasedModel = self::trainContentBasedModel($processedProductData, $processedUserData);
        $recommendedProducts = self::recommendProducts($contentBasedModel, $uid);
        
        $recommendedProductDetails = [];
        $similarityThreshold = 0.5; // Adjust this threshold as needed
        foreach ($recommendedProducts as $productId => $similarityScore) {
            $recommendedProduct = collect($allProducts)->where('id', $productId)->first();
            if ($recommendedProduct && $similarityScore > $similarityThreshold) {
                $recommendedProductDetails[] = [
                    'id' => $recommendedProduct->id,
                    'name' => $recommendedProduct->name,
                    'short_desc' => $recommendedProduct->short_desc,
                    'category' => $recommendedProduct->category,
                    'brand' => $recommendedProduct->brand,
                    'price' => $recommendedProduct->price,
                    'qty' => $recommendedProduct->qty,
                    'is_discounted' => $recommendedProduct->is_discounted,
                    'mrp' => $recommendedProduct->mrp,
                    'image' => $recommendedProduct->image,
                    'similarity_score' => $similarityScore,
                ];
            }
        }

        // return response()->json([
        //     'status' => 'success',
        //     'processedProductData' => $processedProductData,
        //     'processedUserData' => $processedUserData,
        //     'contentBasedModel' => $contentBasedModel,
        //     'recommendedProducts' => $recommendedProducts,
        //     'recommendedProductDetails' => $recommendedProductDetails,
        // ]);
    }
}

public static function preprocessProductData($products, $categories, $brands)
{
    $processedProductData = [];

    foreach ($products as $product) {
        $encodedCategory = self::oneHotEncode($product->category, $categories);
        $encodedBrand = self::oneHotEncode($product->brand, $brands);

        $normalizedPrice = self::normalize($product->price);

        // Combine encoded and normalized features into a single feature vector
        $featureVector = array_merge($encodedCategory, $encodedBrand, [$normalizedPrice]);
        $processedProductData[$product->id] = $featureVector;
    }

    return $processedProductData;
}

public static function preprocessUserData($userId, $userProducts, $categories, $brands)
{
    $encodedCategories = array_fill(0, count($categories), 0);
    $encodedBrands = array_fill(0, count($brands), 0);
    $totalPrice = 0;

    if ($userProducts->isNotEmpty()) {
        foreach ($userProducts as $product) {
            $categoryIndex = array_search($product->category, $categories);
            $brandIndex = array_search($product->brand, $brands);

            if ($categoryIndex !== false) $encodedCategories[$categoryIndex] = 1;
            if ($brandIndex !== false) $encodedBrands[$brandIndex] = 1;

            $totalPrice += $product->price;
        }
        $averagePrice = $totalPrice / $userProducts->count();
    } else {
        $averagePrice = 0;
    }

    $normalizedPrice = self::normalize($averagePrice);

    $featureVector = array_merge($encodedCategories, $encodedBrands, [$normalizedPrice]);
    $processedUserData[$userId] = $featureVector;

    return $processedUserData;
}

public static function oneHotEncode($category, $categories)
{
    $encodedCategory = array_fill(0, count($categories), 0);
    $index = array_search($category, $categories);
    if ($index !== false) {
        $encodedCategory[$index] = 1;
    }
    return $encodedCategory;
}

public static function normalize($value)
{
    $minValue = 0; // Set appropriate min value
    $maxValue = 1000; // Set appropriate max value for product prices
    return ($value - $minValue) / ($maxValue - $minValue);
}

public static function trainContentBasedModel($processedProductData, $processedUserData)
{
    $model = [];

    foreach ($processedProductData as $productId => $productFeatures) {
        foreach ($processedUserData as $userId => $userFeatures) {
            $similarityScore = self::calculateSimilarity($productFeatures, $userFeatures);

            // prx($similarityScore);
            if (!isset($model[$userId])) {
                $model[$userId] = [];
            }
            $model[$userId][$productId] = $similarityScore;
        }
    }

    return $model;
}

public static function calculateSimilarity($productFeatures, $userFeatures)
{
    $dotProduct = array_sum(array_map(function ($a, $b) {
        return $a * $b;
    }, $productFeatures, $userFeatures));
    $productNorm = sqrt(array_sum(array_map(function ($x) {
        return $x * $x;
    }, $productFeatures)));
    $userNorm = sqrt(array_sum(array_map(function ($x) {
        return $x * $x;
    }, $userFeatures)));
    return $dotProduct / ($productNorm * $userNorm);
}


public static function recommendProducts(array $contentBasedModel, int $userId, int $numRecommendations = 6): array
{
    if (!isset($contentBasedModel[$userId])) {
        return [];
    }

    $userScores = $contentBasedModel[$userId];

    // Sort products by similarity score in descending order
    arsort($userScores);

    // Return the top N recommended products
    return array_slice($userScores, 0, $numRecommendations, true);
}


public function account_no(Request $req){
    $user_id=$req->input('user_id');
    $account_no=$req->input('account_no');

    $insert=DB::table('account_no')->insert([
        'user_id'=>$user_id,
        'account_no'=>$account_no,
        'added_on'=>date('Y-m-d h:i:s')
    ]);

    if($insert){
        return redirect()->back()->with('cart_msg','Added Successfully');
    }else{
        return redirect()->back()->with('cart_msg','Error Occured');
    }
}



}


