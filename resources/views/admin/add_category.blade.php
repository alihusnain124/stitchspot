@extends('admin/layout');
@section('title','Add Category')
@section('category_select','active')
@section('add')



<?php

if ($id>0)
$image_req='';
else
$image_req='required';
$checked=''; 

?>  
        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
                
            <h1 class="mx-5">Add Category</h1>
            <a href="{{url('/admin/category')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Back</button></a>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <form action="{{route('category.manage_process')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="form-container">
                    <div class="row">
                           <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                                    <input type="text"  name="category_name" value='{{$category_name}}' class="form-control" id="exampleFormControlInput1" >
                                  </div>
                                  @error('category_name')
                                  <div class="alert alert-danger mt-2" role='alert'>
                                      {{'Requried'}}
                                  </div>
                                  @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Category Slug</label>
                                    <input type="text"  name="category_slug"  value='{{$category_slug}}' class="form-control" id="exampleFormControlInput1" >
                                  </div>
                                  @error('category_slug')
                                  <div class="alert alert-danger mt-2" role='alert'>
                                      {{'Slug should be unique'}}
                                  </div>
                                  @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="Category" class="control-label mb-1">Parent Category</label>
                                <select id="parent_category_id" name="parent_category_id"  class="form-control" >
                                   <option value="0">Select Category</option>
                                   @foreach ($category as $item)
                                   @if ($parent_category_id==$item->id)
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

                     <div class="row">
                        <div class="col-md-12">
                            <label for="Category" class="control-label mb-1">Category Image</label>
                            <input id="category_image" name="category_image" type="file" class="form-control" aria-required="true" aria-invalid="false" {{$image_req}}>
                            @if ($category_image!='')
                            <img class='m-2' width="100px" src="{{asset('/storage/media/category/'.$category_image)}}" alt="">    
                            @endif 
                            @error('category_image')
                            <div class="alert alert-danger mt-2" role='alert'>
                               {{'Requried,should be jpg,png or jpeg'}}
                            </div>
                            @enderror
                        </div>
                    
                     </div>
                     <div class="mt-3">
                        Show in the Home page <input type="checkbox" id="is_home" name="is_home" {{$checked}} >
                     </div>
                     <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-info text-white" type="submit">Submit</button>
                       
                      </div>
                       
                    </div>
                    <input type="hidden" name='id' value="{{$id}}">
                 </form>
                </div>
            </div>
                
            </div>
       
        </div>

    </div>
 
@endsection