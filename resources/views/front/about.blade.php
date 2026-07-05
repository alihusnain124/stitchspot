@extends('front.layout')
@section('title', 'About Us – StitchSpot')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden bg-[#1A1A1A] py-20 text-center">
   <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1600&q=80"
        alt="Tailor at work"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-40">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.75) 100%)"></div>
   <div class="relative z-10">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-4">Our Story</p>
      <h1 class="font-display text-white text-[clamp(34px,5vw,60px)] font-semibold leading-tight">
         Crafting Style,<br>One Stitch at a Time
      </h1>
   </div>
</section>

{{-- About content --}}
<section class="py-20 bg-white">
   <div class="max-w-3xl mx-auto px-6 text-center">
      <div class="w-12 h-0.5 bg-gold mx-auto mb-10"></div>
      <p class="font-body text-[15px] text-gray-600 leading-relaxed mb-6">
         StitchSpot started with a simple observation: most online stores only sell ready-made clothes, and most
         tailoring services only book a tailor — never both. Our small team of three wanted to build something
         more complete, so we set out to combine a full fashion e-commerce store with real, working tailor
         functionality on a single platform.
      </p>
      <p class="font-body text-[15px] text-gray-600 leading-relaxed mb-6">
         That's what makes StitchSpot unique — you can shop ready-to-wear pieces like any modern store, or connect
         directly with skilled tailors for custom stitching and alterations, all without leaving the platform.
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

{{-- Meet the Team --}}
<section class="py-20 bg-white">
   <div class="max-w-[1000px] mx-auto px-4 lg:px-8">
      <div class="text-center mb-12">
         <p class="font-body text-[10.5px] tracking-[3px] uppercase text-gold mb-2">Who Built This</p>
         <h2 class="font-display text-[30px] lg:text-[36px] font-semibold text-[#1A1A1A]">Meet the Team</h2>
         <p class="font-body text-[14px] text-gray-500 mt-3 max-w-[440px] mx-auto leading-relaxed">
            StitchSpot is built and run by a team of three.
         </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
         @foreach([
            ['name' => 'Ali Husnain',    'role' => 'Founder & Full Stack Engineer'],
            ['name' => 'Rida Siddique',  'role' => 'Co-Founder & UI/UX Designer'],
            ['name' => 'Muhammad Noman', 'role' => 'Co-Founder & Frontend Engineer'],
         ] as $member)
         <div class="bg-[#F9F8F6] border border-gray-100 p-8 text-center hover:shadow-lg transition-shadow">
            <div class="w-20 h-20 rounded-full bg-gold/10 flex items-center justify-center mx-auto mb-5">
               <span class="font-display text-[26px] font-semibold text-gold">{{ strtoupper(substr($member['name'], 0, 1)) }}</span>
            </div>
            <h3 class="font-display text-[19px] font-semibold text-[#1A1A1A] mb-1">{{ $member['name'] }}</h3>
            <p class="font-body text-[11.5px] tracking-[0.1em] uppercase text-gold">{{ $member['role'] }}</p>
         </div>
         @endforeach
      </div>
   </div>
</section>

{{-- CTA --}}
<section class="py-14 bg-[#1A1A1A] text-center">
   <div class="max-w-[600px] mx-auto px-6">
      <h3 class="font-display text-white text-[24px] lg:text-[28px] font-semibold mb-3">Have Questions?</h3>
      <p class="font-body text-white/50 text-[13.5px] mb-7 leading-relaxed">
         We'd love to hear from you — whether it's about an order, a custom stitching request, or just feedback.
      </p>
      <a href="{{ url('/contact') }}"
         class="inline-flex items-center h-12 px-8 bg-gold text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[0.2em] uppercase hover:bg-white transition-colors">
         Get in Touch
      </a>
   </div>
</section>

@endsection
