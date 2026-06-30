@extends('admin/layout')
@section('title','Customers')
@section('page_title','Customers')
@section('customer_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">All Customers</span>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Is Tailor</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td style="font-weight:500;">{{$list->name}}</td>
          <td style="color:#888;">{{$list->email}}</td>
          <td>
            @if($list->tailor == 'yes' || $list->tailor == 1)
              <span class="badge-info">Tailor</span>
            @else
              <span style="color:#aaa;font-size:12px;">—</span>
            @endif
          </td>
          <td>
            @if ($list->status==1)
              <a href="{{url('/admin/customer/status/0')}}/{{$list->id}}">
                <span class="badge-on" style="cursor:pointer;">Active</span>
              </a>
            @elseif($list->status==0)
              <a href="{{url('/admin/customer/status/1')}}/{{$list->id}}">
                <span class="badge-off" style="cursor:pointer;">Inactive</span>
              </a>
            @endif
          </td>
          <td>
            <a href="{{url('/admin/customer/view/')}}/{{$list->id}}" class="btn-adm btn-adm-ghost">
              <i class="fa-solid fa-eye"></i> View
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{ $data->links('admin.pagination') }}
</div>

@endsection
