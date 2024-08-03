@extends('admin/layout');
@section('title','Add Size')
@section('size_select','active')
@section('add')

        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
    
            <h1 class="mx-5">Add Size</h1>
            <a href="{{url('/admin/size')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Back</button></a>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <form action="{{route('size.manage_process')}}" method="post" >
                        @csrf
                    <div class="form-container">
                     <div class="row">
                        <div class="col-md-12">
                            <label for="exampleFormControlInput1" class="form-label">Size</label>
                            <input type="text" id="size" name="size" value='{{$size}}' class="form-control" id="exampleFormControlInput1" >
                        </div>
                        @error('title')
                        <div class="alert alert-danger mt-2" role='alert'>
                            {{'Requried'}}
                        </div>
                        @enderror
                     </div>
                     
                     <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-info text-whites" type="submit">Submit</button>
                       
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