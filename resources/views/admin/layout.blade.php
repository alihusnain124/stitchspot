<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','StitchSpot Admin')</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: #F4F2EF;
      color: #1A1A1A;
      margin: 0;
      padding: 0;
    }

    /* ─── SIDEBAR ─────────────────────────────── */
    .ss-sidebar {
      position: fixed;
      top: 0; left: 0;
      width: 240px;
      height: 100vh;
      background: #111111;
      display: flex;
      flex-direction: column;
      z-index: 1000;
      overflow-y: auto;
    }
    .ss-sidebar-brand {
      padding: 28px 24px 20px;
      border-bottom: 1px solid rgba(255,255,255,.07);
      flex-shrink: 0;
    }
    .ss-sidebar-brand .brand-name {
      font-size: 22px;
      font-weight: 700;
      color: #fff;
      letter-spacing: -.02em;
      line-height: 1;
    }
    .ss-sidebar-brand .brand-name span { color: #C9A96E; }
    .ss-sidebar-brand .brand-sub {
      font-size: 10px;
      font-weight: 500;
      color: rgba(255,255,255,.35);
      text-transform: uppercase;
      letter-spacing: .15em;
      margin-top: 4px;
    }

    .ss-nav {
      flex: 1;
      padding: 16px 0;
    }
    .ss-nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }
    .ss-nav-section {
      font-size: 9.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .16em;
      color: rgba(255,255,255,.25);
      padding: 16px 24px 6px;
    }
    .ss-nav li a {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 10px 24px;
      font-size: 13px;
      font-weight: 500;
      color: rgba(255,255,255,.55);
      text-decoration: none;
      transition: color .18s, background .18s;
      border-left: 2px solid transparent;
    }
    .ss-nav li a i {
      width: 16px;
      text-align: center;
      font-size: 13px;
      flex-shrink: 0;
    }
    .ss-nav li a:hover {
      color: #C9A96E;
      background: rgba(201,169,110,.07);
    }
    .ss-nav li.active a {
      color: #C9A96E;
      background: rgba(201,169,110,.1);
      border-left-color: #C9A96E;
    }

    .ss-sidebar-footer {
      padding: 16px 24px;
      border-top: 1px solid rgba(255,255,255,.07);
      flex-shrink: 0;
    }
    .ss-sidebar-footer a {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 13px;
      font-weight: 500;
      color: rgba(255,255,255,.4);
      text-decoration: none;
      transition: color .18s;
    }
    .ss-sidebar-footer a:hover { color: #E63946; }

    /* ─── TOPBAR ─────────────────────────────── */
    .ss-topbar {
      position: fixed;
      top: 0; left: 240px;
      right: 0;
      height: 60px;
      background: #fff;
      border-bottom: 1px solid #E5E7EB;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 28px;
      z-index: 999;
    }
    .ss-topbar-title {
      font-size: 15px;
      font-weight: 600;
      color: #1A1A1A;
      letter-spacing: -.01em;
    }
    .ss-topbar-right {
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .ss-topbar-email {
      font-size: 12.5px;
      color: #888;
    }
    .ss-topbar-logout {
      font-size: 12.5px;
      font-weight: 500;
      color: #1A1A1A;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border: 1px solid #E5E7EB;
      transition: all .18s;
    }
    .ss-topbar-logout:hover {
      border-color: #E63946;
      color: #E63946;
    }

    /* ─── MAIN CONTENT ───────────────────────── */
    .ss-main {
      margin-left: 240px;
      padding-top: 60px;
      min-height: 100vh;
    }
    .ss-content {
      padding: 28px;
    }

    /* ─── ADMIN CARDS & TABLES ───────────────── */
    .admin-card {
      background: #fff;
      border: 1px solid #E5E7EB;
      margin-bottom: 24px;
    }
    .admin-card-header {
      padding: 18px 24px;
      border-bottom: 1px solid #E5E7EB;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .admin-card-title {
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .08em;
      color: #1A1A1A;
      margin: 0;
    }
    .admin-card-body { padding: 24px; }

    .admin-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .admin-table thead th {
      padding: 11px 16px;
      background: #F9F8F6;
      color: #888;
      font-size: 10.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .1em;
      border-bottom: 1px solid #E5E7EB;
      text-align: left;
      white-space: nowrap;
    }
    .admin-table tbody td {
      padding: 13px 16px;
      border-bottom: 1px solid #F3F2EF;
      color: #1A1A1A;
      vertical-align: middle;
    }
    .admin-table tbody tr:last-child td { border-bottom: none; }
    .admin-table tbody tr:hover td { background: #FAFAF8; }

    /* ─── BADGES ─────────────────────────────── */
    .badge-on  { display:inline-flex;align-items:center;padding:3px 10px;background:#DCFCE7;color:#16A34A;font-size:11px;font-weight:600;letter-spacing:.04em; }
    .badge-off { display:inline-flex;align-items:center;padding:3px 10px;background:#FEF3C7;color:#D97706;font-size:11px;font-weight:600;letter-spacing:.04em; }
    .badge-info { display:inline-flex;align-items:center;padding:3px 10px;background:#EFF6FF;color:#2563EB;font-size:11px;font-weight:600; }
    .badge-red  { display:inline-flex;align-items:center;padding:3px 10px;background:#FEF2F2;color:#E63946;font-size:11px;font-weight:600; }

    /* ─── BUTTONS ────────────────────────────── */
    .btn-adm { display:inline-flex;align-items:center;gap:5px;padding:5px 13px;font-size:11.5px;font-weight:500;text-decoration:none;border:1px solid;cursor:pointer;transition:all .18s;letter-spacing:.02em;font-family:inherit; }
    .btn-adm-dark { background:#1A1A1A;border-color:#1A1A1A;color:#fff; }
    .btn-adm-dark:hover { background:#C9A96E;border-color:#C9A96E;color:#fff; }
    .btn-adm-gold { background:#C9A96E;border-color:#C9A96E;color:#fff; }
    .btn-adm-gold:hover { background:#A88948;border-color:#A88948;color:#fff; }
    .btn-adm-red { background:transparent;border-color:#E63946;color:#E63946; }
    .btn-adm-red:hover { background:#E63946;color:#fff; }
    .btn-adm-ghost { background:transparent;border-color:#E5E7EB;color:#6B7280; }
    .btn-adm-ghost:hover { border-color:#1A1A1A;color:#1A1A1A; }
    .btn-adm-green { background:transparent;border-color:#16A34A;color:#16A34A; }
    .btn-adm-green:hover { background:#16A34A;color:#fff; }

    /* ─── FORM ELEMENTS ──────────────────────── */
    .adm-label { display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.12em;color:#888;margin-bottom:6px; }
    .adm-input { width:100%;padding:10px 14px;border:1px solid #E5E7EB;background:#fff;font-size:13px;color:#1A1A1A;outline:none;transition:border-color .2s;font-family:inherit; }
    .adm-input:focus { border-color:#C9A96E; }
    .adm-err { font-size:12px;color:#E63946;margin-top:4px; }
    .adm-select { width:100%;padding:10px 14px;border:1px solid #E5E7EB;background:#fff;font-size:13px;color:#1A1A1A;outline:none;transition:border-color .2s;font-family:inherit;appearance:none; }
    .adm-select:focus { border-color:#C9A96E; }
    .adm-textarea { width:100%;padding:10px 14px;border:1px solid #E5E7EB;background:#fff;font-size:13px;color:#1A1A1A;outline:none;transition:border-color .2s;font-family:inherit;resize:vertical;min-height:90px; }
    .adm-textarea:focus { border-color:#C9A96E; }

    /* ─── STAT CARDS ─────────────────────────── */
    .stat-card {
      background: #fff;
      border: 1px solid #E5E7EB;
      padding: 24px;
    }
    .stat-card-icon {
      width: 42px; height: 42px;
      display: flex; align-items: center; justify-content: center;
      background: rgba(201,169,110,.1);
      color: #C9A96E;
      font-size: 18px;
      margin-bottom: 14px;
    }
    .stat-card-value {
      font-size: 28px;
      font-weight: 700;
      color: #1A1A1A;
      letter-spacing: -.02em;
      line-height: 1;
    }
    .stat-card-label {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #888;
      margin-top: 6px;
    }

    /* ─── PAGE HEADER ROW ────────────────────── */
    .page-header-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }
    .page-header-row h1 {
      font-size: 20px;
      font-weight: 700;
      color: #1A1A1A;
      margin: 0;
      letter-spacing: -.02em;
    }

    /* ─── ATTR CARD ──────────────────────────── */
    .attr-card {
      border: 1px solid #E5E7EB;
      padding: 20px;
      margin-bottom: 16px;
      background: #FAFAF8;
    }
    .attr-card-title {
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #888;
      margin-bottom: 16px;
    }
  </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="ss-sidebar">
  <div class="ss-sidebar-brand">
    <div class="brand-name">Stitch<span>Spot</span></div>
    <div class="brand-sub">Admin Panel</div>
  </div>

  <nav class="ss-nav">
    <div class="ss-nav-section">Main</div>
    <ul>
      <li class="@yield('dashboard_select')">
        <a href="{{url('admin/dashboard')}}">
          <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
      </li>
      <li class="@yield('order_select')">
        <a href="{{url('admin/order')}}">
          <i class="fa-solid fa-bag-shopping"></i> Orders
        </a>
      </li>
      <li class="@yield('tailor_order_select')">
        <a href="{{url('admin/tailor_order')}}">
          <i class="fa-solid fa-scissors"></i> Tailor Orders
        </a>
      </li>
      <li class="@yield('customer_select')">
        <a href="{{url('admin/customer')}}">
          <i class="fa-solid fa-users"></i> Customers
        </a>
      </li>
    </ul>

    <div class="ss-nav-section">Catalog</div>
    <ul>
      <li class="@yield('category_select')">
        <a href="{{url('admin/category')}}">
          <i class="fa-solid fa-shapes"></i> Category
        </a>
      </li>
      <li class="@yield('size_select')">
        <a href="{{url('admin/size')}}">
          <i class="fa-solid fa-ruler"></i> Size
        </a>
      </li>
      <li class="@yield('color_select')">
        <a href="{{url('admin/color')}}">
          <i class="fa-solid fa-palette"></i> Color
        </a>
      </li>
      <li class="@yield('brand_select')">
        <a href="{{url('admin/brand')}}">
          <i class="fa-solid fa-handshake"></i> Brand
        </a>
      </li>
      <li class="@yield('product_select')">
        <a href="{{url('admin/product')}}">
          <i class="fa-solid fa-shirt"></i> Product
        </a>
      </li>
      <li class="@yield('coupon_select')" style="display:none">
        <a href="{{url('admin/coupon')}}">
          <i class="fa-solid fa-ticket"></i> Coupon
        </a>
      </li>
      <li class="@yield('tax_select')" style="display:none">
        <a href="{{url('admin/tax')}}">
          <i class="fa-solid fa-percent"></i> Tax
        </a>
      </li>
    </ul>
  </nav>

  <div class="ss-sidebar-footer">
    <a href="{{url('/admin/logout')}}">
      <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
  </div>
</aside>

<!-- TOPBAR -->
<header class="ss-topbar">
  <span class="ss-topbar-title">@yield('page_title','Dashboard')</span>
  <div class="ss-topbar-right">
    <span class="ss-topbar-email">{{session()->get('admin_email')}}</span>
    <a class="ss-topbar-logout" href="{{url('/admin/logout')}}">
      <i class="fa-solid fa-right-from-bracket" style="font-size:11px"></i> Logout
    </a>
  </div>
</header>

<!-- MAIN -->
<main class="ss-main">
  <div class="ss-content">
    @yield('content')
  </div>
</main>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{asset('admin-assets/js/script.js')}}"></script>

<script>
  /* ── SS Toast ────────────────────────────── */
  window.SS=(function(){
    function _cont(){var c=document.getElementById('ss-tc');if(!c){c=document.createElement('div');c.id='ss-tc';c.style.cssText='position:fixed;top:20px;right:20px;z-index:99999;display:flex;flex-direction:column;gap:8px;pointer-events:none;';document.body.appendChild(c);}return c;}
    var _cfg={success:{b:'#C9A96E',bg:'#C9A96E',s:'✓'},error:{b:'#E63946',bg:'#E63946',s:'✕'},warning:{b:'#F59E0B',bg:'#F59E0B',s:'!'}};
    function toast(type,title,text,timer){timer=timer||3500;var c=_cfg[type]||_cfg.warning;var el=document.createElement('div');el.style.cssText='pointer-events:all;display:flex;align-items:flex-start;gap:10px;background:#fff;border-left:3px solid '+c.b+';box-shadow:0 4px 20px rgba(0,0,0,.12);padding:14px 14px;min-width:260px;max-width:340px;font-family:\'DM Sans\',sans-serif;opacity:0;transform:translateX(20px);transition:opacity .3s,transform .3s;position:relative;overflow:hidden;';el.innerHTML='<div style="width:22px;height:22px;border-radius:50%;background:'+c.bg+';color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0">'+c.s+'</div><div style="flex:1;min-width:0"><div style="font-size:13px;font-weight:600;color:#1A1A1A">'+title+'</div>'+(text?'<div style="font-size:12px;color:#888;margin-top:2px">'+text+'</div>':'')+'</div><button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;color:#ccc;font-size:18px;padding:0;flex-shrink:0">&times;</button><div style="position:absolute;bottom:0;left:0;height:2px;background:'+c.b+';width:100%;transition-property:width;transition-duration:'+timer+'ms;transition-timing-function:linear" class="ss-bar"></div>';_cont().appendChild(el);requestAnimationFrame(function(){requestAnimationFrame(function(){el.style.opacity='1';el.style.transform='translateX(0)';el.querySelector('.ss-bar').style.width='0%';});});setTimeout(function(){el.style.opacity='0';el.style.transform='translateX(20px)';setTimeout(function(){el&&el.remove();},300);},timer);}
    return{toast:toast};
  })();

  /* ── Legacy helpers ──────────────────────── */
  var count=0;
  function add_img(){
    count++;
    var html="<div class='add_image mt-3' id='img-"+count+"'><div class='row g-2'><div class='col-md-8'><input type='file' class='adm-input'></div><div class='col-md-4'><button class='btn-adm btn-adm-red' type='button' onclick='remove_img("+count+")'>Remove</button></div></div></div>";
    $('.img').append(html);
  }
  function remove_img(count){ $('#img-'+count).remove(); }

  function add_details(){
    count++;
    var html="<div class='attr-card mt-3' id='details-"+count+"'><div class='attr-card-title'>No-"+count+"</div><div class='row g-3'><div class='col-md-6'><label class='adm-label'>SKU</label><input type='text' class='adm-input'></div><div class='col-md-6'><label class='adm-label'>MRP</label><input type='text' class='adm-input'></div><div class='col-md-6'><label class='adm-label'>Price</label><input type='text' class='adm-input'></div><div class='col-md-6'><label class='adm-label'>Qty</label><input type='text' class='adm-input'></div></div><button class='btn-adm btn-adm-red mt-3' type='button' onclick='remove_details("+count+")'>Remove</button></div>";
    $('.details').append(html);
  }
  function remove_details(count){ $('#details-'+count).remove(); }
</script>

@if(session('message'))
  <script>document.addEventListener('DOMContentLoaded',function(){SS.toast('success',@json(session('message')),'',3500);});</script>
@endif
@if(session('error'))
  <script>document.addEventListener('DOMContentLoaded',function(){SS.toast('error',@json(session('error')),'',4000);});</script>
@endif

@yield('scripts')

</body>
</html>
