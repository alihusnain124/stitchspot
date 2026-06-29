@extends('admin/layout')
@section('title','Products')
@section('page_title','Products')
@section('product_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">All Products</span>
    <a href="{{url('/admin/product/add_product')}}" class="btn-adm btn-adm-dark">
      <i class="fa-solid fa-plus"></i> Add Product
    </a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Category ID</th>
          <th>Product Name</th>
          <th>Image</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td>{{$list->category_id}}</td>
          <td style="font-weight:500;">{{$list->name}}</td>
          <td>
            <img width="50px" height="50px" style="object-fit:cover;border:1px solid #E5E7EB;"
                 src="{{asset('/storage/media/'.$list->image)}}" alt="">
          </td>
          <td>
            @if ($list->status==1)
              <a href="{{url('/admin/product/status/0')}}/{{$list->id}}">
                <span class="badge-on" style="cursor:pointer;">Active</span>
              </a>
            @elseif($list->status==0)
              <a href="{{url('/admin/product/status/1')}}/{{$list->id}}">
                <span class="badge-off" style="cursor:pointer;">Inactive</span>
              </a>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{url('/admin/product/add_product/')}}/{{$list->id}}" class="btn-adm btn-adm-ghost">
                <i class="fa-solid fa-pen"></i> Edit
              </a>
              <a href="{{url('/admin/product/delete/')}}/{{$list->id}}" class="btn-adm btn-adm-red">
                <i class="fa-solid fa-trash"></i> Delete
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
