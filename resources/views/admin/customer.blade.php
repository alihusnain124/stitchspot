@extends('admin/layout');
@section('title','Customer')
@section('customer_select','active')
@section('add')

       
        <div class="page-container">
       
          <header class="header">
            <p>Welcome {{session()->get('admin_email')}}</p>
            <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
        </header>
          
            <div class="main-content">
              @if (session('message'))
              <div class="alert alert-success mx-5" role='alert'>
              {{session('message')}}
              </div>
             @endif
                
            <h1 class="mx-5">Customers</h1>
          
      
            <div class="row">
                <div class="col-md-11">
                    <table class="table  table-borderless mt-4 mx-5 " style="border-radius: 10px;">
                        <thead class="table-dark">
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Is Tailor</th>
                            <th scope="col">status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($data as $list)
                          <tr>
                              <td>{{$list->id}}</td>
                              <td>{{$list->name}}</td>
                              <td>{{$list->email}}</td>
                              <td>{{$list->tailor}}</td>
                              <td>
                                  @if ($list->status==1)
                                  <a href="{{url('/admin/customer/status/0')}}/{{$list->id}}"><button class='btn btn-info'>Active</button></a>
                                  @elseif($list->status==0) 
                                   <a href="{{url('/admin/customer/status/1')}}/{{$list->id}}"><button class='btn btn-warning'>Deactive</button></a>
                                  @endif
                              </td>
                              <td>
                                  <a href="{{url('/admin/customer/view/')}}/{{$list->id}}"><button class='btn btn-success'>View</button></a>
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
                
            </div>
       
        </div>

    </div>
 
    @endsection