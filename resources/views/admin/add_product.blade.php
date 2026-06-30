@extends('admin/layout')
@section('title','Add Product')
@section('page_title'){{ $id > 0 ? 'Edit Product' : 'Add Product' }}@endsection
@section('product_select','active')
@section('content')

<?php
if ($id > 0) $image_req = '';
else $image_req = 'required';
?>

<div class="mb-3">
  <a href="{{url('/admin/product')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Products
  </a>
</div>

@if(session('sku_error'))
  <div style="background:#FEF2F2;border-left:3px solid #E63946;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#E63946;">
    {{session('sku_error')}}
  </div>
@endif

<form action="{{route('product.manage_process')}}" method="post" enctype="multipart/form-data">
  @csrf

  <div class="admin-card">
    <div class="admin-card-header">
      <span class="admin-card-title">Product Info</span>
    </div>
    <div class="admin-card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="adm-label">Name</label>
          <input id="name" name="name" value="{{$name}}" type="text" class="adm-input">
          @error('name')
            <div class="adm-err">Required</div>
          @enderror
        </div>
        <div class="col-md-6">
          <label class="adm-label">Slug</label>
          <input id="slug" name="slug" value="{{$slug}}" type="text" class="adm-input">
          @error('slug')
            <div class="adm-err">Required, should be unique</div>
          @enderror
        </div>
        <div class="col-md-12">
          <label class="adm-label">Product Image</label>
          <input id="image" name="image" type="file" class="adm-input" {{$image_req}}>
          @if ($image != '')
            <img class="mt-2" width="80px" src="{{ str_starts_with($image, 'http') ? $image : asset('/storage/media/'.$image) }}" alt="">
          @endif
          @error('image')
            <div class="adm-err">Required, should be jpg, png or jpeg</div>
          @enderror
        </div>
        <div class="col-md-4">
          <label class="adm-label">Brand</label>
          <select id="brand_id" name="brand_id" class="adm-select">
            <option value="0">Select Brand</option>
            @foreach ($brand as $item)
              @if ($brand_id == $item->id)
                <option selected value="{{$item->id}}">{{$item->brand_name}}</option>
              @else
                <option value="{{$item->id}}">{{$item->brand_name}}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="adm-label">Category</label>
          <select id="category_id" name="category_id" class="adm-select">
            <option value="">Select Category</option>
            @foreach ($category as $item)
              @if ($category_id == $item->id)
                <option selected value="{{$item->id}}">{{$item->category_name}}</option>
              @else
                <option value="{{$item->id}}">{{$item->category_name}}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="adm-label">Is Discounted</label>
          <select id="is_discounted" name="is_discounted" class="adm-select">
            @if ($is_discounted == '1')
              <option value="1" selected>Yes</option>
              <option value="0">No</option>
            @else
              <option value="1">Yes</option>
              <option value="0" selected>No</option>
            @endif
          </select>
        </div>
        <div class="col-md-12">
          <label class="adm-label">Short Description</label>
          <textarea id="short_desc" name="short_desc" class="adm-textarea">{{$short_desc}}</textarea>
        </div>
        <div class="col-md-12">
          <label class="adm-label">Description</label>
          <textarea id="desc" name="desc" class="adm-textarea" style="min-height:120px;">{{$desc}}</textarea>
        </div>
        <div class="col-md-12">
          <label class="adm-label">Keywords</label>
          <textarea id="keyword" name="keyword" class="adm-textarea">{{$keyword}}</textarea>
        </div>
      </div>
    </div>
  </div>

  <div class="admin-card">
    <div class="admin-card-header">
      <span class="admin-card-title">Product Attributes</span>
    </div>
    <div class="admin-card-body">
      <div id="product_attr">
        <?php $loop_count_num = 1; ?>
        @foreach ($productAttrArr as $key => $val)
          <?php $pAArr = (array)$val; ?>
          <input type="hidden" name="paid[]" value="{{$pAArr['id']}}">
          <div class="attr-card" id="product_count_{{$loop_count_num++}}">
            <div class="attr-card-title">Variant #{{$loop_count_num - 1}}</div>
            <div class="row g-3">
              <div class="col-md-3">
                <label class="adm-label">SKU</label>
                <input name="sku[]" value="{{$pAArr['sku']}}" type="text" class="adm-input">
              </div>
              <div class="col-md-3">
                <label class="adm-label">MRP</label>
                <input name="mrp[]" value="{{$pAArr['mrp']}}" type="text" class="adm-input">
              </div>
              <div class="col-md-3">
                <label class="adm-label">Price</label>
                <input name="price[]" value="{{$pAArr['price']}}" type="text" class="adm-input">
              </div>
              <div class="col-md-3">
                <label class="adm-label">Qty</label>
                <input name="qty[]" value="{{$pAArr['qty']}}" type="text" class="adm-input">
              </div>
              <div class="col-md-6">
                <label class="adm-label">Size</label>
                <select name="size_id[]" class="adm-select">
                  <option value="">Select Size</option>
                  @foreach ($size as $item)
                    @if ($pAArr['size_id'] == $item->id)
                      <option selected value="{{$item->id}}">{{$item->size}}</option>
                    @else
                      <option value="{{$item->id}}">{{$item->size}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="adm-label">Color</label>
                <select name="color_id[]" class="adm-select">
                  <option value="">Select Color</option>
                  @foreach ($color as $item)
                    @if ($pAArr['color_id'] == $item->id)
                      <option selected value="{{$item->id}}">{{$item->color}}</option>
                    @else
                      <option value="{{$item->id}}">{{$item->color}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="adm-label">Variant Image</label>
                <input name="attr_image[]" type="file" class="adm-input" {{$image_req}}>
                @if ($pAArr['attr_image'] != '')
                  <img class="mt-2" width="70px" src="{{ str_starts_with($pAArr['attr_image'], 'http') ? $pAArr['attr_image'] : asset('/storage/media/'.$pAArr['attr_image']) }}" alt="">
                @endif
                @error('attr_image.*')
                  <div class="adm-err">Required, should be jpg, png or jpeg</div>
                @enderror
              </div>
              <div class="col-md-6" style="display:flex;align-items:flex-end;">
                @if ($loop_count_num == 2)
                  <button type="button" onclick="add_more()" class="btn-adm btn-adm-dark">
                    <i class="fa-solid fa-plus"></i> Add Variant
                  </button>
                @else
                  <a href="{{url('/admin/product/product_attr_delete/')}}/{{$pAArr['id']}}/{{$id}}" class="btn-adm btn-adm-red">
                    <i class="fa-solid fa-trash"></i> Remove
                  </a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <input type="hidden" name="id" value="{{$id}}">
  <div class="mb-4">
    <button id="payment-button" type="submit" class="btn-adm btn-adm-dark" style="padding:12px 28px;font-size:13px;">
      <i class="fa-solid fa-floppy-disk"></i> Save Product
    </button>
  </div>
</form>

@endsection
@section('scripts')
<script>
  var loop_count = 1;
  function add_more(){
    loop_count++;
    var html = '<input type="hidden" name="paid[]"><div class="attr-card" id="product_count_'+loop_count+'">';
    html += '<div class="attr-card-title">Variant #'+loop_count+'</div>';
    html += '<div class="row g-3">';
    html += '<div class="col-md-3"><label class="adm-label">SKU</label><input name="sku[]" type="text" class="adm-input"></div>';
    html += '<div class="col-md-3"><label class="adm-label">MRP</label><input name="mrp[]" type="text" class="adm-input"></div>';
    html += '<div class="col-md-3"><label class="adm-label">Price</label><input name="price[]" type="text" class="adm-input"></div>';
    html += '<div class="col-md-3"><label class="adm-label">Qty</label><input name="qty[]" type="text" class="adm-input"></div>';
    html += '<div class="col-md-6"><label class="adm-label">Size</label><select name="size_id[]" class="adm-select"><option value="">Select Size</option>@foreach ($size as $item)<option value="{{$item->id}}">{{$item->size}}</option>@endforeach</select></div>';
    html += '<div class="col-md-6"><label class="adm-label">Color</label><select name="color_id[]" class="adm-select"><option value="">Select Color</option>@foreach ($color as $item)<option value="{{$item->id}}">{{$item->color}}</option>@endforeach</select></div>';
    html += '<div class="col-md-6"><label class="adm-label">Variant Image</label><input name="attr_image[]" type="file" class="adm-input" {{$image_req}}></div>';
    html += '<div class="col-md-6" style="display:flex;align-items:flex-end;"><button type="button" onclick="remove_more('+loop_count+')" class="btn-adm btn-adm-red"><i class="fa-solid fa-trash"></i> Remove</button></div>';
    html += '</div></div>';
    jQuery('#product_attr').append(html);
  }
  function remove_more(loop_count){
    jQuery('#product_count_'+loop_count).remove();
  }
</script>
@endsection
