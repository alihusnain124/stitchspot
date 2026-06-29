@extends('front.layout')
@section('title', 'StitchSpot – New Arrivals & Premium Tailoring')

@section('extra-css')
/* ── Scroll indicator animation ── */
@keyframes scrollDown {
   0%,100% { opacity:1; transform:scaleY(1) translateY(0); }
   50%      { opacity:.4; transform:scaleY(.6) translateY(8px); }
}
.hero-scroll-line { animation: scrollDown 1.5s infinite; }

/* ── Filter tab switching (JS toggles .active class) ── */
.filter-panel        { display: none; }
.filter-panel.active { display: grid; grid-template-columns: repeat(4,1fr); gap: 24px 16px; }
@media(max-width:992px) { .filter-panel.active { grid-template-columns: repeat(2,1fr); } }
@media(max-width:576px) { .filter-panel.active { gap: 12px 10px; } }

/* ── Quick View modal ── */
.qv-backdrop         { position:fixed; inset:0; background:rgba(0,0,0,.65); z-index:9000; display:none; align-items:center; justify-content:center; padding:20px; }
.qv-backdrop.open    { display:flex; }
.qv-modal            { background:#fff; width:100%; max-width:880px; max-height:90vh; overflow-y:auto; display:grid; grid-template-columns:1fr 1fr; animation:qvIn .3s ease; }
@keyframes qvIn      { from{transform:scale(.94);opacity:0} to{transform:scale(1);opacity:1} }
.qv-img-side         { background:#F9F8F6; position:relative; min-height:420px; }
.qv-img-side img     { width:100%; height:100%; object-fit:cover; }
.qv-info-side        { padding:40px 36px; font-family:'DM Sans',sans-serif; display:flex; flex-direction:column; gap:18px; }
.qv-close            { position:absolute; top:14px; right:14px; width:34px; height:34px; background:rgba(255,255,255,.9); border:none; border-radius:50%; cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; z-index:2; transition:background .2s; }
.qv-close:hover      { background:#1A1A1A; color:#fff; }
.qv-badge            { position:absolute; top:14px; left:14px; font-size:10px; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:4px 10px; }
.qv-size-btn         { height:36px; padding:0 14px; border:1.5px solid #E8E8E8; background:none; font-size:12px; font-family:'DM Sans',sans-serif; cursor:pointer; transition:all .2s; }
.qv-size-btn:hover, .qv-size-btn.active { border-color:#1A1A1A; background:#1A1A1A; color:#fff; }
.qv-color-swatch     { width:26px; height:26px; border-radius:50%; border:2px solid #E8E8E8; cursor:pointer; transition:transform .2s; }
.qv-color-swatch:hover,.qv-color-swatch.active { transform:scale(1.2); border-color:#1A1A1A; box-shadow:0 0 0 2px #fff,0 0 0 3.5px #1A1A1A; }
.qv-qty-row          { display:flex; align-items:center; width:fit-content; border:1.5px solid #E8E8E8; }
.qv-qty-btn          { width:36px; height:36px; border:none; background:none; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background .2s; }
.qv-qty-btn:hover    { background:#F9F8F6; }
.qv-qty-num          { width:40px; text-align:center; font-size:14px; font-weight:600; border:none; border-left:1.5px solid #E8E8E8; border-right:1.5px solid #E8E8E8; height:36px; outline:none; }
.qv-add-btn          { width:100%; height:48px; background:#1A1A1A; color:#fff; border:none; font-size:12px; font-weight:700; letter-spacing:2px; text-transform:uppercase; cursor:pointer; transition:opacity .2s; margin-top:4px; }
.qv-add-btn:hover    { opacity:.82; }
@media(max-width:767px) {
   .qv-modal         { grid-template-columns:1fr; }
   .qv-img-side      { min-height:260px; max-height:320px; }
}
@endsection


@section('content')

{{-- ══════════════════════════
     HERO
══════════════════════════ --}}
<section class="grid grid-cols-1 md:grid-cols-2 min-h-[calc(100vh-96px)] overflow-hidden">

   {{-- Text panel --}}
   <div class="flex flex-col justify-center px-8 md:px-16 lg:px-24 py-20 bg-[#F9F8F6] relative">
      <p class="font-body text-[11px] font-semibold tracking-[4px] uppercase text-gray-400 mb-6">
         New Season — 2025 Collection
      </p>
      <h1 class="font-display text-[clamp(40px,5vw,72px)] font-semibold leading-none text-[#1A1A1A] mb-6">
         Redefine<br>Your <em class="italic text-gold">Style.</em>
      </h1>
      <p class="font-body text-base text-gray-500 leading-relaxed max-w-[380px] mb-10">
         Premium fashion meets expert tailoring. Curated collections crafted for those who dress with intention.
      </p>
      <div class="flex gap-4 flex-wrap">
         <a href="{{ url('/products') }}"
            class="inline-flex items-center gap-2 h-[50px] px-8 bg-[#1A1A1A] text-white font-body text-[13px] font-semibold tracking-[1.5px] uppercase hover:opacity-80 transition-opacity">
            Shop Now &nbsp;<i class="fa-solid fa-arrow-right text-[10px]"></i>
         </a>
         <a href="{{ url('/services') }}"
            class="inline-flex items-center h-[50px] px-8 bg-transparent text-[#1A1A1A] font-body text-[13px] font-semibold tracking-[1.5px] uppercase border border-[#1A1A1A] hover:bg-[#1A1A1A] hover:text-white transition-all">
            Our Tailors
         </a>
      </div>
      {{-- Scroll indicator --}}
      <div class="absolute bottom-8 left-1/2 -translate-x-1/2 hidden md:flex flex-col items-center gap-2 font-body text-[10px] tracking-[3px] uppercase text-gray-400">
         Scroll
         <span class="w-px h-10 bg-gray-400 block hero-scroll-line"></span>
      </div>
   </div>

   {{-- Image panel --}}
   <div class="relative overflow-hidden h-[55vh] md:h-auto group">
      <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=900&q=80&auto=format&fit=crop"
           alt="Fashion editorial"
           class="w-full h-full object-cover object-top group-hover:scale-[1.04] transition-transform duration-[8s] ease-linear"
           loading="eager">
      {{-- Badge --}}
      <div class="absolute bottom-10 left-10 bg-white/90 backdrop-blur-sm p-4 lg:p-5">
         <span class="font-body text-[11px] text-gray-400 uppercase tracking-[2px]">New Arrivals</span>
         <strong class="block font-display text-[22px] font-semibold mt-0.5">SS 2025</strong>
      </div>
   </div>

</section>


{{-- ══════════════════════════
     CATEGORY BANNERS
══════════════════════════ --}}
<section class="py-20 bg-[#F9F8F6]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      <div class="text-center mb-12">
         <span class="block font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-3">Shop by Category</span>
         <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-semibold text-[#1A1A1A]">Explore Collections</h2>
         <div class="w-12 h-0.5 bg-gold mx-auto mt-3"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

         <a href="{{ url('/category/women') }}" class="relative overflow-hidden cursor-pointer group block" style="aspect-ratio:3/4">
            <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=700&q=80&auto=format&fit=crop"
                 alt="Women" class="w-full h-full object-cover group-hover:scale-[1.06] transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-black/5 group-hover:from-black/65 transition-all duration-300"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
               <span class="font-body text-[10px] tracking-[3px] uppercase opacity-75">Collection 2025</span>
               <h3 class="font-display text-[26px] font-semibold my-1">Women</h3>
               <span class="font-body text-[11px] tracking-[2px] uppercase border-b border-white/50 pb-0.5 hover:border-white transition-colors">Shop Now</span>
            </div>
         </a>

         <a href="{{ url('/category/men') }}" class="relative overflow-hidden cursor-pointer group block" style="aspect-ratio:3/4">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=700&q=80&auto=format&fit=crop"
                 alt="Men" class="w-full h-full object-cover group-hover:scale-[1.06] transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-black/5 group-hover:from-black/65 transition-all duration-300"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
               <span class="font-body text-[10px] tracking-[3px] uppercase opacity-75">Collection 2025</span>
               <h3 class="font-display text-[26px] font-semibold my-1">Men</h3>
               <span class="font-body text-[11px] tracking-[2px] uppercase border-b border-white/50 pb-0.5 hover:border-white transition-colors">Shop Now</span>
            </div>
         </a>

         <a href="{{ url('/products') }}" class="relative overflow-hidden cursor-pointer group block" style="aspect-ratio:3/4">
            <img src="https://images.unsplash.com/photo-1492707892479-7bc8d5a4ee93?w=700&q=80&auto=format&fit=crop"
                 alt="Accessories" class="w-full h-full object-cover group-hover:scale-[1.06] transition-transform duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-black/55 to-black/5 group-hover:from-black/65 transition-all duration-300"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
               <span class="font-body text-[10px] tracking-[3px] uppercase opacity-75">Collection 2025</span>
               <h3 class="font-display text-[26px] font-semibold my-1">Accessories</h3>
               <span class="font-body text-[11px] tracking-[2px] uppercase border-b border-white/50 pb-0.5 hover:border-white transition-colors">Shop Now</span>
            </div>
         </a>

      </div>
   </div>
</section>


{{-- ══════════════════════════
     NEW ARRIVALS GRID
══════════════════════════ --}}
<section class="py-20 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      <div class="text-center mb-12">
         <span class="block font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-3">Just Dropped</span>
         <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-semibold text-[#1A1A1A]">New Arrivals</h2>
         <div class="w-12 h-0.5 bg-gold mx-auto mt-3"></div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6" id="featured-grid">
         @foreach ($product as $item)
         @php
            $attr      = $product_attr[$item->id][0] ?? null;
            $price     = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
            $mrp       = $attr ? $attr->mrp : 0;
            $qty       = $attr ? $attr->qty : 0;
            $isSale    = $attr && $attr->price > 0 && $attr->price < $attr->mrp;
            $isOut     = $qty == 0;
            $attrsJson = htmlspecialchars(json_encode(
               collect($product_attr[$item->id])->map(fn($a) => [
                  'size'  => $a->size  ?? null,
                  'color' => $a->color ?? null,
                  'price' => $a->price,
                  'mrp'   => $a->mrp,
                  'qty'   => $a->qty,
               ])->toArray()
            ), ENT_QUOTES, 'UTF-8');
         @endphp

         <div class="group relative"
              data-id="{{ $item->id }}"
              data-name="{{ addslashes($item->name) }}"
              data-image="{{ asset('/storage/media/'.$item->image) }}"
              data-price="{{ $price }}"
              data-mrp="{{ $mrp }}"
              data-desc="{{ addslashes(Str::substr($item->short_desc, 0, 200)) }}"
              data-attrs="{{ $attrsJson }}"
              data-sale="{{ $isSale ? 1 : 0 }}"
              data-out="{{ $isOut ? 1 : 0 }}">

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
               <button class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center cursor-pointer z-10 opacity-0 group-hover:opacity-100 transition-all hover:bg-[#E63946] hover:text-white text-gray-500 text-[13px] border-none">
                  <i class="fa-regular fa-heart"></i>
               </button>

               {{-- Image --}}
               <img src="{{ asset('/storage/media/'.$item->image) }}" alt="{{ $item->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy">

               {{-- Hover overlay --}}
               @if(!$isOut)
               <div class="absolute inset-0 bg-[#1A1A1A]/82 flex flex-col items-center justify-center gap-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                  <button onclick="openQuickView(this.closest('[data-id]'))"
                     class="w-40 h-10 bg-white text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[1.5px] uppercase border-none cursor-pointer hover:bg-gold hover:text-white transition-all">
                     <i class="fa-regular fa-eye mr-1"></i> Quick View
                  </button>
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

      <div class="text-center mt-12">
         <a href="{{ url('/products') }}"
            class="inline-flex items-center h-[46px] px-8 bg-transparent text-[#1A1A1A] font-body text-[12px] font-semibold tracking-[1.5px] uppercase border border-[#1A1A1A] hover:bg-[#1A1A1A] hover:text-white transition-all">
            View All Products &nbsp;<i class="fa-solid fa-arrow-right text-[10px]"></i>
         </a>
      </div>
   </div>
</section>


{{-- ══════════════════════════
     TRENDING / ON SALE / LATEST
══════════════════════════ --}}
<section class="py-20 bg-[#F9F8F6]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      <div class="text-center mb-12">
         <span class="block font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-3">Curated Picks</span>
         <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-semibold text-[#1A1A1A]">Trending This Week</h2>
         <div class="w-12 h-0.5 bg-gold mx-auto mt-3"></div>
      </div>

      {{-- Filter tabs --}}
      <div class="flex justify-center border-b border-[#E8E8E8] mb-10">
         <button class="filter-tab font-body text-[12px] font-semibold tracking-[2px] uppercase px-7 py-3 border-none bg-none cursor-pointer text-gray-400 border-b-2 border-transparent -mb-px transition-all active-tab" onclick="switchTab(this,'tab-trending')" style="color:#1A1A1A;border-bottom:2px solid #1A1A1A">Trending</button>
         <button class="filter-tab font-body text-[12px] font-semibold tracking-[2px] uppercase px-7 py-3 border-none bg-none cursor-pointer text-gray-400 border-b-2 border-transparent -mb-px transition-all" onclick="switchTab(this,'tab-discounted')">On Sale</button>
         <button class="filter-tab font-body text-[12px] font-semibold tracking-[2px] uppercase px-7 py-3 border-none bg-none cursor-pointer text-gray-400 border-b-2 border-transparent -mb-px transition-all" onclick="switchTab(this,'tab-latest')">Latest</button>
      </div>

      {{-- Trending --}}
      <div id="tab-trending" class="filter-panel active">
         @forelse($tranding_product as $item)
         @php
            $attr  = $tranding_product_attr[$item->id][0] ?? null;
            $price = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
            $mrp   = $attr ? $attr->mrp : 0;
            $qty   = $attr ? $attr->qty : 0;
            $isSale= $attr && $attr->price > 0 && $attr->price < $attr->mrp;
            $isOut = $qty == 0;
         @endphp
         @include('front._product_card', compact('item','attr','price','mrp','qty','isSale','isOut'))
         @empty
         <p class="font-body text-center text-gray-400 py-8 col-span-4">No trending products yet.</p>
         @endforelse
      </div>

      {{-- Discounted --}}
      <div id="tab-discounted" class="filter-panel">
         @forelse($discounted_product as $item)
         @php
            $attr  = $discounted_product_attr[$item->id][0] ?? null;
            $price = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
            $mrp   = $attr ? $attr->mrp : 0;
            $qty   = $attr ? $attr->qty : 0;
            $isSale= $attr && $attr->price > 0 && $attr->price < $attr->mrp;
            $isOut = $qty == 0;
         @endphp
         @include('front._product_card', compact('item','attr','price','mrp','qty','isSale','isOut'))
         @empty
         <p class="font-body text-center text-gray-400 py-8 col-span-4">No discounted products yet.</p>
         @endforelse
      </div>

      {{-- Latest --}}
      <div id="tab-latest" class="filter-panel">
         @forelse($latest_product as $item)
         @php
            $attr  = $latest_product_attr[$item->id][0] ?? null;
            $price = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
            $mrp   = $attr ? $attr->mrp : 0;
            $qty   = $attr ? $attr->qty : 0;
            $isSale= $attr && $attr->price > 0 && $attr->price < $attr->mrp;
            $isOut = $qty == 0;
         @endphp
         @include('front._product_card', compact('item','attr','price','mrp','qty','isSale','isOut'))
         @empty
         <p class="font-body text-center text-gray-400 py-8 col-span-4">No new products yet.</p>
         @endforelse
      </div>

   </div>
</section>


{{-- ══════════════════════════
     RECOMMENDED (logged-in)
══════════════════════════ --}}
@if(!empty($recommendedProducts))
<section class="py-20 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <div class="text-center mb-12">
         <span class="block font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-3">Picked For You</span>
         <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-semibold text-[#1A1A1A]">Recommended</h2>
         <div class="w-12 h-0.5 bg-gold mx-auto mt-3"></div>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
         @foreach($recommendedProducts as $item)
         @php
            $price  = $item['price'] > 0 ? $item['price'] : $item['mrp'];
            $mrp    = $item['mrp'];
            $qty    = $item['qty'];
            $isSale = $item['price'] > 0 && $item['price'] < $item['mrp'];
            $isOut  = $qty == 0;
         @endphp
         <div class="group relative">
            <div class="relative overflow-hidden bg-[#F9F8F6]" style="aspect-ratio:3/4">
               @if($isOut)<span class="absolute top-3 left-3 bg-gray-500 text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sold Out</span>
               @elseif($isSale || $item['is_discounted'])<span class="absolute top-3 left-3 bg-[#E63946] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">Sale</span>
               @else<span class="absolute top-3 left-3 bg-[#1A1A1A] text-white font-body text-[10px] font-bold tracking-wide uppercase px-2.5 py-1 z-10">New</span>@endif

               <button class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center cursor-pointer z-10 opacity-0 group-hover:opacity-100 transition-all hover:bg-[#E63946] hover:text-white text-gray-500 text-[13px] border-none">
                  <i class="fa-regular fa-heart"></i>
               </button>

               <img src="{{ asset('/storage/media/'.$item['image']) }}" alt="{{ $item['name'] }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">

               @if(!$isOut)
               <div class="absolute inset-0 bg-[#1A1A1A]/82 flex flex-col items-center justify-center gap-2.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                  <a href="{{ url('/product-details/'.$item['id']) }}"
                     class="flex items-center justify-center w-40 h-10 bg-white text-[#1A1A1A] font-body text-[11px] font-semibold tracking-[1.5px] uppercase hover:bg-gold hover:text-white transition-all">
                     <i class="fa-regular fa-eye mr-1"></i> View Details
                  </a>
                  <button onclick="addToCart({{ $item['id'] }})"
                     class="w-40 h-10 bg-transparent text-white font-body text-[11px] font-semibold tracking-[1.5px] uppercase border border-white/50 cursor-pointer hover:bg-white hover:text-[#1A1A1A] transition-all">
                     <i class="fa-solid fa-bag-shopping mr-1"></i> Add to Cart
                  </button>
               </div>
               @endif
            </div>
            <div class="pt-3.5 px-1 pb-2">
               <div class="font-body text-[13.5px] font-medium text-[#1A1A1A] leading-snug mb-1.5">
                  <a href="{{ url('/product-details/'.$item['id']) }}" class="hover:text-gold transition-colors">{{ $item['name'] }}</a>
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
   </div>
</section>
@endif


{{-- ══════════════════════════
     NEWSLETTER
══════════════════════════ --}}
<section class="bg-[#1A1A1A] text-white py-20 text-center">
   <div class="max-w-2xl mx-auto px-6">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-white/40 mb-4">Exclusive Access</p>
      <h2 class="font-display text-[clamp(32px,4vw,52px)] font-semibold mb-3">
         Stay in <em class="italic text-gold">Style</em>
      </h2>
      <p class="font-body text-[15px] text-white/55 mb-9">Get early access to new drops, exclusive offers, and tailor spotlights.</p>
      <div class="flex max-w-[460px] mx-auto">
         <input type="email" placeholder="Your email address"
            class="flex-1 h-[50px] bg-white/10 border-none text-white font-body text-[14px] px-5 outline-none placeholder-white/30 focus:bg-white/15 transition-colors">
         <button type="button"
            class="h-[50px] px-7 bg-gold text-white font-body font-bold text-[11px] tracking-[2px] uppercase border-none cursor-pointer hover:opacity-88 transition-opacity shrink-0">
            Subscribe
         </button>
      </div>
      <p class="font-body text-[11px] text-white/25 mt-4">No spam, unsubscribe anytime.</p>
   </div>
</section>


{{-- ══════════════════════════
     QUICK VIEW MODAL
══════════════════════════ --}}
<div class="qv-backdrop" id="qv-backdrop" onclick="closeQuickView(event)">
   <div class="qv-modal" id="qv-modal">

      <div class="qv-img-side" id="qv-img-side">
         <button class="qv-close" onclick="closeQuickView(null,true)">
            <i class="fa-solid fa-xmark"></i>
         </button>
         <span class="qv-badge bg-[#1A1A1A] text-white" id="qv-badge" style="display:none"></span>
         <img id="qv-img" src="" alt="" style="width:100%;height:100%;object-fit:cover;min-height:420px;">
      </div>

      <div class="qv-info-side">
         <p class="font-body text-[10px] tracking-[3px] uppercase text-gray-400">StitchSpot</p>
         <h2 class="font-display text-[26px] font-semibold text-[#1A1A1A] leading-tight" id="qv-title">Product Name</h2>

         <div class="flex items-center gap-3">
            <span class="font-body text-[20px] font-bold" id="qv-price"></span>
            <span class="font-body text-[15px] text-gray-400 line-through" id="qv-orig" style="display:none"></span>
         </div>

         <div id="qv-size-wrap">
            <p class="font-body text-[11px] font-semibold tracking-[1.5px] uppercase text-gray-400 mb-2.5">Select Size</p>
            <div class="flex gap-2 flex-wrap" id="qv-sizes"></div>
         </div>

         <div id="qv-color-wrap">
            <p class="font-body text-[11px] font-semibold tracking-[1.5px] uppercase text-gray-400 mb-2.5">Select Color</p>
            <div class="flex gap-2.5 flex-wrap" id="qv-colors"></div>
         </div>

         <div>
            <p class="font-body text-[11px] font-semibold tracking-[1.5px] uppercase text-gray-400 mb-2.5">Quantity</p>
            <div class="qv-qty-row">
               <button class="qv-qty-btn" onclick="qvQty(-1)">−</button>
               <input class="qv-qty-num" type="number" id="qv-qty" value="1" min="1" max="20" readonly>
               <button class="qv-qty-btn" onclick="qvQty(1)">+</button>
            </div>
         </div>

         <button class="qv-add-btn" id="qv-add-btn" onclick="qvAddToCart()">
            <i class="fa-solid fa-bag-shopping mr-2"></i> Add to Cart
         </button>

         <p class="font-body text-center text-[12px] text-gray-400 underline cursor-pointer">
            <a id="qv-link" href="#">View Full Details →</a>
         </p>

         <p class="font-body text-[13px] text-gray-500 leading-relaxed border-t border-[#E8E8E8] pt-4" id="qv-desc"></p>
      </div>

   </div>
</div>

@endsection


@section('scripts')
<script>
/* ── Filter Tabs ── */
function switchTab(btn, panelId) {
   document.querySelectorAll('.filter-tab').forEach(b => {
      b.style.color = '#888';
      b.style.borderBottom = '2px solid transparent';
   });
   document.querySelectorAll('.filter-panel').forEach(p => p.classList.remove('active'));
   btn.style.color = '#1A1A1A';
   btn.style.borderBottom = '2px solid #1A1A1A';
   document.getElementById(panelId).classList.add('active');
}

/* ── Quick View ── */
let qvData = null;

function openQuickView(card) {
   const id     = card.dataset.id;
   const name   = card.dataset.name;
   const image  = card.dataset.image;
   const price  = parseFloat(card.dataset.price);
   const mrp    = parseFloat(card.dataset.mrp);
   const desc   = card.dataset.desc;
   const isSale = card.dataset.sale === '1';
   const isOut  = card.dataset.out  === '1';
   let   attrs  = [];
   try { attrs = JSON.parse(card.dataset.attrs || '[]'); } catch(e) {}

   qvData = { id, attrs };

   document.getElementById('qv-img').src            = image;
   document.getElementById('qv-title').textContent  = name;
   document.getElementById('qv-link').href          = `/product-details/${id}`;
   document.getElementById('qv-desc').textContent   = desc ? desc + '…' : '';
   document.getElementById('qv-price').textContent  = `Rs ${price.toLocaleString()}`;

   const origEl = document.getElementById('qv-orig');
   if (isSale) { origEl.textContent = `Rs ${mrp.toLocaleString()}`; origEl.style.display = 'inline'; }
   else        { origEl.style.display = 'none'; }

   const badge = document.getElementById('qv-badge');
   if      (isOut)   { badge.textContent='Sold Out'; badge.style.background='#888'; badge.style.display='inline'; }
   else if (isSale)  { badge.textContent='Sale';     badge.style.background='#E63946'; badge.style.display='inline'; }
   else              { badge.textContent='New';      badge.style.background='#1A1A1A'; badge.style.display='inline'; }

   const sizes   = [...new Set(attrs.map(a => a.size).filter(Boolean))];
   const sizesEl = document.getElementById('qv-sizes');
   sizesEl.innerHTML = sizes.length
      ? sizes.map(s => `<button class="qv-size-btn" onclick="qvSelectSize(this)">${s}</button>`).join('')
      : '<span style="font-size:13px;color:#888">One size</span>';
   document.getElementById('qv-size-wrap').style.display = sizes.length ? 'block' : 'none';

   const colors   = [...new Set(attrs.map(a => a.color).filter(Boolean))];
   const colorsEl = document.getElementById('qv-colors');
   colorsEl.innerHTML = colors.length
      ? colors.map(c => `<span class="qv-color-swatch" title="${c}" style="background:${c.toLowerCase()}" onclick="qvSelectColor(this)"></span>`).join('')
      : '';
   document.getElementById('qv-color-wrap').style.display = colors.length ? 'block' : 'none';

   document.getElementById('qv-qty').value = 1;
   document.getElementById('qv-backdrop').classList.add('open');
   document.body.style.overflow = 'hidden';
}

function closeQuickView(e, force = false) {
   if (force || (e && e.target === document.getElementById('qv-backdrop'))) {
      document.getElementById('qv-backdrop').classList.remove('open');
      document.body.style.overflow = '';
   }
}

function qvSelectSize(btn) {
   document.querySelectorAll('.qv-size-btn').forEach(b => b.classList.remove('active'));
   btn.classList.add('active');
}
function qvSelectColor(el) {
   document.querySelectorAll('.qv-color-swatch').forEach(s => s.classList.remove('active'));
   el.classList.add('active');
}
function qvQty(dir) {
   const el = document.getElementById('qv-qty');
   el.value = Math.max(1, parseInt(el.value) + dir);
}
function qvAddToCart() {
   if (!qvData) return;
   const size  = document.querySelector('.qv-size-btn.active')?.textContent || '';
   const color = document.querySelector('.qv-color-swatch.active')?.title   || '';
   const qty   = parseInt(document.getElementById('qv-qty').value) || 1;
   const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
   if (size || color) {
      add_to_cart(qvData.id, size, color, qty, token);
   } else {
      addToCart(qvData.id);
   }
   closeQuickView(null, true);
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeQuickView(null, true); });
</script>
@endsection
