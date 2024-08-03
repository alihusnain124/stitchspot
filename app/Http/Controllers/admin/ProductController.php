<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;

use App\Models\admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;

class ProductController extends Controller
{
    public function index()
    {
        $result['data']=Product::all();

       return view('admin/product',$result);
    }
    public function add_product(Request $req,$id=''){
        if($id>0){
          $arr=Product::where(['id'=>$id])->get();
          $result['id']=$arr['0']->id;
          $result['category_id']=$arr['0']->category_id;
          $result['name']=$arr['0']->name;
          $result['slug']=$arr['0']->slug;
          $result['image']=$arr['0']->image;
          $result['brand_id']=$arr['0']->brand;
          $result['short_desc']=$arr['0']->short_desc;
          $result['desc']=$arr['0']->desc;
          $result['keyword']=$arr['0']->keyword;
          $result['is_discounted']=$arr['0']->is_discounted;
          $result['status']=$arr['0']->status;
         
           /* Product atttributes data started */

           $result['productAttrArr']=DB::table('products_attr')->where(['products_id'=>$id])->get();
          

        


          /* Product atttributes data end */


        }else{
            $result['id']='';
            $result['category_id']='';
            $result['name']='';
            $result['slug']='';
            $result['image']='';
            $result['brand_id']='';
            $result['desc']='';
            $result['short_desc']='';
            $result['keyword']='';
            $result['is_discounted']='';
            $result['status']='';


            /* Product atttributes data started */
            $result['productAttrArr'][0]['id']='';
            $result['productAttrArr'][0]['products_id']='';
            $result['productAttrArr'][0]['sku']='';
            $result['productAttrArr'][0]['mrp']='';
            $result['productAttrArr'][0]['price']='';
            $result['productAttrArr'][0]['qty']='';
            $result['productAttrArr'][0]['size_id']='';
            $result['productAttrArr'][0]['color_id']='';
            $result['productAttrArr'][0]['attr_image']='';

          
            /* Product atttributes data started */

        }

    
        ///extracting data from another column
        $result['category']=DB::table('categories')->where(['status'=>1])->get();
        $result['size']=DB::table('sizes')->where(['status'=>1])->get();
        $result['color']=DB::table('colors')->where(['status'=>1])->get();
        $result['brand']=DB::table('brands')->where(['status'=>1])->get();
        // $result['tax']=DB::table('taxs')->where(['status'=>1])->get();
      
      
        return view('admin/add_product',$result);
    }

    public function manage_product_process(Request $req){
    //     echo '<pre>';
    //  print_r($req->post());
    //    die();
        // print_r($req->post('size_id'));
        // print_r($req->post('color_id'));
        // die;
        
        if($req->post('id')>0){
            $image_val='mimes:jpg,jpeg,png';
        }else{
            $image_val='required|mimes:jpg,jpeg,png';
        }
       $req->validate([
        'name'=>'required',
        'image'=> $image_val,
        //'slug'=>'required|unique:products,slug,'.$req->post('id'),
        // 'sku.*'=>'required|unique:products_attr,sku'.$req->post('paid'),
        'attr_image.*'=>'mimes:jpg,jpeg,png,jfif',
       
     
       ]);


       ////  is validations ki smjh koi ni ai.......

       $paidarr=$req->post('paid');
       $skuarr=$req->post('sku');
       $mrparr=$req->post('mrp');
       $pricearr=$req->post('price');
       $qtyarr=$req->post('qty');
       $size_idarr=$req->post('size_id');
       $color_idarr=$req->post('color_id');


        ///ya validation ni hoi the mujh sa bad ma krni haa;

    //    foreach($skuarr as $key=>$value){
    //     $check[]=DB::table('products_attr')->where('sku','=',$skuarr[$key])->where('id','!=',$paidarr[$key])->get();
    //     echo '<pre>';
    //     print_r($check);
    //     die;
       

    //     if(isset($check[0])){
    //      $req->session->flash('sku_error','This SKU is already exists');
    //      return redirect(request()->headers->get('referer'));
    //     }



      // }




       if($req->post('id')>0){
        $data=Product::find($req->post('id'));
        $msg='Product Updated';
       }else{
        $data= new Product();
        $msg='Product Inserted';
       }
       if($req->hasfile('image')){
        if($req->post('id')>0){
        $image=DB::table('products')->where(['id'=>$req->post('id')])->get();   
        if(Storage::exists('public/media/'.$image[0]->image)){
            Storage::delete('public/media/'.$image[0]->image);
        }
    }

          
        $image=$req->file('image');
        $ext=$image->extension();
        $image_name=time().'.'.$ext;
        $image->storeAs('/public/media',$image_name);
        $data->image=$image_name;     
       }
      
       $data->category_id=$req->post('category_id');      
       $data->name=$req->post('name');
       $data->slug=$req->post('slug');
       $data->brand=$req->post('brand_id');
       $data->short_desc=$req->post('short_desc');
       $data->desc=$req->post('desc');
       $data->keyword=$req->post('keyword');
       $data->is_discounted=$req->post('is_discounted');
       $data->status=1;
       $data->save();
       $pid=$data->id;
     

        /*Product attributes data started */
     
          
      


        foreach($skuarr as $key=>$value){
           
         $productAttrArr['sku']=$skuarr[$key];
        //  $productAttrArr['attr_image']='ali'; 
         $productAttrArr['mrp']=(int)$mrparr[$key];
         $productAttrArr['price']=(int)$pricearr[$key];
         $productAttrArr['qty']=(int)$qtyarr[$key];
         $productAttrArr['size_id']=$size_idarr[$key];
         $productAttrArr['color_id']=$color_idarr[$key];
         $productAttrArr['products_id']=$pid;

      
      
     
           ////product_attr image
        if($req->hasfile("attr_image.$key")){

            if($paidarr[$key]!=''){
                $image=DB::table('products_attr')->where(['id'=>$paidarr[$key]])->get();   
                if(Storage::exists('public/media/'.$image[0]->attr_image)){
                    Storage::delete('public/media/'.$image[0]->attr_image);
                }
            }


            $rand=rand('111111111','999999999');
            $attr_image=$req->file("attr_image.$key");
            $ext=$attr_image->extension();
            $attr_image_name= $rand.'.'.$ext;
            $req->file("attr_image.$key")->storeAs('/public/media',$attr_image_name);
            $productAttrArr['attr_image']=$attr_image_name;  
           

            if($paidarr[$key]!=''){
              
                DB::table('products_attr')->where(['id'=>$paidarr[$key]])->update($productAttrArr);  
             }else{
               
                DB::table('products_attr')->insert($productAttrArr);
             }

           }

        
        
        }
 
 
        /*Product attributes data end */





       
       $req->session()->flash('message',$msg);
       return redirect('admin/product');
      

    }
    public function delete(Request $req, $id){
       

        $result=Product::find($id);
        $result->delete();
        $req->session()->flash('message','Deleted');
        return redirect('/admin/product');
    }

///product attr delete

public function product_attr_delete(Request $req, $paid,$pid){
    $image=DB::table('products_attr')->where(['id'=>$paid])->get();   
    if(Storage::exists('public/media/'.$image[0]->attr_image)){
        Storage::delete('public/media/'.$image[0]->attr_image);
    }


    DB::table('products_attr')->where(['id'=>$paid])->delete();
    return redirect('/admin/product/add_product/'.$pid);
}

////product img delete

    public function status(Request $req,$status, $id){
        if($status==1){
            $msg='Product has been Activated';
        }else{
            $msg='Product has been Deactivated';
        }
        $result=Product::find($id);
        $result->status=$status;
        $result->save();
        $req->session()->flash('message',$msg);
        return redirect('/admin/product');
    }
}
