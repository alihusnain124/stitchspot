@extends('front.layout')
@section('title', 'All Products – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="{{ asset('front-assets/images/f3.jpg') }}"
        alt="Our Collection"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.6) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">

      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">New Arrivals &amp; Classics</p>

      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Our Collection
      </h1>

      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Discover premium fashion pieces — from everyday wear to special occasion outfits, curated just for you.
      </p>

      <div class="flex items-center gap-3 mb-2">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">All Products</span>
      </div>
      <p class="font-body text-[12px] text-white/30 italic mt-3">{{ $product->count() }} pieces curated for you</p>
   </div>
</section>

{{-- Products grid --}}
<section class="py-14 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      @if($product->isEmpty())
      <div class="text-center py-20">
         <i class="fa-solid fa-shirt text-[56px] text-[#E8E8E8] mb-5 block"></i>
         <h3 class="font-display text-[24px] text-[#1A1A1A] mb-2">No Products Found</h3>
         <p class="font-body text-[14px] text-gray-400">Check back soon — new arrivals drop weekly.</p>
      </div>

      @else
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-7">
         @foreach ($product as $item)
         @php
            $attr   = $product_attr[$item->id][0] ?? null;
            $price  = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
            $mrp    = $attr ? $attr->mrp : 0;
            $qty    = $attr ? $attr->qty : 0;
            $isSale = $attr && $attr->price > 0 && $attr->price < $attr->mrp;
            $isOut     = $qty == 0;
            $wishlisted = isset($wishlist_ids) && in_array($item->id, $wishlist_ids);
         @endphp

         <div class="group relative">
            <div class="relative overflow-hidden bg-[#F9F8F6]" style="aspect-ratio:3/4">

               {{-- Badge --}}
               @if($isOut)
                  <span class="absolute top-3 left-3 bg-gray-500 text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sold Out</span>
               @elseif($isSale || $item->is_discounted)
                  <span class="absolute top-3 left-3 bg-[#E63946] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sale</span>
               @else
                  <span class="absolute top-3 left-3 bg-[#1A1A1A] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">New</span>
               @endif

               {{-- Wishlist --}}
               <button onclick="toggleWishlist(this, {{ $item->id }})"
                  class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center cursor-pointer z-30 opacity-0 group-hover:opacity-100 transition-all border-none {{ $wishlisted ? 'text-[#E63946]' : 'text-gray-400 hover:text-[#E63946]' }}">
                  <i class="{{ $wishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart text-[13px]"></i>
               </button>

               {{-- Image --}}
               <img src="{{ asset('/storage/media/'.$item->image) }}" alt="{{ $item->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy">

               {{-- Hover overlay --}}
               @if(!$isOut)
               <div class="absolute inset-0 bg-[#1A1A1A]/82 flex flex-col items-center justify-center gap-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                  <a href="{{ url('/product-details/'.$item->id) }}"
                     class="flex items-center justify-center w-40 h-10 bg-white text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[1.5px] uppercase hover:bg-gold hover:text-white transition-all">
                     <i class="fa-regular fa-eye mr-1"></i> View Details
                  </a>
                  <button onclick="addToCart({{ $item->id }})"
                     class="w-40 h-10 bg-transparent text-white font-body text-[11px] font-semibold tracking-[1.5px] uppercase border border-white/50 cursor-pointer hover:bg-white hover:text-[#1A1A1A] transition-all">
                     <i class="fa-solid fa-bag-shopping mr-1"></i> Add to Cart
                  </button>
               </div>
               @else
               <div class="absolute inset-0 bg-[#1A1A1A]/70 flex items-center justify-center z-20 cursor-default">
                  <span class="font-body text-white text-[12px] tracking-[2px] uppercase">Out of Stock</span>
               </div>
               @endif

            </div>

            <div class="pt-3.5 px-1 pb-2">
               <div class="font-body text-[13.5px] font-medium text-[#1A1A1A] leading-snug mb-1.5">
                  <a href="{{ url('/product-details/'.$item->id) }}" class="hover:text-gold transition-colors">{{ $item->name }}</a>
               </div>
               <div class="flex items-center gap-2">
                  @if($isSale)
                     <span class="font-body text-sm font-semibold text-[#E63946]">Rs {{ number_format($price) }}</span>
                     <span class="font-body text-xs text-gray-400 line-through">Rs {{ number_format($mrp) }}</span>
                  @else
                     <span class="font-body text-sm font-semibold text-[#1A1A1A]">Rs {{ number_format($price) }}</span>
                  @endif
               </div>
            </div>
         </div>

         @endforeach
      </div>
      @endif

   </div>
</section>

@endsection
