@extends('admin/layout')
@section('title','Add Coupon')
@section('page_title','{{ $id > 0 ? "Edit Coupon" : "Add Coupon" }}')
@section('coupon_select','active')
@section('content')

<div class="mb-3">
  <a href="{{url('/admin/coupon')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Coupons
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">{{ $id > 0 ? 'Edit Coupon' : 'Add Coupon' }}</span>
  </div>
  <div class="admin-card-body">
    <form action="{{route('coupon.manage_process')}}" method="post">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="adm-label">Coupon Title</label>
          <input type="text" id="title" name="title" value="{{$title}}" class="adm-input">
          @error('title')
            <div class="adm-err">Required</div>
          @enderror
        </div>
        <div class="col-md-4">
          <label class="adm-label">Coupon Code</label>
          <input type="text" id="code" name="code" value="{{$code}}" class="adm-input">
          @error('code')
            <div class="adm-err">Code should be unique</div>
          @enderror
        </div>
        <div class="col-md-4">
          <label class="adm-label">Coupon Value</label>
          <input type="text" id="value" name="value" value="{{$value}}" class="adm-input">
          @error('value')
            <div class="adm-err">Required</div>
          @enderror
        </div>
        <div class="col-md-3">
          <label class="adm-label">Type</label>
          <select id="type" name="type" class="adm-select">
            @if ($type=='Value')
              <option value="Value" selected>Value</option>
              <option value="Per">Per</option>
            @elseif($type=='Per')
              <option value="Value">Value</option>
              <option value="Per" selected>Per</option>
            @else
              <option value="Value">Value</option>
              <option value="Per">Per</option>
            @endif
          </select>
        </div>
        <div class="col-md-6">
          <label class="adm-label">Min Order Amount</label>
          <input type="text" id="min_order_amt" name="min_order_amt" value="{{$min_order_amt}}" class="adm-input">
        </div>
        <div class="col-md-3">
          <label class="adm-label">Is One Time</label>
          <select id="is_one_time" name="is_one_time" class="adm-select">
            @if ($is_one_time=='1')
              <option value="1" selected>Yes</option>
              <option value="0">No</option>
            @else
              <option value="1">Yes</option>
              <option value="0" selected>No</option>
            @endif
          </select>
        </div>
      </div>
      <input type="hidden" name="id" value="{{$id}}">
      <div class="mt-4">
        <button type="submit" class="btn-adm btn-adm-dark">
          <i class="fa-solid fa-floppy-disk"></i> Save Coupon
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
