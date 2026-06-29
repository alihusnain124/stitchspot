@extends('front.layout')
@section('title', 'Our Services – StitchSpot')

@section('content')

{{-- ── Hero ── --}}
<section class="relative overflow-hidden bg-[#1A1A1A]" style="min-height:420px">
   <img src="{{ asset('front-assets/images/slider-bg.jpg') }}"
        alt="Services hero"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-40">
   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-28">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-5">Crafted With Expertise</p>
      <h1 class="font-display text-white text-[clamp(36px,5vw,68px)] font-semibold leading-tight mb-5">
         Unlock Your Style<br>With <span class="text-gold">StitchSpot</span>
      </h1>
      <p class="font-body text-white/55 text-base mb-9 max-w-md">"Elevate Your Style with Custom Tailoring"</p>
      <a href="#services-grid"
         class="inline-flex items-center gap-2 bg-gold text-[#1A1A1A] font-body font-semibold text-[11px] tracking-[0.2em] uppercase px-8 h-11 hover:bg-[#A88948] transition-colors">
         Explore Services
      </a>
   </div>
</section>

{{-- ── Services grid ── --}}
<section id="services-grid" class="py-20 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      <div class="text-center mb-14">
         <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-3">What We Offer</p>
         <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-semibold text-[#1A1A1A]">Our Services</h2>
         <div class="w-12 h-0.5 bg-gold mx-auto mt-3"></div>
      </div>

      @if(isset($services) && count($services) > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
         @foreach($services as $item)
         <a href="{{ url('/service-details/'.$item->id) }}"
            class="group bg-white border border-gray-100 hover:border-gray-200 hover:shadow-lg transition-all duration-300 block">

            {{-- Service image --}}
            <div class="relative overflow-hidden bg-gray-100" style="aspect-ratio:4/3">
               <img src="{{ asset('/storage/media/services/'.$item->image) }}"
                    alt="{{ $item->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>

            {{-- Info --}}
            <div class="p-5">
               {{-- Tailor info --}}
               @if(isset($user[$item->id][0]))
               <div class="flex items-center gap-2 mb-3">
                  <img src="{{ asset('/storage/media/customer/'.$user[$item->id][0]->image) }}"
                       alt="{{ $user[$item->id][0]->name }}"
                       class="w-7 h-7 rounded-full object-cover border border-gray-200">
                  <span class="font-body text-[12px] text-gray-500 truncate">{{ $user[$item->id][0]->name }}</span>
               </div>
               @endif

               <h3 class="font-body text-[13.5px] font-medium text-[#1A1A1A] leading-snug mb-3 line-clamp-2">
                  {{ Str::substr($item->title, 0, 70) }}…
               </h3>

               <div class="flex items-center justify-between">
                  <span class="font-body text-[12px] text-gray-400 uppercase tracking-wide">Starting at</span>
                  <span class="font-body text-[14px] font-semibold text-gold">Rs {{ number_format($item->min_price) }}</span>
               </div>
            </div>
         </a>
         @endforeach
      </div>

      @else
      <div class="text-center py-16">
         <i class="fa-solid fa-scissors text-[52px] text-gray-200 mb-5 block"></i>
         <h3 class="font-display text-[24px] text-[#1A1A1A] mb-2">No Services Available</h3>
         <p class="font-body text-[14px] text-gray-400">Check back soon for our tailoring services.</p>
      </div>
      @endif

   </div>
</section>

{{-- ── Help section ── --}}
<section class="bg-[#F9F8F6] py-14 text-center border-t border-gray-100">
   <div class="max-w-2xl mx-auto px-6">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-3">Need Guidance?</p>
      <h2 class="font-display text-3xl font-semibold text-[#1A1A1A] mb-4">How It Works</h2>
      <p class="font-body text-[14px] text-gray-500 mb-7">
         Not sure how to place a tailoring order? Watch our quick guide to get started.
      </p>
      <a href="https://youtu.be/JXnXgEIyv-M?si=l_w7LSND1W7pw0XT" target="_blank" rel="noopener"
         class="inline-flex items-center gap-2 bg-[#1A1A1A] text-white font-body font-medium text-[11px] tracking-[0.18em] uppercase px-7 h-10 hover:bg-gray-800 transition-colors">
         <i class="fa-brands fa-youtube text-sm"></i> Watch Guide
      </a>
   </div>
</section>

@endsection
