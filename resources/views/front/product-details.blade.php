@extends('front.layout')

@section('title','Product Details')
    

 
@section('content')
    


    <div class="container mt-5">
        <section id="prodetails" class="section-p1">
            <div class="single-pro-image ">


              @if(isset($again_product[0]))

                <img src="{{asset('storage/media/'.$again_product_attr[$again_product[0]->id][0]->attr_image)}}" width="100%" height='530px'  alt="text" id="main-img">
               
               @else
               <img src="{{asset('storage/media/'.$product[0]->image)}}" width="100%"  alt="text" id="main-img">
               @endif
               
                  
                <div class="small-img-group">
                @foreach ($product_attr[$product[0]->id] as $item)
                    <div class="small-img-col">
                        <img src="{{asset('storage/media/'.$item->attr_image)}}" width="100%" class="small-img" alt="text" style='height: 100px'>
                    </div> 
                    @endforeach
                </div>

            </div>
            <div class="single-pro-details">
            @if(isset($again_product[0]))

                <h4>{{ $again_product[0]->name }}</h4>

                @if(isset($again_product_attr[$again_product[0]->id][0]))
                    @if($again_product_attr[$again_product[0]->id][0]->price == 0)
                        <h2 id='mrp-1'>RS {{ $again_product_attr[$again_product[0]->id][0]->mrp }}/-</h2>
                    @else
                        <span id='mrp-2'><del>RS {{ $again_product_attr[$again_product[0]->id][0]->mrp }}</del></span>
                        <h2 id='price'>RS {{ $again_product_attr[$again_product[0]->id][0]->price }}/-</h2>
                    @endif
                @endif

                @else

                <h4>{{ $product[0]->name }}</h4>
                @if(isset($product_attr[$product[0]->id][0]))
                    @if($product_attr[$product[0]->id][0]->price == 0)
                        <h2 id='mrp-1'>RS {{ $product_attr[$product[0]->id][0]->mrp }}/-</h2>
                    @else
                        <span id='mrp-2'><del>RS {{ $product_attr[$product[0]->id][0]->mrp }}</del></span>
                        <h2 id='price'>RS {{ $product_attr[$product[0]->id][0]->price }}/-</h2>
                    @endif
                @endif

                @endif






                <?php
                      $arrcolor=[];
                      foreach($product_attr[$product[0]->id] as $color){
                       $arrcolor[$color->color_id]=$color->color;
                      }
                      $arrcolor=array_unique($arrcolor);


                    

                     
                      $arrsize=[];
                      foreach($product_attr[$product[0]->id] as $size){
                       $arrsize[$size->size_id]=$size->size;
                      }
                      $arrsize=array_unique($arrsize);


                    
                      ?>
                      
                  
                <select name="" id="color" >
                    <option>Select Color</option>

                    @if(isset($again_product[0]))

                   
                    @if($again_product_attr[$again_product[0]->id][0]->color)
                    <option value='{{$again_product_attr[$again_product[0]->id][0]->color}}' selected>{{$again_product_attr[$again_product[0]->id][0]->color}}</option>
                    @else
                    <option value='{{$item}}'>{{$item}}</option>
                    @endif
                  

                    @else

                    @foreach($arrcolor as $item)
                    @if($item==$product_attr[$product[0]->id][0]->color)
                    <option value='{{$item}}' selected>{{$item}}</option>
                    @else
                    <option value='{{$item}}'>{{$item}}</option>
                    @endif
                    @endforeach
                    
                    @endif
                </select>
                <select name="" id="size" >
                <option>Select Size</option>
                   @if(isset($again_product[0]))

                   
                    @if($again_product_attr[$again_product[0]->id][0]->size)
                    <option value='{{$again_product_attr[$again_product[0]->id][0]->size}}' selected>{{$again_product_attr[$again_product[0]->id][0]->size}}</option>
                    @else
                    <option value='{{$item}}'>{{$item}}</option>
                    @endif
                  

                    @else

                    @foreach($arrsize as $item)
                    @if($item==$product_attr[$product[0]->id][0]->size)
                    <option value='{{$item}}' selected>{{$item}}</option>
                    @else
                    <option value='{{$item}}'>{{$item}}</option>
                    @endif
                    @endforeach
                    
                    @endif
                 
                </select>
                <input type="number" value="1" id='quantityInput'>               
                <h4>Avaliable Pair</h4>
                @foreach ($product_attr[$product[0]->id] as $item)
                <h7>{ {{$item->color}} - {{$item->size}} } </h7>
                @endforeach
                <h4>About</h4>
                <br><span class="text-dark">{{$product[0]->short_desc}}</span>
                <div class="d-grid gap-1 mt-5">
              <button onclick="add_to_cart({{$product[0]->id}},document.getElementById('size').value,document.getElementById('color').value,document.getElementById('quantityInput').value,'{{csrf_token()}}')" class="btn btn-danger">Add To Cart</button>
             </div>
            </div>
            
        </section>
        
        
    </div>
    <section class="container">
    <section class="reviews">
        <h4>Description</h4>
        <div class="desc">
           <ul>
           {{$product[0]->desc}}
           </ul>  
        </div>
    </section>
    <section class="reviews">
    @if(isset($rating_points))
        <h4>Rating</h4>
       
        <div class="stars">
        <span>{{ $rating_points }}/5</span>

            @for ($i = 0; $i < $fullStars; $i++)
                <i class="fas fa-star"></i>   
            @endfor

            @if ($halfStars)
                <i class="fas fa-star-half-alt"></i>
            @endif
        
        </div>
    @endif
        <h4 class='mt-2'>Reviews</h4>

     @if(isset($rating[0]))
  <?php
  $count=0;
  ?>
     @foreach($rating as $item)
     <?php
     $count++;
     ?>
     <div class="review">
       <div class="reviews">
         <h4>{{$count}}. {{$user[$rating[0]->id][0]->name}}</h4>
          <p>"{{$item->rating_desc}}"</p>
          <div class="start">
                 @for($i=0;$i<$item->rating_stars;$i++)
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
        


    @if(isset($order[0]))
                   <?php
                     $alreadyChecked = false;
                    ?>
    @foreach($order as $item)
                 
    @foreach($order_details[$item->id] as $check)

              
    @if( !$alreadyChecked && $check->product_id==$product[0]->id)

                <?php

                    $alreadyChecked = true;

                  
                  ?>
    
   <form action="" id='rating_form'>
    @csrf
       <div style="display: flex; justify-content: space-between;">
        <div class="comments">
            <p>Post Your Reviews Here about the Product & your Experience</p>
            <input type="text" name='rating_desc' class="post-rev" placeholder="Post Your Review">
           <button type="submit" class="btn btn-danger">Submit</button>
        </div>
        <div id="full-stars-example-two" style="padding-right: 100px;">
            <div class="rating-group">
                <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
                <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
            </div>
          <p class="descr" style="font-family: sans-serif; font-size:0.9rem"><br/>
            Rate from 1 to 5</p>
        </div>
    </div>
    <input type="hidden" name='prod_id' id='id' value='{{$product[0]->id}}'>
</form>


    

@endif
@endforeach
@endforeach

@endif
       
     </section>

     </section>

    <section id="product1" class="container">
        <h1 class="mt-5">Related <span>Products</span></h1>
        <div class="pro-container">



       @foreach($related_product as $item)
             <div class="pro" >
                   <img src="{{asset('/storage/media/'.$item->image)}}">
                   <div class="des">
                      <h5><a  style='color:black'href="{{url('/product-details/'.$item->id)}}">{{$item->name}}</a></h5>
                       @if($related_product_attr[$item->id][0]->qty==0)
                        <span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span>
                        @elseif($item->is_discounted==1)
                        <span class="aa-badge aa-sale" href="#">SALE!</span>
                        @else
                        <span class="aa-badge aa-hot" href="#">HOT!</span>
                        @endif
                        <div class="star">
                           <span>{{$item->short_desc}}</span>
                        </div>
                        @if($related_product_attr[$item->id][0]->price==0)
                        <span style='visibility:hidden'><del>Rs {{$related_product_attr[$item->id][0]->mrp}}/-</del></span>
                        <h4>Rs {{$related_product_attr[$item->id][0]->mrp}}/-</h4>
                     @else
                     <span><del>Rs {{$related_product_attr[$item->id][0]->mrp}}/-</del></span>
                        <h4>Rs {{$related_product_attr[$item->id][0]->price}}/-</h4>
                     @endif
                     
                   </div>
                  <i class="fas fa-shopping-cart cart" onclick='addToCart({{$item->id}})'></i>
                </div>
      @endforeach
    
        </div>
    </section>

@endsection

<form action="{{'/change_product/'.$product[0]->id}}" id='change_form' method='POST'>
@csrf
<input type="hidden" id='color_val' name='color_val'>
<input type="hidden" id='size_val' name='size_val'> 
<input type="hidden" id="prod_id" name='prod_id' value='{{$product[0]->id}}'>

</form>

  