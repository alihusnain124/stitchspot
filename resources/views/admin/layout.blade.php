<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{asset('admin-assets/css/style.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  </head>
  <body>
    <div class="page-wrapper">
        <aside class="sidebar d-lg-block">
            <div class="logo" >
                <a href="#"><img src="{{asset('admin-assets/images/icon/logo.png')}}" alt="Cool Admin" /> </a>
              
            </div>
          
            <div class="menu-sidebar-content">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar-list">
                        <li  class='@yield('dashboard_select')'>
                            <a class="" href="{{url('admin/dashboard')}}" style='display: none'>
                                <i class="fas fa-solid fa-house"></i>Dashboard</a>
                        </li>
                        <li  class='@yield('order_select')'>
                            <a href="{{url('admin/order')}}">
                                <i class="fas fa-solid fa-list"></i>Orders</a>
                               
                        </li>
                        <li  class='@yield('tailor_order_select')'>
                            <a href="{{url('admin/tailor_order')}}">
                                <i class="fas fa-solid fa-ticket-simple"></i>Tailor Orders</a>
                               
                        </li>
                        <li  class='@yield('customer_select')'>
                            <a href="{{url('admin/customer')}}">
                                <i class="fas fa-solid fa-users"></i>Customers</a>
                               
                        </li>
                        <li  class='@yield('category_select')'>
                            <a href="{{url('admin/category')}}">
                                <i class="fas fa-solid fa-list"></i>Category</a>
                               
                        </li>
                        <li  class='@yield('coupon_select')' style='display: none'>
                            <a href="{{url('admin/coupon')}}">
                                <i class="fas fa-solid fa-ticket-simple"></i>Coupon</a>
                                
                        </li>
                        <li  class='@yield('size_select')'>
                            <a href="{{url('admin/size')}}">
                                <i class="fas fa-solid fa-share"></i>Size</a>
                                
                               
                        </li>
                        <li  class='@yield('color_select')'>
                            <a href="{{url('admin/color')}}">
                                <i class="fas fa-solid fa-palette"></i> color</a>
                               
                        </li>
                        <li  class='@yield('brand_select')'>
                            <a href="{{url('admin/brand')}}">
                                <i class="fas fa-solid fa-handshake"></i>Brand</a>
                                
                        </li>
                        <li  class='@yield('tax_select')' style='display: none'>
                            <a href="{{url('admin/tax')}}">
                                <i class="fas fa-solid fa-circle-info"></i>Tax</a>
                        </li>
                        <li  class='@yield('product_select')'>
                            <a href="{{url('admin/product')}}">
                                <i class="fas fa-solid fa-cart-shopping"></i>Product</a>      
                               
                        </li>
        
                    </ul>
                </nav>
            </div>
          
        </aside>
       
      

        @yield('add')
 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    var count=0;
    function add_img(){
        count++;
      var html="<div class='add_image mt-4' id='img-"+count+"'><div class='row'><div class='col-md-8'> <input type='file' class='form-control' id='exampleFormControlInput1' >";
      html+="</div><div class='col-md-4'> <button class='btn btn-danger text-white' type='button' onclick='remove_img("+count+")'>Remove Image</button> </div></div></div>";
      $('.img').append(html);
    }

    function remove_img(count){

        $('#img-'+count).remove();
    }

    function add_details(){
        count++;
        var html="<div class='add_details mt-2' id='details-"+count+"'><hr class='mt-4'><h2>No-"+count+"</h2><div class='row'><div class='col-md-6'> <div class='mb-3'> <label for='exampleFormControlInput1' class='form-label'>SKU</label><input type='text' name='' id='' class='form-control'></div></div> <div class='col-md-6'><div class='mb-3'><label for='exampleFormControlInput1' class='form-label'>MRP</label> <input type='text' class='form-control'></div></div> </div>";

        html+=" <div class='row'><div class='col-md-6'> <div class='mb-3'> <label for='exampleFormControlInput1' class='form-label'>Price</label><input type='text' name='' id='' class='form-control'> </div></div> <div class='col-md-6'> <div class='mb-3'> <label for='exampleFormControlInput1' class='form-label'>Qty</label> <input type='text' class='form-control'>  </div></div></div>";

        html+="  <div class='row'> <div class='col-md-4'><div class='mb-3'><label for='exampleFormControlInput1' class='form-label'>Size</label><select name='' id='' class='form-control'> <option value=''>Yes</option><option value=''>No</option> </select> </div> </div><div class='col-md-4'><div class='mb-3'> <label for='exampleFormControlInput1' class='form-label'>Color</label><select name='' id='' class='form-control'> <option value=''>Yes</option> <option value=''>No</option> </select> </div></div><div class='col-md-4 mt-4'>  <button style='margin-top: 8px;' class='btn btn-danger text-white' type='button' onclick='remove_details("+count+")'> Remove Details</button> </div> </div>";

        $('.details').append(html);
    }
    function remove_details(count){

     $('#details-'+count).remove();
     }  
      </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('admin-assets/js/script.js')}}"></script>

  </body>
</html>