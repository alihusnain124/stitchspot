@extends('front.layout')

@section('title','Profile')
    

 
@section('content')
    
@if(session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
       @endif


     <?php
     $count=0;
     foreach($confirm_order as $item){
      if($item->status!='completed'){
     $count++;
   
      }
     }

     $total=0;
     foreach($reviews as $item){
      $total++;
     }
     ?>

 
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
                 @if($count>0)
                 <p class="text-muted text-center">Order in Queue: {{$count}}</p>
                 @endif
                
                 @endif
                 <ul class="list-group">
                     <li class="list-group-item">Location: {{$user[0]->address}}</li>
                     <li class="list-group-item">Joined: {{$formattedDate}}</li>
                     @if($user[0]->tailor=='yes')
                     <li class="list-group-item">Total Reviews:{{$total}}</li>
                     <li class="list-group-item">
                      @if(isset($rating_points))
                     <span>{{ $rating_points }}/5</span>

                           @for ($i = 0; $i < $fullStars; $i++)
                              <i class="fas fa-star"></i>   
                           @endfor

                           @if ($halfStars)
                              <i class="fas fa-star-half-alt"></i>
                           @endif
                     @endif
                   </li>
                  @if($total_count>50 && $rating_points>4)
                   <li class="list-group-item">Top rated Service Provider</li>
                   @endif
                  @endif
                 </ul>
               </div>
               <div class="mt-3 profile-container">
                  
                     <h2>About Me</h2>
                     <p>{{$user[0]->about}}</p>
                 
               </div>

               @if($user[0]->tailor=='yes')
              @if(isset($account_no))
               <div class=" mt-3 profile-container">
               <h2>Your Stripe Account No<span></span></h2>
                 <p>{{$account_no[0]->account_no}}</p>
               </div>
               @else
               <div class=" mt-3 profile-container">
               <h2>Enter Stripe Account No<span>*</span></h2>
               <input type="text" class="form-control" placeholder="Enter Account No" name='account_no' id='account_no' >             
               </div>
               @endif

               <div class=" mt-3 profile-container">
                 
                     <h2>Skills</h2>
                     <p>{{$user[0]->skills}}</p>
                
               </div>
               @endif
               <div class=" mt-3 profile-container">
                 
                  <h2>Languages</h2>
                  <p>{{$user[0]->language}}</p>
             
            </div>
             </div>
          @if($user[0]->tailor=='yes')
             <div class="col-md-8 " id="product1">
               <div class="profile-container">
               <div class="col d-flex justify-content-center ">
                     <ul class="filter-group mt-3">
                        <li data-filter=".services" >Services</li>
                        <li data-filter=".rev">Reviews</li>
                      @if(session()->get('IS_TAILOR')=='yes')
                 
                        <li><a href="{{url('/form')}}">Add Services</a></li>
                        <li><a href="{{url('/edit_profile/'.$user[0]->id)}}">Edit Profile</a></li>
                      @endif
                     </ul>
                  </div>
                  </div>
              
           
               <div id="product-list" class='deactive'>
            <div class="mt-3 services">
              
               <div class="row" >
                  
               @foreach ($services[$user[0]->id] as $item)

          <div class="col-md-4 my-2" >
          <div class="">
             <div class="pro" style='width:320px'>
                <img  src="{{asset('/storage/media/services/'.$item->image)}}"  class=''>
                <div class="des">
                   <h5 class='mt-4'><a style='color:black' href="{{url('/service-details/'.$item->id)}}">{{ Str::substr($item->title, 0, 50) }}...</a></h5>
                   
                   <span>Started at:Rs {{$item->min_price}}/-</span>
                  
                </div> 
             </div>
         </div>  
       </div>
           @endforeach 
            
 

    
               </div>  
             </div>

             <section class="rev">
       
       @if(isset($reviews[0]))
    <?php
    $count=0;
    ?>
     <h1 class='text-center'>Reviews</h1>
       @foreach($reviews as $item)
       <?php
       $count++;
       ?>
  
       <div class="review">
         <div class="reviews">
           <h4>{{$count}}.{{$user[$item->id][0]->name}}</h4>
            <p>"{{$item->review_desc}}"</p>
            <div class="start">
                   @for($i=0;$i<$item->review_star;$i++)
                    <i class="fas fa-star"></i>
                   @endfor
             </div>
         </div>
         <div class="data">
           <p>Posted on {{$item->added_on}}</p>
         </div>
      </div>

      @endforeach
       
      @else
  
      <div class="rev">
        <p>No Reviews yet</p>
       </div>
      @endif
  </section>
            </div>
   </div>
         @else
         <div class="col-md-8 " id="product1">
               <div class="profile-container">
                 
         <div class="col d-flex justify-content-center ">
            <ul class="filter-group mt-3">
               <li data-filter=".order" >Orders</li>
               <li data-filter=".tailor_order">Tailor Orders</li>
               <li data-filter=".order_pay">Orders To Pay</li>
               <li><a href="{{url('/edit_profile/'.$user[0]->id)}}">Edit Profile</a></li>
            </ul>
         </div>
   </div>
                  
                 

               <div id="product-list" class='deactive'>
               @if(isset($orders[0]))

               <div class="container mt-5 order">
                     <section id="cart" class="section-p1 border">
                        <h1 class="text-center m-5"><span>Your</span> Orders</h1>
                        <table width="100%">
                        <thead>
                           <tr>
                              <td>ID</td>
                              <td>Order Status</td>
                              <td>Payment Status</td>
                              <td>Address</td>
                              <td>Track Details</td>
                              <td>Placed At</td>
                           </tr>
                        </thead>
                        <tbody>
                         
                           @foreach($orders as $item)
                           
                          
                           <tr>
                           <td class='order_a_tag'><a href="{{url('order_details/'.$item->id)}}">{{$item->id}}</a></td>
                           <td >{{$item->order_status}}</td>
                           <td>{{$item->payment_status}}</td>
                           <td>{{$item->address}}</td>
                           <td>{{$item->track_details}}</td>
                           <td>{{$item->added_on}}</td>
                           </tr>
                           @endforeach

                        </tbody>
                        </table>
                     </section>
                  </div>

                  @if(isset($confirm_order[0]))
                  <div class="container mt-5 tailor_order" >
                     <section id="cart" class="section-p1 border">
                        <h1 class="text-center m-5"><span>Your</span> Tailor's Orders</h1>
                        <table width="100%">
                        <thead>
                           <tr>
                              <td>ID</td>
                              <td>Product Id</td>
                              <td>Service User Id</td>
                              <td>Service Id</td>
                              <td>Price</td>
                              <td>Status</td>
                           </tr>
                        </thead>
                        <tbody>
                         
                           @foreach($confirm_order as $item)
                           
                          
                           <tr>
                              @if($item->status=='processing')
                           <td>{{$item->id}}</td>
                           @else
                           <td class='order_a_tag'><a href="{{url('user_review/'.$item->id)}}">{{$item->id}}</a></td>
                           @endif
                           <td >{{$item->order_product_id}}</td>
                           <td>{{$item->service_user_id}}</td>
                           <td>{{$item->service_id}}</td>
                           <td>{{$item->price}}</td>
                           <td>{{$item->status}}</td>
                           </tr>
                           @endforeach

                        </tbody>
                        </table>
                     </section>
                  </div>



                  
                  @if(isset($confirm_order_to_pay[0]))
                  <div class="container mt-5 order_pay" >
                     <section id="cart" class="section-p1 border ">
                        <h1 class="text-center m-5"><span>Orders</span> To Pay</h1>
                        <table width="100%">
                        <thead>
                           <tr>
                              <td>ID</td>
                              <td>Product Id</td>
                              <td>Price</td>
                              <td>Status</td>
                           </tr>
                        </thead>
                        <tbody>
                         
                           @foreach($confirm_order_to_pay as $item)
                           
                          
                           <tr>
                           <td>{{$item->id}}</td>
                           <td >{{$item->order_product_id}}</td>
                           <td>{{$item->price}}</td>
                           <td> <a href="{{'/stripe_pay/'.$item->id.'/'.$item->price.''}}"><button class='btn btn-danger'>Pay</button></a></td>
                           </tr>
                           @endforeach

                        </tbody>
                        </table>
                     </section>
                  </div>
              
             </div>
              
            </div>
   
            
            @else
             <div class="container mt-5">

             <h1 class="text-center m-5"><span>0</span> Order to pay</h1>

            </div>
          @endif

              
             </div>



              
            </div>
            
            
            @else
             <div class="container mt-5">

             <h1 class="text-center m-5"><span>0</span> Tailor's Orders</h1>

            </div>
          @endif


           

             
          



             @else
             <div class="container mt-5">

             <h1 class="text-center m-5"><span>0</span> Orders</h1>

            </div>
          @endif



          

         

         @endif
         
       </div>
   </div>
      


       



       
   </main>
   </div>
   @endsection

 <form action="{{url('/account_no')}}" id='account_form'>
   <input type="hidden" name='account_no' id='account'>
   <input type="hidden" name='user_id' value='{{$user[0]->id}}'>
 </form>
       