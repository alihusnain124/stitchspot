@extends('admin/layout')
@section('title','Tailor Orders')
@section('page_title','Tailor Orders')
@section('tailor_order_select','active')
@section('content')

@if(isset($active_orders[0]))
<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Active Orders</span>
    <span class="badge-info">{{ count($active_orders) }} active</span>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Service User ID</th>
          <th>Service ID</th>
          <th>Price</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($active_orders as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->user_id}}</td>
          <td>{{$item->service_user_id}}</td>
          <td>{{$item->service_id}}</td>
          <td>{{$item->price}}</td>
          <td><span class="badge-info">{{$item->status}}</span></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@if(isset($completed_orders[0]))
<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Completed Orders</span>
    <span class="badge-on">{{ count($completed_orders) }} completed</span>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>User ID</th>
          <th>Service User ID</th>
          <th>Service ID</th>
          <th>Price</th>
          <th>Status</th>
          <th>Paid Tailor</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($completed_orders as $item)
        <tr>
          <td>{{$item->id}}</td>
          <td>{{$item->user_id}}</td>
          <td>{{$item->service_user_id}}</td>
          <td>{{$item->service_id}}</td>
          <td>{{$item->price}}</td>
          <td><span class="badge-on">{{$item->status}}</span></td>
          <td>
            @if($item->paid_tailor == 'yes')
              <span class="badge-on"><i class="fa-solid fa-check" style="margin-right:4px;font-size:10px;"></i> Paid</span>
            @else
              <a href="{{url('stripe_pay_tailor/'.$item->id.'/'.$item->service_user_id)}}" class="btn-adm btn-adm-red">
                <i class="fa-solid fa-credit-card"></i> Pay Now
              </a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@endsection
