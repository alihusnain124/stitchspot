@extends('admin/layout');
@section('title','Dashboard')
@section('dashboard_select','active')
@section('add')
       
        <div class="page-container">
       
            <header class="header">
                <p>Welcome {{session()->get('admin_email')}}</p>
                <a class='alii' href="{{url('/admin/logout')}}"><button class='btn btn-danger '>Logout</button></a>
            </header>
          
            <div class="main-content">
                
      
                
            </div>
       
        </div>

    </div>
 
@endsection