@extends('admin/layout');
@section('title','View Customer')
@section('add')


    <div class="page-container">

        <header class="header">
            <p>Welcome {{session()->get('admin_email')}}</p>
            <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
        </header>
        <div class="main-content">
             <h1 class='mx-5'>Customer Details</h1>
             <a href="{{url('/admin/customer')}}"><button type="button" class="btn btn-outline-success mx-5 my-4 ">Back</button></a> 
     
  
    <div class="col-lg-11 m-5">
        <table class="table table-border table-data3 ">
            <thead>
                <tr>
    
                    <th>Feild</th>
                    <th>Detail</th>

                </tr>
            </thead>
            <tbody>
               <tr > 
                <td>Name</td>
                <td>{{$data->name}}</td>
               </tr>

               <tr>
                <td>Email</td>
                <td>{{$data->email}}</td>
               </tr>

               <tr>
                <td>Phone No</td>
                <td>{{$data->mobile}}</td>
               </tr>

               <tr>
                <td>Address</td>
                <td>{{$data->address}}</td>
               </tr>

               <tr>
                <td>Bio</td>
                <td>{{$data->bio}}</td>
               </tr>

               <tr>
                <td>Image</td>
                <td> <img style='height: 100px' src="{{asset('/storage/media/customer/'.$data->image)}}" class="img-fluid" alt=""></td>
               </tr>

               <tr>
                <td>Is Tailor</td>
                <td>{{$data->tailor}}</td>
               </tr>

               <tr>
                <td>About</td>
                <td>{{$data->about}}</td>
               </tr>
                  
               <tr>
                <td>Status</td>
                <td>{{$data->status}}</td>
               </tr>
               <tr>
                <td>Created</td>
                <td>{{\Carbon\Carbon::parse($data->created_at)->format('d-m-Y h:m:s')}}</td>
               </tr>
               <tr>
                <td>Updated</td>
                <td>{{\Carbon\Carbon::parse($data->updated_at)->format('d-m-Y h:m:s')}}</td>
               </tr>

            </tbody>
        </table>
    </div>
    <div>
</div>
@endsection
