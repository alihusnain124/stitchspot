<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Sign In – StitchSpot</title>

   {{-- Fonts --}}
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

   {{-- Font Awesome --}}
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

   {{-- SweetAlert2 --}}
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   {{-- jQuery --}}
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

   {{-- Tailwind CDN --}}
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
                  gold: '#C9A96E',
               },
            }
         }
      }
   </script>
   <style>
      *, *::before, *::after { box-sizing: border-box; }
      body   { font-family: 'DM Sans', sans-serif; }
      h1,h2,h3 { font-family: 'Cormorant Garamond', serif; }
      a      { text-decoration: none !important; color: inherit !important; }
      input  { outline: none; }
      input:focus { outline: none; }
   </style>
</head>

<body class="bg-[#F5F4F2] min-h-screen flex items-center justify-center p-4">

   <div class="w-full max-w-5xl bg-white flex overflow-hidden shadow-[0_4px_48px_rgba(0,0,0,.08)]" style="min-height:580px">

      {{-- ── LEFT: Editorial image panel ──────────────── --}}
      <div class="hidden lg:block lg:w-[48%] relative overflow-hidden">
         <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=1000&q=80"
              alt="Fashion editorial"
              class="w-full h-full object-cover object-center">
         <div class="absolute inset-0 bg-black/52 flex flex-col justify-end p-14">
            <h2 class="font-display text-white text-[38px] lg:text-[44px] font-semibold leading-tight mb-4">
               "Dress for the story<br>you want to tell."
            </h2>
            <p class="font-body text-white/45 text-[11px] tracking-[4px] uppercase">StitchSpot &mdash; Fashion &amp; Tailoring</p>
         </div>
      </div>

      {{-- ── RIGHT: Form panel ──────────────────────── --}}
      <div class="flex-1 flex flex-col justify-center px-8 lg:px-14 py-12">
         <div class="w-full max-w-sm mx-auto">

            {{-- Back link --}}
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-body text-[11px] tracking-[0.18em] uppercase text-gray-400 hover:text-[#1A1A1A] mb-10 transition-colors">
               <i class="fa-solid fa-arrow-left text-[9px]"></i> Back to Store
            </a>

            {{-- Logo --}}
            <div class="mb-9">
               <span class="font-display text-[28px] font-semibold text-[#1A1A1A]">
                  Stitch<span class="text-gold">Spot</span>
               </span>
            </div>

            {{-- Heading --}}
            <h1 class="font-display text-[38px] font-semibold text-[#1A1A1A] leading-none mb-2">Welcome Back</h1>
            <p class="font-body text-sm text-gray-400 mb-9">Sign in to your account to continue.</p>

            {{-- Form --}}
            <form id="login_form" class="space-y-5">
               @csrf

               {{-- Email --}}
               <div>
                  <label class="block font-body text-[10px] tracking-[0.15em] uppercase text-gray-500 mb-2">Email</label>
                  <input type="email" name="login_email" placeholder="you@example.com"
                     class="w-full border border-gray-300 px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                     required>
               </div>

               {{-- Password --}}
               <div>
                  <div class="flex items-center justify-between mb-2">
                     <label class="font-body text-[10px] tracking-[0.15em] uppercase text-gray-500">Password</label>
                     <a href="#" class="font-body text-[11px] text-gray-400 hover:text-[#1A1A1A] underline underline-offset-2 transition-colors">Forgot password?</a>
                  </div>
                  <div class="relative">
                     <input type="password" name="login_password" id="login_password" placeholder="••••••••"
                        class="w-full border border-gray-300 px-4 py-3 pr-11 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                        required>
                     <button type="button" onclick="togglePwd('login_password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#1A1A1A] transition-colors bg-transparent border-none cursor-pointer p-0.5">
                        <i class="fa-regular fa-eye text-[14px]"></i>
                     </button>
                  </div>
               </div>

               {{-- Error message --}}
               <div class="login_error font-body text-sm text-red-500 text-center min-h-[20px]"></div>

               {{-- Submit --}}
               <button type="submit" id="login_btn"
                  class="w-full bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.22em] uppercase py-[15px] hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 border-none cursor-pointer">
                  Sign In &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>
               </button>
            </form>

            {{-- Divider --}}
            <div class="my-7 flex items-center gap-4">
               <div class="flex-1 border-t border-gray-200"></div>
               <span class="font-body text-[11px] text-gray-400">or</span>
               <div class="flex-1 border-t border-gray-200"></div>
            </div>

            {{-- Register link --}}
            <p class="font-body text-center text-[13px] text-gray-400">
               Don't have an account?
               <a href="{{ url('/registration') }}" class="text-[#1A1A1A] font-medium underline underline-offset-2 hover:text-gold transition-colors">Create Account</a>
            </p>

         </div>
      </div>

   </div>

   <script>
      function togglePwd(id, btn) {
         const input = document.getElementById(id);
         const icon  = btn.querySelector('i');
         if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fa-regular fa-eye-slash text-[14px]';
         } else {
            input.type = 'password';
            icon.className = 'fa-regular fa-eye text-[14px]';
         }
      }

      jQuery('#login_form').submit(function(e) {
         e.preventDefault();
         jQuery('.login_error').html('');
         const btn = jQuery('#login_btn');
         btn.html('<i class="fa-solid fa-spinner fa-spin"></i>&nbsp; Signing in…').prop('disabled', true);

         jQuery.ajax({
            url:  '/login_process',
            data: jQuery('#login_form').serialize(),
            type: 'post',
            success: function(result) {
               if (result.error) {
                  Swal.fire({ title: 'Oops…', text: result.error, icon: 'warning' });
                  btn.html('Sign In &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>').prop('disabled', false);
               } else {
                  Swal.fire({ title: 'Welcome back!', text: result.msg, icon: 'success', timer: 1500, showConfirmButton: false });
                  setTimeout(() => { window.location.href = '/'; }, 1600);
               }
            },
            error: function() {
               btn.html('Sign In &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>').prop('disabled', false);
               jQuery('.login_error').html('Something went wrong. Please try again.');
            }
         });
      });
   </script>

</body>
</html>
