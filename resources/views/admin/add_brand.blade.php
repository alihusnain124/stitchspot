@extends('admin/layout')
@section('title','Add Brand')
@section('page_title'){{ $id > 0 ? 'Edit Brand' : 'Add Brand' }}@endsection
@section('brand_select','active')
@section('content')

<?php
if ($id > 0) $image_req = '';
else $image_req = 'required';
$checked = '';
?>

<div class="mb-3">
  <a href="{{route('brand.manage_process')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Brands
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">{{ $id > 0 ? 'Edit Brand' : 'Add Brand' }}</span>
  </div>
  <div class="admin-card-body">
    <form action="{{route('brand.manage_process')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="adm-label">Brand Name</label>
          <input type="text" id="brand_name" name="brand_name" value="{{$brand_name}}" class="adm-input">
          @error('brand_name')
            <div class="adm-err">Required</div>
          @enderror
        </div>
        <div class="col-md-6">
          <label class="adm-label">Brand Image</label>
          <input type="file" id="brand_image" name="brand_image" class="adm-input">
          @if ($brand_image != '')
            <img class="mt-2" width="80px" src="{{ str_starts_with($brand_image, 'http') ? $brand_image : asset('/storage/media/brand/'.$brand_image) }}" alt="">
          @endif
          @error('brand_image')
            <div class="adm-err">Required, should be jpg, png or jpeg</div>
          @enderror
        </div>
        <div class="col-md-12">
          <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:#555;">
            <input type="checkbox" id="is_home" name="is_home" {{$checked}}>
            Show on Home page
          </label>
        </div>
      </div>
      <input type="hidden" name="id" value="{{$id}}">
      <div class="mt-4">
        <button type="submit" class="btn-adm btn-adm-dark">
          <i class="fa-solid fa-floppy-disk"></i> Save Brand
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
