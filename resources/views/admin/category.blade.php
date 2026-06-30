@extends('admin/layout')
@section('title','Category')
@section('page_title','Category')
@section('category_select','active')
@section('content')

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Categories</span>
    <a href="{{url('/admin/category/add_category')}}" class="btn-adm btn-adm-dark">
      <i class="fa-solid fa-plus"></i> Add Category
    </a>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Category Name</th>
          <th>Slug</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $list)
        <tr>
          <td>{{$list->id}}</td>
          <td style="font-weight:500;">{{$list->category_name}}</td>
          <td style="color:#888;font-size:12px;">{{$list->category_slug}}</td>
          <td>
            @if ($list->status==1)
              <a href="{{url('/admin/category/status/0')}}/{{$list->id}}">
                <span class="badge-on" style="cursor:pointer;">Active</span>
              </a>
            @elseif($list->status==0)
              <a href="{{url('/admin/category/status/1')}}/{{$list->id}}">
                <span class="badge-off" style="cursor:pointer;">Inactive</span>
              </a>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{url('/admin/category/add_category/')}}/{{$list->id}}" class="btn-adm btn-adm-ghost">
                <i class="fa-solid fa-pen"></i> Edit
              </a>
              <a href="{{url('/admin/category/delete/')}}/{{$list->id}}" class="btn-adm btn-adm-red">
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
