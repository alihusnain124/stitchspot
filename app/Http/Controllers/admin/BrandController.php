<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\controller;
use App\Models\admin\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $result['data']=Brand::all();

       return view('admin/brand',$result);
    }
    public function add_brand(Request $req,$id=''){
        if($id>0){
          $arr=Brand::where(['id'=>$id])->get();
          $result['brand_name']=$arr['0']->brand_name;
          $result['brand_image']=$arr['0']->brand_image;
          $result['is_home']=$arr['0']->is_home;
          if($result['is_home']==1){
            $result['checked']='checked';
          }else{
            $result['checked']='';
          }
          $result['id']=$arr['0']->id;
        }else{
            $result['id']='';
            $result['brand_name']='';
            $result['brand_image']='';
            $result['is_home']='';
        }
       
        return view('admin/add_brand',$result);
    }

    public function manage_brand_process(Request $req){
     
        if($req->post('id')>0){
            $image_val='mimes:jpg,jpeg,png';
        }else{
            $image_val='required|mimes:jpg,jpeg,png';
        }
       $req->validate([
          
        'brand_name'=>'required|unique:brands,brand_name,'.$req->post('id'),
        'brand_image'=> $image_val,
     
       ]);
   

       if($req->post('id')>0){
        $data=Brand::find($req->post('id'));
        $msg='Brand Updated';
       }else{
        $data= new Brand();
        $msg='Brand Inserted';
       }

     
       if($req->hasfile('brand_image')){

        if($req->post('id')!=''){
            $image=DB::table('brands')->where(['id'=>$req->post('id')])->get();   
            if(Storage::exists('public/media/brand/'.$image[0]->brand_image)){
                Storage::delete('public/media/brand/'.$image[0]->brand_image);
            }
        }


        $image=$req->file('brand_image');
        $ext=$image->extension();
        $image_name=time().'.'.$ext;
        $image->storeAs('/public/media/brand',$image_name);
        $data->brand_image=$image_name;     
       }
       
    //    echo '<pre>';
    //    print_r($req->post());
    //    print_r($image_name);
    //    die();
       $data->brand_name=$req->post('brand_name');
       $data->is_home=0;
       if($req->post('is_home')!=null){
        $data->is_home=1;
       }
       $data->status=1;
       $data->save();
       $req->session()->flash('message',$msg);
       return redirect('admin/brand');
      

    }
    public function delete(Request $req, $id){
        $result=Brand::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/brand');
    }
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Brand has been Activated';
        }else{
            $msg='Brand has been Deactivated';
        }
        $result=Brand::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/brand');
    }
}
