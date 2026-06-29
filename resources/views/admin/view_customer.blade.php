@extends('admin/layout')
@section('title','View Customer')
@section('page_title','Customer Details')
@section('customer_select','active')
@section('content')

<div class="mb-3">
  <a href="{{url('/admin/customer')}}" class="btn-adm btn-adm-ghost">
    <i class="fa-solid fa-arrow-left"></i> Back to Customers
  </a>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <span class="admin-card-title">Customer Profile</span>
  </div>
  <div class="admin-card-body">
    <div class="row g-4">
      <div class="col-md-3 text-center">
        <img style="width:120px;height:120px;object-fit:cover;border:2px solid #E5E7EB;"
             src="{{asset('/storage/media/customer/'.$data->image)}}" alt="Customer Image">
        <div style="margin-top:12px;font-weight:600;font-size:15px;">{{$data->name}}</div>
        <div style="font-size:12px;color:#888;margin-top:2px;">{{$data->email}}</div>
        @if($data->tailor == 'yes' || $data->tailor == 1)
          <div style="margin-top:8px;"><span class="badge-info">Tailor</span></div>
        @endif
      </div>
      <div class="col-md-9">
        <table class="admin-table">
          <tbody>
            <tr>
              <td style="color:#888;width:160px;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Phone</td>
              <td>{{$data->mobile}}</td>
            </tr>
            <tr>
              <td style="color:#888;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Address</td>
              <td>{{$data->address}}</td>
            </tr>
            <tr>
              <td style="color:#888;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Bio</td>
              <td>{{$data->bio}}</td>
            </tr>
            <tr>
              <td style="color:#888;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">About</td>
              <td>{{$data->about}}</td>
            </tr>
            <tr>
              <td style="color:#888;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Status</td>
              <td>
                @if($data->status == 1)
                  <span class="badge-on">Active</span>
                @else
                  <span class="badge-off">Inactive</span>
                @endif
              </td>
            </tr>
            <tr>
              <td style="color:#888;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Created</td>
              <td style="color:#888;font-size:12px;">{{\Carbon\Carbon::parse($data->created_at)->format('d-m-Y h:m:s')}}</td>
            </tr>
            <tr>
              <td style="color:#888;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;">Updated</td>
              <td style="color:#888;font-size:12px;">{{\Carbon\Carbon::parse($data->updated_at)->format('d-m-Y h:m:s')}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
