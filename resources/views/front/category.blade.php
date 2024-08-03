@extends('front.layout')

@section('title','Category')
    

 
@section('content')
    


    
   <div class="container">
    <div class="heading_container heading_center " style='height:11vh'>
    <!-- <h6 class='mt-3'>
      @if(session('cart_msg'))
    <div class="alert alert-success">
        {{ session('cart_msg') }}
    </div>
       @endif
      </h6> -->
       <h2 class="mt-5 text-center">
        Products Related To "<span>{{$category[0]->category_name}}</span>"
       </h2>
    </div>

 </div>


        <section id="product1" class="container mt-5 mb-5">
            <!-- <h1 class="mt-5">Our Products</h1> -->
            <div class="pro-container">
                
            @if(isset($category_product) && count($category_product)>0)
               
         
                
                @foreach ($category_product as $item)
             
    
                <div class="pro" >
                   <img src="{{asset('/storage/media/'.$item->image)}}">
                   <div class="des">
                      <h5><a  style='color:black'href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
                       @if($category_product_attr[$item->id][0]->qty==0)
                        <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
                        @elseif($item->is_discounted==1)
                        <span class="aa-badge aa-sale" href="#">SALE!</span>
                        @else
                        <span class="aa-badge aa-hot" href="#">HOT!</span>
                        @endif
                        <div class="star">
                           <span>{{$item->short_desc}}</span>
                        </div>
                        @if($category_product_attr[$item->id][0]->price==0)
                        <span style='visibility:hidden'><del>Rs {{$category_product_attr[$item->id][0]->mrp}}/-</del></span>
                        <h4>Rs {{$category_product_attr[$item->id][0]->mrp}}/-</h4>
                     @else
                     <span><del>Rs {{$category_product_attr[$item->id][0]->mrp}}/-</del></span>
                        <h4>Rs {{$category_product_attr[$item->id][0]->price}}/-</h4>
                     @endif
                     
                   </div>
                  <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item->id}})'></i>
                </div>
            
            @endforeach
             
             @else
             <h2 style='width:100%;height:100%; margin:auto;'>No Products Found....</h2> 
           
             @endif
            </div>
        </section>
    </section>

 


@endsection


 