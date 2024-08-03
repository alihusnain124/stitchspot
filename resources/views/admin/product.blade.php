@extends('admin/layout');
@section('title','Product')
@section('product_select','active')
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
                
            <h1 class="mx-5">Product</h1>
            <a href="{{url('/admin/product/add_product')}}"><button type="button" class="btn btn-outline-success mx-5 mt-3">Add Product</button></a>
      
            <div class="row">
                <div class="col-md-11">
                    <table class="table  table-borderless mt-4 mx-5 " style="border-radius: 10px;">
                        <thead class="table-dark">
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Category Id</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Image</th>
                            <th scope="col">status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($data as $list)
                        <tr>
                            <td>{{$list->id}}</td>
                            <td>{{$list->category_id}}</td>
                            <td>{{$list->name}}</td>
                          
                            <td><img width="50px" src="{{asset('/storage/media/'.$list->image)}}" alt=""></td>
                            <td>
                                @if ($list->status==1)
                                <a href="{{url('/admin/product/status/0')}}/{{$list->id}}"><button class='btn btn-info'>Active</button></a>
                                @elseif($list->status==0) 
                                 <a href="{{url('/admin/product/status/1')}}/{{$list->id}}"><button class='btn btn-warning'>Deactive</button></a>
                                @endif
                               
                            </td>
                            <td>
                                <a href="{{url('/admin/product/add_product/')}}/{{$list->id}}"><button class='btn btn-success'>Edit</button></a>
                              
                                <a href="{{url('/admin/product/delete/')}}/{{$list->id}}"><button class='btn btn-danger'>Delete</button></a>
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