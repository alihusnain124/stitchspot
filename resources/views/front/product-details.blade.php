@extends('front.layout')
@section('title', ($product[0]->name ?? 'Product') . ' – StitchSpot')

@section('extra-css')
   /* Star rating input */
   .rating-group { display:inline-flex; flex-direction:row-reverse; }
   .rating__input { position:absolute; left:-9999px; }
   .rating__label { cursor:pointer; color:#D1D5DB; font-size:20px; padding:0 3px; transition:color .15s; }
   .rating__input:checked ~ .rating__label,
   .rating__label:hover,
   .rating__label:hover ~ .rating__label { color:#C9A96E; }
   .rating__input--none { display:none; }
@endsection

@section('content')

@php
   $p   = $product[0];
   $pid = $p->id;

   /* Build color and size arrays */
   $arrcolor = [];
   $arrsize  = [];
   foreach ($product_attr[$pid] as $attr) {
      $arrcolor[$attr->color_id] = $attr->color;
      $arrsize[$attr->size_id]   = $attr->size;
   }
   $arrcolor = array_unique($arrcolor);
   $arrsize  = array_unique($arrsize);

   /* Active variant */
   $activeAttr = isset($again_product[0])
      ? ($again_product_attr[$again_product[0]->id][0] ?? $product_attr[$pid][0])
      : $product_attr[$pid][0];

   $activeProduct = isset($again_product[0]) ? $again_product[0] : $p;

   $hasSale = isset($activeAttr) && $activeAttr->price > 0;
@endphp

{{-- ── Breadcrumb ── --}}
<div class="bg-[#F9F8F6] border-b border-gray-100 py-3">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8 flex items-center gap-2 font-body text-[11.5px] text-gray-400">
      <a href="{{ url('/') }}" class="hover:text-gold transition-colors">Home</a>
      <span>/</span>
      <a href="{{ url('/products') }}" class="hover:text-gold transition-colors">Products</a>
      <span>/</span>
      <span class="text-[#1A1A1A]">{{ $activeProduct->name }}</span>
   </div>
</div>

{{-- ── Main product section ── --}}
<section class="py-12 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <div class="flex flex-col lg:flex-row gap-10 lg:gap-16">

         {{-- ── LEFT: Images ── --}}
         <div class="lg:w-[480px] shrink-0">
            <div class="overflow-hidden bg-gray-50 border border-gray-100 mb-3" style="aspect-ratio:3/4">
               <img id="main-img"
                    src="{{ asset('storage/media/' . ($activeAttr->attr_image ?? $p->image)) }}"
                    alt="{{ $activeProduct->name }}"
                    class="w-full h-full object-cover">
            </div>

            {{-- Thumbnails --}}
            <div class="grid grid-cols-4 gap-2">
               @foreach($product_attr[$pid] as $item)
               <div class="overflow-hidden border border-gray-100 cursor-pointer hover:border-gold transition-colors"
                    style="aspect-ratio:1/1"
                    onclick="document.getElementById('main-img').src='{{ asset('storage/media/'.$item->attr_image) }}'">
                  <img src="{{ asset('storage/media/'.$item->attr_image) }}"
                       alt="{{ $activeProduct->name }}"
                       class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
               </div>
               @endforeach
            </div>
         </div>

         {{-- ── RIGHT: Details ── --}}
         <div class="flex-1 min-w-0">

            {{-- Name --}}
            <h1 class="font-display text-[clamp(26px,3.5vw,38px)] font-semibold text-[#1A1A1A] leading-tight mb-4">
               {{ $activeProduct->name }}
            </h1>

            {{-- Price --}}
            <div class="mb-6">
               @if($hasSale)
               <span class="font-body text-[14px] text-gray-400 line-through mr-2">Rs {{ number_format($activeAttr->mrp) }}/-</span>
               <span class="font-display text-[32px] font-semibold text-[#1A1A1A]">Rs {{ number_format($activeAttr->price) }}/-</span>
               <span class="ml-3 inline-block bg-gold/10 text-gold font-body text-[10px] tracking-[0.15em] uppercase px-3 py-1">
                  Sale
               </span>
               @else
               <span class="font-display text-[32px] font-semibold text-[#1A1A1A]">Rs {{ number_format($activeAttr->mrp ?? 0) }}/-</span>
               @endif
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100 mb-6"></div>

            {{-- Short desc --}}
            @if($p->short_desc)
            <p class="font-body text-[14px] text-gray-500 leading-relaxed mb-6">{{ $p->short_desc }}</p>
            @endif

            {{-- Color --}}
            <div class="mb-4">
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Colour</label>
               <select id="color"
                  class="w-48 h-10 px-3 font-body text-sm text-[#1A1A1A] bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors appearance-none cursor-pointer">
                  <option value="">Select Colour</option>
                  @if(isset($again_product[0]) && isset($activeAttr->color))
                     <option value="{{ $activeAttr->color }}" selected>{{ $activeAttr->color }}</option>
                  @else
                     @foreach($arrcolor as $c)
                     <option value="{{ $c }}" {{ $c == ($product_attr[$pid][0]->color ?? '') ? 'selected' : '' }}>
                        {{ $c }}
                     </option>
                     @endforeach
                  @endif
               </select>
            </div>

            {{-- Size --}}
            <div class="mb-6">
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Size</label>
               <select id="size"
                  class="w-48 h-10 px-3 font-body text-sm text-[#1A1A1A] bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors appearance-none cursor-pointer">
                  <option value="">Select Size</option>
                  @if(isset($again_product[0]) && isset($activeAttr->size))
                     <option value="{{ $activeAttr->size }}" selected>{{ $activeAttr->size }}</option>
                  @else
                     @foreach($arrsize as $sz)
                     <option value="{{ $sz }}" {{ $sz == ($product_attr[$pid][0]->size ?? '') ? 'selected' : '' }}>
                        {{ $sz }}
                     </option>
                     @endforeach
                  @endif
               </select>
            </div>

            {{-- Quantity + Add to Cart --}}
            <div class="flex items-center gap-3 mb-6">
               <div class="flex items-center border border-gray-200">
                  <button type="button" onclick="if(+document.getElementById('quantityInput').value>1) document.getElementById('quantityInput').value--"
                     style="background:transparent;border:none;cursor:pointer;"
                     class="w-10 h-11 flex items-center justify-center text-gray-500 hover:text-[#1A1A1A] font-body text-lg transition-colors">−</button>
                  <input type="number" id="quantityInput" value="1" min="1"
                     class="w-12 h-11 text-center font-body text-sm text-[#1A1A1A] border-none outline-none bg-white">
                  <button type="button" onclick="document.getElementById('quantityInput').value=+document.getElementById('quantityInput').value+1"
                     style="background:transparent;border:none;cursor:pointer;"
                     class="w-10 h-11 flex items-center justify-center text-gray-500 hover:text-[#1A1A1A] font-body text-lg transition-colors">+</button>
               </div>

               <button onclick="add_to_cart({{ $pid }}, document.getElementById('size').value, document.getElementById('color').value, document.getElementById('quantityInput').value, '{{ csrf_token() }}')"
                  style="background:#1A1A1A;color:#fff;border:none;cursor:pointer;"
                  class="flex-1 h-11 font-body text-[11px] font-medium tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                  <i class="fa-solid fa-bag-shopping text-[11px]"></i>
                  Add to Cart
               </button>
            </div>

            {{-- Available variants --}}
            <div class="bg-[#F9F8F6] p-4">
               <p class="font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Available Variants</p>
               <div class="flex flex-wrap gap-2">
                  @foreach($product_attr[$pid] as $item)
                  <span class="font-body text-[11.5px] text-gray-500 border border-gray-200 px-3 py-1 bg-white">
                     {{ $item->color }} / {{ $item->size }}
                     @if($item->qty == 0)
                        <span class="ml-1 text-red-400 text-[10px]">(sold out)</span>
                     @endif
                  </span>
                  @endforeach
               </div>
            </div>

         </div>
      </div>
   </div>
</section>

{{-- ── Description + Reviews ── --}}
<section class="py-12 bg-[#F9F8F6]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <div class="flex flex-col lg:flex-row gap-10">

         {{-- Description --}}
         <div class="flex-1 min-w-0">
            <h2 class="font-display text-[26px] font-semibold text-[#1A1A1A] mb-5">Description</h2>
            <div class="bg-white border border-gray-100 p-6">
               <p class="font-body text-[14px] text-gray-600 leading-relaxed">{{ $p->desc }}</p>
            </div>
         </div>

         {{-- Reviews --}}
         <div class="lg:w-[420px] shrink-0">
            <div class="flex items-center justify-between mb-5">
               <h2 class="font-display text-[26px] font-semibold text-[#1A1A1A]">Reviews</h2>
               @if(isset($rating_points))
               <div class="flex items-center gap-2">
                  <div class="flex items-center gap-0.5 text-gold">
                     @for($i = 0; $i < $fullStars; $i++)<i class="fa-solid fa-star text-[14px]"></i>@endfor
                     @if($halfStars)<i class="fa-solid fa-star-half-alt text-[14px]"></i>@endif
                  </div>
                  <span class="font-body text-[13px] text-gray-400">{{ $rating_points }}/5</span>
               </div>
               @endif
            </div>

            @if(isset($rating[0]))
            <div class="space-y-4">
               @php $count = 0; @endphp
               @foreach($rating as $item)
               @php $count++; @endphp
               <div class="bg-white border border-gray-100 p-5">
                  <div class="flex items-start justify-between mb-2">
                     <div>
                        <p class="font-body text-[13.5px] font-medium text-[#1A1A1A]">
                           {{ isset($user[$rating[0]->id][0]) ? $user[$rating[0]->id][0]->name : 'Anonymous' }}
                        </p>
                        <div class="flex items-center gap-0.5 mt-1 text-gold">
                           @for($i = 0; $i < $item->rating_stars; $i++)
                           <i class="fa-solid fa-star text-[12px]"></i>
                           @endfor
                        </div>
                     </div>
                     <span class="font-body text-[11px] text-gray-400">{{ $item->added_on }}</span>
                  </div>
                  <p class="font-body text-[13px] text-gray-500 leading-relaxed italic">"{{ $item->rating_desc }}"</p>
               </div>
               @endforeach
            </div>
            @else
            <div class="bg-white border border-gray-100 p-8 text-center">
               <i class="fa-regular fa-star text-[40px] text-gray-200 mb-3 block"></i>
               <p class="font-body text-[13.5px] text-gray-400">No reviews yet.</p>
            </div>
            @endif

            {{-- Review form (only if customer bought this product) --}}
            @if(isset($order[0]))
            @php $alreadyChecked = false; @endphp
            @foreach($order as $ord)
               @foreach($order_details[$ord->id] as $check)
                  @if(!$alreadyChecked && $check->product_id == $pid)
                  @php $alreadyChecked = true; @endphp
                  <form id="rating_form" class="mt-6 bg-white border border-gray-100 p-6">
                     @csrf
                     <p class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-4">Write a Review</p>

                     {{-- Star picker --}}
                     <div class="flex items-center gap-3 mb-4">
                        <span class="font-body text-[12px] text-gray-400">Rating:</span>
                        <div class="rating-group">
                           <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio">
                           <label class="rating__label" for="rating3-5"><i class="fa fa-star"></i></label>
                           <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                           <label class="rating__label" for="rating3-4"><i class="fa fa-star"></i></label>
                           <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                           <label class="rating__label" for="rating3-3"><i class="fa fa-star"></i></label>
                           <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                           <label class="rating__label" for="rating3-2"><i class="fa fa-star"></i></label>
                           <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                           <label class="rating__label" for="rating3-1"><i class="fa fa-star"></i></label>
                           <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                        </div>
                     </div>

                     <textarea name="rating_desc" rows="3" placeholder="Share your experience with this product…"
                        class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none mb-4"></textarea>

                     <input type="hidden" name="prod_id" id="id" value="{{ $pid }}">

                     <button type="submit"
                        style="background:#1A1A1A;color:#fff;border:none;cursor:pointer;"
                        class="w-full h-10 font-body text-[10.5px] tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">
                        Submit Review
                     </button>
                  </form>
                  @endif
               @endforeach
            @endforeach
            @endif

         </div>
      </div>
   </div>
</section>

{{-- ── Related Products ── --}}
@if(isset($related_product) && count($related_product) > 0)
<section class="py-14 bg-white border-t border-gray-100">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-1 text-center">You May Also Like</p>
      <h2 class="font-display text-[clamp(24px,3.5vw,36px)] font-semibold text-[#1A1A1A] text-center mb-10">Related Products</h2>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
         @foreach($related_product as $item)
         @php $rAttr = $related_product_attr[$item->id][0] ?? null; @endphp
         <a href="{{ url('/product-details/'.$item->id) }}"
            class="group bg-white border border-gray-100 hover:shadow-lg transition-all duration-300 block">
            <div class="overflow-hidden bg-gray-50 relative" style="aspect-ratio:3/4">
               <img src="{{ asset('/storage/media/'.$item->image) }}"
                    alt="{{ $item->name }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
               @if($rAttr)
                  @if($rAttr->qty == 0)
                  <span class="absolute top-3 left-3 bg-[#1A1A1A] text-white font-body text-[9px] tracking-[0.15em] uppercase px-2.5 py-1">Sold Out</span>
                  @elseif($item->is_discounted == 1)
                  <span class="absolute top-3 left-3 bg-gold text-[#1A1A1A] font-body text-[9px] tracking-[0.15em] uppercase px-2.5 py-1">Sale</span>
                  @else
                  <span class="absolute top-3 left-3 bg-[#1A1A1A] text-white font-body text-[9px] tracking-[0.15em] uppercase px-2.5 py-1">New</span>
                  @endif
               @endif
            </div>
            <div class="p-4">
               <h3 class="font-body text-[13.5px] font-medium text-[#1A1A1A] mb-1 line-clamp-1 group-hover:text-gold transition-colors">{{ $item->name }}</h3>
               <p class="font-body text-[12px] text-gray-400 mb-2 line-clamp-1">{{ $item->short_desc }}</p>
               @if($rAttr)
                  @if($rAttr->price == 0)
                  <span class="font-body text-[14px] font-semibold text-[#1A1A1A]">Rs {{ number_format($rAttr->mrp) }}/-</span>
                  @else
                  <span class="font-body text-[12px] text-gray-400 line-through mr-1">Rs {{ number_format($rAttr->mrp) }}</span>
                  <span class="font-body text-[14px] font-semibold text-[#1A1A1A]">Rs {{ number_format($rAttr->price) }}/-</span>
                  @endif
               @endif
            </div>
         </a>
         @endforeach
      </div>
   </div>
</section>
@endif

{{-- Hidden form for color/size variant reload --}}
<form action="{{ '/change_product/'.$pid }}" id="change_form" method="POST" class="hidden">
   @csrf
   <input type="hidden" id="color_val" name="color_val">
   <input type="hidden" id="size_val"  name="size_val">
   <input type="hidden" id="prod_id"   name="prod_id" value="{{ $pid }}">
</form>

@endsection
