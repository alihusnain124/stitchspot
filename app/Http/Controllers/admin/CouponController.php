<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $result['data']=Coupon::all();

       return view('admin/coupon',$result);
    }
    public function add_coupon(Request $req,$id=''){
        if($id>0){
          $arr=Coupon::where(['id'=>$id])->get();
          $result['title']=$arr['0']->title;
          $result['code']=$arr['0']->code;
          $result['value']=$arr['0']->value;
          $result['type']=$arr['0']->type;
          $result['min_order_amt']=$arr['0']->min_order_amt;
          $result['is_one_time']=$arr['0']->is_one_time;
          $result['id']=$arr['0']->id;
        }else{
            $result['title']='';
            $result['code']='';
            $result['value']='';
            $result['type']='';
            $result['min_order_amt']='';
            $result['is_one_time']='';
            $result['id']='';
        }
       
        return view('admin/add_coupon',$result);
    }

    public function manage_coupon_process(Request $req){
      
       $req->validate([
        'title'=>'required',
        'code'=>'required|unique:coupons,code,'.$req->post('id'),
        'value'=>'required',
       ]);
       if($req->post('id')>0){
        $data=Coupon::find($req->post('id'));
        $msg='Coupon Updated';
       }else{
        $data= new Coupon();
        $msg='Coupon Inserted';
       }
      
       $data->title=$req->post('title');
       $data->code=$req->post('code');
       $data->value=$req->post('value');
       $data->type=$req->post('type');
       $data->min_order_amt=$req->post('min_order_amt');
       $data->is_one_time=$req->post('is_one_time');
       $data->status=1;
       $data->save();
       $req->session()->flash('message',$msg);
       return redirect('admin/coupon');
      

    }
    public function delete(Request $req, $id){
        $result=Coupon::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/coupon');
    }
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Coupon has been Activated';
        }else{
            $msg='Coupon has been Deactivated';
        }
        $result=Coupon::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/coupon');
    }

}
