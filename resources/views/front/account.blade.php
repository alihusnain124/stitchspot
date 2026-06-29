@extends('front.layout')
@section('title', 'My Account – StitchSpot')

@section('content')

<div class="bg-[#F9F8F6] border-b border-gray-100 py-12 text-center">
   <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-2">
      <a href="{{ url('/') }}" class="hover:text-gold transition-colors">Home</a>
      <span class="mx-2 text-gray-300">/</span>
      <span>My Account</span>
   </p>
   <h1 class="font-display text-[clamp(28px,4vw,44px)] font-semibold text-[#1A1A1A]">My Account</h1>
</div>

<section class="py-16 bg-white">
   <div class="max-w-xl mx-auto px-6 text-center">
      @if(session()->has('FRONT_USER_LOGIN'))
         @php $uid = session()->get('FRONT_USER_LOGIN'); @endphp
         <i class="fa-solid fa-circle-user text-gold text-[52px] mb-5 block"></i>
         <h2 class="font-display text-2xl font-semibold text-[#1A1A1A] mb-4">Welcome Back</h2>
         <p class="font-body text-[14px] text-gray-400 mb-8">You are signed in. View your profile to manage your account.</p>
         <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/profile/'.$uid) }}"
               class="inline-flex items-center justify-center bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase px-8 h-10 hover:bg-gray-800 transition-colors">
               View Profile
            </a>
            <a href="{{ url('/logout') }}"
               class="inline-flex items-center justify-center border border-gray-300 text-[#1A1A1A] font-body text-[11px] tracking-[0.18em] uppercase px-8 h-10 hover:border-[#1A1A1A] transition-colors">
               Logout
            </a>
         </div>
      @else
         <i class="fa-solid fa-right-to-bracket text-gold text-[52px] mb-5 block"></i>
         <h2 class="font-display text-2xl font-semibold text-[#1A1A1A] mb-4">Sign In to Your Account</h2>
         <p class="font-body text-[14px] text-gray-400 mb-8">Access your orders, profile, and tailoring services.</p>
         <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/login') }}"
               class="inline-flex items-center justify-center bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase px-8 h-10 hover:bg-gray-800 transition-colors">
               Sign In
            </a>
            <a href="{{ url('/registration') }}"
               class="inline-flex items-center justify-center border border-gray-300 text-[#1A1A1A] font-body text-[11px] tracking-[0.18em] uppercase px-8 h-10 hover:border-[#1A1A1A] transition-colors">
               Create Account
            </a>
         </div>
      @endif
   </div>
</section>

@endsection
