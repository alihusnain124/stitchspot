<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSpot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('front-assets/css/style.css')}}">
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
      .navbar{
         height: 55px;
      }
    </style>
</head>

<body>


  <div class="container-fluid bg-danger">
    <div class="container">
       <div class="header ">
          <div class="logo">
            <a href="index.html">
               <h1 class="text-white">Stitch<span class="sp1">Spot</span></h1>
            </a>
          </div>
          <div class="search">
             <form action="">
                <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                <input type="text" name="" id="input" placeholder="Search Here">

             </form>
          </div>
          <div class="icons">
             <a href="cart.html"><i class="fa fa-cart-plus"></i></a>
             <a href="#"><i class="fa fa-bell"></i></a>
             <a href="account.html"><i class="fa fa-user"></i></a>
             <a href="#"><i class="fa fa-bars"></i></a>
          </div>
       </div>
       <div class="links bg-danger">
          <a href="index.html">Home</a>
          <a href="account.html">My Account</a>
          <a href="wishlist.html">Wishlist</a>
          <a href="cart.html">My Cart</a>
          <a href="checkout.html">Checkout</a>
       </div>
    </div>
 </div>
  

<div class="container">
    <h1 class="text-center mt-4">Say Hi <span>to Your Account</span> </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="index.html">Home</a></li>                   
        <li class="active">Account</li>
      </ol> -->
</div>
</nav>

<!-- Cart view section -->
<section id="aa-myaccount">
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
         <div class="aa-myaccount-area">         
             <div class="row">
               <div class="col-md-6">
                 <div class="aa-myaccount-login">
                 <h4>Login</h4>
                  <form action="" class="aa-login-form">
                   <label for="">Username or Email address<span>*</span></label>
                    <input type="text" placeholder="Username or email">
                    <label for="">Password<span>*</span></label>
                     <input type="password" placeholder="Password">
                     <button type="submit" class="btn btn-danger mt-3">Login</button>
                     <!-- <label class="rememberme" for="rememberme"><input type="checkbox" id="rememberme"> Remember me </label> -->
                     <!-- <p class="aa-lost-password"><a href="#">Lost your password?</a></p> -->
                   </form>
                 </div>
               </div>
               <div class="col-md-6">
                 <div class="aa-myaccount-register">                 
                  <h4>Register</h4>
                  <form action="" class="aa-login-form">
                     <label for="">Username or Email address<span>*</span></label>
                     <input type="text" placeholder="Username or email">
                     <label for="">Password<span>*</span></label>
                     <input type="password" placeholder="Password">
                     <button type="submit" class=" btn btn-danger mt-3">Register</button>                    
                   </form>
                 </div>
               </div>
             </div>          
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- / Cart view section -->

   <!-- footer start -->
   <footer class="mt-5">
    <div class="container">
       <div class="row">
          <div class="col-md-4">
             <div class="full">
                <div class="logo_footer">
                   <!-- <a href="#"><img width="210" src="images/logo.png" alt="#" /></a> -->
                   <a href="index.html">
                      <h1>Stitch<span>Spot</span></h1>
                   </a>
                </div>
                <div class="information_f">
                   <p><strong>ADDRESS:</strong> Sargodha, Pakistan</p>
                   <p><strong>TELEPHONE:</strong> 0300 4563732</p>
                   <p><strong>EMAIL:</strong> abc@gmail.com</p>
                </div>
             </div>
          </div>
          <div class="col-md-8">
             <div class="row">
                <div class="col-md-7">
                   <div class="row">
                      <div class="col-md-6">
                         <div class="widget_menu">
                            <h3>Menu</h3>
                            <ul>
                               <li><a href="index.html">Home</a></li>
                               <li><a href="#">Products</a></li>
                               <li><a href="">Contact</a></li>
                            </ul>
                         </div>
                      </div>
                      <div class="col-md-6">
                         <div class="widget_menu">
                            <h3>Account</h3>
                            <ul>
                               <li><a href="account.html">Account</a></li>
                               <!-- <li><a href="#">Checkout</a></li> -->
                               <li><a href="login.html">Login</a></li>
                               <li><a href="signup.html">Register</a></li>
                               <li><a href="#">Shopping</a></li>
                            </ul>
                         </div>
                      </div>
                   </div>
                </div>
                <!-- <div class="col-md-5">
                   <div class="widget_menu">
                      <h3>Newsletter</h3>
                      <div class="information_f">
                         <p>Subscribe by our newsletter and get update protidin.</p>
                      </div>
                      <div class="form_sub">
                         <form>
                            <fieldset>
                               <div class="field">
                                  <input type="email" placeholder="Enter Your Mail" name="email" />
                                  <input type="submit" value="Subscribe" />
                               </div>
                            </fieldset>
                         </form>
                      </div>
                   </div>
                </div> -->
             </div>
          </div>
       </div>
    </div>
 </footer>
 <!-- footer end -->
 <div class="cpy_">
    <p class="mx-auto">© 2024 All Rights Reserved By <a href="">StitchSpot</a><br>
    </p>
 </div>
 
 <script src="{{asset('front-assets/js/jquery.min.js')}}"></script>
 <script src="{{asset('front-assets/js/isotope.min.js')}}"></script>
 <script src="{{asset('front-assets/js/script.js')}}"></script>
 <script>
  document.getElementsByClassName("fa")[3].addEventListener(
      "click", function(){
          document.getElementsByClassName("links")[0].classList.toggle("showmylinks");
      });
</script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>