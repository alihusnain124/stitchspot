@extends('front.layout')
@section('title', ($cat->category_name ?? 'Category') . ' – StitchSpot')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:280px">
   @if($cat->category_image ?? null)
      @php $catHeroImg = str_starts_with($cat->category_image, 'http') ? $cat->category_image : asset('storage/media/category/'.$cat->category_image); @endphp
      <img src="{{ $catHeroImg }}" alt="{{ $cat->category_name }}"
           class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   @else
      <img src="{{ asset('front-assets/images/f3.jpg') }}" alt=""
           class="absolute inset-0 w-full h-full object-cover object-center opacity-40">
   @endif
   <div class="absolute inset-0" style="background:linear-gradient(to bottom,rgba(0,0,0,.4) 0%,rgba(0,0,0,.65) 100%)"></div>
   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-16" style="min-height:280px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-3">Our Collection</p>
      <h1 class="font-display text-white text-[clamp(30px,4.5vw,56px)] font-semibold leading-tight mb-4">
         {{ $cat->category_name ?? 'Category' }}
      </h1>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <a href="{{ url('/products') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Products</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">{{ $cat->category_name ?? 'Category' }}</span>
      </div>
   </div>
</section>

{{-- Page body --}}
<section class="bg-[#FAFAF9] py-10 min-h-screen">
<div class="max-w-[1340px] mx-auto px-4 lg:px-8">

   {{-- Mobile filter toggle --}}
   <div class="flex items-center justify-between mb-6 lg:hidden">
      <p class="font-body text-[13px] text-gray-500">{{ $total }} products</p>
      <button onclick="toggleFilterPanel()"
         class="flex items-center gap-2 h-9 px-4 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[1.5px] uppercase border-none cursor-pointer">
         <i class="fa-solid fa-sliders text-[12px]"></i> Filter &amp; Sort
      </button>
   </div>

   <div class="flex gap-8">

      <div id="filter-overlay" onclick="toggleFilterPanel()" class="fixed inset-0 bg-black/50 z-[1050] hidden"></div>

      {{-- ===== SIDEBAR ===== --}}
      <aside id="filter-panel"
         class="fixed top-0 left-0 h-full w-[280px] bg-white z-[1100] overflow-y-auto shadow-xl transition-transform duration-300 -translate-x-full
                lg:sticky lg:top-[88px] lg:h-auto lg:max-h-[calc(100vh-112px)] lg:w-[230px] lg:flex-none lg:bg-transparent lg:shadow-none lg:translate-x-0 lg:overflow-y-auto lg:self-start">

         {{-- Mobile header --}}
         <div class="flex items-center justify-between p-5 border-b border-gray-100 lg:hidden">
            <span class="font-body text-[12px] font-semibold text-[#1A1A1A] tracking-[2px] uppercase">Filters</span>
            <button onclick="toggleFilterPanel()" class="w-8 h-8 flex items-center justify-center text-gray-400 bg-transparent border-none cursor-pointer">
               <i class="fa-solid fa-xmark text-[16px]"></i>
            </button>
         </div>

         <form method="GET" action="{{ url('/category/'.$cat->category_slug) }}" id="filter-form" class="p-5 lg:p-0">

            @php $hasFilters = !empty($filters['brands']) || !empty($filters['colors']) || !empty($filters['sizes']); @endphp
            @if($hasFilters)
            <div class="flex items-center justify-between mb-5">
               <span class="font-body text-[10px] tracking-[1.5px] uppercase text-gray-400">Active Filters</span>
               <a href="{{ url('/category/'.$cat->category_slug) }}" class="font-body text-[11px] text-[#E63946] hover:underline">Clear All</a>
            </div>
            @endif

            {{-- Sort --}}
            <div class="border-b border-gray-100 pb-5 mb-5">
               <button type="button" onclick="toggleSection('sec-sort', this)"
                  class="w-full flex items-center justify-between bg-transparent border-none cursor-pointer mb-3">
                  <span class="font-body text-[11px] font-semibold tracking-[2px] uppercase text-[#1A1A1A]">Sort By</span>
                  <i class="fa-solid fa-chevron-up text-gray-300 text-[10px]"></i>
               </button>
               <div id="sec-sort" class="flex flex-col gap-2">
                  @foreach(['newest' => 'Newest First', 'oldest' => 'Oldest First'] as $val => $label)
                  <label class="ss-radio-label">
                     <input type="radio" name="sort" value="{{ $val }}"
                        {{ $filters['sort'] === $val ? 'checked' : '' }} class="ss-radio-input">
                     <span class="ss-radio-circle"></span>
                     <span class="font-body text-[13px] text-gray-600">{{ $label }}</span>
                  </label>
                  @endforeach
               </div>
            </div>

            {{-- Brand --}}
            @if($filter_brands->count())
            @php $brandExtra = $filter_brands->count() - 5; @endphp
            <div class="border-b border-gray-100 pb-5 mb-5">
               <button type="button" onclick="toggleSection('sec-brand', this)"
                  class="w-full flex items-center justify-between bg-transparent border-none cursor-pointer mb-3">
                  <span class="font-body text-[11px] font-semibold tracking-[2px] uppercase text-[#1A1A1A]">
                     Brand
                     @if(!empty($filters['brands']))<span class="ml-1 font-body text-[10px] text-gold">({{ count($filters['brands']) }})</span>@endif
                  </span>
                  <i class="fa-solid fa-chevron-up text-gray-300 text-[10px]"></i>
               </button>
               <div id="sec-brand" class="space-y-2.5">
                  @foreach($filter_brands as $i => $b)
                  <label class="flex items-center gap-2.5 cursor-pointer group {{ $i >= 5 && !in_array($b->id, $filters['brands']) ? 'brand-extra hidden' : '' }}">
                     <input type="checkbox" name="brand[]" value="{{ $b->id }}"
                        {{ in_array($b->id, $filters['brands']) ? 'checked' : '' }}
                        class="w-3.5 h-3.5 accent-[#C9A96E] rounded cursor-pointer">
                     <span class="font-body text-[13px] text-gray-600 group-hover:text-[#1A1A1A] transition-colors">{{ $b->brand_name }}</span>
                  </label>
                  @endforeach
                  @if($brandExtra > 0)
                  <button type="button" id="brand-more-btn" onclick="showMore('brand-extra','brand-more-btn')"
                     class="font-body text-[11px] text-gold hover:underline bg-transparent border-none cursor-pointer p-0 mt-1">
                     + {{ $brandExtra }} more
                  </button>
                  @endif
               </div>
            </div>
            @endif

            {{-- Color --}}
            @if($filter_colors->count())
            @php $colorExtra = $filter_colors->count() - 5; @endphp
            <div class="border-b border-gray-100 pb-5 mb-5">
               <button type="button" onclick="toggleSection('sec-color', this)"
                  class="w-full flex items-center justify-between bg-transparent border-none cursor-pointer mb-3">
                  <span class="font-body text-[11px] font-semibold tracking-[2px] uppercase text-[#1A1A1A]">
                     Color
                     @if(!empty($filters['colors']))<span class="ml-1 font-body text-[10px] text-gold">({{ count($filters['colors']) }})</span>@endif
                  </span>
                  <i class="fa-solid fa-chevron-up text-gray-300 text-[10px]"></i>
               </button>
               <div id="sec-color" class="space-y-2.5">
                  @foreach($filter_colors as $i => $col)
                  <label class="flex items-center gap-2.5 cursor-pointer group {{ $i >= 5 && !in_array($col->id, $filters['colors']) ? 'color-extra hidden' : '' }}">
                     <input type="checkbox" name="color[]" value="{{ $col->id }}"
                        {{ in_array($col->id, $filters['colors']) ? 'checked' : '' }}
                        class="w-3.5 h-3.5 accent-[#C9A96E] rounded cursor-pointer">
                     <span class="font-body text-[13px] text-gray-600 group-hover:text-[#1A1A1A] transition-colors">{{ $col->color }}</span>
                  </label>
                  @endforeach
                  @if($colorExtra > 0)
                  <button type="button" id="color-more-btn" onclick="showMore('color-extra','color-more-btn')"
                     class="font-body text-[11px] text-gold hover:underline bg-transparent border-none cursor-pointer p-0 mt-1">
                     + {{ $colorExtra }} more
                  </button>
                  @endif
               </div>
            </div>
            @endif

            {{-- Size --}}
            @if($filter_sizes->count())
            <div class="pb-5 mb-5">
               <button type="button" onclick="toggleSection('sec-size', this)"
                  class="w-full flex items-center justify-between bg-transparent border-none cursor-pointer mb-3">
                  <span class="font-body text-[11px] font-semibold tracking-[2px] uppercase text-[#1A1A1A]">
                     Size
                     @if(!empty($filters['sizes']))<span class="ml-1 font-body text-[10px] text-gold">({{ count($filters['sizes']) }})</span>@endif
                  </span>
                  <i class="fa-solid fa-chevron-up text-gray-300 text-[10px]"></i>
               </button>
               <div id="sec-size" class="flex flex-wrap gap-2">
                  @foreach($filter_sizes as $sz)
                  <label class="relative cursor-pointer">
                     <input type="checkbox" name="size[]" value="{{ $sz->id }}"
                        {{ in_array($sz->id, $filters['sizes']) ? 'checked' : '' }}
                        class="absolute opacity-0 w-0 h-0 peer">
                     <span class="flex items-center justify-center min-w-[38px] h-9 px-2 border font-body text-[12px] transition-all cursor-pointer
                        peer-checked:border-[#1A1A1A] peer-checked:bg-[#1A1A1A] peer-checked:text-white
                        border-gray-200 text-gray-500 hover:border-[#1A1A1A] hover:text-[#1A1A1A]">
                        {{ $sz->size }}
                     </span>
                  </label>
                  @endforeach
               </div>
            </div>
            @endif

            {{-- Apply --}}
            <div class="mt-4 border-t border-gray-100 pt-5">
               <button type="submit"
                  class="w-full h-11 bg-[#1A1A1A] text-white font-body text-[11px] font-semibold tracking-[2px] uppercase border-none cursor-pointer hover:bg-gold transition-colors">
                  Apply Filters
               </button>
            </div>

         </form>
      </aside>

      {{-- ===== MAIN ===== --}}
      <div class="flex-1 min-w-0">

         <div class="hidden lg:flex items-center justify-between mb-7 flex-wrap gap-3">
            <p class="font-body text-[13px] text-gray-500">
               Showing <span id="shown-count">{{ count($product) }}</span> of <strong class="text-[#1A1A1A]">{{ $total }}</strong> products
            </p>
            <div class="flex flex-wrap gap-2">
               @foreach($filter_brands as $b)
                  @if(in_array($b->id, $filters['brands']))
                  @php $p=request()->except([]); $nb=array_values(array_diff($filters['brands'],[$b->id])); if($nb) $p['brand']=$nb; else unset($p['brand']); @endphp
                  <a href="{{ url('/category/'.$cat->category_slug).'?'.http_build_query($p) }}"
                     class="flex items-center gap-1.5 h-6 px-2.5 bg-[#1A1A1A] text-white font-body text-[10px] hover:bg-[#E63946] transition-colors">
                     {{ $b->brand_name }} <i class="fa-solid fa-xmark text-[9px]"></i>
                  </a>
                  @endif
               @endforeach
               @foreach($filter_colors as $col)
                  @if(in_array($col->id, $filters['colors']))
                  @php $p=request()->except([]); $nco=array_values(array_diff($filters['colors'],[$col->id])); if($nco) $p['color']=$nco; else unset($p['color']); @endphp
                  <a href="{{ url('/category/'.$cat->category_slug).'?'.http_build_query($p) }}"
                     class="flex items-center gap-1.5 h-6 px-2.5 bg-[#1A1A1A] text-white font-body text-[10px] hover:bg-[#E63946] transition-colors">
                     {{ $col->color }} <i class="fa-solid fa-xmark text-[9px]"></i>
                  </a>
                  @endif
               @endforeach
               @foreach($filter_sizes as $sz)
                  @if(in_array($sz->id, $filters['sizes']))
                  @php $p=request()->except([]); $ns=array_values(array_diff($filters['sizes'],[$sz->id])); if($ns) $p['size']=$ns; else unset($p['size']); @endphp
                  <a href="{{ url('/category/'.$cat->category_slug).'?'.http_build_query($p) }}"
                     class="flex items-center gap-1.5 h-6 px-2.5 bg-[#1A1A1A] text-white font-body text-[10px] hover:bg-[#E63946] transition-colors">
                     {{ $sz->size }} <i class="fa-solid fa-xmark text-[9px]"></i>
                  </a>
                  @endif
               @endforeach
            </div>
         </div>

         @if($product->isEmpty())
         <div class="text-center py-20">
            <i class="fa-solid fa-shirt text-[56px] text-[#E8E8E8] mb-5 block"></i>
            <h3 class="font-display text-[24px] text-[#1A1A1A] mb-2">No Products Found</h3>
            <p class="font-body text-[14px] text-gray-400 mb-6">Try adjusting or clearing your filters.</p>
            <a href="{{ url('/category/'.$cat->category_slug) }}"
               class="inline-flex items-center h-10 px-8 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[2px] uppercase hover:bg-gold transition-colors">
               Clear Filters
            </a>
         </div>
         @else
         <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6" id="products-grid">
            @foreach ($product as $item)
            @php
               $attr   = $product_attr[$item->id][0] ?? null;
               $price  = $attr ? ($attr->price > 0 ? $attr->price : $attr->mrp) : 0;
               $mrp    = $attr ? $attr->mrp : 0;
               $qty    = $attr ? $attr->qty : 0;
               $isSale = $attr && $attr->price > 0 && $attr->price < $attr->mrp;
               $isOut  = $qty == 0;
            @endphp
            @include('front._product_card', compact('item','price','mrp','qty','isSale','isOut'))
            @endforeach
         </div>

         @if($total > 10)
         <div class="text-center mt-12" id="load-more-wrap">
            <p class="font-body text-[12px] text-gray-400 mb-4">
               Showing <span id="shown-count-footer">{{ count($product) }}</span> of {{ $total }} products
            </p>
            <button id="load-more-btn" onclick="loadMore()"
               class="inline-flex items-center gap-2 h-12 px-10 bg-[#1A1A1A] font-body text-[11px] font-semibold tracking-[2px] uppercase hover:bg-gold transition-colors border-none cursor-pointer"
               style="color:#fff !important">
               <span id="lm-text" style="color:#fff !important">Load More</span>
               <span id="lm-spinner" style="display:none;color:#fff !important"><i class="fa-solid fa-spinner fa-spin"></i></span>
            </button>
         </div>
         @endif
         @endif

      </div>
   </div>
</div>
</section>

<style>
.ss-radio-label { display:flex; align-items:center; gap:10px; cursor:pointer; padding:5px 0; }
.ss-radio-input { display:none; }
.ss-radio-circle { width:16px; height:16px; border-radius:50%; border:2px solid #D1D5DB; flex-shrink:0; transition:border-color .15s; background:radial-gradient(circle, transparent 40%, transparent 40%); }
.ss-radio-input:checked + .ss-radio-circle { border-color:#C9A96E; background:radial-gradient(circle, #C9A96E 40%, transparent 40%); }
.ss-radio-label:hover .ss-radio-circle { border-color:#9CA3AF; }
</style>

@endsection

@section('scripts')
<script>
var _lmOffset  = {{ count($product) }};
var _lmHasMore = {{ $total > count($product) ? 'true' : 'false' }};
var _catSlug   = '{{ $cat->category_slug }}';

function showMore(cls, btnId) {
   document.querySelectorAll('.' + cls).forEach(function(el){ el.classList.remove('hidden'); });
   var btn = document.getElementById(btnId);
   if (btn) btn.style.display = 'none';
}

function toggleSection(id, btn) {
   var el   = document.getElementById(id);
   var icon = btn.querySelector('i');
   var hidden = el.style.display === 'none';
   el.style.display = hidden ? '' : 'none';
   icon.className = hidden
      ? 'fa-solid fa-chevron-up text-gray-300 text-[10px]'
      : 'fa-solid fa-chevron-down text-gray-300 text-[10px]';
}

function toggleFilterPanel() {
   var panel   = document.getElementById('filter-panel');
   var overlay = document.getElementById('filter-overlay');
   var isOpen  = !panel.classList.contains('-translate-x-full');
   if (isOpen) {
      panel.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
      document.body.style.overflow = '';
   } else {
      panel.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
   }
}

function loadMore() {
   if (!_lmHasMore) return;
   var btn  = document.getElementById('load-more-btn');
   var txt  = document.getElementById('lm-text');
   var spin = document.getElementById('lm-spinner');
   btn.disabled = true;
   txt.textContent = 'Loading…';
   spin.style.display = 'inline';

   var params = new URLSearchParams(window.location.search);
   params.set('offset', _lmOffset);
   fetch('/category/' + _catSlug + '/more?' + params.toString())
      .then(function(r){ return r.json(); })
      .then(function(data) {
         document.getElementById('products-grid').insertAdjacentHTML('beforeend', data.html);
         _lmOffset  = data.next_offset;
         _lmHasMore = data.has_more;
         ['shown-count','shown-count-footer'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.textContent = _lmOffset;
         });
         if (!_lmHasMore) {
            document.getElementById('load-more-wrap').remove();
         } else {
            btn.disabled = false;
            txt.textContent = 'Load More';
            spin.style.display = 'none';
         }
      })
      .catch(function() {
         btn.disabled = false;
         txt.textContent = 'Load More';
         spin.style.display = 'none';
      });
}
</script>
@endsection
