@extends('admin/layout');
@section('title','Add Color')
@section('color_select','active')
@section('add')

        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
                
            <h1 class="mx-5">Add Color</h1>
            <a href="{{url('/admin/color')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Back</button></a>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <form action="{{route('color.manage_process')}}" method="post" >
                        @csrf
                    <div class="form-container">
                
                     <div class="row">
                        <div class="col-md-12">
                            <label for="exampleFormControlInput1" class="form-label">Color</label>
                            <input type="text" id="color" name="color" value='{{$color}}' class="form-control" id="exampleFormControlInput1" >
                        </div>
                        @error('color')
                        <div class="alert alert-danger mt-2" role='alert'>
                            {{'Requried'}}
                        </div>
                        @enderror
                     </div>
                     
                     <div class="d-grid gap-2 mt-3">
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