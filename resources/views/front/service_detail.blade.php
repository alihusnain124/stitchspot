@extends('front.layout')
@section('title', ($services[0]->title ?? 'Service') . ' – StitchSpot')

@section('content')

@php $s = $services[0]; $u = $user[0]; @endphp

{{-- ── Hero banner ── --}}
<div class="relative h-64 lg:h-80 overflow-hidden bg-[#1A1A1A]">
   <img src="{{ asset('/storage/media/services/'.$s->image) }}"
        alt="{{ $s->title }}"
        class="w-full h-full object-cover opacity-40"
        onerror="this.style.display='none'">
   <div class="absolute inset-0 flex flex-col justify-end pb-8 px-6 lg:px-0">
      <div class="max-w-[1100px] mx-auto w-full px-4 lg:px-8">
         <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-2">Tailoring Service</p>
         <h1 class="font-display text-[clamp(24px,4vw,42px)] font-semibold text-white leading-tight">{{ $s->title }}</h1>
      </div>
   </div>
</div>

{{-- ── Main layout ── --}}
<div class="max-w-[1100px] mx-auto px-4 lg:px-8 py-12">
   <div class="flex flex-col lg:flex-row gap-10">

      {{-- ── LEFT: Details ── --}}
      <div class="flex-1 min-w-0 space-y-8">

         {{-- Tailor card --}}
         <div class="flex items-center gap-4 p-5 bg-white border border-gray-100">
            <a href="{{ url('/profile/'.$u->id) }}" class="shrink-0">
               <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-100 border-2 border-gray-100">
                  <img src="{{ asset('/storage/media/customer/'.$u->image) }}"
                       alt="{{ $u->name }}"
                       class="w-full h-full object-cover"
                       onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=C9A96E&color=fff&size=56'">
               </div>
            </a>
            <div class="min-w-0">
               <p class="font-body text-[10.5px] tracking-[2px] uppercase text-gray-400 mb-0.5">Your Tailor</p>
               <a href="{{ url('/profile/'.$u->id) }}"
                  class="font-display text-[20px] font-semibold text-[#1A1A1A] hover:text-gold transition-colors leading-tight">
                  {{ $u->name }}
               </a>
               @if($u->bio)
               <p class="font-body text-[12.5px] text-gray-400 mt-0.5 truncate">{{ $u->bio }}</p>
               @endif
            </div>
            <a href="{{ url('/profile/'.$u->id) }}"
               class="ml-auto shrink-0 hidden sm:inline-flex items-center gap-2 border border-gray-200 text-[#1A1A1A] font-body text-[10.5px] tracking-[0.15em] uppercase px-4 h-8 hover:border-[#1A1A1A] transition-colors">
               View Profile
            </a>
         </div>

         {{-- What's included --}}
         <div class="bg-white border border-gray-100 p-6">
            <h2 class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-4">What's Included</h2>
            <ul class="space-y-3">
               <li class="flex items-start gap-3 font-body text-[13.5px] text-gray-600">
                  <i class="fa-solid fa-check text-gold text-[11px] mt-1 shrink-0"></i>
                  Initial consultation and measurements
               </li>
               <li class="flex items-start gap-3 font-body text-[13.5px] text-gray-600">
                  <i class="fa-solid fa-check text-gold text-[11px] mt-1 shrink-0"></i>
                  Fabric selection
               </li>
               <li class="flex items-start gap-3 font-body text-[13.5px] text-gray-600">
                  <i class="fa-solid fa-check text-gold text-[11px] mt-1 shrink-0"></i>
                  Two fittings
               </li>
               <li class="flex items-start gap-3 font-body text-[13.5px] text-gray-600">
                  <i class="fa-solid fa-check text-gold text-[11px] mt-1 shrink-0"></i>
                  Final adjustments and delivery
               </li>
            </ul>
         </div>

         {{-- Description --}}
         @if($s->desc)
         <div class="bg-white border border-gray-100 p-6">
            <h2 class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-4">Service Description</h2>
            <p class="font-body text-[14px] text-gray-600 leading-relaxed">{{ $s->desc }}</p>
         </div>
         @endif

      </div>

      {{-- ── RIGHT: Pricing sidebar ── --}}
      <div class="lg:w-80 shrink-0 space-y-4">

         {{-- Basic package --}}
         <div class="bg-white border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
               <div>
                  <p class="font-body text-[10px] tracking-[2.5px] uppercase text-gray-400">Basic Package</p>
                  <p class="font-display text-[26px] font-semibold text-[#1A1A1A] leading-none mt-1">
                     Rs {{ number_format($s->min_price) }}
                  </p>
               </div>
               <span class="bg-gold/10 text-gold font-body text-[10px] tracking-wide uppercase px-3 py-1">
                  <i class="fa-regular fa-clock mr-1"></i>{{ $s->max_delivery_time }} days
               </span>
            </div>
            <div class="px-6 py-4">
               <ul class="space-y-2 mb-5">
                  <li class="flex items-center gap-2 font-body text-[13px] text-gray-500">
                     <i class="fa-solid fa-circle-check text-gold text-[11px]"></i> Standard stitching
                  </li>
                  <li class="flex items-center gap-2 font-body text-[13px] text-gray-500">
                     <i class="fa-solid fa-circle-check text-gold text-[11px]"></i> 1 fitting session
                  </li>
               </ul>
               @if(session()->get('IS_TAILOR') == 'no' || !session()->has('FRONT_USER_LOGIN') === false)
               @if(session()->has('FRONT_USER_LOGIN') && session()->get('IS_TAILOR') != 'yes')
               <button onclick='user_order("{{ $s->id }}","{{ $s->user_id }}")'
                  style="width:100%;background:#1A1A1A;color:#fff;border:none;cursor:pointer;"
                  class="h-11 font-body text-[11px] tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">
                  Order This Package
               </button>
               @elseif(!session()->has('FRONT_USER_LOGIN'))
               <a href="{{ url('/login') }}"
                  class="flex items-center justify-center w-full h-11 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.2em] uppercase hover:bg-gray-800 transition-colors">
                  Sign In to Order
               </a>
               @endif
               @endif
            </div>
         </div>

         {{-- Standard package --}}
         <div class="bg-[#1A1A1A]">
            <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between">
               <div>
                  <p class="font-body text-[10px] tracking-[2.5px] uppercase text-gold/70">Standard Package</p>
                  <p class="font-display text-[26px] font-semibold text-white leading-none mt-1">
                     Rs {{ number_format($s->max_price) }}
                  </p>
               </div>
               <span class="bg-white/10 text-white/70 font-body text-[10px] tracking-wide uppercase px-3 py-1">
                  <i class="fa-regular fa-clock mr-1"></i>{{ $s->min_delivery_time }} days
               </span>
            </div>
            <div class="px-6 py-4">
               <ul class="space-y-2 mb-5">
                  <li class="flex items-center gap-2 font-body text-[13px] text-white/70">
                     <i class="fa-solid fa-circle-check text-gold text-[11px]"></i> Premium stitching
                  </li>
                  <li class="flex items-center gap-2 font-body text-[13px] text-white/70">
                     <i class="fa-solid fa-circle-check text-gold text-[11px]"></i> 2 fitting sessions
                  </li>
                  <li class="flex items-center gap-2 font-body text-[13px] text-white/70">
                     <i class="fa-solid fa-circle-check text-gold text-[11px]"></i> Priority delivery
                  </li>
               </ul>
               @if(session()->has('FRONT_USER_LOGIN') && session()->get('IS_TAILOR') != 'yes')
               <button onclick='user_order("{{ $s->id }}","{{ $s->user_id }}")'
                  style="width:100%;background:#C9A96E;color:#1A1A1A;border:none;cursor:pointer;"
                  class="h-11 font-body font-semibold text-[11px] tracking-[0.2em] uppercase hover:bg-[#A88948] transition-colors">
                  Order This Package
               </button>
               @elseif(!session()->has('FRONT_USER_LOGIN'))
               <a href="{{ url('/login') }}"
                  class="flex items-center justify-center w-full h-11 bg-gold text-[#1A1A1A] font-body font-semibold text-[11px] tracking-[0.2em] uppercase hover:bg-[#A88948] transition-colors">
                  Sign In to Order
               </a>
               @endif
            </div>
         </div>

         {{-- Tags --}}
         @if($s->tags)
         <div class="bg-white border border-gray-100 p-5">
            <p class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-3">Tags</p>
            <div class="flex flex-wrap gap-2">
               @foreach(explode(',', $s->tags) as $tag)
               @if(trim($tag))
               <span class="font-body text-[11px] text-gray-500 bg-gray-100 px-3 py-1">{{ trim($tag) }}</span>
               @endif
               @endforeach
            </div>
         </div>
         @endif

      </div>
   </div>
</div>

@endsection
