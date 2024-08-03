<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $result['data']=Customer::all();

       return view('admin/customer',$result);
    }
    public function view(Request $req,$id=''){
    
          $arr=Customer::where(['id'=>$id])->get();
          $result['data']=$arr['0'];     
        return view('admin/view_customer',$result);
    }

   
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='User has been Activated';
        }else{
            $msg='User has been Deactivated';
        }
        $result=Customer::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/customer');
    }
}
