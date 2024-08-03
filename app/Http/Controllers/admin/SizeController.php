<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $result['data']=Size::all();

       return view('admin/size',$result);
    }
    public function add_size(Request $req,$id=''){

        if($id>0){
          $arr=Size::where(['id'=>$id])->get();
          $result['size']=$arr['0']->size;
          $result['id']=$arr['0']->id;
        }else{
            $result['size']='';
            $result['id']='';
        }
       
        return view('admin/add_size',$result);
    }

    public function manage_size_process(Request $req){
      
       $req->validate([
        'size'=>'required',
        
       ]);
       if($req->post('id')>0){
        $data=Size::find($req->post('id'));
        $msg='Size Updated';
       }else{
        $data= new Size();
        $msg='Size Inserted';
       }
      
       $data->size=$req->post('size');
       $data->status=1;
       $data->save();
       $req->session()->flash('message',$msg);
       return redirect('admin/size');
      

    }
    public function delete(Request $req, $id){
        $result=Size::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/size');
    }
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Size has been Activated';
        }else{
            $msg='Size has been Deactivated';
        }
        $result=Size::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/size');
    }

}
