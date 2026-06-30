@extends('admin/layout')
@section('title','Add Color')
@section('page_title'){{ $id > 0 ? 'Edit Color' : 'Add Color' }}@endsection
@section('color_select','active')
@section('content')

<div class="mb-3">
  <a href="{{url('/admin/color')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Colors
  </a>
</div>

<div class="admin-card" style="max-width:480px;">
  <div class="admin-card-header">
    <span class="admin-card-title">{{ $id > 0 ? 'Edit Color' : 'Add Color' }}</span>
  </div>
  <div class="admin-card-body">
    <form action="{{route('color.manage_process')}}" method="post">
      @csrf
      <div class="mb-3">
        <label class="adm-label">Color</label>
        <input type="text" id="color" name="color" value="{{$color}}" class="adm-input">
        @error('color')
          <div class="adm-err">Required</div>
        @enderror
      </div>
      <input type="hidden" name="id" value="{{$id}}">
      <button type="submit" class="btn-adm btn-adm-dark">
        <i class="fa-solid fa-floppy-disk"></i> Save Color
      </button>
    </form>
  </div>
</div>

@endsection
