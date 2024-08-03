@extends('admin/layout');
@section('title','Orders')
@section('order_select','active')
@section('add')
       

        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
              @if (session('message'))
              <div class="alert alert-success mx-5" role='alert'>
              {{session('message')}}
              </div>
             @endif
          

    <form action="" id='update_status'>
        @csrf
            <div class="col-md-4 ms-5">

            <label for="Category" class="control-label mb-1">Order Status</label>

            <select id="" name="order_status"  class="form-control" >

            <option value="">Select Status</option>
                 @foreach($order_status as $val)
                 @if($order[0]->order_status == $val)
                 <option value="{{$val}}" selected>{{$val}}</option>
                 @else
                 <option value="{{$val}}">{{$val}}</option>
                 @endif
               
                 @endforeach
            </select>

             </div>
             
            <div class="col-md-4 ms-5">

            <label for="Category" class="control-label mb-1">Payment Status</label>

            <select id="" name="payment_status"  class="form-control" >

          
            <option value="">Select Status</option>
                 @foreach($payment_status as $val)

                 @if($order[0]->payment_status == $val)
                 <option value="{{$val}}" selected>{{$val}}</option>
                 @else
                 <option value="{{$val}}">{{$val}}</option>
                 @endif
            
                 @endforeach

            </select>

             </div>

             <div class="col-md-4 ms-5 form-group">
                <label for="Category" class="control-label mb-1">Track Details</label>
                <textarea id="" name="track_details"  type="text" class="form-control" aria-required="true" aria-invalid="false">{{$order[0]->track_details}}</textarea>
             </div>

             <button class="btn btn-lg btn-info text-white ms-5 mt-3 mb-5">Update</button>

             <input type="hidden" value='{{$order[0]->id}}' name='id' id='id'>
         
      </form>


            
      <h1 class="mx-5">Order Details</h1>

            <div class="row">
                <div class="col-md-11">
                    <table class="table  table-borderless mt-4 mx-5 " style="border-radius: 10px;">
                        <thead class="table-dark">
                          <tr>
                            <td>ID</td>
                            <td>Product Id</td>
                            <td>Product Name</td>
                            <td>Product Price</td>
                            <td>Product Qty</td>
                            <td>Total Price</td>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($order_details as $item)
                          <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->product_id}}</td>
                            <td>{{$item->product_name}}</td>
                            <td>{{$item->product_price}}</td>
                            <td>{{$item->product_qty}}</td>
                            <td>{{$item->product_qty*$item->product_price}}</td>
                        </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
                
            </div>
       
        </div>

    </div>
 
@endsection