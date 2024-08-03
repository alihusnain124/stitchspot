@extends('admin/layout');
@section('title','Add Brand')
@section('brand_select','active')
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
                
            <h1 class="mx-5">Add Brand</h1>
            <a href="{{route('brand.manage_process')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Back</button></a>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <form action="{{route('brand.manage_process')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="form-container">
                    <div class="row">
                           
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label for="exampleFormControlInput1" class="form-label">Brand Name</label>
                                    <input type="text" id="brand_name" name="brand_name" value='{{$brand_name}}' class="form-control" id="exampleFormControlInput1" >
                                </div>
                                @error('brand_name')
                                <div class="alert alert-danger mt-2" role='alert'>
                                    {{'Requried'}}
                                </div>
                                @enderror
                            </div>
                     </div>

                     <div class="row">
                        <div class="col-md-12">
                            <label for="exampleFormControlInput1" class="form-label">Brand Image</label>
                            <input type="file"  id="brand_image" name="brand_image" value='{{$brand_image}}'  class="form-control" id="exampleFormControlInput1" >
                            @if ($brand_image!='')
                            <img class='m-2' width="100px" src="{{asset('/storage/media/brand/'.$brand_image)}}" alt="">    
                              @endif 
                        </div>
                        @error('brand_image')
                        <div class="alert alert-danger mt-2" role='alert'>
                        {{'Requried,should be jpg,png or jpeg'}}
                        </div>
                        @enderror
                        
                     </div>
                     <div class="mt-3">
                        Show in the Home page <input type="checkbox" id="is_home" name="is_home"  {{$checked}}>
                     </div>
                     <div class="d-grid gap-2 mt-3 ">
                        <button class="btn btn-info text-white" type="submit">Submit</button>
                       
                      </div>
                      <input type="hidden" name='id' value="{{$id}}">
                    </div>
                    </form>
                </div>
            </div>
                
            </div>
       
        </div>

    </div>
 
@endsection