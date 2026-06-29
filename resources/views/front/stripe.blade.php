@extends('front.layout')
@section('title', 'Payment – StitchSpot')

@section('extra-css')
<style>
   .stripe-el { transition: border-color 200ms, box-shadow 200ms, background-color 200ms; }
   .stripe-el.StripeElement--focus    { border-color: #C9A96E !important; background-color: #fff !important; box-shadow: 0 0 0 3px rgba(201,169,110,0.15) !important; }
   .stripe-el.StripeElement--invalid  { border-color: #E63946 !important; background-color: #fff8f8 !important; }
   .stripe-el.StripeElement--complete { border-color: #10B981 !important; background-color: #f0fdf4 !important; }
</style>
@endsection

@section('head')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=1600&q=80"
        alt="Payment"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">
         <i class="fa-solid fa-lock text-[9px] mr-1"></i> Secure Checkout
      </p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Payment Details
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Your payment is encrypted and 100% secure. Complete your purchase below.
      </p>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <a href="{{ url('/cart') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Cart</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Payment</span>
      </div>
   </div>
</section>

<section class="py-16 bg-white min-h-[60vh]">
   <div class="max-w-[600px] mx-auto px-4 lg:px-8">


      {{-- Card --}}
      <div class="border border-gray-200 bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-sm">
         <div class="px-8 py-6 border-b border-gray-100 bg-[#F9F8F6]/30 flex justify-between items-center">
            <div>
               <h2 class="font-display text-[24px] font-semibold text-[#1A1A1A]">Card Information</h2>
               <p class="font-body text-[13px] text-gray-500 mt-1 flex items-center gap-2">
                  <i class="fa-solid fa-lock text-[10px] text-green-600"></i> Secure encrypted connection
               </p>
            </div>
         </div>

         <div class="px-7 py-8">
            <form action="{{ route('stripe.post') }}" method="post" id="payment-form" class="space-y-5">
               @csrf

               {{-- Hidden order fields --}}
               <input type="hidden" name="name"           value="{{ $name }}">
               <input type="hidden" name="email"          value="{{ $email }}">
               <input type="hidden" name="address"        value="{{ $address }}">
               <input type="hidden" name="city"           value="{{ $city }}">
               <input type="hidden" name="mobile_no"      value="{{ $mobile_no }}">
               <input type="hidden" name="state"          value="{{ $state }}">
               <input type="hidden" name="zip_code"       value="{{ $zip_code }}">
               <input type="hidden" name="is_stitch"      value="{{ $is_stitch }}">
               <input type="hidden" name="total_price"    value="{{ $total_price }}">
               <input type="hidden" name="payment_method" value="{{ $payment_method }}">

               {{-- Card Number --}}
               <div>
                  <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Card Number</label>
                  <div id="card-number" class="stripe-el w-full py-[16px] px-4 border-[1.5px] border-gray-200 bg-gray-50"></div>
               </div>

               {{-- Expiry & CVC --}}
               <div class="grid grid-cols-2 gap-4">
                  <div>
                     <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Expiry Date</label>
                     <div id="card-expiry" class="stripe-el w-full py-[16px] px-4 border-[1.5px] border-gray-200 bg-gray-50"></div>
                  </div>
                  <div>
                     <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">CVC / CVV</label>
                     <div id="card-cvc" class="stripe-el w-full py-[16px] px-4 border-[1.5px] border-gray-200 bg-gray-50"></div>
                  </div>
               </div>

               <!-- Error display -->
               <div id="card-errors" role="alert" class="font-body text-[13px] text-red-600 bg-red-50 border border-red-200 px-4 py-3 items-center gap-2" style="display:none"></div>

               {{-- Submit --}}
               <button type="submit" id="submit-button"
                  class="w-full h-14 bg-[#1A1A1A] text-white font-body font-semibold text-[13px] tracking-[2px] uppercase hover:bg-gold transition-colors border-none cursor-pointer flex items-center justify-center gap-3 mt-6 shadow-lg shadow-black/5">
                  <i class="fa-solid fa-lock text-[12px]"></i>
                  Pay Now — Rs {{ number_format($total_price) }}
               </button>

               <div class="flex items-center justify-center gap-4 mt-8 pt-6 border-t border-gray-100">
                  <i class="fa-brands fa-cc-stripe text-gray-300 text-3xl"></i>
                  <i class="fa-brands fa-cc-visa text-gray-300 text-3xl"></i>
                  <i class="fa-brands fa-cc-mastercard text-gray-300 text-3xl"></i>
               </div>

            </form>
         </div>
      </div>

   </div>
</section>

@endsection

@section('scripts')
<script>
   // Create a Stripe client.
   var stripe = Stripe('{{ env('STRIPE_KEY') }}');

   // Create an instance of Elements.
   var elements = stripe.elements();

   // Custom styling can be passed to options when creating an Element.
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


   // Create three SEPARATE elements for individual rows
   var cardNumber = elements.create('cardNumber', { style: style });
   var cardExpiry = elements.create('cardExpiry', { style: style });
   var cardCvc    = elements.create('cardCvc',    { style: style });

   cardNumber.mount('#card-number');
   cardExpiry.mount('#card-expiry');
   cardCvc.mount('#card-cvc');

   // Show real-time errors on any element change
   [cardNumber, cardExpiry, cardCvc].forEach(function(el) {
      el.on('change', function(event) {
         var displayError = document.getElementById('card-errors');
         if (event.error) {
            displayError.innerHTML = '<i class="fa-solid fa-circle-exclamation mr-2"></i>' + event.error.message;
            displayError.style.display = 'flex';
         } else {
            displayError.textContent = '';
            displayError.style.display = 'none';
         }
      });
   });

   // Handle form submission.
   var form = document.getElementById('payment-form');
   var submitButton = document.getElementById('submit-button');

   form.addEventListener('submit', function(event) {
      event.preventDefault();
      submitButton.disabled = true;
      submitButton.classList.add('opacity-80', 'cursor-not-allowed');
      submitButton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin text-[14px]"></i>&nbsp; Processing...';

      stripe.confirmCardPayment('{{ $client_secret }}', {
         payment_method: {
            card: cardNumber,
            billing_details: {
               name: '{{ $name }}',
               email: '{{ $email }}'
            }
         }
      }).then(function(result) {
         if (result.error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.innerHTML = '<i class="fa-solid fa-circle-exclamation mr-2"></i>' + result.error.message;
            errorElement.style.display = 'flex';
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-80', 'cursor-not-allowed');
            submitButton.innerHTML = '<i class="fa-solid fa-lock text-[12px]"></i>&nbsp; Pay Now — Rs {{ number_format($total_price) }}';
         } else {
            if (result.paymentIntent.status === 'succeeded') {
               stripeTokenHandler(result.paymentIntent.id);
            }
         }
      });
   });

   function stripeTokenHandler(token) {
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token);
      form.appendChild(hiddenInput);
      form.submit();
   }
</script>
@endsection
