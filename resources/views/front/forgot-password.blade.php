@extends('front.auth-layout')

@section('title', 'Reset Password')
@section('heading', 'Forgot Password')
@section('subheading', "Enter your email and we'll send you a link to choose a new password.")

@section('form')
   <form method="POST" action="{{ route('password.email') }}" class="space-y-5" data-loading-text="Sending…">
      @csrf

      <div>
         <label class="block font-body text-[10px] tracking-[0.15em] uppercase text-gray-500 mb-2">Email</label>
         <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
            class="w-full border border-gray-300 px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
            required autofocus>
      </div>

      <button type="submit"
         class="w-full bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.22em] uppercase py-[15px] hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 border-none cursor-pointer">
         Send Reset Link &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>
      </button>
   </form>

   <p class="mt-7 font-body text-[12px] text-gray-400 text-center">
      Remembered it?
      <a href="{{ url('/login') }}" class="text-[#1A1A1A] underline underline-offset-2">Sign in</a>
   </p>
@endsection
