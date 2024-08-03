  
@extends('front.layout')

@section('title','Checkout')
    

 
@section('content')


<div class="container">
    <h1 class='text-center m-5'><span >Order Details</span><hr></h1>

<div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      <h2>Billing Address</h2>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      
      <div  id="container">

      <form id='order_form'>
  
          <div class="row">
  
              <div class="col-md-12">
  
                  <div class="inputBox">
                      <span>Full Name :</span>
                      <input type="text" placeholder="Enter Your Name" value='{{$user[0]->name}}' name='name'>
                  </div>
                  <div class="inputBox">
                      <span>Email :</span>
                      <input type="email" placeholder="example@example.com" value='{{$user[0]->email}}'name='email'>
                  </div>
                  <div class="inputBox">
                      <span>Address :</span>
                      <input type="text" placeholder="Street etc" value='{{$user[0]->address}}' name='address'>
                  </div>
                  <div class="inputBox">
                      <span>City :</span>
                      <input type="text" placeholder="City" name='city'>
                  </div>
                  <div class="inputBox">
                      <span>Mobile No :</span>
                      <input type="text" placeholder="mobile" name='mobile_no'>
                  </div>
  
  
                  <div class="flex">
                      <div class="inputBox">
                          <span>State :</span>
                          <input type="text" placeholder="Enter Your State" name='state'> 
                      </div>
                      <div class="inputBox">
                          <span>Zip Code :</span>
                          <input type="number" placeholder="123 456" name='zip_code'>
                      </div>
                      <div class="inputBox">
                          <span>Do you wanna Stitch it:</span>
                         <select name="is_stitch" id="">
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                         </select>
                      </div>
                  </div>
  
              </div>
     
  
  </div> 

      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <h2>Cart Total</h2>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">

      <div class="accordion-body">
      <div class="row mx-5 ">
        <div class="col-8 mx-5">

       
<table class="table mx-5 mt-5" border >
  <thead>
    <tr>
        <td>Product Name</td>
        <td>Price</td>
    </tr>
    <?php
    $product_price=0;
    ?>
    @foreach($cart as $item)
   <?php
   
   $product_price+=$item->product_price*$item->product_qty;
   
   ?>
   <tr>
    <td>{{$item->product_name}} x {{$item->product_qty}}</td>
    <td>{{$item->product_price}}</td>
   </tr>
  @endforeach
  <tr>
    <td>SubTotal</td>
    <td>{{$product_price}}</td>
    <input type="hidden" value='{{$product_price}}' name='total_price'>
   </tr>
   
</table>

 </div>
 </div>
</div>

     
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
     <h2>Payment Methods</h2>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      
      <div class='ms-5 mt-2'>
    
      <input type="radio" value='COD' class='method' name='payment_method'>&nbsp COD<br><br>
      <input type="radio" value='Gateway' class='method'  name='payment_method'>&nbsp ONLINE
    
      </div>

      </div>
    </div>
  </div>
</div>
</div>
<div class="d-grid gap-2">
  <button class="btn btn-danger mt-5 p-3" type="submit">Order</button>
</div>
</form>
</div>
</div>

  @endsection

  