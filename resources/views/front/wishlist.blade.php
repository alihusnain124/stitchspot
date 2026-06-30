@extends('front.layout')
@section('title', 'My Wishlist – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=1600&q=80"
        alt="My Wishlist"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">

      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">My Account</p>

      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         My Wishlist
      </h1>

      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Your saved favourites — pieces you love, all in one place.
      </p>

      <div class="flex items-center gap-3 mb-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Wishlist</span>
      </div>

      <p class="font-body text-[12px] text-white/30 italic mt-2">
         {{ count($wishlist_products) }} {{ count($wishlist_products) == 1 ? 'item' : 'items' }} saved
      </p>
   </div>
</section>

<section class="py-14 bg-white min-h-[50vh]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      @if(count($wishlist_products) == 0)
      {{-- Empty state --}}
      <div class="text-center py-20 max-w-md mx-auto">
         <div class="w-24 h-24 bg-[#FFF5F5] rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-regular fa-heart text-[36px] text-[#E63946]/40"></i>
         </div>
         <h3 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-3">Your wishlist is empty</h3>
         <p class="font-body text-[14.5px] text-gray-500 mb-8 leading-relaxed">
            Save items you love by clicking the heart icon on any product.
         </p>
         <a href="{{ url('/products') }}"
            class="inline-flex items-center justify-center h-12 px-8 bg-[#1A1A1A] text-white font-body text-[11px] font-semibold tracking-[2px] uppercase hover:bg-gold transition-colors">
            Browse Products
         </a>
      </div>

      @else
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-7">
         @foreach($wishlist_products as $item)
         @php
            $attr   = $wishlist_attrs[$item->id][0] ?? null;
            $price  = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
            $mrp    = $attr ? $attr->mrp : 0;
            $qty    = $attr ? $attr->qty : 0;
            $isSale = $attr && $attr->price > 0 && $attr->price < $attr->mrp;
            $isOut  = $qty == 0;
         @endphp

         <div class="group relative" id="wish-card-{{ $item->id }}">
            <div class="relative overflow-hidden bg-[#F9F8F6]" style="aspect-ratio:3/4">

               {{-- Badge --}}
               @if($isOut)
                  <span class="absolute top-3 left-3 bg-gray-500 text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sold Out</span>
               @elseif($isSale || $item->is_discounted)
                  <span class="absolute top-3 left-3 bg-[#E63946] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sale</span>
               @else
                  <span class="absolute top-3 left-3 bg-[#1A1A1A] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">New</span>
               @endif

               {{-- Remove from wishlist --}}
               <button onclick="removeFromWishlist(this, {{ $item->id }})"
                  title="Remove from wishlist"
                  class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center cursor-pointer z-30 transition-all border-none text-[#E63946] hover:bg-[#E63946] hover:text-white opacity-0 group-hover:opacity-100">
                  <i class="fa-solid fa-heart text-[13px]"></i>
               </button>

               {{-- Image --}}
               @php $wImg = str_starts_with($item->image ?? '', 'http') ? $item->image : asset('/storage/media/'.$item->image); @endphp
               <img src="{{ $wImg }}" alt="{{ $item->name }}"
                    class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                    onerror="this.onerror=null;this.src='{{ asset('front-assets/images/slider-bg.jpg') }}'">

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

      <div class="mt-12 text-center">
         <a href="{{ url('/products') }}"
            class="inline-flex items-center gap-2 h-11 px-8 border border-gray-300 text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[2px] uppercase hover:border-gold hover:text-gold transition-colors">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Continue Shopping
         </a>
      </div>
      @endif

   </div>
</section>

@endsection

@section('scripts')
<script>
function removeFromWishlist(btn, productId) {
   var csrfToken = $('meta[name="csrf-token"]').attr('content');
   $.ajax({
      url: '/wishlist/toggle',
      method: 'POST',
      data: { product_id: productId, _token: csrfToken },
      success: function(res) {
         if(res.status === 'removed') {
            var card = document.getElementById('wish-card-' + productId);
            if(card) {
               card.style.transition = 'opacity 0.3s, transform 0.3s';
               card.style.opacity = '0';
               card.style.transform = 'scale(0.95)';
               setTimeout(function(){ card.remove(); }, 300);
            }
            SS.toast('success', 'Removed from wishlist', '', 2000);
         }
      }
   });
}
</script>
@endsection
