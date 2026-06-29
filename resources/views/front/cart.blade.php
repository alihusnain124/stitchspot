@extends('front.layout')
@section('title', 'Shopping Cart – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1600&q=80"
        alt="Shopping Cart"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">My Order</p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Your Cart
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Review your selected items and proceed to checkout when you're ready.
      </p>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Shopping Cart</span>
      </div>
   </div>
</section>

<section class="py-14 bg-white min-h-[50vh]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      @if(isset($cart) && count($cart) > 0)
         <div class="flex flex-col lg:flex-row gap-10">
            {{-- Cart Items --}}
            <div class="lg:w-2/3">
               {{-- Table headers (Desktop) --}}
               <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 pb-4 mb-2 font-body text-[12px] font-bold text-gray-400 uppercase tracking-wider">
                  <div class="col-span-6">Product</div>
                  <div class="col-span-2 text-center">Price</div>
                  <div class="col-span-2 text-center">Quantity</div>
                  <div class="col-span-2 text-right">Total</div>
               </div>

               @php $total_price = 0; @endphp
               @foreach($cart as $item)
               @php $total_price += ($item->product_price * $item->product_qty); @endphp
               <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center border-b border-gray-100 py-6 group">
                  <div class="col-span-1 md:col-span-6 flex items-center gap-4 relative">
                     {{-- Remove btn --}}
                     <button onclick="deleteCart({{ $item->pid }}, {{ $item->attr_id }}, '{{ csrf_token() }}')" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 hover:bg-[#E63946] hover:text-white transition-all shrink-0">
                        <i class="fa-solid fa-xmark text-sm"></i>
                     </button>
                     
                     {{-- Image --}}
                     <a href="{{ url('/product-details/'.$item->pid) }}" class="shrink-0 block overflow-hidden border border-gray-100">
                        <img src="{{ asset('/storage/media/'.$item->product_image) }}" alt="{{ $item->product_name }}" class="w-20 h-24 object-cover hover:scale-105 transition-transform duration-500">
                     </a>
                     
                     {{-- Name --}}
                     <div class="font-body pr-4">
                        <a href="{{ url('/product-details/'.$item->pid) }}" class="text-[15px] font-medium text-[#1A1A1A] hover:text-gold transition-colors line-clamp-2 leading-snug">{{ $item->product_name }}</a>
                     </div>
                  </div>
                  
                  {{-- Price --}}
                  <div class="col-span-1 md:col-span-2 md:text-center font-body text-[14.5px] text-gray-600 mt-3 md:mt-0 flex md:block justify-between items-center">
                     <span class="md:hidden text-gray-400 text-xs font-bold uppercase tracking-wider">Price:</span>
                     <span>Rs {{ number_format($item->product_price) }}</span>
                  </div>

                  {{-- Quantity --}}
                  <div class="col-span-1 md:col-span-2 flex md:justify-center mt-3 md:mt-0 justify-between items-center">
                     <span class="md:hidden text-gray-400 text-xs font-bold uppercase tracking-wider">Qty:</span>
                     <div class="border border-gray-200 flex items-center w-24 h-10 hover:border-gray-300 transition-colors bg-white">
                        <input type="number" value="{{ $item->product_qty }}" min="1" onchange="updateCart({{ $item->pid }}, this.value, '{{ csrf_token() }}', {{ $item->attr_id }})" class="w-full text-center font-body text-[14px] text-[#1A1A1A] outline-none bg-transparent">
                     </div>
                  </div>

                  {{-- Subtotal --}}
                  <div class="col-span-1 md:col-span-2 md:text-right font-body text-[15px] font-semibold text-[#1A1A1A] mt-3 md:mt-0 flex md:block justify-between items-center">
                     <span class="md:hidden text-gray-400 text-xs font-bold uppercase tracking-wider">Total:</span>
                     <span>Rs {{ number_format($item->product_price * $item->product_qty) }}</span>
                  </div>
               </div>
               @endforeach
            </div>

            {{-- Order Summary --}}
            <div class="lg:w-1/3 mt-8 lg:mt-0">
               <div class="bg-[#F9F8F6] p-7 md:p-9 border border-[#E8E8E8] sticky top-24">
                  <h3 class="font-display text-[22px] font-semibold text-[#1A1A1A] mb-6 pb-4 border-b border-gray-200">Order Summary</h3>
                  
                  <div class="space-y-4 font-body text-[14.5px] mb-6">
                     <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rs {{ number_format($total_price) }}</span>
                     </div>
                     <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span class="text-green-600 font-medium tracking-wide">FREE</span>
                     </div>
                  </div>

                  <div class="flex justify-between items-center border-t border-gray-200 pt-6 mb-8">
                     <span class="font-body text-[16px] font-bold text-[#1A1A1A]">Total</span>
                     <span class="font-display text-[24px] font-semibold text-[#1A1A1A]">Rs {{ number_format($total_price) }}</span>
                  </div>

                  <a href="{{ url('/checkout') }}" class="flex items-center justify-center w-full h-12 bg-[#1A1A1A] text-white font-body text-[12px] font-semibold tracking-[2px] uppercase hover:bg-gold transition-colors">
                     Proceed to Checkout <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                  </a>
               </div>
            </div>
         </div>
      @else
         {{-- Empty Cart --}}
         <div class="text-center py-16 max-w-md mx-auto">
            <div class="w-24 h-24 bg-[#F9F8F6] rounded-full flex items-center justify-center mx-auto mb-6">
               <i class="fa-solid fa-bag-shopping text-[32px] text-gray-300"></i>
            </div>
            <h3 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-3">Your cart is empty</h3>
            <p class="font-body text-[14.5px] text-gray-500 mb-8 leading-relaxed">Looks like you haven't added anything to your cart yet. Discover our collection of premium fashion pieces.</p>
            <a href="{{ url('/products') }}" class="inline-flex items-center justify-center h-12 px-8 bg-[#1A1A1A] text-white font-body text-[11px] font-semibold tracking-[2px] uppercase hover:bg-gold transition-colors">
               Return to Shop
            </a>
         </div>
      @endif
   </div>
</section>

@endsection