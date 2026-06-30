<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title', 'StitchSpot – Fashion & Tailoring')</title>
   <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
   <link rel="shortcut icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

   {{-- Google Fonts: Cormorant Garamond (display) + DM Sans (body) --}}
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

   {{-- Font Awesome --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   {{-- StitchSpot Notification System --}}
   <style>
      #ss-toast-container{position:fixed;top:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:10px;pointer-events:none;}
      .ss-toast{pointer-events:all;display:flex;align-items:flex-start;gap:12px;background:#fff;box-shadow:0 8px 32px rgba(0,0,0,0.13);padding:15px 16px;min-width:280px;max-width:380px;font-family:'DM Sans',sans-serif;opacity:0;transform:translateX(30px);transition:opacity .3s,transform .3s;position:relative;overflow:hidden;}
      .ss-toast.ss-show{opacity:1;transform:translateX(0);}
      .ss-toast-icon{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;margin-top:1px;}
      .ss-toast-title{font-size:13px;font-weight:600;color:#1A1A1A;line-height:1.3;}
      .ss-toast-text{font-size:12px;color:#888;margin-top:3px;line-height:1.4;}
      .ss-toast-close{background:none;border:none;cursor:pointer;color:#ccc;font-size:19px;line-height:1;padding:0;flex-shrink:0;transition:color .2s;}
      .ss-toast-close:hover{color:#1A1A1A;}
      .ss-toast-bar{position:absolute;bottom:0;left:0;height:2px;transition-property:width;transition-timing-function:linear;}
      .ss-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.42);z-index:99998;display:flex;align-items:center;justify-content:center;font-family:'DM Sans',sans-serif;opacity:0;transition:opacity .25s;}
      .ss-overlay.ss-show{opacity:1;}
      .ss-modal{background:#fff;max-width:420px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.18);transform:translateY(16px);transition:transform .25s;}
      .ss-overlay.ss-show .ss-modal{transform:translateY(0);}
      .ss-btn{padding:10px 26px;border:none;font-family:'DM Sans',sans-serif;font-size:11.5px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;transition:background .2s,color .2s;}
      .ss-btn-primary{background:#1A1A1A;color:#fff;}.ss-btn-primary:hover{background:#C9A96E;}
      .ss-btn-gold{background:#C9A96E;color:#fff;}.ss-btn-gold:hover{background:#A88948;}
      .ss-btn-ghost{background:#fff;color:#666;border:1px solid #E5E5E5;}.ss-btn-ghost:hover{border-color:#999;color:#1A1A1A;}
      .ss-input{width:100%;padding:10px 14px;border:1px solid #E5E5E5;font-family:'DM Sans',sans-serif;font-size:13px;color:#1A1A1A;outline:none;box-sizing:border-box;transition:border-color .2s;}
      .ss-input:focus{border-color:#C9A96E;}
      .ss-input-label{font-size:10.5px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#888;display:block;margin-bottom:5px;}
   </style>
   <script>
   window.SS=(function(){
      function _cont(){var c=document.getElementById('ss-toast-container');if(!c){c=document.createElement('div');c.id='ss-toast-container';document.body.appendChild(c);}return c;}
      var _cfg={success:{border:'#C9A96E',bg:'#C9A96E',sym:'✓'},error:{border:'#E63946',bg:'#E63946',sym:'✕'},warning:{border:'#F59E0B',bg:'#F59E0B',sym:'!'},info:{border:'#3B82F6',bg:'#3B82F6',sym:'i'}};
      function toast(type,title,text,timer){
         timer=timer||3500;var c=_cfg[type]||_cfg.info;
         var el=document.createElement('div');el.className='ss-toast';el.style.borderLeft='3px solid '+c.border;
         el.innerHTML='<div class="ss-toast-icon" style="background:'+c.bg+';color:#fff">'+c.sym+'</div>'
            +'<div style="flex:1;min-width:0"><div class="ss-toast-title">'+title+'</div>'+(text?'<div class="ss-toast-text">'+text+'</div>':'')+'</div>'
            +'<button class="ss-toast-close">&times;</button>'
            +'<div class="ss-toast-bar" style="background:'+c.border+';width:100%;transition-duration:'+timer+'ms"></div>';
         _cont().appendChild(el);
         el.querySelector('.ss-toast-close').onclick=function(){clearTimeout(tid);_dismiss(el);};
         requestAnimationFrame(function(){requestAnimationFrame(function(){el.classList.add('ss-show');el.querySelector('.ss-toast-bar').style.width='0%';});});
         var tid=setTimeout(function(){_dismiss(el);},timer);
      }
      function _dismiss(el){el.classList.remove('ss-show');setTimeout(function(){el&&el.remove();},320);}
      function confirm(opts){
         return new Promise(function(resolve){
            var ic=({warning:{s:'!',c:'#F59E0B'},error:{s:'✕',c:'#E63946'},success:{s:'✓',c:'#C9A96E'}})[opts.type||'warning'];
            var ov=_mkOv('<div class="ss-modal" style="padding:36px;text-align:center">'
               +'<div style="width:60px;height:60px;border-radius:50%;background:'+ic.c+'1a;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:24px;font-weight:700;color:'+ic.c+'">'+ic.s+'</div>'
               +'<div style="font-size:18px;font-weight:600;color:#1A1A1A;margin-bottom:8px">'+(opts.title||'')+'</div>'
               +(opts.text?'<div style="font-size:13px;color:#888;margin-bottom:28px;line-height:1.6">'+(opts.text)+'</div>':'<div style="margin-bottom:28px"></div>')
               +'<div style="display:flex;gap:10px;justify-content:center">'
               +'<button class="ss-btn ss-btn-ghost ss-cancel">'+(opts.cancelText||'Cancel')+'</button>'
               +'<button class="ss-btn ss-btn-primary ss-ok">'+(opts.confirmText||'Confirm')+'</button>'
               +'</div></div>');
            function close(v){_closeOv(ov,function(){resolve(v);});}
            ov.querySelector('.ss-ok').onclick=function(){close(true);};
            ov.querySelector('.ss-cancel').onclick=function(){close(false);};
            ov.addEventListener('click',function(e){if(e.target===ov)close(false);});
         });
      }
      function formModal(opts){
         return new Promise(function(resolve){
            var fh=(opts.fields||[]).map(function(f){return '<div style="margin-bottom:12px">'+(f.label?'<label class="ss-input-label">'+f.label+'</label>':'')+'<input id="ssf_'+f.id+'" class="ss-input" type="'+(f.type||'text')+'" placeholder="'+(f.placeholder||'')+'"></div>';}).join('');
            var ov=_mkOv('<div class="ss-modal" style="padding:32px">'
               +'<div style="font-size:17px;font-weight:600;color:#1A1A1A;margin-bottom:22px">'+(opts.title||'')+'</div>'
               +fh
               +'<div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px">'
               +'<button class="ss-btn ss-btn-ghost ss-cancel">'+(opts.cancelText||'Cancel')+'</button>'
               +'<button class="ss-btn ss-btn-gold ss-ok">'+(opts.confirmText||'Submit')+'</button>'
               +'</div></div>');
            ov.querySelector('.ss-ok').onclick=function(){var v={};(opts.fields||[]).forEach(function(f){v[f.id]=ov.querySelector('#ssf_'+f.id).value;});_closeOv(ov,function(){resolve({confirmed:true,values:v});});};
            ov.querySelector('.ss-cancel').onclick=function(){_closeOv(ov,function(){resolve({confirmed:false});});};
         });
      }
      function alert(type,title,text){
         var ic=_cfg[type]||_cfg.info;
         var ov=_mkOv('<div class="ss-modal" style="padding:36px;text-align:center">'
            +'<div style="width:56px;height:56px;border-radius:50%;background:'+ic.bg+'1a;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;font-weight:700;color:'+ic.bg+'">'+ic.sym+'</div>'
            +'<div style="font-size:18px;font-weight:600;color:#1A1A1A;margin-bottom:8px">'+title+'</div>'
            +(text?'<div style="font-size:13px;color:#888;margin-bottom:24px;line-height:1.6">'+text+'</div>':'<div style="margin-bottom:24px"></div>')
            +'<button class="ss-btn ss-btn-primary ss-ok" style="min-width:100px">OK</button>'
            +'</div>');
         ov.querySelector('.ss-ok').onclick=function(){_closeOv(ov,null);};
         ov.addEventListener('click',function(e){if(e.target===ov)_closeOv(ov,null);});
      }
      function _mkOv(html){var ov=document.createElement('div');ov.className='ss-overlay';ov.innerHTML=html;document.body.appendChild(ov);requestAnimationFrame(function(){requestAnimationFrame(function(){ov.classList.add('ss-show');});});return ov;}
      function _closeOv(ov,cb){ov.classList.remove('ss-show');setTimeout(function(){ov&&ov.remove();if(cb)cb();},260);}
      return{toast:toast,confirm:confirm,formModal:formModal,alert:alert};
   })();
   </script>

   {{-- Tailwind CDN (JIT) --}}
   <script src="https://cdn.tailwindcss.com"></script>
   <script>
      tailwind.config = {
         theme: {
            extend: {
               fontFamily: {
                  display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                  body:    ['"DM Sans"', 'system-ui', 'sans-serif'],
               },
               colors: {
                  gold:       '#C9A96E',
                  'gold-dk':  '#A88948',
                  accent:     '#1A1A1A',
               },
               aspectRatio: {
                  fashion: '3 / 4',
               },
            }
         }
      }
   </script>

   {{-- Legacy styles for product-detail / cart / checkout pages --}}
   <link rel="stylesheet" href="{{ asset('front-assets/css/style.css') }}">

   <style>
      /* ── Global resets (beat style.css) ────────────── */
      *, *::before, *::after { box-sizing: border-box; }
      html, body { margin: 0 !important; padding: 0 !important; }
      body   { font-family: 'Roboto', sans-serif !important; color: #1A1A1A; background: #fff; }
      h1,h2,h3,h4,h5,h6 { font-family: 'Roboto', sans-serif !important; }
      a      { text-decoration: none !important; color: inherit; }
      img    { object-fit: cover; }
      footer { margin-bottom: 0 !important; padding-bottom: 0 !important; }

      /* ── Kill legacy style.css nav/span overrides ── */
      header nav { background: transparent !important; background-color: transparent !important; padding: 0 !important; height: auto !important; width: auto !important; }
      header nav span { color: inherit !important; }
      header nav ul li { display: inline-flex !important; padding: 0 !important; margin: 0 !important; }

      /* ── Kill style.css "form input" rule on search bar ── */
      #search-form input {
         padding: 0 !important;
         margin: 0 !important;
         border: none !important;
         background: transparent !important;
         width: auto !important;
         text-transform: none !important;
         line-height: normal !important;
      }

      /* ── Kill style.css red hover on Publish/submit buttons ── */
      form input[type="submit"].btn-complete {
         background-color: #1A1A1A !important;
         color: #fff !important;
         padding: 0 2.5rem !important;
         height: 44px !important;
         font-size: 11px !important;
         letter-spacing: 0.2em !important;
         text-transform: uppercase !important;
         margin: 0 !important;
         display: inline-flex !important;
         align-items: center !important;
         border: none !important;
         cursor: pointer !important;
         transition: background-color 0.2s !important;
      }
      form input[type="submit"].btn-complete:hover {
         background-color: #C9A96E !important;
         color: #fff !important;
      }

      /* ── Category nav bar (PHP helper outputs these classes) ── */
      .ss-cat-bar {
         background: #fff;
         border-bottom: 1px solid #E5E5E5;
      }
      .ss-nav-list {
         display: flex;
         list-style: none;
         margin: 0;
         padding: 0;
         gap: 0;
      }
      .ss-nav-item { position: relative; }
      .ss-nav-item > a {
         display: flex;
         align-items: center;
         gap: 4px;
         color: #666 !important;
         font-family: 'DM Sans', sans-serif !important;
         font-size: 11.5px;
         font-weight: 500;
         letter-spacing: 0.1em;
         text-transform: uppercase;
         padding: 12px 18px;
         border-bottom: 2px solid transparent;
         white-space: nowrap;
         transition: color .2s, border-color .2s;
         text-decoration: none !important;
      }
      .ss-nav-item > a:hover,
      .ss-nav-item:hover > a {
         color: #C9A96E !important;
         border-bottom-color: #C9A96E;
      }
      .ss-nav-sub {
         display: none;
         position: absolute;
         top: 100%;
         left: 0;
         background: #fff;
         border: 1px solid #E5E5E5;
         min-width: 200px;
         box-shadow: 0 8px 24px rgba(0,0,0,.07);
         padding: 8px 0;
         z-index: 1050;
         list-style: none;
         margin: 0;
      }
      .ss-nav-item:hover .ss-nav-sub { display: block; }
      .ss-nav-sub .ss-nav-item > a {
         padding: 9px 20px;
         border-bottom: none;
         font-size: 12px;
         color: #666 !important;
      }
      .ss-nav-sub .ss-nav-item > a:hover {
         color: #C9A96E !important;
         background: #FBF9F5;
      }

      /* ── CSS vars (keeps legacy pages working) ── */
      :root {
         --primary:    #1A1A1A;
         --accent:     #C9A96E;
         --accent-dark:#A88948;
         --nav-bg:     #FFFFFF;
         --footer-bg:  #111111;
         --light-bg:   #F9F8F6;
      }

      /* ── Child-page injected CSS ── */
      @yield('extra-css')
   </style>

   @yield('head')
</head>

<body class="bg-white text-[#1A1A1A]">

   <?php $uid = session()->get('FRONT_USER_LOGIN'); ?>

   {{-- ═══════════════════════════════
        ANNOUNCEMENT BAR
   ═══════════════════════════════ --}}
   <div class="bg-[#1A1A1A] text-white text-center py-[9px] px-4 font-body text-[10.5px] tracking-[0.2em] uppercase">
      Free shipping on orders over Rs 2,000 &nbsp;&middot;&nbsp; Use code <span class="text-gold font-medium">STITCH10</span> for 10% off
   </div>

   {{-- ═══════════════════════════════
        STICKY NAVBAR
   ═══════════════════════════════ --}}
   <header class="sticky top-0 z-[1200] bg-white border-b border-gray-200">
      {{-- Flex navbar: Logo | Nav Center | Actions --}}
      <div class="max-w-[1280px] mx-auto px-4 lg:px-8 flex items-center h-16">

         {{-- ── Logo ── --}}
         <div class="flex-none flex items-center">
            <a href="{{ url('/') }}" class="flex flex-col leading-none">
               <span class="font-display text-[24px] font-semibold text-[#1A1A1A] leading-none tracking-wide">
                  Stitch<span class="text-gold">Spot</span>
               </span>
               <span class="font-body text-[7.5px] tracking-[3.5px] uppercase text-gray-400 mt-[3px]">Fashion &amp; Tailoring</span>
            </a>
         </div>

         {{-- ── Center Nav (desktop only) ── --}}
         <div class="flex-1 hidden lg:flex items-center justify-center h-full">
            @if(session()->get('IS_TAILOR') == 'yes')
               {{-- Tailor links --}}
               <nav class="flex items-center h-full">
                  <a href="{{ url('/customers_dashboard') }}" class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Dashboard</a>
                  <a href="{{ url('/services') }}"            class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Services</a>
                  <a href="{{ url('/form') }}"                class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Add Service</a>
               </nav>
            @elseif(session()->has('FRONT_USER_LOGIN'))
               {{-- Logged-in customer links --}}
               <nav class="flex items-center h-full">
                  <a href="{{ url('/products') }}" class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Products</a>
                  <a href="{{ url('/services') }}" class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Services</a>
                  <a href="{{ url('/contact') }}"  class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Contact</a>
               </nav>
            @else
               {{-- Guest links --}}
               <nav class="flex items-center h-full">
                  <a href="{{ url('/products') }}" class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Products</a>
                  <a href="{{ url('/services') }}" class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Services</a>
                  <a href="{{ url('/contact') }}"  class="px-5 font-body text-[11.5px] tracking-[0.14em] uppercase text-gray-600 hover:text-gold h-full flex items-center border-b-2 border-transparent hover:border-gold transition-all duration-200">Contact</a>
               </nav>
            @endif
         </div>

         {{-- ── Right Actions ── --}}
         <div class="flex-none flex items-center justify-end gap-1 ml-auto">

            @if(session()->get('IS_TAILOR') == 'yes')
               {{-- Tailor right icons --}}
               <a href="{{ url('/profile/' . $uid) }}" title="Profile"
                  class="hidden lg:flex w-9 h-9 items-center justify-center overflow-hidden rounded-full border-2 border-transparent hover:border-gold transition-all">
                  @if(session()->get('FRONT_USER_IMAGE'))
                     <img src="{{ asset('storage/media/customer/'.session()->get('FRONT_USER_IMAGE')) }}"
                          alt="{{ session()->get('FRONT_USER_NAME') }}"
                          class="w-full h-full object-cover rounded-full"
                          onerror="this.onerror=null;this.parentElement.innerHTML='<i class=\'fa-solid fa-circle-user text-[22px] text-gray-500\'></i>'">
                  @else
                     <i class="fa-solid fa-circle-user text-[22px] text-gray-500"></i>
                  @endif
               </a>
               <a href="{{ url('/logout') }}" title="Logout"
                  class="hidden lg:flex w-9 h-9 items-center justify-center text-gray-500 hover:text-gold transition-colors">
                  <i class="fa-solid fa-right-from-bracket text-[17px]"></i>
               </a>

            @else
               {{-- Search icon (toggles dropdown) --}}
               <button id="search-toggle-btn" title="Search"
                  class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-[#C9A96E] transition-colors bg-transparent border-none cursor-pointer">
                  <i class="fa-solid fa-magnifying-glass text-[16px]"></i>
               </button>

               {{-- Wishlist: desktop only --}}
               @if(session()->has('FRONT_USER_LOGIN'))
               <a href="{{ url('/wishlist') }}" title="Wishlist"
                  class="relative hidden lg:flex w-9 h-9 items-center justify-center text-gray-500 hover:text-[#E63946] transition-colors">
                  <i class="fa-regular fa-heart text-[17px]"></i>
                  @if(total_wishlist_items() > 0)
                  <span class="absolute top-[3px] right-[2px] bg-[#E63946] text-white font-body font-bold text-[8px] min-w-[15px] h-[15px] rounded-full flex items-center justify-center px-[3px] leading-none">
                     {{ total_wishlist_items() }}
                  </span>
                  @endif
               </a>
               @endif

               {{-- Cart: always visible --}}
               <a href="{{ url('/cart') }}" title="Cart"
                  class="relative w-9 h-9 flex items-center justify-center text-gray-500 hover:text-gold transition-colors">
                  <i class="fa-solid fa-bag-shopping text-[18px]"></i>
                  @if(total_cart_items() > 0)
                  <span class="absolute top-[3px] right-[2px] bg-[#1A1A1A] text-white font-body font-bold text-[8px] min-w-[15px] h-[15px] rounded-full flex items-center justify-center px-[3px] leading-none">
                     {{ total_cart_items() }}
                  </span>
                  @endif
               </a>

               @if(session()->has('FRONT_USER_LOGIN'))
                  {{-- Profile avatar: desktop only --}}
                  <a href="{{ url('/profile/' . $uid) }}" title="My Account"
                     class="hidden lg:flex w-9 h-9 items-center justify-center overflow-hidden rounded-full border-2 border-transparent hover:border-gold transition-all">
                     @if(session()->get('FRONT_USER_IMAGE'))
                        <img src="{{ asset('storage/media/customer/'.session()->get('FRONT_USER_IMAGE')) }}"
                             alt="{{ session()->get('FRONT_USER_NAME') }}"
                             class="w-full h-full object-cover rounded-full"
                             onerror="this.onerror=null;this.parentElement.innerHTML='<i class=\'fa-solid fa-circle-user text-[22px] text-gray-500\'></i>'">
                     @else
                        <i class="fa-solid fa-circle-user text-[22px] text-gray-500 hover:text-gold transition-colors"></i>
                     @endif
                  </a>
                  {{-- Logout: desktop only --}}
                  <a href="{{ url('/logout') }}" title="Logout"
                     class="hidden lg:flex w-9 h-9 items-center justify-center text-gray-500 hover:text-gold transition-colors">
                     <i class="fa-solid fa-right-from-bracket text-[17px]"></i>
                  </a>
               @else
                  <a href="{{ url('/login') }}"
                     class="ml-2 hidden lg:inline-flex items-center bg-[#1A1A1A] text-white font-body text-[10px] font-medium tracking-[0.2em] uppercase px-5 h-8 hover:bg-gray-800 transition-colors">
                     Sign In
                  </a>
               @endif
            @endif

            {{-- Hamburger (mobile) --}}
            <button id="hamburger-btn" aria-label="Open menu"
               class="lg:hidden w-9 h-9 flex items-center justify-center text-gray-600 hover:text-gold transition-colors bg-transparent border-none cursor-pointer ml-1">
               <i id="hamburger-icon" class="fa-solid fa-bars text-[18px]"></i>
            </button>

         </div>
      </div>

      {{-- ── Search Dropdown ── --}}
      <div id="search-dropdown" class="hidden absolute top-full left-0 w-full bg-white border-b-2 border-[#F0EDE8] z-50" style="box-shadow:0 12px 40px rgba(0,0,0,0.08)">
         <div class="max-w-[1280px] mx-auto px-3 lg:px-8 py-4 lg:py-6 flex items-center gap-2 lg:gap-4">
            <form action="{{ url('search') }}" method="GET" class="flex-1 min-w-0 flex items-center h-[48px] lg:h-[56px] bg-[#F9F8F6] border border-gray-200 focus-within:border-[#C9A96E] transition-colors" id="search-form">
               <i class="fa-solid fa-magnifying-glass text-gray-400 text-[14px] px-3 shrink-0"></i>
               <input id="search-input" type="text" name="search_val" placeholder="Search products…"
                      class="flex-1 min-w-0 bg-transparent outline-none border-none font-body text-[13px] lg:text-[14px] text-[#1A1A1A] placeholder-gray-400">
               {{-- Mobile: icon-only submit; Desktop: text button --}}
              <button
  type="submit"
  class="shrink-0 h-full px-3 lg:px-7 bg-[#1A1A1A] !text-white hover:bg-[#C9A96E] transition-colors border-none cursor-pointer flex items-center justify-center"
>
  <i class="fa-solid fa-magnifying-glass text-[13px] lg:hidden !text-white"></i>
  <span class="hidden lg:inline font-body text-[10px] font-semibold tracking-[0.2em] uppercase !text-white">
    Search
  </span>
</button>
            </form>
            <button id="search-close-btn" type="button" title="Close"
               class="shrink-0 w-9 h-9 flex items-center justify-center text-gray-400 hover:text-[#1A1A1A] transition-colors bg-transparent border-none cursor-pointer text-[18px]">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>
      </div>

      {{-- ── Mobile menu ── --}}
      <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-md">

         {{-- User info strip at top of mobile menu --}}
         @if(session()->has('FRONT_USER_LOGIN'))
         <div class="flex items-center gap-3 px-6 py-4 bg-[#F9F8F6] border-b border-gray-100">
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gold/40 shrink-0">
               @if(session()->get('FRONT_USER_IMAGE'))
                  <img src="{{ asset('storage/media/customer/'.session()->get('FRONT_USER_IMAGE')) }}"
                       alt="{{ session()->get('FRONT_USER_NAME') }}"
                       class="w-full h-full object-cover"
                       onerror="this.onerror=null;this.outerHTML='<i class=\'fa-solid fa-circle-user text-[28px] text-gray-400\'></i>'">
               @else
                  <div class="w-full h-full bg-gold/10 flex items-center justify-center">
                     <i class="fa-solid fa-circle-user text-[22px] text-gold/60"></i>
                  </div>
               @endif
            </div>
            <div>
               <p class="font-body text-[13px] font-medium text-[#1A1A1A] leading-tight">{{ session()->get('FRONT_USER_NAME') }}</p>
               <p class="font-body text-[11px] text-gray-400 leading-tight">{{ session()->get('FRONT_USER_EMAIL') }}</p>
            </div>
         </div>
         @endif

         @if(session()->get('IS_TAILOR') == 'yes')
            <a href="{{ url('/customers_dashboard') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-gauge-high text-gold w-4 text-center text-sm"></i> Dashboard
            </a>
            <a href="{{ url('/services') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-scissors text-gold w-4 text-center text-sm"></i> Our Services
            </a>
            @if(session()->has('FRONT_USER_LOGIN'))
            <a href="{{ url('/profile/' . $uid) }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-circle-user text-gold w-4 text-center text-sm"></i> My Profile
            </a>
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 transition-colors">
               <i class="fa-solid fa-right-from-bracket text-gold w-4 text-center text-sm"></i> Logout
            </a>
            @endif
         @else
            <a href="{{ url('/') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-house text-gold w-4 text-center text-sm"></i> Home
            </a>
            <a href="{{ url('/products') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-shirt text-gold w-4 text-center text-sm"></i> Products
            </a>
            <a href="{{ url('/services') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-scissors text-gold w-4 text-center text-sm"></i> Our Services
            </a>
            <a href="{{ url('/cart') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-bag-shopping text-gold w-4 text-center text-sm"></i> My Cart
               @if(total_cart_items() > 0)
               <span class="ml-1 bg-gold text-white font-body font-bold text-[9px] px-2 py-0.5 rounded-full">{{ total_cart_items() }}</span>
               @endif
            </a>
            <a href="{{ url('/contact') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-envelope text-gold w-4 text-center text-sm"></i> Contact
            </a>
            @if(session()->has('FRONT_USER_LOGIN'))
            <a href="{{ url('/wishlist') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-regular fa-heart text-gold w-4 text-center text-sm"></i> My Wishlist
               @if(total_wishlist_items() > 0)
               <span class="ml-1 bg-[#E63946] text-white font-body font-bold text-[9px] px-2 py-0.5 rounded-full">{{ total_wishlist_items() }}</span>
               @endif
            </a>
            <a href="{{ url('/profile/' . $uid) }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 border-b border-gray-50 transition-colors">
               <i class="fa-solid fa-circle-user text-gold w-4 text-center text-sm"></i> My Account
            </a>
            <a href="{{ url('/logout') }}" class="flex items-center gap-3 px-6 py-[14px] font-body text-[13px] text-gray-600 hover:text-gold hover:bg-gray-50 transition-colors">
               <i class="fa-solid fa-right-from-bracket text-gold w-4 text-center text-sm"></i> Logout
            </a>
            @else
            <div class="px-6 py-4">
               <a href="{{ url('/login') }}" class="flex items-center justify-center gap-2 w-full bg-[#1A1A1A] text-white font-body font-medium text-[11px] tracking-[0.2em] uppercase py-3 hover:bg-gray-800 transition-colors">
                  <i class="fa-solid fa-right-to-bracket text-xs"></i> Sign In
               </a>
            </div>
            @endif
         @endif
      </div>
   </header>

   {{-- ═══════════════════════════════
        CATEGORY NAV BAR (desktop)
   ═══════════════════════════════ --}}
   @if(session()->get('IS_TAILOR') != 'yes')
   @php $catNav = getTopNavCat(); @endphp
   @if(trim($catNav) !== '')
   <nav class="hidden lg:block ss-cat-bar">
      <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
         {!! $catNav !!}
      </div>
   </nav>
   @endif
   @endif

   {{-- ═══════════════════════════════
        PAGE CONTENT
   ═══════════════════════════════ --}}
   <main>
      @section('content')
      @show
   </main>

   {{-- ═══════════════════════════════
        FOOTER
   ═══════════════════════════════ --}}
   <footer class="bg-[#0F0F0F] text-white">

      {{-- Gold top accent bar --}}
      <div class="h-[3px] bg-gradient-to-r from-transparent via-gold to-transparent"></div>

      <div class="max-w-[1280px] mx-auto px-6 lg:px-8 py-12">
         <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Brand --}}
            <div>
               <a href="{{ url('/') }}" class="inline-block mb-4">
                  <span class="font-display text-[22px] font-semibold text-white leading-none">
                     Stitch<span class="text-gold">Spot</span>
                  </span>
               </a>
               <p class="font-body text-[12.5px] text-white/35 leading-relaxed mb-5">
                  Pakistan's premier fashion marketplace connecting customers with skilled tailors.
               </p>
               <div class="space-y-2 mb-5">
                  <div class="flex items-start gap-2.5">
                     <i class="fa-solid fa-location-dot text-gold text-[11px] mt-0.5 shrink-0"></i>
                     <span class="font-body text-[12px] text-white/35">University of Sargodha, Pakistan</span>
                  </div>
                  <div class="flex items-center gap-2.5">
                     <i class="fa-solid fa-phone text-gold text-[11px] shrink-0"></i>
                     <span class="font-body text-[12px] text-white/35">+92 300 456 3732</span>
                  </div>
                  <div class="flex items-center gap-2.5">
                     <i class="fa-solid fa-envelope text-gold text-[11px] shrink-0"></i>
                     <span class="font-body text-[12px] text-white/35">hello@stitchspot.pk</span>
                  </div>
               </div>
               <div class="flex gap-2">
                  @foreach(['facebook-f','instagram','twitter','tiktok'] as $soc)
                  <a href="#" class="w-8 h-8 flex items-center justify-center border border-white/10 text-white/35 text-[11px] hover:border-gold hover:text-gold transition-all">
                     <i class="fa-brands fa-{{ $soc }}"></i>
                  </a>
                  @endforeach
               </div>
            </div>

            {{-- Quick Links --}}
            <div>
               <h5 class="font-body text-[11px] font-semibold tracking-[3px] uppercase text-gold mb-5">Quick Links</h5>
               <ul class="space-y-3">
                  @foreach([['/', 'Home'],['/products','Products'],['/services','Our Services'],['/contact','Contact']] as [$u,$l])
                  <li>
                     <a href="{{ url($u) }}" class="font-body text-[13px] text-white/40 hover:text-gold hover:pl-1 transition-all">{{ $l }}</a>
                  </li>
                  @endforeach
               </ul>
            </div>

            {{-- Account --}}
            <div>
               <h5 class="font-body text-[11px] font-semibold tracking-[3px] uppercase text-gold mb-5">My Account</h5>
               <ul class="space-y-3">
                  @php
                     $accountLinks = session()->has('FRONT_USER_LOGIN')
                        ? [['/profile/'.$uid,'My Profile'],['/wishlist','My Wishlist'],['/cart','My Cart'],['/logout','Logout']]
                        : [['/login','Sign In'],['/registration','Register'],['/cart','My Cart']];
                  @endphp
                  @foreach($accountLinks as [$u,$l])
                  <li>
                     <a href="{{ url($u) }}" class="font-body text-[13px] text-white/40 hover:text-gold hover:pl-1 transition-all">{{ $l }}</a>
                  </li>
                  @endforeach
               </ul>
            </div>

            {{-- Newsletter --}}
            <div>
               <h5 class="font-body text-[11px] font-semibold tracking-[3px] uppercase text-gold mb-5">Newsletter</h5>
               <p class="font-body text-[12.5px] text-white/35 leading-relaxed mb-4">
                  Exclusive deals, new arrivals &amp; tailor spotlights — straight to your inbox.
               </p>
               <div class="flex">
                  <input type="email" placeholder="Your email address"
                     class="flex-1 min-w-0 h-10 bg-white/[.04] border border-white/10 text-white font-body text-[12px] px-3 outline-none placeholder-white/20 focus:border-gold/50 transition-colors">
                  <button type="button"
                     class="h-10 px-4 bg-gold text-[#0F0F0F] font-body font-bold text-[10px] tracking-[1.5px] uppercase hover:bg-white transition-all shrink-0 border-none cursor-pointer">
                     Go
                  </button>
               </div>
               <p class="font-body text-[10.5px] text-white/20 mt-2">No spam. Unsubscribe anytime.</p>
            </div>

         </div>
      </div>

      {{-- Bottom bar --}}
      <div class="border-t border-white/[.06]">
         <div class="max-w-[1280px] mx-auto px-6 py-4 flex flex-wrap items-center justify-between gap-2">
            <span class="font-body text-[11.5px] text-white/20">
               © {{ date('Y') }} <a href="{{ url('/') }}" class="text-gold/70 hover:text-gold transition-colors">StitchSpot</a>. All rights reserved.
            </span>
            <span class="font-body text-[11.5px] text-white/20">
               Crafted with <i class="fa-solid fa-heart text-gold/70 text-[9px]"></i> in Pakistan
            </span>
         </div>
      </div>

   </footer>

   {{-- ═══════════════════════════════
        SCRIPTS
   ═══════════════════════════════ --}}
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script src="{{ asset('front-assets/js/script.js') }}"></script>

   <script>
      /* Hamburger toggle */
      const hamburger    = document.getElementById('hamburger-btn');
      const mobileMenu   = document.getElementById('mobile-menu');
      const hamburgerIcon = document.getElementById('hamburger-icon');

      if (hamburger) {
         hamburger.addEventListener('click', e => {
            e.stopPropagation();
            const open = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden', open);
            hamburgerIcon.className = open
               ? 'fa-solid fa-bars text-[18px]'
               : 'fa-solid fa-xmark text-[18px]';
         });
      }

      /* Search toggle */
      const searchBtn      = document.getElementById('search-toggle-btn');
      const searchDropdown = document.getElementById('search-dropdown');
      const searchInput    = document.getElementById('search-input');
      const searchCloseBtn = document.getElementById('search-close-btn');

      function openSearch() {
         searchDropdown.classList.remove('hidden');
         searchInput && searchInput.focus();
      }
      function closeSearch() {
         searchDropdown.classList.add('hidden');
      }

      if (searchBtn)      searchBtn.addEventListener('click',      e => { e.stopPropagation(); searchDropdown.classList.contains('hidden') ? openSearch() : closeSearch(); });
      if (searchCloseBtn) searchCloseBtn.addEventListener('click', e => { e.stopPropagation(); closeSearch(); });
      if (searchDropdown) searchDropdown.addEventListener('click', e => e.stopPropagation());

      document.addEventListener('click', e => {
         // Close mobile menu
         if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            if (hamburger && !hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
               mobileMenu.classList.add('hidden');
               if (hamburgerIcon) hamburgerIcon.className = 'fa-solid fa-bars text-[18px]';
            }
         }
         // Close search dropdown
         if (searchDropdown && !searchDropdown.classList.contains('hidden')) {
            if (searchBtn && !searchBtn.contains(e.target)) {
               searchDropdown.classList.add('hidden');
            }
         }
      });
   </script>

   {{-- ── Global Flash Alerts ── --}}
   <script>
      @if(session('msg'))
         SS.toast('success', @json(session('msg')), '', 3500);
      @endif
      @if(session('cart_msg'))
         @php $cmsg = session('cart_msg'); $cicon = (str_contains(strtolower($cmsg),'error') || str_contains(strtolower($cmsg),'please')) ? 'warning' : 'success'; @endphp
         SS.toast('{{ $cicon }}', @json($cmsg), '', 3500);
      @endif
      @if(session('success'))
         SS.toast('success', @json(session('success')), '', 3500);
      @endif
      @if(session('error'))
         SS.toast('error', @json(session('error')), '', 4000);
      @endif
   </script>

   @yield('scripts')

</body>
</html>
