<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $result['data']=Color::all();

       return view('admin/color',$result);
    }
    public function add_color(Request $req,$id=''){
        if($id>0){
          $arr=Color::where(['id'=>$id])->get();
          $result['color']=$arr['0']->color;
          $result['id']=$arr['0']->id;
        }else{
            $result['color']='';
            $result['id']='';
        }
       
        return view('admin/add_color',$result);
    }

    public function manage_color_process(Request $req){
       $req->validate([
       
        'color'=>'required|unique:colors,color,'.$req->post('id'),
     
       ]);
       if($req->post('id')>0){
        $data=Color::find($req->post('id'));
        $msg='Color Updated';
       }else{
        $data= new Color();
        $msg='Color Inserted';
       }
      
       $data->color=$req->post('color');
       $data->status=1;
       $data->save();
       $req->session()->flash('message',$msg);
       return redirect('admin/color');
      

    }
    public function delete(Request $req, $id){
        $result=Color::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/color');
    }
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Color has been Activated';
        }else{
            $msg='Color has been Deactivated';
        }
        $result=Color::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/color');
    }

}
