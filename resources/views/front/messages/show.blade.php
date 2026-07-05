@extends('front.layout')
@section('title', ($other->name ?? 'Chat') . ' – Messages – StitchSpot')

@section('content')

<section class="bg-white border-t border-gray-100">
   <style>
      .ss-chat-panel { height: calc(100vh - 160px); max-height: 900px; }
      @media (min-width: 1024px) {
         .ss-chat-panel { height: 78vh; min-height: 560px; max-height: none; }
      }
   </style>
   <div class="ss-chat-panel max-w-[1340px] mx-auto flex flex-col lg:flex-row">

      @include('front.messages._sidebar', ['activeConversationId' => $conversationId, 'hideOnMobile' => true])

      <div id="messages-main-pane" class="flex-1 flex flex-col min-w-0 min-h-0 bg-[#FAFAF9]">

         {{-- Thread header --}}
         <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-white shrink-0">
            <a href="{{ url('/messages') }}" class="lg:hidden w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gold transition-colors -ml-1">
               <i class="fa-solid fa-arrow-left"></i>
            </a>
            @php $oImg = ($other->image ?? null) ? asset('storage/media/customer/'.$other->image) : null; @endphp
            <div class="w-10 h-10 rounded-full overflow-hidden bg-[#F9F8F6] flex items-center justify-center shrink-0">
               @if($oImg)
                  <img src="{{ $oImg }}" alt="{{ $other->name ?? '' }}" class="w-full h-full object-cover">
               @else
                  <i class="fa-solid fa-circle-user text-gray-300 text-[20px]"></i>
               @endif
            </div>
            <div class="min-w-0">
               <p class="font-body text-[14px] font-semibold text-[#1A1A1A] leading-tight truncate">{{ $other->name ?? 'Unknown' }}</p>
               @if(($other->tailor ?? 'no') === 'yes')
               <span class="inline-block bg-gold/10 text-gold font-body text-[9px] tracking-[0.1em] uppercase px-2 py-0.5 mt-0.5">Tailor</span>
               @endif
            </div>
         </div>

         {{-- Thread --}}
         <div id="thread" class="flex-1 min-h-0 overflow-y-auto flex flex-col gap-3 px-6 py-6">
            @foreach($messages as $i => $msg)
            @php $isOwn = $msg->sender_id == session('FRONT_USER_LOGIN'); @endphp
            <div class="max-w-[70%] {{ $i === 0 ? 'mt-auto' : '' }} {{ $isOwn ? 'self-end bg-[#1A1A1A]' : 'self-start bg-white border border-gray-100' }} px-4 py-2.5">
               <p class="font-body text-[13.5px] leading-snug m-0 {{ $isOwn ? 'text-white' : 'text-[#1A1A1A]' }}" style="white-space:pre-wrap;">{{ $msg->body }}</p>
            </div>
            @endforeach
         </div>

         {{-- Composer --}}
         <form id="composer-form" class="flex gap-3 px-6 py-4 border-t border-gray-100 bg-white shrink-0">
            <input type="text" id="composer-input" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false"
               placeholder="Type a message…"
               class="flex-1 h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-400 bg-[#F9F8F6] border border-transparent outline-none focus:border-[#1A1A1A] focus:bg-white transition-colors">
            <button type="submit" id="composer-send-btn"
               class="px-6 h-11 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase hover:bg-gold transition-colors border-none cursor-pointer shrink-0 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
               <span id="composer-send-text" class="text-white">Send</span>
               <i id="composer-send-spinner" class="fa-solid fa-spinner fa-spin text-white" style="display:none"></i>
            </button>
         </form>

      </div>
   </div>
</section>

@endsection

@section('scripts')
<script>
const conversationId = {{ $conversationId }};
const currentUserId  = {{ (int) session('FRONT_USER_LOGIN') }};
const thread          = document.getElementById('thread');
const composerForm    = document.getElementById('composer-form');
const composerInput   = document.getElementById('composer-input');
const composerSendBtn = document.getElementById('composer-send-btn');
const composerSendText = document.getElementById('composer-send-text');
const composerSendSpinner = document.getElementById('composer-send-spinner');

function scrollThreadToBottom() {
   thread.scrollTop = thread.scrollHeight;
}
scrollThreadToBottom();

function setSending(isSending) {
   composerSendBtn.disabled = isSending;
   composerSendText.style.display = isSending ? 'none' : '';
   composerSendSpinner.style.display = isSending ? '' : 'none';
}

function appendMessage(body, isOwn) {
   const bubble = document.createElement('div');
   const isFirst = thread.children.length === 0;
   bubble.className = 'max-w-[70%] px-4 py-2.5 ' + (isFirst ? 'mt-auto ' : '') + (isOwn ? 'self-end bg-[#1A1A1A]' : 'self-start bg-white border border-gray-100');
   const p = document.createElement('p');
   p.className = 'font-body text-[13.5px] leading-snug m-0 ' + (isOwn ? 'text-white' : 'text-[#1A1A1A]');
   p.style.whiteSpace = 'pre-wrap';
   p.textContent = body;
   bubble.appendChild(p);
   thread.appendChild(bubble);
   scrollThreadToBottom();
}

composerForm.addEventListener('submit', function(e) {
   e.preventDefault();
   const body = composerInput.value.trim();
   if (!body) return;

   setSending(true);

   fetch('/messages/' + conversationId + '/send', {
      method: 'POST',
      headers: {
         'Content-Type': 'application/json',
         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ body: body })
   })
   .then(function(r) { return r.json(); })
   .then(function(res) {
      if (res.status === 'ok') {
         appendMessage(res.data.body, true);
         composerInput.value = '';
         if (window.SSUpdateConversationPreview) SSUpdateConversationPreview(conversationId, res.data.body, false);
      } else if (window.SS && SS.toast) {
         SS.toast('error', 'Message failed', res.message);
      }
   })
   .catch(function() {
      if (window.SS && SS.toast) SS.toast('error', 'Message failed', 'Please try again.');
   })
   .finally(function() {
      setSending(false);
      composerInput.focus();
   });
});

{{-- Real-time delivery is best-effort: if Pusher fails to load/init (blocked by an
     ad-blocker, network issue, bad config, etc.) sending/receiving via plain HTTP
     above must keep working regardless. --}}
@if($pusherKey)
try {
   // Reuses the shared Pusher client already created by the site-wide
   // notification script in layout.blade.php (avoids a second websocket connection).
   const channel = window.pusherClient.subscribe('private-conversation.' + conversationId);
   channel.bind('message.sent', function(data) {
      if (data.sender_id != currentUserId) {
         appendMessage(data.body, false);
         if (window.SSUpdateConversationPreview) SSUpdateConversationPreview(conversationId, data.body, false);
         // This message is being shown live while the thread is open — actually mark it
         // read server-side too, so it doesn't come back as unread on the next page load.
         fetch('/messages/' + conversationId + '/read', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
         }).catch(function() {});
      }
   });
} catch (err) {
   console.warn('Real-time messaging unavailable, falling back to manual refresh.', err);
}
@endif
</script>
@endsection
