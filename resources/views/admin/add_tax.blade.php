@extends('admin/layout');
@section('title','Add Tax')
@section('tax_select','active')
@section('add')

        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
    
            <h1 class="mx-5">Add Tax</h1>
            <a href="{{url('/admin/tax')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Back</button></a>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <form action="{{route('tax.manage_process')}}" method="post" >
                        @csrf
                    <div class="form-container">
                     <div class="row">
                        <div class="col-md-6">
                            <label for="Category" class="control-label mb-1">Tax Desc</label>
                           <input id="tax_desc" name="tax_desc" value='{{$tax_desc}}' type="text" class="form-control" aria-required="true" aria-invalid="false" >
                        </div>
                        <div class="col-md-6">
                            <label for="Category" class="control-label mb-1">Tax value</label>
                            <input id="tax_value" name="tax_value" value='{{$tax_value}}' type="text" class="form-control" aria-required="true" aria-invalid="false" >
                            @error('tax_value')
                            <div class="alert alert-danger mt-2" role='alert'>
                                {{'Requried,and should be unique'}}
                            </div>
                            @enderror
                        </div>
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