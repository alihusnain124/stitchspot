@extends('front.layout')

@section('title','Dashboard')
    

 
@section('content')
    

    <div class="container-fluid">
      <main class="container-fluid mt-5">
         <div class="row">
             <div class="col-md-4 ">
               <div class="profile-container">
                 <img src="{{asset('/storage/media/customer/'.$user[0]->image)}}" alt="Your Profile Picture"
                     class="img-thumbnail rounded-circle mx-auto d-block mb-3">
                 <h3 class="text-center">{{$user[0]->name}}</h3>
                 @if($user[0]->tailor=='yes')
                 <p class="text-muted text-center">{{$user[0]->bio}}</p>
                 
                 @endif
                 <ul class="list-group">
                     <li class="list-group-item">Location: {{$user[0]->address}}</li>
                     <li class="list-group-item">Joined:  {{$formattedDate}}</li>
                     <li class="list-group-item">Total completed orders:  {{$total_completed_orders}}</li>
                     <li class="list-group-item">Total Earning:  Rs<span>{{$total_earning}} </span>/-</li>
                     <li class="list-group-item">Total Price Recieved:  Rs<span>{{$price_recieved}} </span>/-</li>
                 </ul>
               </div>
            
             </div>

            <div class="col-md-8 container" id="product1">
            <div class="profile-container">
           
         <div class="col d-flex justify-content-center ">
            <ul class="filter-group mt-3">
               <li data-filter=".order_req" >Orders Request</li>
               <li data-filter=".active_order">Active Orders</li>
               
            </ul>
         </div>
      
                  
         </div>

   <div id="product-list" class='deactive'>
          <div class="row order_req" >
         
          @if(isset($order_detail[0]))
          @foreach($order_detail as $item )

            <div class="col-md-3">
              <div class="card mt-3" style="width: 18rem;">
                <div class="card-body">
                  <h5 class="card-title">Order Details</h5>
                   <p>Username:{{$order_user_detail[0]->name}}</p>
                   <p>Price:{{$item->price}}</p>
                   <p>Delivery Time:{{$item->delivery_time}}</p>
                   <p>Placed at:{{$item->added_on}}</p>
                  <a href="#" onclick='action("{{$item->id}}","yes")' class="btn btn-danger">Confirm</a>
                  <a href="#" onclick='action("{{$item->id}}","no")' class="btn btn-secondary">Cancel</a>
                </div>
              </div>
           </div>

           @endforeach
           @else
           <h1 class="text-center m-5"><span>0</span> Orders Request</h1>
           @endif
          </div>
              
          <div class="row mt-2  active_order  " >

          
          <div class="col-md-12 ">
           
          <div class="row  ">
                 <div class="col-md-12">
                  
               @if(isset($active_orders[0]))
                <section id="cart" class="section-p1 border mt-2 ">
                       
                        <table width="100%" > 
                        <thead >
                           <tr>
                              <td>ID</td>
                              <td>Order Product Id</td>
                              <td>Price</td>
                              <td>Delivery Time</td>
                              <td>Status</td>
                              <td>Action</td>
                              <td>Added On</td>
                           </tr>
                        </thead>
                        <tbody>
                       
                        @foreach($active_orders as $item)

                        <tr>
                          <td>{{$item->id}}</td>                         
                          <td>{{$item->order_product_id}}</td>                      
                          <td>{{$item->price}}</td>
                          <td>{{$item->delivery_time}} days</td>
                          <td>{{$item->status}}</td>
                          @if($item->status=='processing')
                          <td><button class='btn btn-danger mb-1' onclick='complete("{{$item->id}}","yes")'>Pending..</button></td>
                          @else
                          <td><button class='btn btn-success mb-1'>Delivered</button></td>
                          @endif
                          <td>{{$item->added_on}}</td>
                          
                        </tr>

                        @endforeach
                         

                        </tbody>
                        </table>
                     </section>
                     @else
                    <h1 class="text-center m-5"><span>0</span> Active Orders</h1>
                    @endif

          </div>
          </div>


            

     </div>



         </div>
     
      
             


         </div>
</div>
             
          
       </div>

   </main>
   </div>
   @endsection

 
       