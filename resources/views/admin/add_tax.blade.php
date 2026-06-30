@extends('admin/layout')
@section('title','Add Tax')
@section('page_title'){{ $id > 0 ? 'Edit Tax' : 'Add Tax' }}@endsection
@section('tax_select','active')
@section('content')

<div class="mb-3">
  <a href="{{url('/admin/tax')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Taxes
  </a>
</div>

<div class="admin-card" style="max-width:600px;">
  <div class="admin-card-header">
    <span class="admin-card-title">{{ $id > 0 ? 'Edit Tax' : 'Add Tax' }}</span>
  </div>
  <div class="admin-card-body">
    <form action="{{route('tax.manage_process')}}" method="post">
      @csrf
      <div class="row g-3">
        <div class="col-md-6">
          <label class="adm-label">Tax Description</label>
          <input id="tax_desc" name="tax_desc" value="{{$tax_desc}}" type="text" class="adm-input">
        </div>
        <div class="col-md-6">
          <label class="adm-label">Tax Value</label>
          <input id="tax_value" name="tax_value" value="{{$tax_value}}" type="text" class="adm-input">
          @error('tax_value')
            <div class="adm-err">Required and should be unique</div>
          @enderror
        </div>
      </div>
      <input type="hidden" name="id" value="{{$id}}">
      <div class="mt-4">
        <button type="submit" class="btn-adm btn-adm-dark">
          <i class="fa-solid fa-floppy-disk"></i> Save Tax
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
