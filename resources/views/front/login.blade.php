
@extends('front.layout')
@section('title','Login')
    
@section('content')

   <div class="container">
      <div class="row justify-content-center">
         <div class="col-md-6 mt-5">
           
         <div class="profile-container mt-5">
        
      <form class="mt-4 "  id='login_form'>
         @csrf
          <h1 class="m-2 mb-4 text-center">Login</h1>
            <div class="mb-3 col-md-12 ">
               <label for="">Email address<span>*</span></label>
               <input type="text" placeholder="Enter your email" name='login_email' >
            </div>
            <div class="mb-3 col-md-12 ">
               <label for="">Password<span>*</span></label>
               <input type="password" placeholder="Password" name='login_password'>
            </div>
            <div class="d-grid gap-2">
               <button type="submit" id='login_btn' class="btn btn-outline-success m-3">Login</button>
             </div>
            

          </form>
          <div style='color:red; text-align:center; font-weight:bold' class="login_error"></div> 
         <span style='color:red; margin-left: 170px' class='reg'>Don't Have account? <a href="{{url('/registration')}}">Registration</a></span>     
   </div>
</div>
</div>

</div>

 @endsection