<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;


class CategoryController extends Controller
{
    public function index()
    {
        $result['data']=Category::all();

       return view('admin/category',$result);
    }
    public function add_cat(Request $req,$id=''){
        if($id>0){
          $arr=Category::where(['id'=>$id])->get();
          $result['category_name']=$arr['0']->category_name;
          $result['category_slug']=$arr['0']->category_slug;
          $result['parent_category_id']=$arr['0']->parent_category_id;
          $result['is_home']=$arr['0']->is_home;
          if($result['is_home']==1){
            $result['checked']='checked';
          }else{
            $result['checked']='';
          }
          $result['category_image']=$arr['0']->category_image;
          $result['id']=$arr['0']->id;
          $result['category']=DB::table('categories')->where(['status'=>1])->where('id','!=',$id)->get();
        }else{
            $result['category_name']='';
            $result['category_slug']='';
            $result['is_home']='';
            $result['parent_category_id']='';
            $result['category_image']='';
            $result['id']='';
             $result['category']=DB::table('categories')->where(['status'=>1])->get();
        }
       
       
        return view('admin/add_category',$result);
    }

    public function manage_cat_process(Request $req){
        // echo '<pre>';
        // print_r($req->post());
        // die();

      
        if($req->post('id')>0){
            $image_val='mimes:jpg,jpeg,png';
        }else{
            $image_val='required|mimes:jpg,jpeg,png';
        }
       $req->validate([
        'category_name'=>'required',
        'category_image'=> $image_val,
        'category_slug'=>'required|unique:categories,category_slug,'.$req->post('id')
       ]);
       if($req->post('id')>0){
        $data=category::find($req->post('id'));
        $msg='Category Updated';
       }else{
        $data= new category();
        $msg='Category Inserted';
       }

       if($req->hasfile('category_image')){

        // if($req->post('id')!=''){
        //     $image=DB::table('categories')->where(['id'=>$req->post('id')])->get();   
        //     if(Storage::exists('public/media/category/'.$image[0]->category_image)){
        //         Storage::delete('public/media/category/'.$image[0]->category_image);
        //     }
        // }


        $image=$req->file('category_image');
        $ext=$image->extension();
        $image_name=time().'.'.$ext;
      
        $image->storeAs('/public/media/category',$image_name);
        $data->category_image=$image_name;     
       }
      
      
       $data->category_name=$req->post('category_name');
       $data->category_slug=$req->post('category_slug');
       $data->is_home=0;
       if($req->post('is_home')!=null){
        $data->is_home=1;
       }
      
       $data->parent_category_id=$req->post('parent_category_id');
       $data->status=1;
       $data->save();
       $req->session()->flash('message',$msg);
       return redirect('admin/category');
      

    }
    public function delete(Request $req, $id){
        $result=Category::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/category');
    }
    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Category has been Activated';
        }else{
            $msg='Category has been Deactivated';
        }
        $result=Category::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/category');
       
    }
}
