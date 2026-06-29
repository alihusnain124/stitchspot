@extends('admin/layout')
@section('title','Add Size')
@section('page_title','{{ $id > 0 ? "Edit Size" : "Add Size" }}')
@section('size_select','active')
@section('content')

<div class="mb-3">
  <a href="{{url('/admin/size')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Sizes
  </a>
</div>

<div class="admin-card" style="max-width:480px;">
  <div class="admin-card-header">
    <span class="admin-card-title">{{ $id > 0 ? 'Edit Size' : 'Add Size' }}</span>
  </div>
  <div class="admin-card-body">
    <form action="{{route('size.manage_process')}}" method="post">
      @csrf
      <div class="mb-3">
        <label class="adm-label">Size</label>
        <input type="text" id="size" name="size" value="{{$size}}" class="adm-input">
        @error('title')
          <div class="adm-err">Required</div>
        @enderror
      </div>
      <input type="hidden" name="id" value="{{$id}}">
      <button type="submit" class="btn-adm btn-adm-dark">
        <i class="fa-solid fa-floppy-disk"></i> Save Size
      </button>
    </form>
  </div>
</div>

@endsection
