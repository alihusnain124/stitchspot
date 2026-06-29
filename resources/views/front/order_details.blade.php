@extends('front.layout')
@section('title', 'Order Details – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?w=1600&q=80"
        alt="Order Details"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">My Account</p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Order Details
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Track your order status and review everything you ordered.
      </p>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <a href="{{ url('/profile/' . session()->get('FRONT_USER_LOGIN')) }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">My Account</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Order Details</span>
      </div>
   </div>
</section>

<section class="py-14 bg-white min-h-[50vh]">
   <div class="max-w-[1000px] mx-auto px-4 lg:px-8">
      
      <div class="bg-white border border-gray-200 shadow-[0_4px_20px_rgb(0,0,0,0.02)]">
         {{-- Table headers (Desktop) --}}
         <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 bg-[#F9F8F6] p-5 font-body text-[11px] font-bold text-gray-500 uppercase tracking-wider">
            <div class="col-span-1 text-center">ID</div>
            <div class="col-span-2 text-center">Product ID</div>
            <div class="col-span-4">Product Name</div>
            <div class="col-span-2 text-center">Price</div>
            <div class="col-span-1 text-center">Qty</div>
            <div class="col-span-2 text-right pr-4">Total</div>
         </div>

         <div class="divide-y divide-gray-100">
            @foreach($order_details as $item)
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center p-5 group hover:bg-gray-50 transition-colors">
               
               {{-- Mobile headers & content --}}
               <div class="col-span-1 md:col-span-1 md:text-center font-body text-[14px] text-gray-600 flex md:block justify-between items-center">
                  <span class="md:hidden text-[11px] font-bold text-gray-400 uppercase tracking-wider">ID:</span>
                  #{{ $item->id }}
               </div>
               
               <div class="col-span-1 md:col-span-2 md:text-center font-body text-[14px] text-gray-600 flex md:block justify-between items-center">
                  <span class="md:hidden text-[11px] font-bold text-gray-400 uppercase tracking-wider">Product ID:</span>
                  {{ $item->product_id }}
               </div>
               
               <div class="col-span-1 md:col-span-4 font-body flex justify-between items-center md:block">
                  <span class="md:hidden text-[11px] font-bold text-gray-400 uppercase tracking-wider">Product:</span>
                  <a href="{{ url('/product-details/'.$item->product_id) }}" class="text-[14.5px] font-medium text-[#1A1A1A] hover:text-gold transition-colors line-clamp-1">{{ $item->product_name }}</a>
               </div>
               
               <div class="col-span-1 md:col-span-2 md:text-center font-body text-[14px] text-gray-600 flex md:block justify-between items-center">
                  <span class="md:hidden text-[11px] font-bold text-gray-400 uppercase tracking-wider">Price:</span>
                  Rs {{ number_format($item->product_price) }}
               </div>
               
               <div class="col-span-1 md:col-span-1 md:text-center font-body text-[14px] text-gray-600 flex md:block justify-between items-center">
                  <span class="md:hidden text-[11px] font-bold text-gray-400 uppercase tracking-wider">Quantity:</span>
                  <span class="bg-gray-100 px-3 py-1 rounded-sm text-xs font-semibold">{{ $item->product_qty }}</span>
               </div>
               
               <div class="col-span-1 md:col-span-2 md:text-right md:pr-4 font-body text-[14.5px] font-semibold text-[#1A1A1A] flex md:block justify-between items-center">
                  <span class="md:hidden text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total:</span>
                  Rs {{ number_format($item->product_qty * $item->product_price) }}
               </div>
            </div>
            @endforeach
         </div>
      </div>

      <div class="mt-8 text-center md:text-left">
         <a href="javascript:history.back()" class="inline-flex items-center text-gray-500 hover:text-gold transition-colors font-body text-[13px] tracking-[1px] uppercase font-semibold">
            <i class="fa-solid fa-arrow-left mr-2 text-[11px]"></i> Back to My Account
         </a>
      </div>

   </div>
</section>

@endsection