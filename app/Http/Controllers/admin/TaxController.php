<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $result['data']=Tax::all();

       return view('admin/tax',$result);
    }
    public function add_tax(Request $req,$id=''){
        if($id>0){
          $arr=Tax::where(['id'=>$id])->get();
          $result['tax_desc']=$arr['0']->tax_desc;
          $result['tax_value']=$arr['0']->tax_value;
          $result['id']=$arr['0']->id;
        }else{
            $result['tax_desc']='';
          $result['tax_value']='';
            $result['id']='';
        }
       
        return view('admin/add_tax',$result);
    }

    public function manage_tax_process(Request $req){

       
       $req->validate([
       
        'tax_value'=>'required|unique:taxs,tax_value,'.$req->post('id'),
     
       ]);
       if($req->post('id')>0){
        $data=Tax::find($req->post('id'));
        $msg='Tax Updated';
       }else{
        $data= new Tax();
        $msg='Tax Inserted';
       }
      
       $data->tax_desc=$req->post('tax_desc');
       $data->tax_value=$req->post('tax_value');
       $data->status=1;
       $data->save();
       $req->session()->flash('message',$msg);
       return redirect('admin/tax');
      

    }
    public function delete(Request $req, $id){
        $result=Tax::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/tax');
    }
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Tax has been Activated';
        }else{
            $msg='Tax has been Deactivated';
        }
        $result=Tax::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/tax');
    }
}
