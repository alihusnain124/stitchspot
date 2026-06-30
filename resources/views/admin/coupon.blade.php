@extends('admin/layout')
@section('title','Coupon')
@section('page_title','Coupons')
@section('coupon_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">All Coupons</span>
    <a href="{{url('/admin/coupon/add_coupon')}}" class="btn-adm btn-adm-dark">
      <i class="fa-solid fa-plus"></i> Add Coupon
    </a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Code</th>
          <th>Value</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td style="font-weight:500;">{{$list->title}}</td>
          <td>
            <span style="font-family:monospace;background:#F4F2EF;padding:2px 8px;font-size:12px;letter-spacing:.05em;">
              {{$list->code}}
            </span>
          </td>
          <td>{{$list->value}}</td>
          <td>
            @if ($list->status==1)
              <a href="{{url('/admin/coupon/status/0')}}/{{$list->id}}">
                <span class="badge-on" style="cursor:pointer;">Active</span>
              </a>
            @elseif($list->status==0)
              <a href="{{url('/admin/coupon/status/1')}}/{{$list->id}}">
                <span class="badge-off" style="cursor:pointer;">Inactive</span>
              </a>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{url('/admin/coupon/add_coupon/')}}/{{$list->id}}" class="btn-adm btn-adm-ghost">
                <i class="fa-solid fa-pen"></i> Edit
              </a>
              <a href="{{url('/admin/coupon/delete/')}}/{{$list->id}}" class="btn-adm btn-adm-red">
                <i class="fa-solid fa-trash"></i> Delete
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $data->links('admin.pagination') }}
</div>

@endsection
