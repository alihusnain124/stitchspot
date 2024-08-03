
@extends('front.layout')
@section('title','Edit Profile')
    
@section('content')
    

     <div class="container-flex">
      <div class="row justify-content-center" >
        <div class="col-md-6 mt-5">
        <div class="profile-container mt-5">
        <form action="{{url('registration_process')}}" class="mt-4" id='reg_form' method="POST"  enctype="multipart/form-data">
          @csrf
          <h1 class="m-2 mb-3 text-center">Edit Profile</h1>
            <div class="mb-3 col-md-12 ">
              <label for="">Username<span>*</span></label>
              <input type="text" placeholder="Username" name='name' value='{{$customer[0]->name}}'>
              <span  style='color:red' class='field_error' id='name_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Email<span>*</span></label>
              <input type="text" placeholder="Email" name='email' value='{{$customer[0]->email}}'>
              <span style='color:red' class='field_error' id='email_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Mobile<span>*</span></label>
              <input type="text" placeholder="Mobile no" name='mobile' value='{{$customer[0]->mobile}}'>
              <span style='color:red' class='field_error' id='mobile_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Address<span>*</span></label>
              <input type="text" placeholder="Address" name='address' value='{{$customer[0]->address}}'>
              <span style='color:red' class='field_error' id='address_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Password<span>*</span></label>
              <input type="password" placeholder="Password" name='password' value=''>
              <span style='color:red' class='field_error' id='password_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Short Bio</label>
              <input type="text" placeholder="Bio" name='bio' value='{{$customer[0]->bio}}'>
              <span style='color:red' class='field_error' id='bio_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Image<span>*</span></label>
              <input type="file" placeholder="Image" name='image' id='image' value='{{$customer[0]->image}}'>
              <span style='color:red' class='field_error' id='image_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">About<span>*</span></label>
              <textarea name="about" id="" cols="10" rows="5">{{$customer[0]->about}}</textarea>
              <span style='color:red' class='field_error' id='about_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Skills</label>
              <textarea name="skills" id="" cols="5" rows="5">{{$customer[0]->skills}}</textarea>
              <span style='color:red' class='field_error' id='skills_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Language<span>*</span></label>
              <textarea name="language" id="" cols="5" rows="5">{{$customer[0]->language}}</textarea>
              <span style='color:red' class='field_error' id='language_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Are you joining as Tailor<span>*</span></label>
               <select name="tailor" id="" class="form-select">
               
                <option value="">Select </option>
                @if($customer[0]->tailor=='yes')
                <option value="yes" selected>Yes</option>
                <option value="no">No</option>
                @else
                <option value="yes">Yes</option>
                <option value="no" selected>No</option>
                @endif
               </select>
              <span style='color:red' class='field_error' id='tailor_error'></span><br>
            </div>
          
            <div class="d-grid gap-2">
              <button  type="submit" id='reg_btn' class="btn btn-outline-success m-3">Update</button>
            </div>
           <input type="hidden" name='id' value='{{$customer[0]->id}}'>
          </form>
          <div style='color:green; text-align:center; font-weight:bold' class="reg_msg"></div> 
     </div>
</div>
    </div>
     </div>
    
@endsection