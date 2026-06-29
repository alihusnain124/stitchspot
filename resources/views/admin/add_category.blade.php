@extends('admin/layout')
@section('title','Add Category')
@section('page_title','{{ $id > 0 ? "Edit Category" : "Add Category" }}')
@section('category_select','active')
@section('content')

<?php
if ($id > 0) $image_req = '';
else $image_req = 'required';
$checked = '';
?>

<div class="mb-3">
  <a href="{{url('/admin/category')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Categories
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">{{ $id > 0 ? 'Edit Category' : 'Add Category' }}</span>
  </div>
  <div class="admin-card-body">
    <form action="{{route('category.manage_process')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="adm-label">Category Name</label>
          <input type="text" name="category_name" value="{{$category_name}}" class="adm-input">
          @error('category_name')
            <div class="adm-err">Required</div>
          @enderror
        </div>
        <div class="col-md-4">
          <label class="adm-label">Category Slug</label>
          <input type="text" name="category_slug" value="{{$category_slug}}" class="adm-input">
          @error('category_slug')
            <div class="adm-err">Slug should be unique</div>
          @enderror
        </div>
        <div class="col-md-4">
          <label class="adm-label">Parent Category</label>
          <select id="parent_category_id" name="parent_category_id" class="adm-select">
            <option value="0">Select Category</option>
            @foreach ($category as $item)
              @if ($parent_category_id == $item->id)
                <option selected value="{{$item->id}}">{{$item->category_name}}</option>
              @else
                <option value="{{$item->id}}">{{$item->category_name}}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-12">
          <label class="adm-label">Category Image</label>
          <input id="category_image" name="category_image" type="file" class="adm-input" {{$image_req}}>
          @if ($category_image != '')
            <img class="mt-2" width="80px" src="{{asset('/storage/media/category/'.$category_image)}}" alt="">
          @endif
          @error('category_image')
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
          <i class="fa-solid fa-floppy-disk"></i> Save Category
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
