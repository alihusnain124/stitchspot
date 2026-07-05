{{--
   Shared conversation-list sidebar for the messages split-pane UI.
   Expects: $conversations, $my_contacts, $isTailor. Optional: $activeConversationId, $hideOnMobile
   (pass hideOnMobile=true from the thread page so mobile shows only the open thread, not both panes stacked)
--}}
<aside class="w-full lg:w-[320px] lg:flex-none {{ ($hideOnMobile ?? false) ? 'hidden lg:flex' : 'flex' }} flex-col h-full min-h-0 border-b lg:border-b-0 lg:border-r border-gray-100 bg-white">

   @php $totalUnread = $conversations->where('unread_count', '>', 0)->count(); @endphp
   <div class="p-5 border-b border-gray-100 shrink-0">
      <h2 class="font-display text-[19px] font-semibold text-[#1A1A1A] mb-4 flex items-center gap-2">
         Messages
         <span id="messages-total-badge"
            class="bg-gold text-white font-body font-bold text-[11px] min-w-[22px] h-[22px] rounded-full flex items-center justify-center px-1.5"
            style="{{ $totalUnread > 0 ? '' : 'display:none' }}">
            {{ $totalUnread }}
         </span>
      </h2>
      <div class="relative">
         <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-[12px] pointer-events-none"></i>
         <input type="text" id="tailor-search-input" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false"
            placeholder="{{ ($isTailor ?? false) ? 'Search your customers…' : 'Search your tailors…' }}"
            data-no-results-text="{{ ($isTailor ?? false) ? 'No customers found.' : 'No tailors found.' }}"
            class="w-full h-9 pl-9 pr-3 font-body text-[12.5px] text-[#1A1A1A] placeholder-gray-400 bg-[#F9F8F6] border border-transparent outline-none focus:border-[#1A1A1A] focus:bg-white transition-colors rounded-full">
      </div>
      <div id="tailor-search-results" class="mt-2.5 space-y-1"></div>
   </div>

   @php $currentFilter = $activeFilter ?? 'all'; @endphp
   <div class="flex items-center gap-4 px-5 border-b border-gray-100 shrink-0 flex-wrap">
      @foreach(['all' => 'All', 'unread' => 'Unread', 'read' => 'Read', 'archived' => 'Archived'] as $key => $label)
      <a href="{{ url()->current() }}?filter={{ $key }}"
         class="font-body text-[12.5px] pt-3 pb-2.5 border-b-2 transition-colors {{ $currentFilter === $key ? 'text-[#1A1A1A] font-semibold border-gold' : 'text-gray-400 hover:text-gray-600 border-transparent' }}">
         {{ $label }}
      </a>
      @endforeach
   </div>

   <div class="flex-1 min-h-0 overflow-y-auto" id="conversation-list">
      @forelse($conversations as $conv)
      @php $cImg = $conv->other_image ? asset('storage/media/customer/'.$conv->other_image) : null; @endphp
      <div id="conv-item-{{ $conv->id }}"
         class="group flex items-center gap-3 px-5 py-3.5 border-b border-gray-50 hover:bg-[#F9F8F6] transition-colors {{ (($activeConversationId ?? null) == $conv->id) ? 'bg-[#F9F8F6]' : '' }}">
         <a href="{{ url('/messages/'.$conv->id) }}" class="flex items-center gap-3 flex-1 min-w-0">
            <div class="w-11 h-11 rounded-full overflow-hidden bg-[#F9F8F6] flex items-center justify-center shrink-0">
               @if($cImg)
                  <img src="{{ $cImg }}" alt="{{ $conv->other_name }}" class="w-full h-full object-cover">
               @else
                  <i class="fa-solid fa-circle-user text-gray-300 text-[22px]"></i>
               @endif
            </div>
            <div class="min-w-0 flex-1">
               <p class="font-body text-[13.5px] font-semibold text-[#1A1A1A] truncate">{{ $conv->other_name }}</p>
               <p id="conv-preview-{{ $conv->id }}"
                  class="font-body text-[12px] truncate {{ $conv->unread_count > 0 ? 'text-[#1A1A1A] font-semibold' : 'text-gray-400' }}">
                  {{ $conv->last_message ?? 'No messages yet' }}
               </p>
            </div>
            <span id="conv-badge-{{ $conv->id }}"
               class="w-2.5 h-2.5 rounded-full bg-gold shrink-0"
               style="{{ $conv->unread_count > 0 ? '' : 'display:none' }}">
            </span>
         </a>
         <button type="button" class="conv-archive-btn shrink-0 w-7 h-7 flex items-center justify-center text-gray-300 hover:text-gold opacity-0 group-hover:opacity-100 transition-all bg-transparent border-none cursor-pointer"
            data-conversation-id="{{ $conv->id }}"
            title="{{ $conv->archived ? 'Unarchive' : 'Archive' }}">
            <i class="fa-solid {{ $conv->archived ? 'fa-box-open' : 'fa-box-archive' }} text-[13px]"></i>
         </button>
      </div>
      @empty
      <div class="text-center py-12 px-6">
         <i class="fa-regular fa-comments text-[32px] text-gray-200 mb-3 block"></i>
         <p class="font-body text-[12.5px] text-gray-400">
            {{ $currentFilter === 'archived' ? 'No archived chats.' : ($currentFilter === 'unread' ? 'No unread chats.' : ($currentFilter === 'read' ? 'No read chats.' : 'No conversations yet')) }}
         </p>
      </div>
      @endforelse
   </div>

</aside>

<script>
/* Live-update a conversation's sidebar preview (and, for incoming messages
   the user isn't currently viewing, its unread highlight + the total badge —
   these are counts of unread CONVERSATIONS, not raw message counts) without
   requiring a full page refresh. */
window.SSUpdateConversationPreview = function(conversationId, body, incomingUnread) {
   var preview = document.getElementById('conv-preview-' + conversationId);
   if (preview) preview.textContent = body;

   var item = document.getElementById('conv-item-' + conversationId);
   var list = document.getElementById('conversation-list');
   if (item && list && list.firstElementChild !== item) {
      list.insertBefore(item, list.firstElementChild);
   }

   if (incomingUnread) {
      var badge = document.getElementById('conv-badge-' + conversationId);
      var wasAlreadyUnread = badge && badge.style.display !== 'none';

      if (badge) badge.style.display = '';
      if (preview) {
         preview.classList.add('text-[#1A1A1A]', 'font-semibold');
         preview.classList.remove('text-gray-400');
      }

      if (!wasAlreadyUnread) {
         var total = document.getElementById('messages-total-badge');
         if (total) {
            total.textContent = (parseInt(total.textContent, 10) || 0) + 1;
            total.style.display = '';
         }
      }
   }
};

/* Show a spinner in the main pane the instant a conversation/contact is clicked,
   so there's visible feedback while the browser loads the next page. */
document.addEventListener('click', function(e) {
   var link = e.target.closest('#conversation-list a, #tailor-search-results a');
   if (!link) return;
   var mainPane = document.getElementById('messages-main-pane');
   if (mainPane) {
      mainPane.innerHTML = '<div class="w-full h-full flex items-center justify-center">'
         + '<i class="fa-solid fa-spinner fa-spin text-gold text-[28px]"></i></div>';
   }
});

/* Archive / unarchive a conversation without leaving the page — it just
   disappears from whichever filter tab you're currently viewing. */
document.addEventListener('click', function(e) {
   var btn = e.target.closest('.conv-archive-btn');
   if (!btn) return;
   e.preventDefault();
   var conversationId = btn.dataset.conversationId;
   btn.disabled = true;
   fetch('/messages/' + conversationId + '/archive', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
   })
   .then(function(r) { return r.json(); })
   .then(function(res) {
      if (res.status === 'ok') {
         var item = document.getElementById('conv-item-' + conversationId);
         if (item) item.remove();
      } else {
         btn.disabled = false;
         if (window.SS && SS.toast) SS.toast('error', 'Action failed', res.message);
      }
   })
   .catch(function() { btn.disabled = false; });
});

(function() {
   var input   = document.getElementById('tailor-search-input');
   var results = document.getElementById('tailor-search-results');
   var list    = document.getElementById('conversation-list');
   if (!input || input.dataset.bound) return;
   input.dataset.bound = '1';

   var timer = null;
   input.addEventListener('input', function() {
      clearTimeout(timer);
      var q = this.value;
      timer = setTimeout(function() {
         fetch('/messages/search?search_val=' + encodeURIComponent(q))
            .then(function(r) { return r.json(); })
            .then(function(res) {
               if (res.status !== 'ok') return;
               results.innerHTML = '';
               if (q.trim() === '') { list.style.display = ''; return; }
               list.style.display = 'none';
               if (res.data.length === 0) {
                  var p = document.createElement('p');
                  p.className = 'font-body text-[12px] text-gray-400 px-1 py-2';
                  p.textContent = input.dataset.noResultsText || 'No results found.';
                  results.appendChild(p);
                  return;
               }
               res.data.forEach(function(t) {
                  var a = document.createElement('a');
                  a.href = '/messages/start/' + encodeURIComponent(t.id);
                  a.className = 'flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-[#F9F8F6] transition-colors';

                  var avatar = document.createElement('div');
                  avatar.className = 'w-9 h-9 rounded-full overflow-hidden bg-[#F9F8F6] flex items-center justify-center shrink-0';
                  if (t.image) {
                     var img = document.createElement('img');
                     img.src = '/storage/media/customer/' + encodeURIComponent(t.image);
                     img.alt = '';
                     img.className = 'w-full h-full object-cover';
                     avatar.appendChild(img);
                  } else {
                     avatar.innerHTML = '<i class="fa-solid fa-scissors text-gold text-[13px]"></i>';
                  }

                  var nameEl = document.createElement('span');
                  nameEl.className = 'font-body text-[13px] font-medium text-[#1A1A1A] truncate';
                  nameEl.textContent = t.name;

                  a.appendChild(avatar);
                  a.appendChild(nameEl);
                  results.appendChild(a);
               });
            });
      }, 250);
   });
})();
</script>
