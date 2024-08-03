<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title')</title>
   <link rel="stylesheet" href=" {{asset('front-assets/css/bootstrap.css')}}">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="{{asset('front-assets/css/style.css')}}">
   <link href="css/font-awesome.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 
</head>

<body>
           <?php
            $id=session()->get('FRONT_USER_LOGIN');
          
            ?>

   <div class="container-fluid bg-danger">
      <div class="container">
         <div class="header ">
            <div class="logo">
               <a href="{{url('/')}}">
                  <h1 class="text-white">Stitch<span class="sp1">Spot</span></h1>
               </a>
            </div>
            @if(session()->get('IS_TAILOR')=='yes')
            <div class="search" style='visibility: hidden;'>
               <form action="{{url('/search')}}" id='search_form'>
             
                   {{-- <i class="fa-solid fa-magnifying-glass"></i> --}}
                  <input type="text" name="search_val" id="input" placeholder="Search Here">
                

               </form>
            </div>
            @else
            <div class="search">
               <form action="{{url('/search')}}" id='search_form'>
             
                   {{-- <i class="fa-solid fa-magnifying-glass"></i> --}}
                  <input type="text" name="search_val" id="input" placeholder="Search Here">
                

               </form>
            </div>
            @endif
           
            @if(session()->get('IS_TAILOR')=='yes')
            <div class="icons" >
               <a style='display:none' href="{{url('/cart')}}"><i class="fa fa-cart-plus"><sup style='font-weight:lighter'>{{ total_cart_items()}}</sup></i></a>
               <a href="{{url('/profile/'.$id)}}"><i class="fa fa-user"></i></a>
               <a href="#" id="bar" onclick=toggleElement()><i class="fa fa-bars"></i></a>
            </div>
            
            @else
            <div class="icons">
               <a href="{{url('/cart')}}"><i class="fa fa-cart-plus"><sup style='font-weight:lighter'>{{ total_cart_items()}}</sup></i></a>
               @if(session()->has('FRONT_USER_LOGIN'))
               <a href="{{url('/profile/'.$id)}}"><i class="fa fa-user"></i></a>
               @else
               <a href="{{url('/profile/1')}}"><i class="fa fa-user"></i></a>
               @endif
               <a href="#" id="bar" onclick=toggleElement()><i class="fa fa-bars"></i></a>
            </div>
            @endif
         </div>
         @if(session()->get('IS_TAILOR')=='yes')
         <div class="links nav-items" id="nav-items-js">
            <a href="{{url('/customers_dashboard')}}"><i class="fas fa-solid fa-house"></i> Dashboard</a>
            <!-- <a href="{{url('/profile')}}">My Account</a> -->
               <a href="{{url('/services')}}"><i class="fa-solid fa-s"></i> Our Services</a>
            <a href="{{url('/contact')}}"><i class="fa-regular fa-id-badge"></i> Contact us</a>
            @if(session()->has('FRONT_USER_LOGIN'))
            <a href="http://127.0.0.1:8002"><i style='font-size:23px' class="fa-brands fa-rocketchat"></i> Messanger</a>
            <a href="{{url('logout')}}"><i class="fa-solid fa-person-through-window"></i> Logout</a>
            @else
            <a href="{{url('login')}}"><i class="fa-solid fa-right-to-bracket"></li> Login</a>
            @endif
         </div>
         @else
        
         <div class="links nav-items" id="nav-items-js">
            <a href="{{url('/')}}"><i class="fas fa-solid fa-house"></i> Home</a>
            <!-- <a href="{{url('/profile')}}">My Account</a> -->
               <a href="{{url('/services')}}"><i class="fa-solid fa-s"></i> Our Services</a>
            <a href="{{url('/cart')}}"><i class="fa fa-cart-plus"></i> My Cart</a>
            <a href="{{url('/contact')}}"><i class="fa-regular fa-id-badge"></i> Contact us</a>
            @if(session()->has('FRONT_USER_LOGIN'))
            <a href="http://127.0.0.1:8002"><i style='font-size:23px' class="fa-brands fa-rocketchat"></i> Messanger</a>
            <a href="{{url('logout')}}"><i class="fa-solid fa-person-through-window"></i> Logout</a>
            @else
            <a href="{{url('login')}}"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
            @endif
         </div>
         @endif

      </div>
   </div>


   @if(session()->get('IS_TAILOR')=='yes')
   <nav class="navbar navbar-expand-lg bg-dark " style='display:none'>
      <div class="container ">

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           {!!getTopNavCat()!!}
         </div>
      </div>
   </nav>
   @else
   <nav class="navbar navbar-expand bg-dark ">
      <div class="container ">
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           {!!getTopNavCat()!!}
         </div>
      </div>
   </nav>

   @endif



   @section('content')
       
   @show




   <footer class="mt-5">
      <div class="container">
         <div class="row">
            <div class="col-md-4">
               <div class="full">
                  <div class="logo_footer">
                     <!-- <a href="#"><img width="210" src="images/logo.png" alt="#" /></a> -->
                     <a href="{{url('/')}}">
                        <h1>Stitch<span>Spot</span></h1>
                     </a>
                  </div>
                  <div class="information_f">
                     <p><strong>ADDRESS:</strong> Sargodha, Pakistan</p>
                     <p><strong>TELEPHONE:</strong> 0300 4563732</p>
                     <p><strong>EMAIL:</strong> stitchspot@gmail.com</p>
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
                                 <li><a href="{{url('/')}}">Home</a></li>
                                 <!-- <li><a href="#">About</a></li> -->
                                 <li><a href="{{url('/products')}}">Products</a></li>
                                 <li><a href="{{url('/contact')}}">Contact</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="widget_menu">
                              <h3>Account</h3>
                              <ul>
                              @if(session()->has('FRONT_USER_LOGIN'))
                                <li> <a href="{{url('/profile/'.$id)}}">Account</a></li>
                                 @else
                                 <li><a href="{{url('/profile/1')}}">Account</a></li>
                                 @endif   
                                 <!-- <li><a href="#">Checkout</a></li> -->
                                 @if(session()->has('FRONT_USER_LOGIN'))
                                 <li><a href="{{'/logout'}}">Logout</a></li>
                                 @else
                                 <li><a href="{{'/login'}}">Login</a></li>
                                 <li><a href="{{'/registration'}}">Register</a></li>
                                 @endif
                                 <li><a href="{{'/'}}">Shopping</a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>

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

               <!--Start of Tawk.to Script-->
            <script type="text/javascript">
            var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
            (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/660d620fa0c6737bd127e781/1hqi4e43n';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
            })();
            </script>
            <!--End of Tawk.to Script-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
      crossorigin="anonymous"></script>
  <!-- Include SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <script src="{{asset('front-assets/js/jquery.min.js')}}"></script> 
    <script src="{{asset('front-assets/js/isotope.min.js')}}"></script>
   <script src="{{asset('front-assets/js/script.js')}}"></script>
   <script>
      document.getElementsByClassName("fa")[2].addEventListener(
         "click", function () {
            document.getElementsByClassName("links")[0].classList.toggle("showmylinks");
         });
      
         // init Isotope
        // init Isotope
        var $grid = $('#product-list').isotope({
         // options
      });
      // filter items on button click
      $('.col ul').on('click', 'li', function () {
         var filterValue = $(this).attr('data-filter');
         $grid.isotope({ filter: filterValue });
         $('#product-list').removeClass('deactive');
       
      });
      $('.col ul').on('click', 'li', function () {
         $(this).siblings('active').removeClass('active');
         $(this).addClass('active');
        
      })

      const buttons = document.querySelectorAll('.filter-group li');

buttons.forEach(button => {
    button.addEventListener('click', function () {
        buttons.forEach(item => item.classList.remove('active'));
        this.classList.add('active');
       
    });
});


        var MainImg = document.getElementById("main-img");
        var smallimg = document.getElementsByClassName("small-img");

        smallimg[0].onclick = function () {
            MainImg.src = smallimg[0].src;
        }
        smallimg[1].onclick = function () {
            MainImg.src = smallimg[1].src;
        }
        smallimg[2].onclick = function () {
            MainImg.src = smallimg[2].src;
        }
        smallimg[3].onclick = function () {
            MainImg.src = smallimg[3].src;
        }
      
   </script>
 
  
</body>

</html>