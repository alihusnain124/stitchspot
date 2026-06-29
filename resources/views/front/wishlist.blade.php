@extends('front.layout')
@section('title', 'My Wishlist – StitchSpot')

@section('content')

<div class="bg-[#F9F8F6] border-b border-gray-100 py-12 text-center">
   <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-2">
      <a href="{{ url('/') }}" class="hover:text-gold transition-colors">Home</a>
      <span class="mx-2 text-gray-300">/</span>
      <span>Wishlist</span>
   </p>
   <h1 class="font-display text-[clamp(28px,4vw,44px)] font-semibold text-[#1A1A1A]">My Wishlist</h1>
</div>

<section class="py-16 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <div class="text-center py-16">
         <i class="fa-regular fa-heart text-[52px] text-gray-200 mb-5 block"></i>
         <h3 class="font-display text-[26px] text-[#1A1A1A] mb-2">Your Wishlist is Empty</h3>
         <p class="font-body text-[14px] text-gray-400 mb-7">Save your favourite items to come back to them later.</p>
         <a href="{{ url('/products') }}"
            class="inline-flex items-center bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase px-8 h-10 hover:bg-gray-800 transition-colors">
            Browse Products
         </a>
      </div>
   </div>
</section>

@endsection
