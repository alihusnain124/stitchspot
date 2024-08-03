
@extends('front.layout')

@section('title','Order Details')
    

 
@section('content')
    
  <div class="container mt-5">
    <section id="cart" class="section-p1 border">
      <h1 class="text-center m-5"><span>Order</span> Details</h1>
      <table width="100%">
        <thead>
          <tr>
            <td>ID</td>
            <td>Product Id</td>
            <td>Product Name</td>
            <td>Product Price</td>
            <td>Product Qty</td>
            <td>Total Price</td>
          </tr>
        </thead>
        <tbody>
         
          @foreach($order_details as $item)

          <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->product_id}}</td>
            <td>{{$item->product_name}}</td>
            <td>{{$item->product_price}}</td>
            <td>{{$item->product_qty}}</td>
            <td>{{$item->product_qty*$item->product_price}}</td>
          </tr>
          @endforeach

        </tbody>
      </table>
    </section>
  </div>
  

  @endsection