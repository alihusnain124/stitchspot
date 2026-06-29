@extends('front.layout')
@section('title', 'Leave a Review – StitchSpot')

@section('extra-css')
<style>
    /* CSS Star Rating */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .star-rating input {
        display: none;
    }
    .star-rating label {
        cursor: pointer;
        font-size: 28px;
        color: #E5E7EB; /* gray-200 */
        transition: color 0.2s, transform 0.1s;
    }
    .star-rating label i {
        pointer-events: none;
    }
    .star-rating label:hover {
        transform: scale(1.1);
    }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #C9A96E; /* gold */
    }
    .star-rating input:checked + label:hover,
    .star-rating input:checked ~ label:hover,
    .star-rating label:hover ~ input:checked ~ label,
    .star-rating input:checked ~ label:hover ~ label {
        color: #B5955C; /* darker gold on hover when selected */
    }
</style>
@endsection

@section('content')

{{-- Hero Banner --}}
<section class="relative overflow-hidden bg-[#111]" style="min-height:460px">
   <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1600&q=80"
        alt="Leave a Review"
        class="absolute inset-0 w-full h-full object-cover object-center opacity-45">
   <div class="absolute inset-0" style="background:linear-gradient(to bottom, rgba(0,0,0,0.35) 0%, rgba(0,0,0,0.65) 100%)"></div>

   <div class="relative z-10 flex flex-col items-center justify-center text-center px-6 py-24" style="min-height:460px">
      <p class="font-body text-[10px] tracking-[5px] uppercase text-gold mb-5">Your Feedback</p>
      <h1 class="font-display text-white text-[clamp(38px,5.5vw,72px)] font-semibold leading-tight mb-5">
         Leave a Review
      </h1>
      <p class="font-body text-white/55 text-[15px] leading-relaxed mb-6 max-w-[480px]">
         Share your experience and help others make better choices.
      </p>
      <div class="flex items-center gap-3">
         <a href="{{ url('/') }}" class="font-body text-[11px] tracking-[2px] uppercase text-white/40 hover:text-gold transition-colors">Home</a>
         <span class="text-white/25 text-xs">›</span>
         <span class="font-body text-[11px] tracking-[2px] uppercase text-white/65">Review</span>
      </div>
   </div>
</section>

<section class="py-14 bg-white min-h-[50vh]">
   <div class="max-w-[540px] mx-auto px-4">
      
      {{-- Card --}}
      <div class="border border-gray-200 bg-white shadow-[0_4px_24px_rgba(0,0,0,0.05)]">
         
         {{-- Header --}}
         <div class="px-7 py-5 border-b border-gray-100 bg-[#F9F8F6]">
            <h2 class="font-display text-[20px] font-semibold text-[#1A1A1A]">Rate your Tailor</h2>
            <p class="font-body text-[13px] text-gray-500 mt-1">Please let us know about your experience.</p>
         </div>

         {{-- Form --}}
         <div class="px-7 py-8">
            <form action="" id="review_form" class="space-y-6">
               @csrf
               <input type="hidden" id="user_id" name="user_id" value="{{$order_detail[0]->service_user_id}}">
               <input type="hidden" id="service_id" name="service_id" value="{{$order_detail[0]->service_id}}">

               {{-- Star Rating --}}
               <div>
                  <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Rating</label>
                  <div class="star-rating gap-1.5">
                     <input type="radio" id="star5" name="rating3" value="5" />
                     <label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                     <input type="radio" id="star4" name="rating3" value="4" />
                     <label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                     <input type="radio" id="star3" name="rating3" value="3" />
                     <label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                     <input type="radio" id="star2" name="rating3" value="2" />
                     <label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                     <input type="radio" id="star1" name="rating3" value="1" required />
                     <label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                  </div>
               </div>

               {{-- Review Text --}}
               <div>
                  <label class="block font-body text-[11px] font-semibold text-gray-400 uppercase tracking-widest mb-2">Your Review</label>
                  <textarea name="rating_desc" id="rating_desc" cols="30" rows="5" required
                     class="w-full px-4 py-4 border-[1.5px] border-gray-200 bg-gray-50 font-body text-[14px] text-[#1A1A1A] placeholder-gray-300 outline-none focus:border-[#C9A96E] focus:bg-white focus:shadow-[0_0_0_3px_rgba(201,169,110,0.15)] transition-all duration-200 resize-none"
                     placeholder="How was the service? Fit, quality, timing..."></textarea>
               </div>

               {{-- Submit --}}
               <button type="submit" id="submit-button"
                  class="w-full h-[52px] bg-[#1A1A1A] text-white font-body font-semibold text-[12px] tracking-[2.5px] uppercase hover:bg-[#C9A96E] transition-all duration-200 border-none cursor-pointer flex items-center justify-center gap-3 shadow-md shadow-black/10 mt-2">
                  <i class="fa-regular fa-paper-plane text-[13px]"></i> Submit Review
               </button>
            </form>
         </div>
      </div>

   </div>
</section>

@endsection