@extends('front.layout')
@section('title', 'Checkout – StitchSpot')

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1600&q=80"
        alt="Checkout"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">Almost There</p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Checkout
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Complete your order securely — just a few details and you're done.
      </p>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <a href="{{ url('/cart') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Cart</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Checkout</span>
      </div>
   </div>
</section>

<section class="py-14 bg-white min-h-[60vh]">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <form id="order_form">
         <div class="flex flex-col lg:flex-row gap-10">
            
            {{-- Left Column: Billing & Payment --}}
            <div class="lg:w-2/3 space-y-10">
               
               {{-- Billing Details --}}
               <div>
                  <h3 class="font-display text-[24px] font-semibold text-[#1A1A1A] mb-6 border-b border-gray-200 pb-4">Billing Details</h3>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div class="flex flex-col">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Enter Your Name" value="{{ $user[0]->name }}" name="name" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" placeholder="example@example.com" value="{{ $user[0]->email }}" name="email" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col md:col-span-2">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Address <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Street etc" value="{{ $user[0]->address }}" name="address" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">City <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="City" name="city" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Mobile No <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Mobile Number" name="mobile_no" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">State <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="State" name="state" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Zip Code <span class="text-red-500">*</span></label>
                        <input type="number" placeholder="ZIP Code" name="zip_code" class="h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white" required>
                     </div>
                     <div class="flex flex-col md:col-span-2">
                        <label class="font-body text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Do you want to stitch it?</label>
                        <div class="relative">
                           <select name="is_stitch" class="w-full h-12 border border-gray-200 px-4 font-body text-[14px] text-[#1A1A1A] appearance-none outline-none focus:border-gold transition-colors bg-white cursor-pointer">
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                           </select>
                           <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                        </div>
                     </div>
                  </div>
               </div>

               {{-- Payment Methods --}}
               <div>
                  <h3 class="font-display text-[24px] font-semibold text-[#1A1A1A] mb-6 border-b border-gray-200 pb-4">Payment Method</h3>
                  <div class="space-y-4">
                     <label class="flex items-center gap-4 p-5 border border-gray-200 cursor-pointer hover:border-gold transition-colors bg-[#F9F8F6]/50 rounded-sm">
                        <input type="radio" value="COD" name="payment_method" class="w-4 h-4 text-gold accent-gold focus:ring-gold border-gray-300" checked required>
                        <div class="flex items-center justify-between w-full">
                           <span class="font-body text-[15px] font-medium text-[#1A1A1A]">Cash on Delivery (COD)</span>
                           <i class="fa-solid fa-money-bill-wave text-gray-400 text-lg"></i>
                        </div>
                     </label>
                     <label class="flex items-center gap-4 p-5 border border-gray-200 cursor-pointer hover:border-gold transition-colors bg-[#F9F8F6]/50 rounded-sm">
                        <input type="radio" value="Gateway" name="payment_method" class="w-4 h-4 text-gold accent-gold focus:ring-gold border-gray-300" required>
                        <div class="flex items-center justify-between w-full">
                           <span class="font-body text-[15px] font-medium text-[#1A1A1A]">Online Payment (Stripe)</span>
                           <div class="flex gap-2">
                              <i class="fa-brands fa-cc-stripe text-gray-400 text-2xl"></i>
                              <i class="fa-brands fa-cc-visa text-gray-400 text-2xl"></i>
                              <i class="fa-brands fa-cc-mastercard text-gray-400 text-2xl"></i>
                           </div>
                        </div>
                     </label>
                  </div>
               </div>

            </div>

            {{-- Right Column: Order Summary --}}
            <div class="lg:w-1/3">
               <div class="bg-[#F9F8F6] p-7 md:p-9 border border-[#E8E8E8] sticky top-24">
                  <h3 class="font-display text-[22px] font-semibold text-[#1A1A1A] mb-6 pb-4 border-b border-gray-200">Your Order</h3>
                  
                  <div class="space-y-4 font-body text-[14.5px] mb-6 max-h-[300px] overflow-y-auto pr-2">
                     @php $product_price = 0; @endphp
                     @foreach($cart as $item)
                     @php $product_price += $item->product_price * $item->product_qty; @endphp
                     <div class="flex justify-between items-start text-[#1A1A1A] border-b border-gray-200/50 pb-4 last:border-0 last:pb-0">
                        <div class="pr-4">
                           <span class="block text-[14px] font-medium leading-snug">{{ $item->product_name }}</span>
                           <span class="text-[12px] text-gray-500 mt-1 block">Qty: {{ $item->product_qty }} &times; Rs {{ number_format($item->product_price) }}</span>
                        </div>
                        <span class="font-medium whitespace-nowrap">Rs {{ number_format($item->product_price * $item->product_qty) }}</span>
                     </div>
                     @endforeach
                  </div>

                  <div class="border-t border-gray-200 pt-6 mb-8 space-y-3">
                     <div class="flex justify-between items-center">
                        <span class="font-body text-[14.5px] text-gray-600">Subtotal</span>
                        <span class="font-body text-[14.5px] font-medium text-[#1A1A1A]">Rs {{ number_format($product_price) }}</span>
                     </div>
                     <div class="flex justify-between items-center">
                        <span class="font-body text-[14.5px] text-gray-600">Shipping</span>
                        <span class="font-body text-[14.5px] font-medium text-green-600 tracking-wide">FREE</span>
                     </div>
                  </div>

                  {{-- Coupon --}}
                  <div class="mb-6">
                     <div class="flex gap-2">
                        <input type="text" id="coupon_code" placeholder="Coupon code"
                           class="flex-1 h-10 border border-gray-200 px-3 font-body text-[13px] text-[#1A1A1A] outline-none focus:border-gold transition-colors bg-white">
                        <button type="button" onclick="applyCoupon()"
                           class="h-10 px-4 bg-[#1A1A1A] text-white font-body text-[11px] font-semibold tracking-[1.5px] uppercase hover:bg-gold transition-colors border-none cursor-pointer whitespace-nowrap">
                           Apply
                        </button>
                     </div>
                     <div id="coupon_msg" class="font-body text-[12px] mt-2 min-h-[16px]"></div>
                  </div>

                  <div id="discount_row" style="display:none;justify-content:space-between;align-items:center;margin-bottom:12px;">
                     <span class="font-body text-[14.5px] text-green-600">Discount</span>
                     <span id="discount_val" class="font-body text-[14.5px] font-medium text-green-600"></span>
                  </div>

                  <div class="flex justify-between items-center border-t border-gray-200 pt-6 mb-8">
                     <span class="font-body text-[16px] font-bold text-[#1A1A1A]">Total</span>
                     <span class="font-display text-[24px] font-semibold text-[#1A1A1A]" id="final_total">Rs {{ number_format($product_price) }}</span>
                     <input type="hidden" value="{{ $product_price }}" name="total_price" id="total_price_input">
                  </div>

                  <button type="submit" class="flex items-center justify-center w-full h-12 bg-[#1A1A1A] text-white font-body text-[12px] font-semibold tracking-[2px] uppercase hover:bg-gold transition-colors border-none cursor-pointer">
                     Place Order
                  </button>
               </div>
            </div>

         </div>
      </form>
   </div>
</section>

@endsection

@section('scripts')
<script>
function applyCoupon() {
   var code  = document.getElementById('coupon_code').value.trim();
   var total = parseFloat('{{ $product_price }}');
   var msg   = document.getElementById('coupon_msg');

   if (!code) { msg.style.color = '#E63946'; msg.textContent = 'Please enter a coupon code.'; return; }

   msg.style.color = '#888'; msg.textContent = 'Checking…';

   $.ajax({
      url: '/apply_coupon',
      type: 'POST',
      data: { code: code, total: total, _token: $('meta[name="csrf-token"]').attr('content') },
      success: function(res) {
         if (res.status === 'success') {
            msg.style.color = '#16A34A'; msg.textContent = res.msg;
            document.getElementById('discount_val').textContent = '− Rs ' + res.discount.toLocaleString('en-PK');
            document.getElementById('discount_row').style.display = 'flex';
            document.getElementById('final_total').textContent = 'Rs ' + Math.round(res.new_total).toLocaleString('en-PK');
            document.getElementById('total_price_input').value = res.new_total;
            document.getElementById('coupon_code').disabled = true;
         } else {
            msg.style.color = '#E63946'; msg.textContent = res.msg;
            document.getElementById('discount_row').style.display = 'none';
         }
      },
      error: function() { msg.style.color = '#E63946'; msg.textContent = 'Something went wrong. Try again.'; }
   });
}

document.getElementById('coupon_code').addEventListener('keydown', function(e) {
   if (e.key === 'Enter') { e.preventDefault(); applyCoupon(); }
});
</script>
@endsection