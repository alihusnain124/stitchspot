@extends('front.layout')
@section('title', 'Order Placed – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=1600&q=80"
        alt="Order Placed"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <div class="w-16 h-16 rounded-full bg-gold/20 border-2 border-gold flex items-center justify-center mx-auto mb-6">
         <i class="fa-solid fa-check text-gold text-[22px]"></i>
      </div>
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-4">Order Confirmed</p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Order Successful!
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed max-w-[480px]">
         Thank you for your purchase. We're getting your order ready right away.
      </p>
   </div>
</section>

<section class="py-16 bg-white min-h-[50vh]">
   <div class="max-w-[800px] mx-auto px-4">
      
      {{-- Order ID Card --}}
      <div class="bg-white border border-gray-100 p-8 md:p-12 text-center mb-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-sm">
         <p class="font-body text-[12px] font-bold text-gray-400 uppercase tracking-[0.25em] mb-3">Your Order Number Is</p>
         <h2 class="font-display text-[40px] font-semibold text-gold mb-5 leading-none">#{{ session()->get('ORDER_ID') }}</h2>
         <p class="font-body text-[15px] text-gray-500 max-w-md mx-auto leading-relaxed">We've received your order and are getting it ready. We'll email you an order confirmation with details and tracking info.</p>
      </div>

      {{-- Promotional Message --}}
      <div class="bg-[#F9F8F6] p-8 md:p-12 border border-[#E8E8E8] relative overflow-hidden group rounded-sm">
         {{-- Decorative accent --}}
         <div class="absolute top-0 right-0 w-48 h-48 bg-gold/10 rounded-full blur-3xl -mr-20 -mt-20 transition-all duration-700 group-hover:bg-gold/20"></div>

         <div class="relative z-10">
            <div class="flex items-center gap-3 mb-6">
               <i class="fa-solid fa-scissors text-gold text-xl"></i>
               <h3 class="font-display text-[28px] font-semibold text-[#1A1A1A]">Exciting News!</h3>
            </div>
            
            <p class="font-body text-[15px] text-gray-700 mb-5">Dear <span class="font-medium text-[#1A1A1A]">{{ session()->get('FRONT_USER_NAME') ?? 'Customer' }}</span>,</p>
            
            <div class="font-body text-[15px] text-gray-600 leading-[1.8] space-y-5 mb-8">
               <p>We're thrilled to announce that our platform now offers tailor-made solutions beyond our traditional offerings. In addition to our existing services, we're expanding into the world of clothes stitching and customization.</p>
               <p>Whether you're looking for the perfect fit, unique designs, or alterations to your existing wardrobe, our team of experienced tailors is here to bring your vision to life. From elegant formal wear to casual chic, we've got you covered.</p>
               <p>With our commitment to quality craftsmanship and attention to detail, you can trust us to deliver garments that not only fit impeccably but also reflect your personal style.</p>
               <p>Get started today by exploring our new tailoring services section on the platform. We can't wait to embark on this sartorial journey with you!</p>
            </div>

            <div class="font-body text-[14px] text-gray-500 mt-8 border-t border-gray-200 pt-8">
               <p class="mb-1">Best regards,</p>
               <p class="font-medium text-[#1A1A1A] text-[15px]">Ali Husnain</p>
               <p class="text-[13px]">CEO of StitchSpot</p>
            </div>
         </div>
      </div>

      {{-- Actions --}}
      <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
         <a href="{{ url('/products') }}" class="flex items-center justify-center h-14 px-10 bg-white border border-gray-200 text-[#1A1A1A] font-body text-[12px] font-semibold tracking-[2px] uppercase hover:border-[#1A1A1A] hover:bg-gray-50 transition-all">
            Continue Shopping
         </a>
         <a href="{{ url('/services') }}" class="flex items-center justify-center h-14 px-10 bg-[#1A1A1A] text-white font-body text-[12px] font-semibold tracking-[2px] uppercase hover:bg-gold transition-colors shadow-lg shadow-black/10">
            Explore Services
         </a>
      </div>

   </div>
</section>

@endsection