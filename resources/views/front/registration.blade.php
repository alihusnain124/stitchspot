<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>Create Account – StitchSpot</title>

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <script src="https://cdn.tailwindcss.com"></script>
   <script>
      tailwind.config = {
         theme: {
            extend: {
               fontFamily: {
                  display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                  body:    ['"DM Sans"', 'system-ui', 'sans-serif'],
               },
               colors: { gold: '#C9A96E', 'gold-dk': '#A88948' },
            }
         }
      }
   </script>
   <style>
      *, *::before, *::after { box-sizing: border-box; }
      body   { font-family: 'DM Sans', sans-serif; }
      h1,h2,h3 { font-family: 'Cormorant Garamond', serif; }
      a      { text-decoration: none !important; color: inherit; }
      input, select, textarea { outline: none; }
      .field_error { color: #EF4444; font-size: 11.5px; margin-top: 4px; display: block; }
      .pwd-rule { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #9CA3AF; }
      .pwd-rule.ok { color: #22C55E; }
      .pwd-rule i  { font-size: 10px; }

      /* Step transition */
      .step { display: none; }
      .step.active { display: block; }

      /* Image panel quote swap */
      .img-quote { transition: opacity .4s ease; }
   </style>
   <style>
      #ss-toast-container{position:fixed;top:24px;right:24px;z-index:99999;display:flex;flex-direction:column;gap:10px;pointer-events:none;}
      .ss-toast{pointer-events:all;display:flex;align-items:flex-start;gap:12px;background:#fff;box-shadow:0 8px 32px rgba(0,0,0,0.13);padding:15px 16px;min-width:280px;max-width:380px;font-family:'DM Sans',sans-serif;opacity:0;transform:translateX(30px);transition:opacity .3s,transform .3s;position:relative;overflow:hidden;}
      .ss-toast.ss-show{opacity:1;transform:translateX(0);}
      .ss-toast-bar{position:absolute;bottom:0;left:0;height:2px;transition-property:width;transition-timing-function:linear;}
   </style>
   <script>
   window.SS=(function(){
      function _cont(){var c=document.getElementById('ss-toast-container');if(!c){c=document.createElement('div');c.id='ss-toast-container';document.body.appendChild(c);}return c;}
      var _cfg={success:{border:'#C9A96E',bg:'#C9A96E',sym:'✓'},error:{border:'#E63946',bg:'#E63946',sym:'✕'},warning:{border:'#F59E0B',bg:'#F59E0B',sym:'!'}};
      function toast(type,title,text,timer){
         timer=timer||3500;var c=_cfg[type]||_cfg.warning;
         var el=document.createElement('div');el.className='ss-toast';el.style.borderLeft='3px solid '+c.border;
         el.innerHTML='<div style="width:24px;height:24px;border-radius:50%;background:'+c.bg+';color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0">'+c.sym+'</div>'
            +'<div style="flex:1;min-width:0"><div style="font-size:13px;font-weight:600;color:#1A1A1A;line-height:1.3">'+title+'</div>'+(text?'<div style="font-size:12px;color:#888;margin-top:3px">'+text+'</div>':'')+'</div>'
            +'<button onclick="this.closest(\'.ss-toast\').remove()" style="background:none;border:none;cursor:pointer;color:#ccc;font-size:19px;line-height:1;padding:0;flex-shrink:0">&times;</button>'
            +'<div class="ss-toast-bar" style="background:'+c.border+';width:100%;transition-duration:'+timer+'ms"></div>';
         _cont().appendChild(el);
         requestAnimationFrame(function(){requestAnimationFrame(function(){el.classList.add('ss-show');el.querySelector('.ss-toast-bar').style.width='0%';});});
         setTimeout(function(){el.classList.remove('ss-show');setTimeout(function(){el&&el.remove();},320);},timer);
      }
      return{toast:toast};
   })();
   </script>
</head>

<body class="bg-[#F5F4F2] min-h-screen flex items-center justify-center py-8 px-4">

<div class="w-full max-w-5xl bg-white flex overflow-hidden shadow-[0_4px_48px_rgba(0,0,0,.08)]" style="min-height:640px">

   {{-- ── LEFT: Editorial image panel ────────────────── --}}
   <div class="hidden lg:block lg:w-[44%] relative" style="min-height:640px">
      <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=1000&q=80"
           alt="Fashion editorial"
           class="absolute inset-0 w-full h-full object-cover object-top">
      <div class="absolute inset-0 bg-black/52 flex flex-col justify-end p-14">

         {{-- Step 1 quote --}}
         <div id="quote-step1" class="img-quote">
            <h2 class="font-display text-white text-[38px] font-semibold leading-tight mb-4">
               "Your style.<br>Your story.<br>Starts here."
            </h2>
            <p class="font-body text-white/45 text-[11px] tracking-[4px] uppercase mb-8">Join StitchSpot Today</p>
            <div class="w-8 h-0.5 bg-gold"></div>
         </div>

         {{-- Step 2 quote --}}
         <div id="quote-step2" class="img-quote" style="display:none">
            <h2 class="font-display text-white text-[38px] font-semibold leading-tight mb-4">
               "One more step<br>to your<br>perfect fit."
            </h2>
            <p class="font-body text-white/45 text-[11px] tracking-[4px] uppercase mb-8">Almost There</p>
            <div class="w-8 h-0.5 bg-gold"></div>
         </div>

      </div>
   </div>

   {{-- ── RIGHT: Form panel ───────────────────────────── --}}
   <div class="flex-1 flex flex-col px-8 lg:px-12 py-10 overflow-y-auto max-h-screen">

      {{-- Top bar --}}
      <div class="flex items-center justify-between mb-8">
         <a href="{{ url('/') }}" class="inline-flex items-center gap-2 font-body text-[11px] tracking-[0.18em] uppercase text-gray-400 hover:text-[#1A1A1A] transition-colors">
            <i class="fa-solid fa-arrow-left text-[9px]"></i> Back
         </a>
         <span class="font-body text-[13px] text-gray-400">
            Already a member?
            <a href="{{ url('/login') }}" class="text-[#1A1A1A] font-medium underline underline-offset-2 hover:text-gold transition-colors">Sign in</a>
         </span>
      </div>

      {{-- Logo --}}
      <span class="font-display text-[26px] font-semibold text-[#1A1A1A] block mb-6">
         Stitch<span class="text-gold">Spot</span>
      </span>

      {{-- Step indicator --}}
      <div class="flex items-center gap-3 mb-8">
         <div class="flex items-center gap-2">
            <div id="dot1" class="w-7 h-7 rounded-full bg-[#1A1A1A] text-white font-body text-[11px] font-semibold flex items-center justify-center transition-colors">1</div>
            <span id="label1" class="font-body text-[11px] tracking-[0.12em] uppercase text-[#1A1A1A] font-medium transition-colors">Account</span>
         </div>
         <div class="flex-1 h-px bg-gray-200 mx-1"></div>
         <div class="flex items-center gap-2">
            <div id="dot2" class="w-7 h-7 rounded-full bg-gray-200 text-gray-400 font-body text-[11px] font-semibold flex items-center justify-center transition-colors">2</div>
            <span id="label2" class="font-body text-[11px] tracking-[0.12em] uppercase text-gray-400 font-medium transition-colors">Profile</span>
         </div>
      </div>

      {{-- ONE form, two visible sections --}}
      <form id="reg_form" method="POST" enctype="multipart/form-data" class="flex-1">
         @csrf

         {{-- ═══════════ STEP 1 ═══════════ --}}
         <div class="step active" id="step1">
            <h1 class="font-display text-[34px] font-semibold text-[#1A1A1A] leading-none mb-1">Create Account</h1>
            <p class="font-body text-sm text-gray-400 mb-7">Fill in your basic details to get started.</p>

            <div class="space-y-4">

               <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Full Name <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-solid fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="text" name="name" id="s1_name" placeholder="Your full name"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                           oninput="clearErr('name_error')">
                     </div>
                     <span class="field_error" id="name_error"></span>
                  </div>
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Email <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="email" name="email" id="s1_email" placeholder="you@example.com"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                           oninput="clearErr('email_error')">
                     </div>
                     <span class="field_error" id="email_error"></span>
                  </div>
               </div>

               <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Mobile <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-solid fa-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="text" name="mobile" id="s1_mobile" placeholder="+92 300 000 0000"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                           oninput="clearErr('mobile_error')">
                     </div>
                     <span class="field_error" id="mobile_error"></span>
                  </div>
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Address <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-solid fa-location-dot absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <input type="text" name="address" id="s1_address" placeholder="City, Province"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                           oninput="clearErr('address_error')">
                     </div>
                     <span class="field_error" id="address_error"></span>
                  </div>
               </div>

               <div>
                  <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Password <span class="text-gold">*</span></label>
                  <div class="relative">
                     <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                     <input type="password" name="password" id="reg_password" placeholder="Min. 8 characters"
                        class="w-full border border-gray-200 pl-9 pr-10 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
                        oninput="checkPwd(this.value); clearErr('password_error')">
                     <button type="button" onclick="togglePwd('reg_password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-[#1A1A1A] transition-colors bg-transparent border-none cursor-pointer p-0.5">
                        <i class="fa-regular fa-eye text-[13px]"></i>
                     </button>
                  </div>
                  <span class="field_error" id="password_error"></span>
                  <div class="flex flex-col gap-1 mt-2 pl-1">
                     <div class="pwd-rule" id="rule-len"><i class="fa-solid fa-circle"></i> At least 8 characters</div>
                     <div class="pwd-rule" id="rule-num"><i class="fa-solid fa-circle"></i> At least one number (0–9)</div>
                     <div class="pwd-rule" id="rule-case"><i class="fa-solid fa-circle"></i> Uppercase (A-Z) and lowercase (a-z)</div>
                  </div>
               </div>

               {{-- Next button --}}
               <button type="button" onclick="goToStep2()"
                  class="w-full bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.22em] uppercase py-[15px] hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 border-none cursor-pointer mt-2">
                  Continue &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>
               </button>

               <p class="font-body text-center text-[13px] text-gray-400 pb-2">
                  Already have an account?
                  <a href="{{ url('/login') }}" class="text-[#1A1A1A] font-medium underline underline-offset-2 hover:text-gold transition-colors">Sign in</a>
               </p>

            </div>
         </div>

         {{-- ═══════════ STEP 2 ═══════════ --}}
         <div class="step" id="step2">
            <h1 class="font-display text-[34px] font-semibold text-[#1A1A1A] leading-none mb-1">Your Profile</h1>
            <p class="font-body text-sm text-gray-400 mb-7">Almost done — tell us a bit about yourself.</p>

            <div class="space-y-4">

               {{-- Role selection (prominent, at top) --}}
               <div>
                  <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">
                     Joining as <span class="text-gold">*</span>
                  </label>
                  <div class="grid grid-cols-2 gap-3">
                     <label id="role-customer"
                        class="role-card flex flex-col items-center gap-2 p-4 border-2 border-gray-200 cursor-pointer transition-all hover:border-[#1A1A1A]">
                        <i class="fa-solid fa-bag-shopping text-xl text-gray-400"></i>
                        <span class="font-body text-[12px] font-medium text-[#1A1A1A]">Customer</span>
                        <span class="font-body text-[10.5px] text-gray-400 text-center">Shop &amp; order products</span>
                        <input type="radio" name="tailor" value="no" class="hidden" onclick="selectRole('customer')">
                     </label>
                     <label id="role-tailor"
                        class="role-card flex flex-col items-center gap-2 p-4 border-2 border-gray-200 cursor-pointer transition-all hover:border-[#1A1A1A]">
                        <i class="fa-solid fa-scissors text-xl text-gray-400"></i>
                        <span class="font-body text-[12px] font-medium text-[#1A1A1A]">Tailor</span>
                        <span class="font-body text-[10.5px] text-gray-400 text-center">Offer tailoring services</span>
                        <input type="radio" name="tailor" value="yes" class="hidden" onclick="selectRole('tailor')">
                     </label>
                  </div>
                  <span class="field_error" id="tailor_error"></span>
               </div>

               {{-- Profile photo --}}
               <div>
                  <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">
                     Profile Photo <span class="text-gold">*</span>
                  </label>
                  <label class="flex items-center gap-3 w-full border border-gray-200 px-4 py-2.5 cursor-pointer hover:border-[#1A1A1A] transition-colors bg-white">
                     <i class="fa-solid fa-camera text-gray-300 text-sm"></i>
                     <span id="photo-label" class="font-body text-sm text-gray-400">Choose photo…</span>
                     <input type="file" name="image" id="image" accept="image/*" class="hidden"
                        onchange="document.getElementById('photo-label').textContent = this.files[0]?.name || 'Choose photo…'">
                  </label>
                  <span class="field_error" id="image_error"></span>
               </div>

               <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  {{-- Short Bio --}}
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Short Bio</label>
                     <div class="relative">
                        <i class="fa-solid fa-quote-left absolute left-3 top-3 text-gray-300 text-xs pointer-events-none"></i>
                        <textarea name="bio" placeholder="One line about you…" rows="3"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white resize-none"></textarea>
                     </div>
                     <span class="field_error" id="bio_error"></span>
                  </div>
                  {{-- About --}}
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">About</label>
                     <div class="relative">
                        <i class="fa-solid fa-circle-info absolute left-3 top-3 text-gray-300 text-xs pointer-events-none"></i>
                        <textarea name="about" placeholder="Tell us more about yourself…" rows="3"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white resize-none"></textarea>
                     </div>
                     <span class="field_error" id="about_error"></span>
                  </div>
               </div>

               <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  {{-- Skills --}}
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Skills</label>
                     <div class="relative">
                        <i class="fa-solid fa-star absolute left-3 top-3 text-gray-300 text-xs pointer-events-none"></i>
                        <textarea name="skills" placeholder="e.g. stitching, embroidery…" rows="3"
                           class="w-full border border-gray-200 pl-9 pr-4 py-2.5 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white resize-none"></textarea>
                     </div>
                     <span class="field_error" id="skills_error"></span>
                  </div>
                  {{-- Language --}}
                  <div>
                     <label class="block font-body text-[10px] tracking-[0.12em] uppercase text-gray-500 mb-1.5">Language <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-solid fa-language absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-xs pointer-events-none"></i>
                        <select name="language" id="s2_language"
                           class="w-full border border-gray-200 pl-9 pr-8 py-2.5 font-body text-sm text-[#1A1A1A] focus:border-[#1A1A1A] transition-colors bg-white appearance-none cursor-pointer"
                           onchange="clearErr('language_error')">
                           <option value="">Select language…</option>
                           <option value="Urdu">Urdu</option>
                           <option value="English">English</option>
                           <option value="Punjabi">Punjabi</option>
                           <option value="Urdu, English">Urdu &amp; English</option>
                           <option value="Urdu, Punjabi">Urdu &amp; Punjabi</option>
                           <option value="Urdu, English, Punjabi">Urdu, English &amp; Punjabi</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none"></i>
                     </div>
                     <span class="field_error" id="language_error"></span>
                  </div>
               </div>

               <div class="reg_msg font-body text-sm text-green-600 text-center font-medium min-h-[20px]"></div>

               {{-- Back + Submit --}}
               <div class="flex gap-3 mt-2">
                  <button type="button" onclick="goToStep1()"
                     class="flex-1 bg-white border border-gray-300 text-[#1A1A1A] font-body text-[11px] tracking-[0.2em] uppercase py-[15px] hover:border-[#1A1A1A] transition-colors flex items-center justify-center gap-2 cursor-pointer">
                     <i class="fa-solid fa-arrow-left text-[9px]"></i> Back
                  </button>
                  <button type="submit" id="reg_btn"
                     class="flex-2 flex-grow bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.22em] uppercase py-[15px] hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 border-none cursor-pointer">
                     Create Account &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </button>
               </div>

            </div>
         </div>

      </form>
   </div>
</div>

<script>
   /* ─── Clear error on input ─── */
   function clearErr(errId) {
      var el = document.getElementById(errId);
      if (el) el.textContent = '';
   }

   // Auto-wire: any input/select/textarea inside the form clears its paired _error span
   document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('#reg_form input, #reg_form select, #reg_form textarea').forEach(function(field) {
         var errId = (field.name || field.id) + '_error';
         var errEl = document.getElementById(errId);
         if (!errEl) return;
         var evt = (field.tagName === 'SELECT' || field.type === 'file' || field.type === 'radio') ? 'change' : 'input';
         field.addEventListener(evt, function() { errEl.textContent = ''; });
      });
   });

   /* ─── Step navigation ─── */
   function goToStep2() {
      // Basic client-side validation for step 1
      var errors = false;
      var fields = [
         { id: 's1_name',    err: 'name_error',     label: 'Full name' },
         { id: 's1_email',   err: 'email_error',    label: 'Email' },
         { id: 's1_mobile',  err: 'mobile_error',   label: 'Mobile' },
         { id: 's1_address', err: 'address_error',  label: 'Address' },
         { id: 'reg_password', err: 'password_error', label: 'Password' },
      ];
      fields.forEach(function(f) {
         var el = document.getElementById(f.id);
         document.getElementById(f.err).textContent = '';
         if (!el.value.trim()) {
            document.getElementById(f.err).textContent = f.label + ' is required.';
            errors = true;
         }
      });
      if (errors) return;

      document.getElementById('step1').classList.remove('active');
      document.getElementById('step2').classList.add('active');

      // Update stepper
      document.getElementById('dot2').classList.remove('bg-gray-200', 'text-gray-400');
      document.getElementById('dot2').classList.add('bg-[#1A1A1A]', 'text-white');
      document.getElementById('label2').classList.remove('text-gray-400');
      document.getElementById('label2').classList.add('text-[#1A1A1A]');

      // Swap image quote
      document.getElementById('quote-step1').style.display = 'none';
      document.getElementById('quote-step2').style.display = 'block';

      // Scroll right panel to top
      document.querySelector('.overflow-y-auto').scrollTop = 0;
   }

   function goToStep1() {
      document.getElementById('step2').classList.remove('active');
      document.getElementById('step1').classList.add('active');

      // Revert stepper
      document.getElementById('dot2').classList.add('bg-gray-200', 'text-gray-400');
      document.getElementById('dot2').classList.remove('bg-[#1A1A1A]', 'text-white');
      document.getElementById('label2').classList.add('text-gray-400');
      document.getElementById('label2').classList.remove('text-[#1A1A1A]');

      // Swap image quote back
      document.getElementById('quote-step1').style.display = 'block';
      document.getElementById('quote-step2').style.display = 'none';

      document.querySelector('.overflow-y-auto').scrollTop = 0;
   }

   /* ─── Role card selection ─── */
   function selectRole(role) {
      document.getElementById('role-customer').classList.remove('border-[#1A1A1A]', 'bg-[#FAFAFA]');
      document.getElementById('role-tailor').classList.remove('border-[#1A1A1A]', 'bg-[#FAFAFA]');
      document.getElementById('role-customer').classList.add('border-gray-200');
      document.getElementById('role-tailor').classList.add('border-gray-200');

      var active = role === 'customer' ? 'role-customer' : 'role-tailor';
      document.getElementById(active).classList.remove('border-gray-200');
      document.getElementById(active).classList.add('border-[#1A1A1A]', 'bg-[#FAFAFA]');

      // Update icon color
      document.querySelectorAll('.role-card i.fa-bag-shopping, .role-card i.fa-scissors').forEach(function(ic) {
         ic.classList.add('text-gray-400');
         ic.classList.remove('text-[#1A1A1A]');
      });
      document.querySelector('#' + active + ' i').classList.remove('text-gray-400');
      document.querySelector('#' + active + ' i').classList.add('text-[#1A1A1A]');
   }

   /* ─── Password helpers ─── */
   function togglePwd(id, btn) {
      const input = document.getElementById(id);
      const icon  = btn.querySelector('i');
      if (input.type === 'password') {
         input.type = 'text';
         icon.className = 'fa-regular fa-eye-slash text-[13px]';
      } else {
         input.type = 'password';
         icon.className = 'fa-regular fa-eye text-[13px]';
      }
   }

   function checkPwd(val) {
      const check = (el, pass) => {
         el.classList.toggle('ok', pass);
         el.querySelector('i').className = pass ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle';
      };
      check(document.getElementById('rule-len'),  val.length >= 8);
      check(document.getElementById('rule-num'),  /[0-9]/.test(val));
      check(document.getElementById('rule-case'), /[a-z]/.test(val) && /[A-Z]/.test(val));
   }

   /* ─── AJAX submit (unchanged) ─── */
   jQuery('#reg_form').submit(function(e) {
      e.preventDefault();
      const btn = jQuery('#reg_btn');
      btn.html('<i class="fa-solid fa-spinner fa-spin"></i>&nbsp; Creating…').prop('disabled', true);
      jQuery('.field_error').html('');

      const data = new FormData(document.getElementById('reg_form'));

      jQuery.ajax({
         url:         '/registration_process',
         data:        data,
         type:        'post',
         processData: false,
         contentType: false,
         success: function(result) {
            if (result.error) {
               // If errors are on step 1 fields, go back to step 1
               var step1Fields = ['name', 'email', 'mobile', 'address', 'password'];
               var hasStep1Error = step1Fields.some(function(f) { return result.error[f]; });
               if (hasStep1Error) goToStep1();

               jQuery.each(result.error, function(key, val) {
                  jQuery('#' + key + '_error').html(val[0] || val);
               });
               btn.html('Create Account &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>').prop('disabled', false);
            } else {
               SS.toast('success', 'Welcome!', result.msg, 2000);
               jQuery('#reg_form').trigger('reset');
               if (result.status === 'update') {
                  setTimeout(function() { window.location.href = '/profile/' + result.id; }, 2100);
               } else {
                  setTimeout(function() { window.location.href = '/login'; }, 2100);
               }
            }
         },
         error: function() {
            btn.html('Create Account &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>').prop('disabled', false);
         }
      });
   });
</script>

</body>
</html>
