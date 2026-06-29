<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('title', 'StitchSpot – Fashion & Tailoring')</title>

   {{-- Google Fonts: Cormorant Garamond (display) + DM Sans (body) --}}
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

   {{-- Font Awesome --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   {{-- SweetAlert2 --}}
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
      body   { font-family: 'DM Sans', sans-serif !important; color: #1A1A1A; background: #fff; }
      h1,h2,h3,h4,h5,h6 { font-family: 'Cormorant Garamond', serif !important; }
      a      { text-decoration: none !important; color: inherit; }
      img    { object-fit: cover; }

      /* ── Kill legacy style.css nav/span overrides ── */
      header nav { background: transparent !important; background-color: transparent !important; padding: 0 !important; height: auto !important; width: auto !important; }
      header nav span { color: inherit !important; }
      header nav ul li { display: inline-flex !important; padding: 0 !important; margin: 0 !important; }

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
   <header class="sticky top-0 z-[1000] bg-white border-b border-gray-200">
      {{-- 3-column grid: Logo | Nav Center | Actions --}}
      <div class="max-w-[1280px] mx-auto px-4 lg:px-8 grid grid-cols-3 items-center h-16">

         {{-- ── COL 1: Logo ── --}}
         <div class="flex items-center">
            <a href="{{ url('/') }}" class="flex flex-col leading-none">
               <span class="font-display text-[24px] font-semibold text-[#1A1A1A] leading-none tracking-wide">
                  Stitch<span class="text-gold">Spot</span>
               </span>
               <span class="font-body text-[7.5px] tracking-[3.5px] uppercase text-gray-400 mt-[3px]">Fashion &amp; Tailoring</span>
            </a>
         </div>

         {{-- ── COL 2: Center Nav (desktop only) ── --}}
         <div class="hidden lg:flex items-center justify-center h-full">
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

         {{-- ── COL 3: Right Actions ── --}}
         <div class="flex items-center justify-end gap-1">

            @if(session()->get('IS_TAILOR') == 'yes')
               {{-- Tailor right icons --}}
               <a href="{{ url('/profile/' . $uid) }}" title="Profile"
                  class="hidden lg:flex w-9 h-9 items-center justify-center text-gray-500 hover:text-gold transition-colors">
                  <i class="fa-solid fa-circle-user text-[18px]"></i>
               </a>
               <a href="{{ url('/logout') }}" title="Logout"
                  class="hidden lg:flex w-9 h-9 items-center justify-center text-gray-500 hover:text-gold transition-colors">
                  <i class="fa-solid fa-right-from-bracket text-[17px]"></i>
               </a>

            @else
               {{-- Search icon (desktop → link to search) --}}
               <a href="{{ url('/search') }}" title="Search"
                  class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-gold transition-colors">
                  <i class="fa-solid fa-magnifying-glass text-[16px]"></i>
               </a>

               {{-- Cart --}}
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
                  <a href="{{ url('/profile/' . $uid) }}" title="My Account"
                     class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-gold transition-colors">
                     <i class="fa-solid fa-circle-user text-[18px]"></i>
                  </a>
                  <a href="{{ url('/logout') }}" title="Logout"
                     class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-gold transition-colors">
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

      {{-- ── Mobile menu ── --}}
      <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-md">
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
   <main class="min-h-[65vh]">
      @section('content')
      @show
   </main>

   {{-- ═══════════════════════════════
        FOOTER
   ═══════════════════════════════ --}}
   <footer class="bg-[#111111] text-white">
      <div class="max-w-[1280px] mx-auto px-6 lg:px-8 pt-16 pb-0">

         <div class="grid grid-cols-2 lg:grid-cols-4 gap-10 pb-14">

            {{-- Brand --}}
            <div class="col-span-2 lg:col-span-1">
               <a href="{{ url('/') }}">
                  <span class="font-display text-[24px] font-semibold text-white leading-none">
                     Stitch<span class="text-gold">Spot</span>
                  </span>
               </a>
               <p class="font-body text-[13px] text-white/40 leading-relaxed mt-4 max-w-[260px]">
                  Pakistan's premier fashion marketplace connecting customers with skilled tailors.
               </p>
               <div class="mt-5 space-y-2.5">
                  <div class="flex items-start gap-3">
                     <i class="fa-solid fa-location-dot text-gold text-xs mt-0.5 shrink-0"></i>
                     <span class="font-body text-[12.5px] text-white/40">University of Sargodha, Sargodha, Pakistan</span>
                  </div>
                  <div class="flex items-center gap-3">
                     <i class="fa-solid fa-phone text-gold text-xs shrink-0"></i>
                     <span class="font-body text-[12.5px] text-white/40">+92 300 456 3732</span>
                  </div>
                  <div class="flex items-center gap-3">
                     <i class="fa-solid fa-envelope text-gold text-xs shrink-0"></i>
                     <span class="font-body text-[12.5px] text-white/40">hello@stitchspot.pk</span>
                  </div>
               </div>
               <div class="flex gap-2.5 mt-5">
                  @foreach(['facebook-f','instagram','twitter','tiktok'] as $soc)
                  <a href="#" class="w-8 h-8 flex items-center justify-center border border-white/10 text-white/40 text-[12px] hover:border-gold hover:text-gold transition-all">
                     <i class="fa-brands fa-{{ $soc }}"></i>
                  </a>
                  @endforeach
               </div>
            </div>

            {{-- Quick Links --}}
            <div>
               <h5 class="font-display text-white text-[17px] font-semibold pb-2.5 mb-5 relative">
                  Quick Links
                  <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-gold block"></span>
               </h5>
               <ul class="space-y-2.5">
                  @foreach([['/', 'Home'],['/products','Products'],['/services','Our Services'],['/contact','Contact']] as [$u,$l])
                  <li>
                     <a href="{{ url($u) }}" class="flex items-center gap-2.5 font-body text-[13px] text-white/45 hover:text-gold transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-gold/40 shrink-0"></span>{{ $l }}
                     </a>
                  </li>
                  @endforeach
                  @if(!session()->has('FRONT_USER_LOGIN'))
                  <li>
                     <a href="{{ url('/registration') }}" class="flex items-center gap-2.5 font-body text-[13px] text-white/45 hover:text-gold transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-gold/40 shrink-0"></span>Register
                     </a>
                  </li>
                  @endif
               </ul>
            </div>

            {{-- Account --}}
            <div>
               <h5 class="font-display text-white text-[17px] font-semibold pb-2.5 mb-5 relative">
                  Account
                  <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-gold block"></span>
               </h5>
               <ul class="space-y-2.5">
                  @php
                     $accountLinks = session()->has('FRONT_USER_LOGIN')
                        ? [['/profile/'.$uid,'My Profile'],['/cart','My Cart'],['/customers_dashboard','Dashboard'],['/logout','Logout']]
                        : [['/login','Sign In'],['/registration','Register'],['/cart','My Cart']];
                  @endphp
                  @foreach($accountLinks as [$u,$l])
                  <li>
                     <a href="{{ url($u) }}" class="flex items-center gap-2.5 font-body text-[13px] text-white/45 hover:text-gold transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-gold/40 shrink-0"></span>{{ $l }}
                     </a>
                  </li>
                  @endforeach
               </ul>
            </div>

            {{-- Newsletter --}}
            <div>
               <h5 class="font-display text-white text-[17px] font-semibold pb-2.5 mb-5 relative">
                  Stay in the Loop
                  <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-gold block"></span>
               </h5>
               <p class="font-body text-[13px] text-white/40 leading-relaxed mb-4">
                  Get the latest trends, exclusive deals, and tailor spotlights.
               </p>
               <div class="flex">
                  <input type="email" placeholder="Your email address"
                     class="flex-1 h-11 bg-white/[.04] border border-white/10 text-white font-body text-[13px] px-4 outline-none placeholder-white/25 focus:border-gold/40 transition-colors">
                  <button type="button"
                     class="h-11 px-5 bg-gold text-[#1A1A1A] font-body font-bold text-[10px] tracking-[2px] uppercase hover:bg-gold-dk hover:text-white transition-all shrink-0 border-none cursor-pointer">
                     Subscribe
                  </button>
               </div>
               <p class="font-body text-[11px] text-white/20 mt-3">No spam, unsubscribe any time.</p>
            </div>

         </div>
      </div>

      {{-- Bottom bar --}}
      <div class="border-t border-white/[.06] bg-black/20">
         <div class="max-w-[1280px] mx-auto px-6 py-5 flex flex-wrap items-center justify-between gap-3">
            <span class="font-body text-[12px] text-white/25">
               © {{ date('Y') }} <a href="{{ url('/') }}" class="text-gold hover:text-white transition-colors">StitchSpot</a>. All rights reserved.
            </span>
            <span class="font-body text-[12px] text-white/25">
               Crafted with <i class="fa-solid fa-heart text-gold text-[10px]"></i> in Pakistan
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
      document.addEventListener('click', e => {
         if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            if (hamburger && !hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
               mobileMenu.classList.add('hidden');
               if (hamburgerIcon) hamburgerIcon.className = 'fa-solid fa-bars text-[18px]';
            }
         }
      });
   </script>

   @yield('scripts')

</body>
</html>
