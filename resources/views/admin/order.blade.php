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
                
            <h1 class="mx-5">Orders</h1>
         
      
            <div class="row">
                <div class="col-md-11">
                    <table class="table  table-borderless mt-4 mx-5 " style="border-radius: 10px;">
                        <thead class="table-dark">
                          <tr>
                              <td>ID</td>
                              <td>User Id</td>
                              <td>Order Status</td>
                              <td>Payment Status</td>
                              <td>Address</td>
                              <td>Placed At</td>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($orders as $item)
                          <tr>
                           <td class='order_a_tag'><a href="{{url('admin/order_details/'.$item->id)}}">{{$item->id}}</a></td>
                           <td>{{$item->user_id}}</td>
                           <td >Placed</td>
                           <td>{{$item->payment_status}}</td>
                           <td>{{$item->address}}</td>
                           <td>{{$item->added_on}}</td>
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