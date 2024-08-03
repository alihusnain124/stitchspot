<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Session;
use Stripe;
use DB;
class StripePaymentController extends Controller
{
/**
* success response method.
*
* @return \Illuminate\Http\Response
*/
public function stripe(Request $req)

{
    $data = [
        'name' => $req->input('name'),
        'email' => $req->input('email'),
        'address' => $req->input('address'),
        'city' => $req->input('city'),
        'state' => $req->input('state'),
        'zip_code' => $req->input('zip_code'),
        'mobile_no' => $req->input('mobile_no'),
        'payment_method' => $req->input('payment_method'),
        'total_price' => $req->input('total_price'),
        'is_stitch'=>$req->input('is_stitch')
    ];

    if ($req->session()->has('FRONT_USER_LOGIN')) {
        $data['user_id'] = $req->session()->get('FRONT_USER_LOGIN');
        $data['user_type'] = 'Reg';
    } else {
        $data['user_id'] = getUserTempid();
        $data['user_type'] = 'Not Reg';
    }

    return view('front.stripe', $data);

}
/**
* success response method.
*
* @return \Illuminate\Http\Response
*/
public function stripePost(Request $req)
{
Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
Stripe\Charge::create ([
"amount" => $req->total_price * 100,
"currency" => "pkr",
"source" => $req->stripeToken,
"description" => "New payment has been recieved"
]);
Session::flash('success', 'Payment successful!');


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
    'payment_status'=>'Success',
    'added_on'=>date('Y-m-d h:i:s')

]);

$order_id=$order;

$cart = DB::table('cart')->where(['user_id'=>$user_id])->get();
if(isset($cart[0])){

    
foreach($cart as $item){

    DB::table('order_details')->insert([
        'order_id'=>$order_id,
        'product_id'=>$item->product_id,
        'product_name'=>$item->product_name,
        'product_price'=>$item->product_price,
        'product_qty'=>$item->product_qty,
        'product_attr_id'=>$item->product_attr_id,
        'is_stitch'=>$is_stitch,
        'added_on'=>date('Y-m-d h:i:s')

    ]);
   
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




return redirect('/order_placed')->with('msg','Please add items to cart');

}





public function stripe_pay(Request $req,$id,$price){

    $data = [
        'id' => $id,
        'price'=>$price
    ];

    if ($req->session()->has('FRONT_USER_LOGIN')) {
        $data['user_id'] = $req->session()->get('FRONT_USER_LOGIN');
        $data['user_type'] = 'Reg';
    } else {
        $data['user_id'] = getUserTempid();
        $data['user_type'] = 'Not Reg';
    }

    return view('front.stripe_pay', $data);

}
/**
* success response method.
*
* @return \Illuminate\Http\Response
*/
public function stripePost_pay(Request $req)
{
Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
Stripe\Charge::create ([
"amount" => $req->price * 100,
"currency" => "pkr",
"source" => $req->stripeToken,
"description" => "New payment has been recieved"
]);
Session::flash('success', 'Payment successful!');


if($req->session()->has('FRONT_USER_LOGIN')){
    $user_id=$req->session()->get('FRONT_USER_LOGIN');
    $user_type='Reg';

}else{
    $user_id=getUserTempid();
    $user_type='Not Reg';

}

$id=$req->input('id');


if($req->session()->has('FRONT_USER_LOGIN')){

$user_id=$req->session()->get('FRONT_USER_LOGIN');

$order_confirm=DB::table('confirm_orders')->where('id',$id)->update(['is_paid'=>'yes','added_on'=>date('Y-m-d h:i:s')]);

if($order_confirm){

}

 


}

else{

}




return redirect('/profile/'.$user_id)->with('msg',"Your tailor's order has been confirmed");

}




public function stripe_pay_tailor(Request $req,$id,$user_id,$price){

    $data = [
        'id' => $id,
        'user_id'=>$user_id,
        'price'=>$price
    ];

   

    return view('admin.stripe_pay_tailor', $data);

}
/**
* success response method.
*
* @return \Illuminate\Http\Response
*/
public function stripePost_pay_tailor(Request $req)
{
Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
Stripe\Charge::create ([
"amount" => $req->price * 100,
"currency" => "pkr",
"source" => $req->stripeToken,
"description" => "New payment has been recieved"
]);
Session::flash('success', 'Payment successful!');




$id=$req->input('id');
$user_id=$req->input('user_id');

$result=DB::table('confirm_orders')->where(['id'=>$id,'service_user_id'=>$user_id])->update(['paid_tailor'=>'yes']);

if($result){

return redirect('/admin/tailor_order')->with('msg',"Successfully paid");
}else{
    return redirect('/admin/tailor_order')->with('msg',"Error");
}




}
}
