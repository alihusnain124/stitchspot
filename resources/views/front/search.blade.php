@extends('front.layout')

@section('title','Search')
    

 
@section('content')
    


    
   <div class="container " style="height:11vh">
    <div class="heading_container heading_center ">
       <h2 class="mt-5 text-center">
        Search <span>Results</span>
       </h2>
    </div>

 </div>

    

        <section id="product1" class="container mt-5 mb-5">
            <!-- <h1 class="mt-5">Our Products</h1> -->
            <div class="pro-container">
               @if(isset($product[0]))
                
                @foreach ($product as $item)
             
    
                <div class="pro" onclick="window.location.href = 'front.product-details.html';">
                   <img src="{{asset('/storage/media/'.$item->image)}}">
                   <div class="des">
                      <h5>{{$item->name}}</h5>
                      <span>{{$item->short_desc}}</span>
                      <div class="start">
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                         <i class="fas fa-star"></i>
                      </div>
                      <span><del>Rs {{$product_attr[$item->id][0]->mrp}}/-</del></span>
                      <h4>Rs {{$product_attr[$item->id][0]->price}}/-</h4>
                     
                   </div>
                   <a href="#"><i class="fas fa-shopping-cart cart"></i></a>
                </div>
            
            @endforeach
            
            @else
           <h2 style='width:100%;height:130px; margin:auto;'>No Results found....</h2> 
            @endif

            </div>
          
        </section>
   
 


@endsection


 