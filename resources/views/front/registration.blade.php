
@extends('front.layout')
@section('title','Signup')
    
@section('content')
    

     <div class="container-flex">
      <div class="row justify-content-center" >
        <div class="col-md-6 mt-5">
        <div class="profile-container mt-5">
        <form action="{{url('registration_process')}}" class="mt-4" id='reg_form' method="POST"  enctype="multipart/form-data">
          @csrf
          <h1 class="m-2 mb-3 text-center">Signup</h1>
            <div class="mb-3 col-md-12 ">
              <label for="">Username<span>*</span></label>
              <input type="text" placeholder="Username" name='name'>
              <span  style='color:red' class='field_error' id='name_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Email<span>*</span></label>
              <input type="text" placeholder="Email" name='email'>
              <span style='color:red' class='field_error' id='email_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Mobile<span>*</span></label>
              <input type="text" placeholder="Mobile no" name='mobile'>
              <span style='color:red' class='field_error' id='mobile_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Address<span>*</span></label>
              <input type="text" placeholder="Address" name='address'>
              <span style='color:red' class='field_error' id='address_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Password<span>*</span></label>
              <input type="password" placeholder="Password" name='password'>
              <span style='color:red' class='field_error' id='password_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Short Bio</label>
              <input type="text" placeholder="Bio" name='bio'>
              <span style='color:red' class='field_error' id='bio_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Image<span>*</span></label>
              <input type="file" placeholder="Image" name='image' id='image'>
              <span style='color:red' class='field_error' id='image_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">About<span>*</span></label>
              <textarea name="about" id="" cols="10" rows="5"></textarea>
              <span style='color:red' class='field_error' id='about_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Skills</label>
              <textarea name="skills" id="" cols="5" rows="5"></textarea>
              <span style='color:red' class='field_error' id='skills_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Language<span>*</span></label>
              <textarea name="language" id="" cols="5" rows="5"></textarea>
              <span style='color:red' class='field_error' id='language_error'></span><br>
            </div>
            <div class="mb-3 col-md-12 ">
              <label for="">Are you joining as Tailor<span>*</span></label>
               <select name="tailor" id="" class="form-select">
                <option value="">Select </option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
               </select>
              <span style='color:red' class='field_error' id='tailor_error'></span><br>
            </div>
          
            <div class="d-grid gap-2">
              <button  type="submit" id='reg_btn' class="btn btn-outline-success m-3">Register</button>
            </div>
           
          </form>
          <div style='color:green; text-align:center; font-weight:bold' class="reg_msg"></div> 
     </div>
</div>
    </div>
     </div>
 
    
@endsection