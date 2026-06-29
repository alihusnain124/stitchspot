@extends('front.layout')
@section('title', 'About Us – StitchSpot')

@section('content')

{{-- Hero --}}
<div class="bg-[#1A1A1A] py-20 text-center">
   <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-4">Our Story</p>
   <h1 class="font-display text-white text-[clamp(34px,5vw,60px)] font-semibold leading-tight">
      Crafting Style,<br>One Stitch at a Time
   </h1>
</div>

{{-- About content --}}
<section class="py-20 bg-white">
   <div class="max-w-3xl mx-auto px-6 text-center">
      <div class="w-12 h-0.5 bg-gold mx-auto mb-10"></div>
      <p class="font-body text-[15px] text-gray-600 leading-relaxed mb-6">
         StitchSpot is a premium fashion and tailoring platform that connects customers with skilled tailors
         across Pakistan. We believe that great style isn't just about what you wear — it's about wearing
         something made precisely for you.
      </p>
      <p class="font-body text-[15px] text-gray-600 leading-relaxed mb-6">
         Founded with a passion for craftsmanship and a commitment to quality, StitchSpot bridges the gap
         between modern fashion and traditional tailoring expertise. Whether you're looking for ready-to-wear
         pieces or custom-tailored garments, we have you covered.
      </p>
      <p class="font-body text-[15px] text-gray-600 leading-relaxed">
         Based in Sargodha, Pakistan — serving customers everywhere.
      </p>
      <div class="w-12 h-0.5 bg-gold mx-auto mt-10"></div>
   </div>
</section>

{{-- Values --}}
<section class="py-16 bg-[#F9F8F6]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
         <div class="px-6">
            <i class="fa-solid fa-scissors text-gold text-3xl mb-5 block"></i>
            <h3 class="font-display text-xl font-semibold text-[#1A1A1A] mb-3">Expert Tailoring</h3>
            <p class="font-body text-[13.5px] text-gray-500 leading-relaxed">Skilled tailors with years of expertise in custom garment creation and alterations.</p>
         </div>
         <div class="px-6">
            <i class="fa-solid fa-shirt text-gold text-3xl mb-5 block"></i>
            <h3 class="font-display text-xl font-semibold text-[#1A1A1A] mb-3">Quality Fashion</h3>
            <p class="font-body text-[13.5px] text-gray-500 leading-relaxed">Curated fashion products that combine style, comfort, and lasting quality.</p>
         </div>
         <div class="px-6">
            <i class="fa-solid fa-star text-gold text-3xl mb-5 block"></i>
            <h3 class="font-display text-xl font-semibold text-[#1A1A1A] mb-3">Customer First</h3>
            <p class="font-body text-[13.5px] text-gray-500 leading-relaxed">Your satisfaction is our priority. Every order is handled with care and attention.</p>
         </div>
      </div>
   </div>
</section>

@endsection
