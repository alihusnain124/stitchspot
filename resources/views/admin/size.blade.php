@extends('admin/layout')
@section('title','Sizes')
@section('page_title','Sizes')
@section('size_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">All Sizes</span>
    <a href="{{url('/admin/size/add_size')}}" class="btn-adm btn-adm-dark">
      <i class="fa-solid fa-plus"></i> Add Size
    </a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Size</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td style="font-weight:500;">{{$list->size}}</td>
          <td>
            @if ($list->status==1)
              <a href="{{url('/admin/size/status/0')}}/{{$list->id}}">
                <span class="badge-on" style="cursor:pointer;">Active</span>
              </a>
            @elseif($list->status==0)
              <a href="{{url('/admin/size/status/1')}}/{{$list->id}}">
                <span class="badge-off" style="cursor:pointer;">Inactive</span>
              </a>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{url('/admin/size/add_size/')}}/{{$list->id}}" class="btn-adm btn-adm-ghost">
                <i class="fa-solid fa-pen"></i> Edit
              </a>
              <a href="{{url('/admin/size/delete/')}}/{{$list->id}}" class="btn-adm btn-adm-red">
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
