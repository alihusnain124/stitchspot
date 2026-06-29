@extends('front.layout')
@section('title', 'Payment – StitchSpot')

{{-- Minimal style block ONLY for Stripe iframe state classes (can't be done with Tailwind) --}}
@section('extra-css')
<style>
   .stripe-el { transition: border-color 200ms, box-shadow 200ms, background-color 200ms; }
   .stripe-el.StripeElement--focus      { border-color: #C9A96E !important; background-color: #fff !important; box-shadow: 0 0 0 3px rgba(201,169,110,0.15) !important; }
   .stripe-el.StripeElement--invalid    { border-color: #E63946 !important; background-color: #fff8f8 !important; }
   .stripe-el.StripeElement--complete   { border-color: #10B981 !important; background-color: #f0fdf4 !important; }
</style>
@endsection

@section('head')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

{{-- Page Header --}}
<div class="bg-[#F9F8F6] border-b border-[#E8E8E8] py-14 text-center">
   <p class="font-body text-[11px] tracking-[4px] uppercase text-gray-400 mb-3">Secure Checkout</p>
   <h1 class="font-display text-[clamp(28px,4vw,44px)] font-semibold text-[#1A1A1A]">Payment Details</h1>
</div>

<section class="py-14 bg-white min-h-[60vh]">
   <div class="max-w-[540px] mx-auto px-4">


      {{-- Card --}}
      <div class="border border-gray-200 bg-white shadow-[0_4px_24px_rgba(0,0,0,0.05)]">

         {{-- Header --}}
         <div class="px-7 py-5 border-b border-gray-100 bg-[#F9F8F6] flex items-center justify-between">
            <div>
               <h2 class="font-display text-[20px] font-semibold text-[#1A1A1A]">Card Information</h2>
               <p class="font-body text-[12px] text-gray-400 mt-0.5 flex items-center gap-1.5">
                  <i class="fa-solid fa-lock text-[9px] text-green-500"></i> SSL encrypted &amp; secure
               </p>
            </div>
            <div class="flex items-center gap-3">
               <i class="fa-brands fa-cc-visa text-gray-300 text-2xl"></i>
               <i class="fa-brands fa-cc-mastercard text-gray-300 text-2xl"></i>
            </div>
         </div>

         {{-- Form --}}
         <div class="px-7 py-8">
            <form action="{{ route('stripe_pay.post') }}" method="post" id="payment-form" class="space-y-5">
               @csrf
               <input type="hidden" name="id"    value="{{ $id }}">
               <input type="hidden" name="price" value="{{ $price }}">

               {{-- Cardholder Name (regular HTML input) --}}
               <div>
                  <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Cardholder Name</label>
                  <input
                     type="text"
                     id="cardholder-name"
                     placeholder="Full name as on card"
                     autocomplete="cc-name"
                     required
                     class="w-full h-[52px] px-4 border-[1.5px] border-gray-200 bg-gray-50 font-body text-[14px] text-[#1A1A1A] placeholder-gray-300 outline-none focus:border-[#C9A96E] focus:bg-white focus:shadow-[0_0_0_3px_rgba(201,169,110,0.15)] transition-all duration-200"
                  >
               </div>

               {{-- Card Number --}}
               <div>
                  <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Card Number</label>
                  <div id="card-number"
                     class="stripe-el w-full py-[16px] px-4 border-[1.5px] border-gray-200 bg-gray-50">
                  </div>
               </div>

               {{-- Expiry + CVC --}}
               <div class="grid grid-cols-2 gap-4">
                  <div>
                     <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Expiry Date</label>
                     <div id="card-expiry"
                        class="stripe-el w-full py-[16px] px-4 border-[1.5px] border-gray-200 bg-gray-50">
                     </div>
                  </div>
                  <div>
                     <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">CVC / CVV</label>
                     <div id="card-cvc"
                        class="stripe-el w-full py-[16px] px-4 border-[1.5px] border-gray-200 bg-gray-50">
                     </div>
                  </div>
               </div>

               {{-- Error --}}
               <div id="card-errors" role="alert"
                  class="font-body text-[13px] text-red-600 bg-red-50 border border-red-200 px-4 py-3 items-center gap-2" style="display:none">
               </div>

               {{-- Submit --}}
               <button type="submit" id="submit-button"
                  class="w-full h-[52px] bg-[#1A1A1A] text-white font-body font-semibold text-[12px] tracking-[2.5px] uppercase hover:bg-[#C9A96E] transition-all duration-200 border-none cursor-pointer flex items-center justify-center gap-3 shadow-md shadow-black/10 mt-1">
                  <i class="fa-solid fa-lock text-[11px]"></i>
                  Pay Rs {{ number_format($price) }}
               </button>

               <p class="text-center font-body text-[11px] text-gray-400 flex items-center justify-center gap-1.5">
                  <i class="fa-solid fa-shield-halved text-[10px]"></i> 256-bit SSL secure payment
               </p>

            </form>
         </div>
      </div>

   </div>
</section>

@endsection

@section('scripts')
<script>
   var stripe   = Stripe('{{ env('STRIPE_KEY') }}');
   var elements = stripe.elements();

   var style = {
      base: {
         color: '#1A1A1A',
         fontFamily: '"DM Sans", system-ui, sans-serif',
         fontSmoothing: 'antialiased',
         fontSize: '14px',
         '::placeholder': { color: '#C0C7D0' }
      },
      invalid: { color: '#E63946', iconColor: '#E63946' }
   };

   var cardNumber = elements.create('cardNumber', { style: style, placeholder: '1234 5678 9012 3456' });
   var cardExpiry = elements.create('cardExpiry', { style: style });
   var cardCvc    = elements.create('cardCvc',    { style: style });

   cardNumber.mount('#card-number');
   cardExpiry.mount('#card-expiry');
   cardCvc.mount('#card-cvc');

   // Real-time validation errors
   [cardNumber, cardExpiry, cardCvc].forEach(function(el) {
      el.on('change', function(event) {
         var errEl = document.getElementById('card-errors');
         if (event.error) {
            errEl.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>&nbsp;' + event.error.message;
            errEl.style.display = 'flex';
         } else {
            errEl.textContent = '';
            errEl.style.display = 'none';
         }
      });
   });

   var form         = document.getElementById('payment-form');
   var submitButton = document.getElementById('submit-button');

   form.addEventListener('submit', function(e) {
      e.preventDefault();

      var cardholderName = document.getElementById('cardholder-name').value.trim();
      if (!cardholderName) {
         var errEl = document.getElementById('card-errors');
         errEl.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>&nbsp;Please enter the cardholder name.';
         errEl.style.display = 'flex';
         return;
      }

      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>&nbsp; Processing...';

      stripe.confirmCardPayment('{{ $client_secret }}', {
         payment_method: {
            card: cardNumber,
            billing_details: { name: cardholderName }
         }
      }).then(function(result) {
         if (result.error) {
            var errEl = document.getElementById('card-errors');
            errEl.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>&nbsp;' + result.error.message;
            errEl.style.display = 'flex';
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fa-solid fa-lock text-[11px]"></i>&nbsp; Pay Rs {{ number_format($price) }}';
         } else if (result.paymentIntent.status === 'succeeded') {
            var input   = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'stripeToken';
            input.value = result.paymentIntent.id;
            form.appendChild(input);
            form.submit();
         }
      });
   });
</script>
@endsection
