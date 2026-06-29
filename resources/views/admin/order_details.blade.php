@extends('admin/layout')
@section('title','Order Details')
@section('page_title','Order Details')
@section('order_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Update Order</span>
  </div>
  <div class="admin-card-body">
    <form action="" id="update_status">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="adm-label">Order Status</label>
          <select name="order_status" class="adm-select">
            <option value="">Select Status</option>
            @foreach($order_status as $val)
              @if($order[0]->order_status == $val)
                <option value="{{$val}}" selected>{{$val}}</option>
              @else
                <option value="{{$val}}">{{$val}}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="adm-label">Payment Status</label>
          <select name="payment_status" class="adm-select">
            <option value="">Select Status</option>
            @foreach($payment_status as $val)
              @if($order[0]->payment_status == $val)
                <option value="{{$val}}" selected>{{$val}}</option>
              @else
                <option value="{{$val}}">{{$val}}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="adm-label">Track Details</label>
          <textarea name="track_details" class="adm-textarea">{{$order[0]->track_details}}</textarea>
        </div>
      </div>
      <input type="hidden" value="{{$order[0]->id}}" name="id" id="id">
      <div class="mt-3">
        <button type="submit" class="btn-adm btn-adm-dark">
          <i class="fa-solid fa-floppy-disk"></i> Update Order
        </button>
      </div>
    </form>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Order Items</span>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order_details as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->product_id}}</td>
          <td>{{$item->product_name}}</td>
          <td>{{$item->product_price}}</td>
          <td>{{$item->product_qty}}</td>
          <td style="font-weight:600;">{{$item->product_qty * $item->product_price}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
