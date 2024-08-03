<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\controller;
use App\Models\admin\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

        $result['orders']=DB::table('orders')->get();
        return view('admin.order',$result);
     
    }

    public function order_details(Request $req,$id){

        $result['order']=DB::table('orders')->where('id',$id)->get();
        $result['order_details']=DB::table('order_details')->where('order_id',$id)->get();

 

        $result['payment_status']=['Panding','Success'];
        $result['order_status']=['Panding','On the Way','Delivered'];

      
        return view('admin.order_details',$result);
     
    }

    
    public function update_status(Request $req){
    
      $order_status=$req->post('order_status');
      $payment_status=$req->post('payment_status');
      $track_details=$req->post('track_details');
      $id=$req->post('id');

     $result=DB::table('orders')->where('id',$id)->update(['payment_status'=>$payment_status,'order_status'=>$order_status,'track_details'=>$track_details]);

     if($result){
        return response()->json(['status'=>'success','msg'=>'Updated']);
     }else{
        return response()->json(['status'=>'error','msg'=>'First Change Them']);
     }
    }


    public function tailor_order(Request $req){

        $result['active_orders']=DB::table('confirm_orders')->where(['is_paid'=>'yes','status'=>'processing'])->get();

        $result['completed_orders']=DB::table('confirm_orders')->where(['is_paid'=>'yes','status'=>'completed'])->get();


        return view('admin.tailor_order',$result);
    
    }

   
}
