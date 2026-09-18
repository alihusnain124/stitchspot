@extends('front.auth-layout')

@section('title', 'Choose a New Password')
@section('heading', 'New Password')
@section('subheading', 'Choose a new password for your account.')

@section('form')
   <form method="POST" action="{{ route('password.update') }}" class="space-y-5" data-loading-text="Updating…">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div>
         <label class="block font-body text-[10px] tracking-[0.15em] uppercase text-gray-500 mb-2">Email</label>
         <input type="email" name="email" value="{{ old('email', $email) }}"
            class="w-full border border-gray-300 px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-gray-50"
            required readonly>
      </div>

      <div>
         <label class="block font-body text-[10px] tracking-[0.15em] uppercase text-gray-500 mb-2">New Password</label>
         <div class="relative">
            <input type="password" name="password" id="new_password" placeholder="••••••••"
               class="w-full border border-gray-300 px-4 py-3 pr-11 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
               required autofocus>
            <button type="button" onclick="togglePwd('new_password', this)"
               class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#1A1A1A] transition-colors bg-transparent border-none cursor-pointer p-0.5">
               <i class="fa-regular fa-eye text-[14px]"></i>
            </button>
         </div>
         <p class="mt-2 font-body text-[11px] text-gray-400">At least 8 characters, including a letter and a number.</p>
      </div>

      <div>
         <label class="block font-body text-[10px] tracking-[0.15em] uppercase text-gray-500 mb-2">Confirm Password</label>
         <input type="password" name="password_confirmation" placeholder="••••••••"
            class="w-full border border-gray-300 px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 focus:border-[#1A1A1A] transition-colors bg-white"
            required>
      </div>

      <button type="submit"
         class="w-full bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.22em] uppercase py-[15px] hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 border-none cursor-pointer">
         Update Password &nbsp;<i class="fa-solid fa-arrow-right text-[9px]"></i>
      </button>
   </form>

   <script>
      function togglePwd(id, btn) {
         var input = document.getElementById(id), icon = btn.querySelector('i');
         if (input.type === 'password') {
            input.type = 'text';  icon.className = 'fa-regular fa-eye-slash text-[14px]';
         } else {
            input.type = 'password'; icon.className = 'fa-regular fa-eye text-[14px]';
         }
      }
   </script>
@endsection
