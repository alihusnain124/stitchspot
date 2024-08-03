@extends('admin/layout');
@section('title','Tailor Orders')
@section('tailor_order_select','active')
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
             @if(isset($active_orders[0]))   
            <h1 class="mx-5">Tailor Active Orders</h1>
        
             
     
            <div class="row" >
                <div class="col-md-11">
                    <table class="table  table-borderless mt-4 mx-5 " style="border-radius: 10px;">
                        <thead class="table-dark">
                          <tr>
                              <td>ID</td>
                              <td>User Id</td>
                              <td>Service User Id</td>
                              <td>Service Id</td>
                              <td>Price</td>
                              <td>Status</td>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($active_orders as $item)
                          <tr>
                           <td>{{$item->id}}</td>
                           <td>{{$item->user_id}}</td>
                           <td >{{$item->service_user_id}}</td>
                           <td>{{$item->service_id}}</td>
                           <td>{{$item->price}}</td>
                           <td>{{$item->status}}</td>
                           </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        
       
           @endif

           
          @if(isset($completed_orders[0]))
     
            <h1 class="mx-5">Tailor Completed Orders</h1>
        

           
        <div class="row">
            <div class="col-md-11">
                <table class="table  table-borderless mt-4 mx-5 " style="border-radius: 10px;">
                    <thead class="table-dark">
                      <tr>
                              <td>ID</td>
                              <td>User Id</td>
                              <td>Service User Id</td>
                              <td>Service Id</td>
                              <td>Price</td>
                              <td>Status</td>
                              <td>Paid tailor</td>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($completed_orders as $item)
                          <tr>
                           <td>{{$item->id}}</td>
                           <td>{{$item->user_id}}</td>
                           <td >{{$item->service_user_id}}</td>
                           <td>{{$item->service_id}}</td>
                           <td>{{$item->price}}</td>
                           <td>{{$item->status}}</td>
                           @if($item->paid_tailor=='yes')
                           <td><button class="btn btn-success">Yes</button></td>
                           @else
                           <td><a href="{{url('stripe_pay_tailor/'.$item->id.'/'.$item->service_user_id.'/'.$item->price)}}"><button class="btn btn-danger">Not Yet</button></a></td>
                           @endif
                           </tr>
                          @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
            
        </div>  
      </div> 
     
   
@endif


        </div>

    </div>
 
@endsection