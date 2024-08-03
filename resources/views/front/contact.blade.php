@extends('front.layout')

@section('title','Contact')
    

 
@section('content')
    


     <div class="container mt-5">
        <h1 class="text-center">Get <span>in Touch</span></h1>
     </div>
     <!-- <section id="aa-banner ">
        <div class="container mt-5">
           <div class="row">
              <div class="col-md-12">
  
                 <div class="aa-banner-area" id="banner">
                    <img src="images/b2.jpg" alt="fashion banner img">
                 </div>
  
              </div>
           </div>
        </div>
     </section> -->

     <section id="form-details">
        <form id='contact_form'>
            <span>Leave A Message</span>
            <!-- <h2>We Love to Hear From You</h2> -->
            <h2>Share Your Thoughts</h2>
            <input type="text" placeholder="Your Name" name='name'>
            <input type="text" placeholder="Your Email" name='email'>
            <input type="text" placeholder="Your Subject" name='subject'>
            <textarea id="" cols="30" rows="10" placeholder="Message" name='message'></textarea>

            <button class="btn btn-danger" type="submit">Submit</button>

            <span id='msg' class='mt-4'></span>
        </form>
        <div class="people mt-5">
            <div>
                <!-- <img src="" alt=""> -->
                <i class="fa-solid fa-user"></i>
                <p><span>Muhammad Noman</span> <br>Phone: 0310-3465783 <br>Email: contact@gmail.com</p>
            </div>
            <div>
                <!-- <img src="" alt=""> -->
                <i class="fa-solid fa-user"></i>
                <p><span>Ali Husnain</span> <br>Phone: 0310-3465783 <br>Email: contact@gmail.com</p>
            </div>
            <div>
                <!-- <img src="" alt=""> -->
                <i class="fa-solid fa-user"></i>
                <p><span>Rida Siddique</span> <br>Phone: 0310-3465783 <br>Email: contact@gmail.com</p>
            </div>
        </div>
     </section>
     @endsection