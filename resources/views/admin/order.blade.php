@extends('admin/layout')
@section('title','Orders')
@section('page_title','Orders')
@section('order_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">All Orders</span>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Order Status</th>
          <th>Payment Status</th>
          <th>Address</th>
          <th>Placed At</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $item)
        <tr>
          <td>
            <a href="{{url('admin/order_details/'.$item->id)}}" style="color:#C9A96E;font-weight:600;text-decoration:none;">
              #{{$item->id}}
            </a>
          </td>
          <td>{{$item->user_id}}</td>
          <td><span class="badge-info">Placed</span></td>
          <td>
            @if($item->payment_status == 'paid')
              <span class="badge-on">{{$item->payment_status}}</span>
            @else
              <span class="badge-off">{{$item->payment_status}}</span>
            @endif
          </td>
          <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$item->address}}</td>
          <td style="color:#888;font-size:12px;">{{$item->added_on}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
