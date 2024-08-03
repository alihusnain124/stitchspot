@extends('admin/layout');
@section('title','Add Product')
@section('product_select','active')
@section('add')
<?php
if ($id>0)
$image_req='';
else
$image_req='required'; 

?>

        <div class="page-container">
       

            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">

                {{session('sku_error')}}
           <h1 class='mx-5'>Add Product</h1>
            <a href="{{url('/admin/product')}}">

           <button type="button" class="btn btn-outline-success mx-5 my-4 "> Back</button></a>  

                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{route('product.manage_process')}}" method="post" enctype="multipart/form-data">
                          <div class="row">
                             <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                    
                       @csrf
                       <div class="form-group">
                       <label for="Category" class="control-label mb-1">Name</label>
                       <input id="name" name="name" value='{{$name}}' type="text" class="form-control" aria-required="true" aria-invalid="false" >
                       @error('name')
                       <div class="alert alert-danger mt-2" role='alert'>
                          {{'Requried'}}
                       </div>
                       @enderror
                       <div class="form-group">
                       <label for="Category" class="control-label mb-1">Slug</label>
                       <input id="slug" name="slug" value='{{$slug}}' type="text" class="form-control" aria-required="true" aria-invalid="false" >
                       @error('slug')
                       <div class="alert alert-danger mt-2" role='alert'>
                          {{'Requried,should be unique'}}
                       </div>
                       @enderror
                       <div class="form-group">
                       <label for="Category" class="control-label mb-1">Image</label>
                       <input id="image" name="image" value='{{$image}}' type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_req}}>
                              @if ($image!='')
                                    <img class='m-2' width="100px" src="{{asset('/storage/media/'.$image)}}" alt="">    
                                    @endif 
                                    @error('image')
                                    <div class="alert alert-danger mt-2" role='alert'>
                                       {{'Requried,should be jpg,png or jpeg'}}
                                    </div>
                                    @enderror
                       <div>
                       <div class="form-group">
                       <div class="row">

                          <div class="col-md-4">
                             <label for="Category" class="control-label mb-1">Brand</label>
                             <select id="brand_id" name="brand_id"  class="form-control" >
                                <option value="0">Select Brand</option>
                                @foreach ($brand as $item)
                                @if ($brand_id==$item->id)
                                <option selected value="{{$item->id}}">
                                   @else
                                <option value="{{$item->id}}">
                                   @endif
                                   {{$item->brand_name}}
                                </option>
                                @endforeach
                             </select>
                             <div> 
                             </div>
                          </div>

                          <div class="col-md-4">
                             <label for="Discounted" class="control-label mb-1">Is Discounted</label>
                             <select id="is_discounted" name="is_discounted"  class="form-control" >
                                @if ($is_discounted=='1')
                                <option value="1" selected>yes</option>
                                <option value="0">No</option>
                                @else
                                <option value="1">yes</option>
                                <option value="0" selected>No</option>
                                @endif
                             </select>  
                          </div>
                    
                          <div class="col-md-4">
                             <label for="Category" class="control-label mb-1">Category</label>
                             <select id="category_id" name="category_id"  class="form-control" >
                                <option value="">Select Category</option>
                                @foreach ($category as $item)
                                @if ($category_id==$item->id)
                                <option selected value="{{$item->id}}">
                                   @else
                                <option value="{{$item->id}}">
                                   @endif
                                   {{$item->category_name}}
                                </option>
                                @endforeach
                             </select>
                             <div> 
                           </div>
                          </div>
                       </div>
                       <div class="form-group">
                       <label for="Category" class="control-label mb-1">Short Description</label>
                       <textarea id="short_desc" name="short_desc"  type="text" class="form-control" aria-required="true" aria-invalid="false">{{$short_desc}}</textarea>
                       </div>
                       <div class="form-group">
                       <label for="Category" class="control-label mb-1">Description</label>
                       <textarea id="desc" name="desc"  type="text" class="form-control" aria-required="true" aria-invalid="false">{{$desc}}</textarea>
                       </div>
                       <div class="form-group">
                       <label for="Category" class="control-label mb-1">Keywords</label>
                       <textarea id="keyword" name="keyword"  type="text" class="form-control" aria-required="true" aria-invalid="false">{{$keyword}}</textarea>
                       </div>
                          
                      
                    
                    
                    
                    </div> 
                    
                    
                    
                         {{-- product attributes --}}
                    
                    
                    <h1 class='mb-4 mx-2'>Product Attributes</h1>
                    <div class="col-lg-12"  id='product_attr'>
                    
                       <?php
                           $loop_count_num=1;
                          ?>
                       @foreach ($productAttrArr as $key=>$val)
                    
                       <?php
                      
                       $pAArr=(array)$val;
                       ?>
                     <input id="paid" type="hidden" name="paid[]" value="{{$pAArr['id']}}">
                    <div class="card" id='product_count_{{$loop_count_num++}}'>
                      
                        <div class="card-body">
                            <div class="form-group" >
                                <div class="row">
                                   <div class="col-md-3">
                                      <label for="Category" class="control-label mb-1">SKU</label>
                                      <input id="sku" name="sku[]" value="{{$pAArr['sku']}}"  type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                     
                                   </div>
                                   <div class="col-md-3">
                                      <label for="Category" class="control-label mb-1">MRP</label>
                                      <input id="mrp" name="mrp[]" value="{{$pAArr['mrp']}}" type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                   </div>
                                   <div class="col-md-3">
                                    <label for="Category" class="control-label mb-1">Price</label>
                                    <input id="price" name="price[]" value="{{$pAArr['price']}}"  type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                 </div>
                                 <div class="col-md-3">
                                    <label for="Category" class="control-label mb-1">Qty</label>
                                    <input id="qty" name="qty[]" value="{{$pAArr['qty']}}"  type="text" class="form-control" aria-required="true" aria-invalid="false" >
                                 </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                            
                                        <label for="Category" class="control-label mb-1">Size</label>
                                        <select id="size_id" name="size_id[]"  class="form-control" >
                                           <option value="">Select Size</option>
                                           @foreach ($size as $item)
                                           @if ($pAArr['size_id']==$item->id)
                                           <option selected value="{{$item->id}}">
                                              @else
                                           <option value="{{$item->id}}">
                                              @endif
                                              {{$item->size}}
                                           </option>
                                           @endforeach
                                        </select>
                        
                                </div>
                                <div class="col-md-6">  
                    
                                    <label for="Category" class="control-label mb-1">Color</label>
                                    <select id="color_id" name="color_id[]"  class="form-control" >
                                       <option value="">Select Color</option>
                                       @foreach ($color as $item)
                                       @if ($pAArr['color_id']==$item->id)
                                       <option selected value="{{$item->id}}">
                                          @else
                                       <option value="{{$item->id}}">
                                          @endif
                                          {{$item->color}}
                                       </option>
                                       @endforeach
                                    </select>
                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <label for="Category" class="control-label mb-1">Image</label>
                                    <input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_req}}>
                                    @if ($pAArr['attr_image']!='')
                                    <img class='m-2' width="100px" src="{{asset('/storage/media/'.$pAArr['attr_image'])}}" alt="">    
                                    @endif
                                    @error('attr_image.*')
                                    <div class="alert alert-danger mt-2" role='alert'>
                                       {{'Requried,should be jpg,png or jpeg'}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-5">
                                   @if ($loop_count_num==2)
                                   <button id="" type='button' onclick="add_more()" class="btn btn-info text-white">Add</button>
                                   @else
                                   <a href="{{url('/admin/product/product_attr_delete/')}}/{{$pAArr['id']}}/{{$id}}"><button type='button' class="btn btn-lg btn-danger btn-block">Remove</button></a>
                                   @endif
                                   
                                </div>
                            </div>
                            </div>
                         </div>
                      </div>
                      @endforeach
                    </div>
                    </div>
                    </div>
                    <div>
                        <div class="d-grid gap-2 mt-4">
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block text-white">
                                Submit
                                </button>
                          </div>
                       
                     </div>
                     <input type="hidden" name='id' value="{{$id}}">
                    </form>
             
    </div>
 
</div>

<script>
    var loop_count=1;
     function add_more(){
       loop_count++;
       var html='<input id="paid" type="hidden" name="paid[]" ><div class="card" id="product_count_'+loop_count+'"><h1 class="m-3">No-'+loop_count+'</h1><div class="card-body"><div class="form-group"><div class="row">';
         html+=' <div class="col-md-3"><label for="Category" class="control-label mb-1">SKU</label><input id="sku" name="sku[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" ></div>';
         html+=' <div class="col-md-3"><label for="Category" class="control-label mb-1">MRP</label><input id="mrp" name="mrp[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" ></div>';
         html+=' <div class="col-md-3"><label for="Category" class="control-label mb-1">Price</label><input id="price" name="price[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" ></div>';
         html+=' <div class="col-md-3"><label for="Category" class="control-label mb-1">Qty</label><input id="qty" name="qty[]"  type="text" class="form-control" aria-required="true" aria-invalid="false" ></div>';
 
         html+='<div class="col-md-6"><label for="Category" class="control-label mb-1">Size</label><select id="size_id" name="size_id[]"  class="form-control" ><option value="">Select Size</option>@foreach ($size as $item) @if ($id==$item->id) <option selected value="{{$item->id}}"> @else<option value="{{$item->id}}"> @endif {{$item->size}}</option>@endforeach </select></div>';
 
         html+='<div class="col-md-6"><label for="Category" class="control-label mb-1">Color</label><select id="color_id" name="color_id[]"  class="form-control" ><option value="">Select color</option>@foreach ($color as $item) @if ($id==$item->id) <option selected value="{{$item->id}}"> @else<option value="{{$item->id}}"> @endif {{$item->color}}</option>@endforeach </select></div>';
         html+=' <div class="col-md-4 mt-3"><label for="Category" class="control-label mb-1">Image</label><input id="attr_image" name="attr_image[]" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_req}}></div></div>';
         html+='<div class="col-md-4 mt-2"><button type="button"  onclick="remove_more('+loop_count+')" class="btn btn-lg btn-danger ">Remove</button></div>';
        html+='</div></div></div></div></div>';
        jQuery('#product_attr').append(html);
 
 
     }
     function remove_more(loop_count){
       jQuery("#product_count_"+loop_count).remove();
     }
    
 </script>

 
 @endsection