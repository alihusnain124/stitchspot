<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchSpot</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href=" {{asset('front-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href=" {{asset('front-assets/css/style.css')}}">
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
            <input type="text" name="" id="input"  placeholder="Search Here">
            
        </form>
    </div>
    <div class="icons">
        <a href="#"><i class="fa fa-cart-plus"></i></a>
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

   <!-- <header id="aa-header">
      <div class="aa-header-top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="aa-header-top-area">
                <div class="aa-header-top-left">
  
                </div>
                <div class="aa-header-top-right">
                  <ul class="aa-head-top-nav-right m-2">
                    <li><a href="account.html">My Account</a></li>
                    <li class="hidden-xs"><a href="wishlist.html">Wishlist</a></li>
                    <li class="hidden-xs"><a href="cart.html">My Cart</a></li>
                    <li class="hidden-xs"><a href="checkout.html">Checkout</a></li>
                    <li><a href="login.html" data-toggle="modal" data-target="#login-modal">Login</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="aa-header-bottom">
         <div class="container">
           <div class="row">
             <div class="col-md-12">
               <div class="aa-header-bottom-area">
                 <div class="aa-logo">
                   <a href="index.html">
                     <h1 class="text-bold">Stitch<span>Spot</span></h1>
                   </a>
                 </div>
                 <div class="aa-cartbox">
                   <a class="aa-cart-link" href="#">
                      <i class="fa-solid fa-cart-shopping mt-3"></i>
                     
                   </a>
                   <div class="aa-cartbox-summary">
                     <ul>
                       <li>
                         <a class="aa-cartbox-img" href="#"><img src="img/woman-small-2.jpg" alt="img"></a>
                         <div class="aa-cartbox-info">
                           <h4><a href="#">Product Name</a></h4>
                           <p>1 x $250</p>
                         </div>
                         <a class="aa-remove-product" href="#"><span class="fa fa-times"></span></a>
                       </li>
                       <li>
                         <a class="aa-cartbox-img" href="#"><img src="img/woman-small-1.jpg" alt="img"></a>
                         <div class="aa-cartbox-info">
                           <h4><a href="#">Product Name</a></h4>
                           <p>1 x $250</p>
                         </div>
                         <a class="aa-remove-product" href="#"><span class="fa fa-times"></span></a>
                       </li>                    
                       <li>
                         <span class="aa-cartbox-total-title">
                           Total
                         </span>
                         <span class="aa-cartbox-total-price">
                           $500
                         </span>
                       </li>
                     </ul>
                     <a class="aa-cartbox-checkout aa-primary-btn" href="checkout.html">Checkout</a>
                   </div>
                 </div>
                 <div class="aa-search-box">
                   <form action="">
                     <input type="text" name="" id="" placeholder="Search Here ">
                     <button type="submit"><span class="fa fa-search "></span></button>
                   </form>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
     </header> -->

     <nav class="navbar navbar-expand-lg bg-light ">
      <div class="container  ">

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item mb-2">
                  <a class="nav-link active" aria-current="page" href="index.html">Home</a>
               </li>
               
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                     aria-expanded="false">
                     Men
                  </a>
                  <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="#">Casual</a></li>
                     <li><a class="dropdown-item" href="#">Sports</a></li>
                     <li><a class="dropdown-item" href="#">Formal</a></li>
                    
                  </ul>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                     aria-expanded="false">
                     Women
                  </a>
                  <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="#">Action</a></li>
                     <li><a class="dropdown-item" href="#">Action</a></li>
                     <li><a class="dropdown-item" href="#">Action</a></li>
                  </ul>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                     aria-expanded="false">
                     Kids
                  </a>
                  <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="#">Action</a></li>
                     <li><a class="dropdown-item" href="#">Action</a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="#">Action</a></li>
                  </ul>
               </li>

            </ul>

         </div>
      </div>
   </nav>

    <div class="container">
        <h1 class="text-center mt-4">My <span>Wishlist</span></h1><!-- Cart view section -->
        <section id="cart-view">
          <div class="container mt-5">
            <div class="row">
              <div class="col-md-12">
                <div class="cart-view-area">
                  <div class="cart-view-table aa-wishlist-table">
                    <form action="">
                      <div class="table-responsive">
                         <table class="table">
                           <thead>
                             <tr>
                               <th></th>
                               <th></th>
                               <th>Product</th>
                               <th>Price</th>
                               <th>Stock Status</th>
                               <th></th>
                             </tr>
                           </thead>
                           <tbody>
                             <tr>
                               <td><a class="remove" href="#"><fa class="fa fa-close"></fa></a></td>
                               <td><a href=""><img src="images/cart-img2.jpg" alt="img"></a></td>
                               <td><a class="aa-cart-title" href="#">Polo T-Shirt</a></td>
                               <td>Pkr: 2500</td>
                               <td>In Stock</td>
                               <td><a href="cart.html" class="btn btn-danger">Add To Cart</a></td>
                             </tr>
                             <tr>
                               <td><a class="remove" href="#"><fa class="fa fa-close"></fa></a></td>
                               <td><a href="#"><img src="images/cart-img3.jpg" alt="img"></a></td>
                               <td><a class="aa-cart-title" href="#">Polo T-Shirt</a></td>
                               <td>Pkr: 3000</td>
                               <td>In Stock</td>
                               <td><a href="cart.html" class="btn btn-danger">Add To Cart</a></td>
                             </tr>
                             <tr>
                               <td><a class="remove" href="#"><fa class="fa fa-close"></fa></a></td>
                               <td><a href="#"><img src="images/cart-img2.jpg" alt="img"></a></td>
                               <td><a class="aa-cart-title" href="#">Polo T-Shirt</a></td>
                               <td>Pkr: 3000</td>
                               <td>In Stock</td>
                               <td><a href="cart.html" class="btn btn-danger">Add To Cart</a></td>
                             </tr>                     
                             </tbody>
                         </table>
                       </div>
                    </form>             
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- / Cart view section -->
    </div>

   


 <footer class="mt-3">
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
                              <!-- <li><a href="#">About</a></li> -->
                              <li><a href="products.html">Products</a></li>
                              <li><a href="contact.html">Contact</a></li>
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