
@extends('front.layout')

@section('title','Order Placed')
    

 
@section('content')
    
  <div class="container mt-5 text-center">
    
  <h2>Order has been placed </h2>
  <span>Your order id is : {{session()->get('ORDER_ID')}}</span>
   
  </div>

  <div class="container profile-container mt-3">
    <h3>Exciting News! Tailoring Services Now Available on Our Platform</h3>
    <span>Dear {{session()->get('FRONT_USER_NAME')}},</span>
    <h5>
    We're thrilled to announce that our platform now offers tailor-made solutions beyond our traditional offerings. In addition to our existing services, we're expanding into the world of clothes stitching and customization.
    Whether you're looking for the perfect fit, unique designs, or alterations to your existing wardrobe, our team of experienced tailors is here to bring your vision to life. From elegant formal wear to casual chic, we've got you covered.
    With our commitment to quality craftsmanship and attention to detail, you can trust us to deliver garments that not only fit impeccably but also reflect your personal style.
    Get started today by exploring our new tailoring services section on the platform. We can't wait to embark on this sartorial journey with you!
    </h5>
    <span>
    Best regards,<br><br>

    Ali Husnain <br>
    HR of Organisation... <br>
    StitchSpot....
    </span>
  </div>

  <div class="continer text-center">
<a href="{{url('/services')}}"><button class="btn btn-danger me-2 mt-3">Go towards Services</button></a>
  </div>


  @endsection