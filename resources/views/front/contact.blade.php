@extends('front.layout')
@section('title', 'Contact – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1600&q=80"
        alt="Contact Us"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">We'd Love to Hear From You</p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Get in Touch
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Have a question, feedback or a custom tailoring request? We're here to help.
      </p>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Contact</span>
      </div>
   </div>
</section>

{{-- ── Main ── --}}
<section class="py-16 bg-[#F9F8F6]">
   <div class="max-w-[1100px] mx-auto px-4 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">

         {{-- ── LEFT: Form ── --}}
         <div class="lg:col-span-3 bg-white border border-gray-100 p-8 lg:p-10">

            <p class="font-body text-[10.5px] tracking-[3px] uppercase text-gold mb-1">Send a Message</p>
            <h2 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-8">Share Your Thoughts</h2>

            <form id="contact_form" class="space-y-5">
               @csrf

               <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                  <div>
                     <label class="block font-body text-[10.5px] tracking-[2px] uppercase text-gray-400 mb-2">Your Name</label>
                     <input type="text" name="name" placeholder="e.g. Ali Husnain"
                        class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  </div>
                  <div>
                     <label class="block font-body text-[10.5px] tracking-[2px] uppercase text-gray-400 mb-2">Your Email</label>
                     <input type="text" name="email" placeholder="you@example.com"
                        class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  </div>
               </div>

               <div>
                  <label class="block font-body text-[10.5px] tracking-[2px] uppercase text-gray-400 mb-2">Subject</label>
                  <input type="text" name="subject" placeholder="What's this about?"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
               </div>

               <div>
                  <label class="block font-body text-[10.5px] tracking-[2px] uppercase text-gray-400 mb-2">Message</label>
                  <textarea name="message" rows="6" placeholder="Write your message here…"
                     class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none"></textarea>
               </div>

               <button type="submit"
                  class="w-full h-12 bg-[#1A1A1A] text-white font-body text-[11px] font-medium tracking-[0.22em] uppercase hover:bg-gray-800 transition-colors border-none cursor-pointer flex items-center justify-center gap-2">
                  <i class="fa-solid fa-paper-plane text-[11px]"></i>
                  Send Message
               </button>
            </form>
         </div>

         {{-- ── RIGHT: Info ── --}}
         <div class="lg:col-span-2 space-y-6">

            {{-- Info card --}}
            <div class="bg-white border border-gray-100 p-7">
               <p class="font-body text-[10.5px] tracking-[3px] uppercase text-gold mb-1">Contact Info</p>
               <h3 class="font-display text-[22px] font-semibold text-[#1A1A1A] mb-6">Reach Us Directly</h3>

               <div class="space-y-5">
                  <div class="flex items-start gap-4">
                     <div class="w-9 h-9 bg-[#1A1A1A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-location-dot text-gold text-[13px]"></i>
                     </div>
                     <div>
                        <p class="font-body text-[11px] tracking-[1.5px] uppercase text-gray-400 mb-0.5">Address</p>
                        <p class="font-body text-[13.5px] text-[#1A1A1A]">Lahore, Punjab, Pakistan</p>
                     </div>
                  </div>
                  <div class="flex items-start gap-4">
                     <div class="w-9 h-9 bg-[#1A1A1A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-phone text-gold text-[13px]"></i>
                     </div>
                     <div>
                        <p class="font-body text-[11px] tracking-[1.5px] uppercase text-gray-400 mb-0.5">Phone</p>
                        <p class="font-body text-[13.5px] text-[#1A1A1A]">0310-3465783</p>
                     </div>
                  </div>
                  <div class="flex items-start gap-4">
                     <div class="w-9 h-9 bg-[#1A1A1A] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-envelope text-gold text-[13px]"></i>
                     </div>
                     <div>
                        <p class="font-body text-[11px] tracking-[1.5px] uppercase text-gray-400 mb-0.5">Email</p>
                        <p class="font-body text-[13.5px] text-[#1A1A1A]">contact@stitchspot.com</p>
                     </div>
                  </div>
               </div>
            </div>

            {{-- Team card --}}
            <div class="bg-white border border-gray-100 p-7">
               <p class="font-body text-[10.5px] tracking-[3px] uppercase text-gold mb-1">Our Team</p>
               <h3 class="font-display text-[22px] font-semibold text-[#1A1A1A] mb-5">Who to Contact</h3>

               <div class="space-y-4">
                  @foreach([
                     ['name' => 'Ali Husnain',     'phone' => '0310-3465783', 'email' => 'ali@stitchspot.com'],
                     ['name' => 'Rida Siddique',   'phone' => '0310-3465783', 'email' => 'rida@stitchspot.com'],
                     ['name' => 'Muhammad Noman',  'phone' => '0310-3465783', 'email' => 'noman@stitchspot.com'],
                  ] as $member)
                  <div class="flex items-center gap-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                     <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center shrink-0">
                        <span class="font-display text-[15px] font-semibold text-gold">{{ strtoupper(substr($member['name'], 0, 1)) }}</span>
                     </div>
                     <div class="min-w-0">
                        <p class="font-body text-[13.5px] font-medium text-[#1A1A1A]">{{ $member['name'] }}</p>
                        <p class="font-body text-[12px] text-gray-400 truncate">{{ $member['phone'] }} &nbsp;·&nbsp; {{ $member['email'] }}</p>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>

         </div>
      </div>
   </div>
</section>

@endsection
