
@extends('front.layout')

@section('title','Cart')
    

 
@section('content')
  
  <div class="container mt-5">
    <section id="cart" class="section-p1 border">
      <h1 class="text-center m-5"><span>Your</span> Cart</h1>
      <table width="100%">
        <thead>
          <tr>
            <td>Remove</td>
            <td>Image</td>
            <td>Product</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Sub Total</td>
          </tr>
        </thead>
        <tbody>
          <?php $total_price=0;?>
          @foreach($cart as $item)
         
          <?php
           $total_price+=($item->product_price*$item->product_qty);
           ?>
          <tr>
            <td><a href="javascript:void(0)" onclick="deleteCart({{$item->pid}},{{$item->attr_id}},'{{ csrf_token() }}')"><i class="fa-solid fa-times-circle" ></i></a></td>
            <td><img src="{{asset('/storage/media/'.$item->product_image)}}" alt="text"></td>
            <td>{{$item->product_name}}</td>
            <td>{{$item->product_price}}</td>
            <td><input type="number" value="{{$item->product_qty}}" onchange="updateCart({{$item->pid}},this.value,'{{ csrf_token() }}',{{$item->attr_id}})"></td>
            <td>{{$item->product_price *$item->product_qty}}</td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </section>
  </div>
  <div class="container mt-5">
    <section id="cart-add" class="section-p1 text-center">
      <div id="subtotal">
        <h3>Cart Totals</h3>
        <table>
          <tr>
            <td>Sub Totals</td>
            <td>{{$total_price}}</td>
          </tr>
          <tr>
            <td>Shipping</td>
            <td>Free</td>
          </tr>
          <tr>
            <td><strong>Total</strong></td>
            <td><strong>{{$total_price}}</strong></td>
          </tr>
        </table>
        <a href="{{url('/checkout')}}" > <button class="btn btn-danger">Proceed To Checkout</button></a>
      </div>
    </section>
  </div>

  @endsection