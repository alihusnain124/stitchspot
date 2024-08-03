@extends('admin/layout');
@section('title','Add Coupon')
@section('couponselect','active')
@section('add')

       
        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
                
            <h1 class="mx-5">Add Coupon</h1>
            <a href="{{url('/admin/coupon')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Back</button></a>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <form action="{{route('coupon.manage_process')}}" method="post" >
                        @csrf
                    <div class="form-container">
                    <div class="row">
                           <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Coupon Tiltle</label>
                                    <input type="text" id="title" name="title" value='{{$title}}' class="form-control" id="exampleFormControlInput1" >
                                  </div>
                                  @error('title')
                                  <div class="alert alert-danger mt-2" role='alert'>
                                      {{'Requried'}}
                                  </div>
                                  @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Coupon Code</label>
                                    <input type="text" id="code" name="code"  value='{{$code}}' class="form-control" id="exampleFormControlInput1" >
                                  </div>
                                  @error('code')
                                  <div class="alert alert-danger mt-2" role='alert'>
                                      {{'Code should be unique'}}
                                  </div>
                                  @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Coupon Value</label>
                                    <input type="text" id="value" name="value"  value='{{$value}}' class="form-control" id="exampleFormControlInput1" >
                                  </div>
                                  @error('value')
                                  <div class="alert alert-danger mt-2" role='alert'>
                                      {{'Requried'}}
                                  </div>
                                  @enderror
                            </div>
                           
                     </div>

                     <div class="row">
                            <div class="col-md-3">
                                <label for="Category" class="control-label mb-1">Type</label>
                                <select id="type" name="type"  class="form-control" >
                                    @if ($type=='Value')
                                    <option value="Value" selected>Value</option>
                                    <option value="Per">Per</option>
                                    @elseif($type=='Per')
                                    <option value="Value" >Value</option>
                                    <option value="Per" selected>Per</option>
                                    @else
                                    <option value="Value" >Value</option>
                                    <option value="Per" >Per</option>
                                    @endif
                                 </select>
                            </div>


                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Min Order Amount</label>
                                    <input type="text" id="min_order_amt" name="min_order_amt"  value='{{$min_order_amt}}' class="form-control" id="exampleFormControlInput1" >
                                  </div>
                            </div>



                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Is One Time</label>
                                    <select id="is_one_time" name="is_one_time"  class="form-control" >
                                        @if ($is_one_time=='1')
                                        <option value="1" selected>yes</option>
                                        <option value="0">No</option>
                                        @else
                                        <option value="1">yes</option>
                                        <option value="0" selected>No</option>
                                        @endif
                                     </select>
                                  </div>
                            </div>
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