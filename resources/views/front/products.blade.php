@extends('front.layout')

@section('title','Products')
    

 
@section('content')
    


    
   <div class="container">
    <div class="heading_container heading_center ">
  
       <h2 class="mt-5 text-center">
        Our All <span>Products</span>
       </h2>
    </div>

 </div>


        <section id="product1" class="container mt-5 mb-5">
            <!-- <h1 class="mt-5">Our Products</h1> -->
            <div class="pro-container">
               
                
                @foreach ($product as $item)
             
    
                <div class="pro" >
                   <img src="{{asset('/storage/media/'.$item->image)}}">
                   <div class="des">
                      <h5><a  style='color:black'href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
                       @if($product_attr[$item->id][0]->qty==0)
                        <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
                        @elseif($item->is_discounted==1)
                        <span class="aa-badge aa-sale" href="#">SALE!</span>
                        @else
                        <span class="aa-badge aa-hot" href="#">HOT!</span>
                        @endif
                        <div class="star">
                           <span>{{$item->short_desc}}</span>
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
    </section>

 


@endsection


 