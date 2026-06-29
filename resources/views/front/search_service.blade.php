@extends('front.layout')
@section('title', 'Search Services – StitchSpot')

@section('content')

{{-- Page header --}}
<div class="bg-[#F9F8F6] border-b border-gray-100 py-12 text-center">
   <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-2">
      <a href="{{ url('/') }}" class="hover:text-gold transition-colors">Home</a>
      <span class="mx-2 text-gray-300">/</span>
      <a href="{{ url('/services') }}" class="hover:text-gold transition-colors">Services</a>
      <span class="mx-2 text-gray-300">/</span>
      <span>Search Results</span>
   </p>
   <h1 class="font-display text-[clamp(28px,4vw,44px)] font-semibold text-[#1A1A1A]">Search Results</h1>
</div>

{{-- Search bar --}}
<div class="max-w-[1280px] mx-auto px-4 lg:px-8 pt-12 pb-4">
   <form action="{{ url('/search_service') }}" method="GET" class="flex gap-3 max-w-xl mx-auto">
      <input type="text" name="search_val"
         value="{{ request('search_val') }}"
         placeholder="Search services…"
         class="flex-1 h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-400 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
      <button type="submit"
         class="px-6 h-11 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase hover:bg-gray-800 transition-colors border-none cursor-pointer">
         Search
      </button>
   </form>
</div>

{{-- Results --}}
<section class="py-12 bg-white">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">

      @if(isset($service) && count($service) > 0)
      <p class="font-body text-[12px] text-gray-400 mb-8">{{ count($service) }} result(s) found</p>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
         @foreach($service as $item)
         <a href="{{ url('/service-details/'.$item->id) }}"
            class="group bg-white border border-gray-100 hover:border-gray-200 hover:shadow-lg transition-all duration-300 block">

            <div class="relative overflow-hidden bg-gray-100" style="aspect-ratio:4/3">
               <img src="{{ asset('/storage/media/services/'.$item->image) }}"
                    alt="{{ $item->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>

            <div class="p-5">
               <h3 class="font-body text-[13.5px] font-medium text-[#1A1A1A] leading-snug mb-3 line-clamp-2">
                  {{ Str::substr($item->title, 0, 70) }}…
               </h3>
               <div class="flex items-center justify-between">
                  <span class="font-body text-[12px] text-gray-400 uppercase tracking-wide">Starting at</span>
                  <span class="font-body text-[14px] font-semibold text-gold">Rs {{ number_format($item->min_price) }}</span>
               </div>
            </div>
         </a>
         @endforeach
      </div>

      @else
      <div class="text-center py-20">
         <i class="fa-solid fa-magnifying-glass text-[52px] text-gray-200 mb-5 block"></i>
         <h3 class="font-display text-[26px] text-[#1A1A1A] mb-2">No Results Found</h3>
         <p class="font-body text-[14px] text-gray-400 mb-6">
            We couldn't find any services matching your search.
         </p>
         <a href="{{ url('/services') }}"
            class="inline-flex items-center bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase px-7 h-10 hover:bg-gray-800 transition-colors">
            Browse All Services
         </a>
      </div>
      @endif

   </div>
</section>

@endsection
