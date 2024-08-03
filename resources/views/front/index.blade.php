@extends('front.layout')

@section('title','Home')
    

 
@section('content')
    



<div class="crousal">
   <div class="img">
   <img src="{{asset('front-assets/images/slider-bg.jpg')}}" alt="">
  </div>
  <div class="inner_text">
      <h1>Unlock Your Style With <br><span class="sp">StitchSpot</span></h1>
      <p>"Elevate Your Style with Custom Tailoring"</p>
      @if(session()->has('FRONT_USER_LOGIN'))
      <a href="#product1"  class="btn bg-danger">Shop Now</a>
      @else
      <div class='login'>
      <a href="{{url('/login')}}" class="btn  bg-danger">Login</a><a href="{{url('/registration')}}" class="btn bg-danger">SignUp</a>
      </div>
    
      @endif
   </div>
</div>


   <div class="container">
      <h6 class='mt-3'>
      @if(session('cart_msg'))
    <div class="alert alert-success">
        {{ session('cart_msg') }}
    </div>
       @endif
      </h6>
      <div class="heading_container heading_center ">
         <h2 class="mt-5 text-center">
            Featured <span>Products</span>
         </h2>
      </div>

   </div>



   <section id="product1" class="container">
      <!-- <h1 class="mt-5">Our Products</h1> -->
      <div class="pro-container">

         @foreach ($product as $item)
             
    
         <div class="pro">
            <img src="{{asset('/storage/media/'.$item->image)}}">
            <div class="des">
               <h5><a style='color:black' href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
                @if($product_attr[$item->id][0]->qty==0)
               <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
               @elseif($item->is_discounted==1)
               <span class="aa-badge aa-sale" href="#">SALE!</span>
               @else
               <span class="aa-badge aa-hot" href="#">HOT!</span>
               @endif
               <div class="start">
               <span>{{ Str::substr($item->short_desc, 0, 150)}}...</span>
              </div>
               @if($product_attr[$item->id][0]->price==0)
               <span style='visibility:hidden'><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->mrp}}/-</h4>
              @else
              <span><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->price}}/-</h4>
              @endif
            </div>
           <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item->id}})'></i>
         </div>
     
     @endforeach

      </div>
   </section>


   <section id="pagination" class="section-p1 mt-5 ">
      <a href="{{url('/products')}}" class="bg-danger">View All Products <i class="fa fa-long-arrow-alt-right"></i></a>
   </section>

   <section id="product1" class="container mt-5 mb-5">
            <!-- <h1 class="mt-5">Our Products</h1> -->
            <div class="pro-container">
               
            @if (!empty($recommendedProducts))
            <div class="container">
    <div class="heading_container heading_center ">
  
       <h2 class="mt-5 text-center">
        Recommended <span>Products</span>
       </h2>
    </div>

 </div>
                @foreach($recommendedProducts as $item)
             
              
                <div class="pro" >
                   <img src="{{asset('/storage/media/'.$item['image'])}}">
                   <div class="des">
                      <h5><a  style='color:black'href="{{url('/product-details/'.$item['id'])}}">{{$item['name']}}</a></h5>
                      @if($item['qty']==0)
                        <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
                        @elseif($item['is_discounted']==1)
                        <span class="aa-badge aa-sale" href="#">SALE!</span>
                        @else
                        <span class="aa-badge aa-hot" href="#">HOT!</span>
                        @endif
                        <div class="star">
                           <span>{{ Str::substr($item['short_desc'], 0, 150)}}...</span>
                        </div>
                        @if($item['price']==0)
                        <span style='visibility:hidden'><del>Rs {{$item['mrp']}}/-</del></span>
                        <h4>Rs {{$item['mrp']}}/-</h4>
                     @else
                     <span><del>Rs {{$item['mrp']}}/-</del></span>
                        <h4>Rs {{$item['price']}}/-</h4>
                     @endif
                     
                   </div>
                  <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item["id"]}})'></i>
                </div>
            
            @endforeach
             
     
      @endif

            </div>
        </section>

   <section id="aa-banner ">
      <div class="container mt-5">
         <div class="row">
            <div class="col-md-12">

               <div class="aa-banner-area" id="banner">
                  <img src=" {{asset('front-assets/images/b2.jpg')}}" alt="fashion banner img">
               </div>

            </div>
         </div>
      </div>
   </section>


 


   <section id="product1" class="container ">
      <div class="row mb-3 mt-5  ">
         <div class="col d-flex justify-content-center ">
            <ul class="filter-group">
               <li data-filter=".tranding" >Trending</li>
               <li data-filter=".discounted">Discounted</li>
               <li data-filter=".latest">Latest</li>
            </ul>
         </div>
      </div>
      <div class="pro-container " id="product-list">

      @if(isset($tranding_product[0]))

        @foreach ($tranding_product as $item)
         
         <div class="pro tranding mx-2" >
            <img src="{{asset('/storage/media/'.$item->image)}}">
            <div class="des">
               <h5><a style='color:black' href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
               @if($product_attr[$item->id][0]->qty==0)
               <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
               @elseif($item->is_discounted==1)
               <span class="aa-badge aa-sale" href="#">SALE!</span>
               @else
               <span class="aa-badge aa-hot" href="#">HOT!</span>
               @endif
               <div class="start">
               <span>{{ Str::substr($item->short_desc, 0, 150)}}...</span>
              </div>
               @if($product_attr[$item->id][0]->price==0)
               <span style='visibility:hidden'><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->mrp}}/-</h4>
              @else
              <span><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->price}}/-</h4>
              @endif
            </div>
           <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item->id}})'></i>
         </div>
   @endforeach

   @else

   <!-- <div class="d-flex justify-content-center">No Tranding Product Yet.</div> -->
   @endif

         @foreach ($discounted_product as $item)
               
         <div class="pro discounted mx-2" >
            <img src="{{asset('/storage/media/'.$item->image)}}">
            <div class="des">
               <h5><a style='color:black' href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
               @if($product_attr[$item->id][0]->qty==0)
               <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
               @elseif($item->is_discounted==1)
               <span class="aa-badge aa-sale" href="#">SALE!</span>
               @else
               <span class="aa-badge aa-hot" href="#">HOT!</span>
               @endif
               <div class="start">
               <span>{{ Str::substr($item->short_desc, 0, 150)}}...</span>
              </div>
               @if($product_attr[$item->id][0]->price==0)
               <span style='visibility:hidden'><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->mrp}}/-</h4>
              @else
              <span><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->price}}/-</h4>
              @endif
            </div>
           <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item->id}})'></i>
         </div>
      @endforeach


       @if(isset($latest_product[0]))
         @foreach ($latest_product as $item)
                  
         <div class="pro latest mx-2" >
            <img src="{{asset('/storage/media/'.$item->image)}}">
            <div class="des">
               <h5><a style='color:black' href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
                @if($product_attr[$item->id][0]->qty==0)
               <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
               @elseif($item->is_discounted==1)
               <span class="aa-badge aa-sale" href="#">SALE!</span>
               @else
               <span class="aa-badge aa-hot" href="#">HOT!</span>
               @endif
               <div class="star">
               <span>{{ Str::substr($item->short_desc, 0, 150)}}...</span>
              </div>
               @if($product_attr[$item->id][0]->price==0)
               <span style='visibility:hidden'><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->mrp}}/-</h4>
              @else
              <span><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
               <h4>Rs {{$product_attr[$item->id][0]->price}}/-</h4>
              @endif
            </div>
            <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item->id}})' ></i>
         </div>
         @endforeach

      @else

      <!-- <div class="d-flex justify-content-center">No Letest Product Yet.</div> -->

        @endif
        
      </div>
   </section>

@endsection