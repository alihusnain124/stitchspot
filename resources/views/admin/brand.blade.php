@extends('admin/layout')
@section('title','Brands')
@section('page_title','Brands')
@section('brand_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">All Brands</span>
    <a href="{{url('/admin/brand/add_brand')}}" class="btn-adm btn-adm-dark">
      <i class="fa-solid fa-plus"></i> Add Brand
    </a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Image</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td style="font-weight:500;">{{$list->brand_name}}</td>
          <td>
            <img width="50px" height="50px" style="object-fit:cover;border:1px solid #E5E7EB;"
                 src="{{ str_starts_with($list->brand_image, 'http') ? $list->brand_image : asset('/storage/media/brand/'.$list->brand_image) }}" alt="">
          </td>
          <td>
            @if ($list->status==1)
              <a href="{{url('/admin/brand/status/0')}}/{{$list->id}}">
                <span class="badge-on" style="cursor:pointer;">Active</span>
              </a>
            @elseif($list->status==0)
              <a href="{{url('/admin/brand/status/1')}}/{{$list->id}}">
                <span class="badge-off" style="cursor:pointer;">Inactive</span>
              </a>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{url('/admin/brand/add_brand/')}}/{{$list->id}}" class="btn-adm btn-adm-ghost">
                <i class="fa-solid fa-pen"></i> Edit
              </a>
              <a href="{{url('/admin/brand/delete/')}}/{{$list->id}}" class="btn-adm btn-adm-red">
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
