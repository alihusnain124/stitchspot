@extends('front.layout')
@section('title', 'Profile – StitchSpot')

@section('extra-css')
   .tab-btn.active { color:#1A1A1A; border-bottom-color:#C9A96E; }
   .tab-panel { display:none; }
   .tab-panel.active { display:block; }
@endsection

@section('content')

@php
   $u = $user[0];
   $pendingCount = 0;
   foreach($confirm_order as $o){ if($o->status != 'completed') $pendingCount++; }
   $reviewTotal = count($reviews);
@endphp


{{-- Profile header banner --}}
<div class="bg-[#1A1A1A] h-36 relative">
   <div class="absolute inset-0 opacity-10"
        style="background-image:repeating-linear-gradient(45deg,#C9A96E 0,#C9A96E 1px,transparent 0,transparent 50%);background-size:20px 20px;"></div>
</div>

<div class="max-w-[1280px] mx-auto px-4 lg:px-8 pb-20">

   {{-- Two-column layout --}}
   <div class="flex flex-col lg:flex-row gap-8">

      {{-- ══════════════════════════
           LEFT SIDEBAR
      ══════════════════════════ --}}
      <aside class="lg:w-72 shrink-0">

         {{-- Profile card --}}
         <div class="bg-white border border-gray-100 -mt-16 relative z-10 p-6 text-center">

            {{-- Avatar --}}
            <div class="w-24 h-24 rounded-full mx-auto mb-4 overflow-hidden border-2 border-white shadow-md bg-gray-100">
               <img src="{{ asset('/storage/media/customer/'.$u->image) }}"
                    alt="{{ $u->name }}"
                    class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=C9A96E&color=fff&size=96'">
            </div>

            <h1 class="font-display text-2xl font-semibold text-[#1A1A1A] leading-tight">{{ $u->name }}</h1>

            @if($u->tailor == 'yes')
               <p class="font-body text-[13px] text-gray-400 mt-1">{{ $u->bio }}</p>
               <div class="flex flex-wrap justify-center gap-2 mt-3">
                  <span class="inline-flex items-center gap-1 bg-gold/10 text-gold font-body text-[10.5px] tracking-wide uppercase px-3 py-1">
                     <i class="fa-solid fa-scissors text-[9px]"></i> Tailor
                  </span>
                  @if($pendingCount > 0)
                  <span class="inline-flex items-center gap-1 bg-[#1A1A1A]/5 text-[#1A1A1A] font-body text-[10.5px] tracking-wide uppercase px-3 py-1">
                     {{ $pendingCount }} in queue
                  </span>
                  @endif
               </div>

               {{-- Rating --}}
               @if(isset($rating_points))
               <div class="mt-4 flex flex-col items-center gap-1">
                  <div class="flex items-center gap-0.5 text-gold">
                     @for($i = 0; $i < $fullStars; $i++)<i class="fa-solid fa-star text-[14px]"></i>@endfor
                     @if($halfStars)<i class="fa-solid fa-star-half-alt text-[14px]"></i>@endif
                  </div>
                  <span class="font-body text-[12px] text-gray-400">{{ $rating_points }}/5 · {{ $reviewTotal }} reviews</span>
               </div>
               @endif

               @if(isset($total_count) && $total_count > 50 && isset($rating_points) && $rating_points > 4)
               <div class="mt-3">
                  <span class="inline-flex items-center gap-1.5 bg-gold text-[#1A1A1A] font-body font-semibold text-[10px] tracking-[0.15em] uppercase px-4 py-1.5">
                     <i class="fa-solid fa-medal text-[10px]"></i> Top Rated
                  </span>
               </div>
               @endif
            @endif

         </div>

         {{-- Info list --}}
         <div class="mt-4 bg-white border border-gray-100 divide-y divide-gray-50">
            <div class="flex items-center gap-3 px-5 py-3.5">
               <i class="fa-solid fa-location-dot text-gold text-[13px] w-4"></i>
               <span class="font-body text-[13px] text-gray-600">{{ $u->address }}</span>
            </div>
            <div class="flex items-center gap-3 px-5 py-3.5">
               <i class="fa-solid fa-calendar-days text-gold text-[13px] w-4"></i>
               <span class="font-body text-[13px] text-gray-600">Joined {{ $formattedDate }}</span>
            </div>
            @if($u->tailor == 'yes')
            <div class="flex items-center gap-3 px-5 py-3.5">
               <i class="fa-solid fa-star text-gold text-[13px] w-4"></i>
               <span class="font-body text-[13px] text-gray-600">{{ $reviewTotal }} Reviews</span>
            </div>
            @endif
         </div>

         {{-- About --}}
         @if($u->about)
         <div class="mt-4 bg-white border border-gray-100 p-5">
            <h3 class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-2">About</h3>
            <p class="font-body text-[13.5px] text-gray-600 leading-relaxed">{{ $u->about }}</p>
         </div>
         @endif

         {{-- Skills (tailors only) --}}
         @if($u->tailor == 'yes' && $u->skills)
         <div class="mt-4 bg-white border border-gray-100 p-5">
            <h3 class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-2">Skills</h3>
            <p class="font-body text-[13.5px] text-gray-600 leading-relaxed">{{ $u->skills }}</p>
         </div>
         @endif

         {{-- Languages --}}
         @if($u->language)
         <div class="mt-4 bg-white border border-gray-100 p-5">
            <h3 class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-2">Languages</h3>
            <p class="font-body text-[13.5px] text-gray-600">{{ $u->language }}</p>
         </div>
         @endif

         {{-- Stripe Account (own tailor profile only) --}}
         @if($u->tailor == 'yes' && session()->get('FRONT_USER_LOGIN') == $u->id)
         <div class="mt-4 bg-white border border-gray-100 p-5">
            <h3 class="font-body text-[10.5px] tracking-[3px] uppercase text-gray-400 mb-2">Stripe Account</h3>
            @if(isset($account_no[0]))
               <p class="font-body text-[13px] text-gray-500 break-all tracking-wide">{{ $account_no[0]->account_no }}</p>
            @else
               <div class="flex gap-2 mt-1">
                  <input type="text" id="account_no" placeholder="Enter account no"
                     class="flex-1 h-9 px-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  <button onclick="submitAccountNo()"
                     style="background:#1A1A1A;color:#fff;border:none;cursor:pointer;"
                     class="px-4 h-9 font-body text-[10px] tracking-wide uppercase hover:bg-gray-800 transition-colors">
                     Save
                  </button>
               </div>
            @endif
         </div>
         @endif

         {{-- Edit profile link --}}
         @if(session()->get('FRONT_USER_LOGIN') == $u->id || session()->get('IS_TAILOR') == 'yes')
         <div class="mt-4">
            <a href="{{ url('/edit_profile/'.$u->id) }}"
               class="flex items-center justify-center gap-2 w-full h-10 border border-gray-300 text-[#1A1A1A] font-body text-[11px] tracking-[0.15em] uppercase hover:border-[#1A1A1A] transition-colors bg-white">
               <i class="fa-solid fa-pen-to-square text-[11px]"></i> Edit Profile
            </a>
         </div>
         @endif

      </aside>

      {{-- ══════════════════════════
           RIGHT CONTENT
      ══════════════════════════ --}}
      <div class="flex-1 min-w-0 lg:mt-8">

         {{-- ── TAILOR VIEW ── --}}
         @if($u->tailor == 'yes')

         {{-- Tabs --}}
         <div class="flex border-b border-gray-200 mb-6 gap-0">
            <button onclick="switchProfileTab('services', this)"
               class="tab-btn active px-6 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-gold text-[#1A1A1A] transition-colors hover:text-gold bg-transparent cursor-pointer">
               Services
            </button>
            <button onclick="switchProfileTab('reviews', this)"
               class="tab-btn px-6 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-transparent text-gray-400 transition-colors hover:text-gold bg-transparent cursor-pointer">
               Reviews
            </button>
            @if(session()->get('IS_TAILOR') == 'yes')
            <a href="{{ url('/form') }}"
               class="ml-auto flex items-center gap-2 px-5 py-3 font-body text-[11px] tracking-[0.12em] uppercase text-gold hover:text-[#A88948] transition-colors">
               <i class="fa-solid fa-plus text-[10px]"></i> Add Service
            </a>
            @endif
         </div>

         {{-- Services tab --}}
         <div id="tab-services" class="tab-panel active">
            @if(isset($services[$u->id]) && count($services[$u->id]) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
               @foreach($services[$u->id] as $item)
               <a href="{{ url('/service-details/'.$item->id) }}"
                  class="group bg-white border border-gray-100 hover:shadow-lg transition-all duration-300 block">
                  <div class="overflow-hidden bg-gray-100" style="aspect-ratio:4/3">
                     <img src="{{ asset('/storage/media/services/'.$item->image) }}"
                          alt="{{ $item->title }}"
                          class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                  </div>
                  <div class="p-4">
                     <h4 class="font-body text-[13.5px] font-medium text-[#1A1A1A] leading-snug mb-2 line-clamp-2">
                        {{ Str::substr($item->title, 0, 50) }}…
                     </h4>
                     <span class="font-body text-[13px] font-semibold text-gold">Rs {{ number_format($item->min_price) }}</span>
                  </div>
               </a>
               @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-solid fa-scissors text-[48px] text-gray-200 mb-4 block"></i>
               <p class="font-body text-[14px] text-gray-400">No services posted yet.</p>
            </div>
            @endif
         </div>

         {{-- Reviews tab --}}
         <div id="tab-reviews" class="tab-panel">
            @if(isset($reviews[0]))
            <div class="space-y-4">
               @foreach($reviews as $item)
               <div class="bg-white border border-gray-100 p-5">
                  <div class="flex items-start justify-between mb-2">
                     <div>
                        <p class="font-body text-[13.5px] font-medium text-[#1A1A1A]">
                           {{ isset($user[$item->id][0]) ? $user[$item->id][0]->name : 'Anonymous' }}
                        </p>
                        <div class="flex items-center gap-0.5 mt-1 text-gold">
                           @for($i = 0; $i < $item->review_star; $i++)
                           <i class="fa-solid fa-star text-[12px]"></i>
                           @endfor
                        </div>
                     </div>
                     <span class="font-body text-[11px] text-gray-400">{{ $item->added_on }}</span>
                  </div>
                  <p class="font-body text-[13px] text-gray-500 leading-relaxed italic">"{{ $item->review_desc }}"</p>
               </div>
               @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-regular fa-star text-[48px] text-gray-200 mb-4 block"></i>
               <p class="font-body text-[14px] text-gray-400">No reviews yet.</p>
            </div>
            @endif
         </div>

         {{-- ── CUSTOMER VIEW ── --}}
         @else

         {{-- Tabs --}}
         <div class="flex border-b border-gray-200 mb-6 gap-0 overflow-x-auto">
            <button onclick="switchProfileTab('orders', this)"
               class="tab-btn active whitespace-nowrap px-5 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-gold text-[#1A1A1A] transition-colors hover:text-gold bg-transparent cursor-pointer">
               Orders
            </button>
            <button onclick="switchProfileTab('tailor-orders', this)"
               class="tab-btn whitespace-nowrap px-5 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-transparent text-gray-400 transition-colors hover:text-gold bg-transparent cursor-pointer">
               Tailor Orders
            </button>
            <button onclick="switchProfileTab('orders-to-pay', this)"
               class="tab-btn whitespace-nowrap px-5 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-transparent text-gray-400 transition-colors hover:text-gold bg-transparent cursor-pointer">
               Orders To Pay
            </button>
         </div>

         {{-- Orders tab --}}
         <div id="tab-orders" class="tab-panel active">
            @if(isset($orders[0]))
            <div class="bg-white border border-gray-100 overflow-hidden">
               <div class="px-5 py-4 border-b border-gray-50">
                  <h3 class="font-display text-lg font-semibold text-[#1A1A1A]">Your Orders</h3>
               </div>
               <div class="overflow-x-auto">
                  <table class="w-full font-body text-[13px]">
                     <thead class="bg-[#F9F8F6]">
                        <tr>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Status</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Payment</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Address</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Tracking</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Placed</th>
                        </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-50">
                        @foreach($orders as $item)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                           <td class="px-4 py-3">
                              <a href="{{ url('order_details/'.$item->id) }}" class="text-gold hover:text-[#A88948] font-medium transition-colors">#{{ $item->id }}</a>
                           </td>
                           <td class="px-4 py-3">
                              <span class="inline-block px-2.5 py-1 text-[10.5px] font-medium uppercase tracking-wide
                                 {{ $item->order_status == 'completed' ? 'bg-green-50 text-green-700' : ($item->order_status == 'processing' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                 {{ $item->order_status }}
                              </span>
                           </td>
                           <td class="px-4 py-3 text-gray-500">{{ $item->payment_status }}</td>
                           <td class="px-4 py-3 text-gray-500 max-w-[160px] truncate">{{ $item->address }}</td>
                           <td class="px-4 py-3 text-gray-500">{{ $item->track_details ?: '—' }}</td>
                           <td class="px-4 py-3 text-gray-400">{{ $item->added_on }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-solid fa-bag-shopping text-[48px] text-gray-200 mb-4 block"></i>
               <h3 class="font-display text-xl text-[#1A1A1A] mb-2">No Orders Yet</h3>
               <p class="font-body text-[13px] text-gray-400 mb-6">Start shopping to see your orders here.</p>
               <a href="{{ url('/products') }}"
                  class="inline-flex items-center bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.18em] uppercase px-7 h-9 hover:bg-gray-800 transition-colors">
                  Browse Products
               </a>
            </div>
            @endif
         </div>

         {{-- Tailor Orders tab --}}
         <div id="tab-tailor-orders" class="tab-panel">
            @if(isset($confirm_order[0]))
            <div class="bg-white border border-gray-100 overflow-hidden">
               <div class="px-5 py-4 border-b border-gray-50">
                  <h3 class="font-display text-lg font-semibold text-[#1A1A1A]">Tailor's Orders</h3>
               </div>
               <div class="overflow-x-auto">
                  <table class="w-full font-body text-[13px]">
                     <thead class="bg-[#F9F8F6]">
                        <tr>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Product ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Service ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Price</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Status</th>
                        </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-50">
                        @foreach($confirm_order as $item)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                           <td class="px-4 py-3">
                              @if($item->status == 'processing')
                                 <span class="text-gray-500">#{{ $item->id }}</span>
                              @else
                                 <a href="{{ url('user_review/'.$item->id) }}" class="text-gold hover:text-[#A88948] font-medium transition-colors">#{{ $item->id }}</a>
                              @endif
                           </td>
                           <td class="px-4 py-3 text-gray-500">{{ $item->order_product_id }}</td>
                           <td class="px-4 py-3 text-gray-500">{{ $item->service_id }}</td>
                           <td class="px-4 py-3 font-medium text-[#1A1A1A]">Rs {{ number_format($item->price) }}</td>
                           <td class="px-4 py-3">
                              <span class="inline-block px-2.5 py-1 text-[10.5px] font-medium uppercase tracking-wide
                                 {{ $item->status == 'completed' ? 'bg-green-50 text-green-700' : ($item->status == 'processing' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                 {{ $item->status }}
                              </span>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-solid fa-scissors text-[48px] text-gray-200 mb-4 block"></i>
               <p class="font-body text-[14px] text-gray-400">No tailor orders yet.</p>
            </div>
            @endif
         </div>

         {{-- Orders To Pay tab --}}
         <div id="tab-orders-to-pay" class="tab-panel">
            @if(isset($confirm_order_to_pay[0]))
            <div class="bg-white border border-gray-100 overflow-hidden">
               <div class="px-5 py-4 border-b border-gray-50">
                  <h3 class="font-display text-lg font-semibold text-[#1A1A1A]">Orders To Pay</h3>
               </div>
               <div class="overflow-x-auto">
                  <table class="w-full font-body text-[13px]">
                     <thead class="bg-[#F9F8F6]">
                        <tr>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Product ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Price</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Action</th>
                        </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-50">
                        @foreach($confirm_order_to_pay as $item)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                           <td class="px-4 py-3 text-gray-500">#{{ $item->id }}</td>
                           <td class="px-4 py-3 text-gray-500">{{ $item->order_product_id }}</td>
                           <td class="px-4 py-3 font-semibold text-gold">Rs {{ number_format($item->price) }}</td>
                           <td class="px-4 py-3">
                              <a href="{{ '/stripe_pay/'.$item->id.'/'.$item->price }}"
                                 class="inline-flex items-center gap-1.5 px-4 h-8 bg-[#1A1A1A] text-white font-body text-[10px] tracking-[0.15em] uppercase hover:bg-gray-800 transition-colors">
                                 <i class="fa-solid fa-lock text-[9px]"></i> Pay Now
                              </a>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-solid fa-circle-check text-[48px] text-gray-200 mb-4 block"></i>
               <h3 class="font-display text-xl text-[#1A1A1A] mb-2">All Paid Up</h3>
               <p class="font-body text-[13px] text-gray-400">No pending payments.</p>
            </div>
            @endif
         </div>

         @endif
      </div>
   </div>
</div>

{{-- Hidden account form for AJAX --}}
<form action="{{ url('/account_no') }}" id="account_form">
   <input type="hidden" name="account_no" id="account">
   <input type="hidden" name="user_id" value="{{ $u->id }}">
</form>

@endsection

@section('scripts')
<script>
function switchProfileTab(name, btn) {
   document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
   document.querySelectorAll('.tab-btn').forEach(b => {
      b.classList.remove('active');
      b.classList.add('text-gray-400');
      b.classList.remove('text-[#1A1A1A]');
      b.style.borderBottomColor = 'transparent';
   });
   document.getElementById('tab-' + name).classList.add('active');
   btn.classList.add('active');
   btn.classList.remove('text-gray-400');
   btn.classList.add('text-[#1A1A1A]');
   btn.style.borderBottomColor = '#C9A96E';
}

function submitAccountNo() {
   var val = document.getElementById('account_no').value.trim();
   if (!val) return;
   document.getElementById('account').value = val;
   document.getElementById('account_form').submit();
}
</script>
@endsection
