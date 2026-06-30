{{--
   Reusable product card partial.
   Required: $item, $price, $mrp, $qty, $isSale, $isOut
   Optional: $attrsJson — if present enables Quick View, otherwise shows View Details link
--}}
@php $hasQV = isset($attrsJson) && $attrsJson; @endphp

<div class="group relative"
   @if($hasQV)
   data-id="{{ $item->id }}"
   data-name="{{ addslashes($item->name) }}"
   data-image="{{ str_starts_with($item->image ?? '', 'http') ? $item->image : asset('/storage/media/'.$item->image) }}"
   data-price="{{ $price }}"
   data-mrp="{{ $mrp }}"
   data-desc="{{ addslashes(Str::substr($item->short_desc ?? '', 0, 200)) }}"
   data-attrs="{{ $attrsJson }}"
   data-sale="{{ $isSale ? 1 : 0 }}"
   data-out="{{ $isOut ? 1 : 0 }}"
   @endif
>

   <div class="relative overflow-hidden bg-[#F9F8F6]" style="aspect-ratio:3/4">

      {{-- Badge --}}
      @if($isOut)
         <span class="absolute top-3 left-3 bg-gray-500 text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sold Out</span>
      @elseif($isSale || ($item->is_discounted ?? false))
         <span class="absolute top-3 left-3 bg-[#E63946] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sale</span>
      @else
         <span class="absolute top-3 left-3 bg-[#1A1A1A] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">New</span>
      @endif

      {{-- Wishlist --}}
      <button class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center cursor-pointer z-10 opacity-0 group-hover:opacity-100 transition-all hover:bg-[#E63946] hover:text-white text-gray-500 text-[13px] border-none" title="Wishlist">
         <i class="fa-regular fa-heart"></i>
      </button>

      {{-- Image --}}
      @php $imgSrc = str_starts_with($item->image ?? '', 'http') ? $item->image : asset('/storage/media/'.$item->image); @endphp
      <img src="{{ $imgSrc }}" alt="{{ $item->name }}"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
           loading="lazy">

      {{-- Hover overlay --}}
      @if(!$isOut)
         <div class="absolute inset-0 bg-[#1A1A1A]/82 flex flex-col items-center justify-center gap-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
            @if($hasQV)
               <button onclick="openQuickView(this.closest('[data-id]'))"
                  class="w-40 h-10 bg-white text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[1.5px] uppercase border-none cursor-pointer hover:bg-gold hover:text-white transition-all">
                  <i class="fa-regular fa-eye mr-1"></i> Quick View
               </button>
            @else
               <a href="{{ url('/product-details/'.$item->id) }}"
                  class="flex items-center justify-center w-40 h-10 bg-white text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[1.5px] uppercase hover:bg-gold hover:text-white transition-all">
                  <i class="fa-regular fa-eye mr-1"></i> View Details
               </a>
            @endif
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
