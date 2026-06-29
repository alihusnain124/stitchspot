@extends('front.layout')
@section('title', 'Payment – StitchSpot')

@section('extra-css')
   .hide { display: none !important; }
   .has-error input { border-color: #E63946 !important; }
@endsection

@section('head')
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@endsection

@section('content')

<div class="bg-[#F9F8F6] border-b border-gray-100 py-12 text-center">
   <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-2">Secure Checkout</p>
   <h1 class="font-display text-[clamp(28px,4vw,40px)] font-semibold text-[#1A1A1A]">Payment Details</h1>
</div>

<section class="py-16 bg-white">
   <div class="max-w-lg mx-auto px-6">

      {{-- Success message --}}
      @if(Session::has('success'))
      <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 font-body text-sm text-center">
         {{ Session::get('success') }}
      </div>
      @endif

      {{-- Card --}}
      <div class="border border-gray-200 bg-white">
         <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-display text-xl font-semibold text-[#1A1A1A]">Card Information</h2>
            <p class="font-body text-[12px] text-gray-400 mt-1">Your payment is secured with SSL encryption</p>
         </div>

         <div class="px-6 py-6">
            <form role="form" action="{{ route('stripe.post') }}" method="post"
               class="require-validation"
               data-cc-on-file="false"
               data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
               id="payment-form">
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
               <input type="hidden" name="payment_method" value="{{ $payment_method }}" class="method">

               {{-- Name on card --}}
               <div class="form-row required mb-5">
                  <label class="block font-body text-[12px] text-gray-500 uppercase tracking-wide mb-2">Name on Card</label>
                  <input type="text" placeholder="Full name on card"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
               </div>

               {{-- Card number --}}
               <div class="form-row card required mb-5">
                  <label class="block font-body text-[12px] text-gray-500 uppercase tracking-wide mb-2">Card Number</label>
                  <input type="text" autocomplete="off" placeholder="•••• •••• •••• ••••"
                     class="form-control card-number w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
               </div>

               {{-- CVC / Expiry --}}
               <div class="grid grid-cols-3 gap-4 mb-6">
                  <div class="form-row cvc required">
                     <label class="block font-body text-[12px] text-gray-500 uppercase tracking-wide mb-2">CVC</label>
                     <input type="text" autocomplete="off" placeholder="123"
                        class="form-control card-cvc w-full h-11 px-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  </div>
                  <div class="form-row expiration required">
                     <label class="block font-body text-[12px] text-gray-500 uppercase tracking-wide mb-2">Month</label>
                     <input type="text" placeholder="MM"
                        class="form-control card-expiry-month w-full h-11 px-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  </div>
                  <div class="form-row expiration required">
                     <label class="block font-body text-[12px] text-gray-500 uppercase tracking-wide mb-2">Year</label>
                     <input type="text" placeholder="YYYY"
                        class="form-control card-expiry-year w-full h-11 px-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  </div>
               </div>

               {{-- Error message --}}
               <div class="error form-row hide mb-4">
                  <div class="alert px-4 py-3 bg-red-50 border border-red-200 font-body text-sm text-red-600">
                     Please correct the errors and try again.
                  </div>
               </div>

               {{-- Submit --}}
               <button type="submit"
                  class="w-full h-12 bg-[#1A1A1A] text-white font-body font-semibold text-[12px] tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors border-none cursor-pointer flex items-center justify-center gap-2">
                  <i class="fa-solid fa-lock text-[11px]"></i>
                  Pay Now — Rs {{ $total_price }}
               </button>

               <p class="font-body text-[11px] text-gray-400 text-center mt-4">
                  <i class="fa-solid fa-shield-halved mr-1"></i> 256-bit SSL secure payment
               </p>

            </form>
         </div>
      </div>

   </div>
</section>

@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]',
                'input[type=text]', 'input[type=file]',
                'textarea'
            ].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
</script>
@endsection
