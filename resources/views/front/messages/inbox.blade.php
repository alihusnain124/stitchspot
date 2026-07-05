@extends('front.layout')
@section('title', 'Messages – StitchSpot')

@section('content')

@if(session('error'))
<div class="max-w-[1340px] mx-auto px-4 lg:px-8 pt-5">
   <div class="bg-red-50 border border-red-100 text-[#E63946] font-body text-[13px] px-4 py-3">
      {{ session('error') }}
   </div>
</div>
@endif

<style>
   .ss-chat-panel { height: calc(100vh - 160px); max-height: 900px; }
   @media (min-width: 1024px) {
      .ss-chat-panel { height: 78vh; min-height: 560px; max-height: none; }
   }
</style>
<section class="bg-white border-t border-gray-100">
   <div class="ss-chat-panel max-w-[1340px] mx-auto flex flex-col lg:flex-row">

      @include('front.messages._sidebar')

      <div id="messages-main-pane" class="flex-1 hidden lg:flex flex-col items-center justify-center text-center px-8 bg-[#FAFAF9]">
         <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mb-5">
            <i class="fa-regular fa-comment-dots text-[26px] text-gold"></i>
         </div>
         <h3 class="font-display text-[22px] text-[#1A1A1A] mb-2">Your Messages</h3>
         <p class="font-body text-[13.5px] text-gray-400 max-w-[300px] leading-relaxed">
            @if($isTailor ?? false)
               Select a conversation from the list, or search for a customer who's ordered from you to start a new chat.
            @else
               Select a conversation from the list, or search for a tailor you've ordered from to start a new chat.
            @endif
         </p>
      </div>

   </div>
</section>

@endsection
