
@extends('front.layout')

@section('title','User Review')
    

 
@section('content')
    
  <div class="container " style='margin-top:140px'> 
  <h1 class="text-center"><span>Reviews</span></h1>
    <section id="cart" class="section-p1 border" >
   
    <form action="" id='review_form' >
    @csrf
       <div style="display: flex; justify-content: space-between;">
        <div class="comments">
            <p>Post Your Reviews about Tailor Service</p>
            <textarea name="rating_desc" id="" cols="50" rows="05"  placeholder="Post Your Review"></textarea>
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
<input type="hidden" id='user_id' name="user_id" value="{{$order_detail[0]->service_user_id}}">
<input type="hidden" id='service_id' name="service_id" value="{{$order_detail[0]->service_id}}">
</form>
    </section>
  </div>
  

  @endsection