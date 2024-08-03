<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{asset('admin-assets/css/style.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
   
        <div class="page-content">
                <div class="login-wrap">
                 <div class="login-logo">
                    <a href="#"><img src="{{asset('admin-assets/images/icon/logo.png')}}" alt="" /> </a>
                 </div>
                 <form action="{{route('admin.auth')}}" method='post'>
                    @csrf
                 <div class="form">
                    <div class="row">
                            <div class="col-md-12">
                                <label for="exampleFormControlInput1" class="form-label">Email Address</label>
                                <input type="email" name='email' class="form-control" placeholder="Email">
                            </div>
                        
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                            <input type="password" name='password' class="form-control"  placeholder="Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3"> 
                            Remember Me <input type="checkbox" class="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="d-grid gap-2">
                                <button class="btn btn-info text-white" type="submit">Login</button>
                              </div>   
                        </div>
                        @if (session('error'))
                        <div class="alert alert-danger mt-3" role='alert'>
                            {{session('error')}}
                        </div>
                       @endif
                    </div>
                 </div>
                 </form>
              </div>
        </div>
  
 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>