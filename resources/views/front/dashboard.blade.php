@extends('front.layout')
@section('title', 'Dashboard – StitchSpot')

@section('extra-css')
   .tab-btn.active { color:#1A1A1A; border-bottom-color:#C9A96E; }
   .tab-panel { display:none; }
   .tab-panel.active { display:block; }
@endsection

@section('content')

{{-- ── Dark header ── --}}
<div class="bg-[#1A1A1A] py-12 relative overflow-hidden">
   <div class="absolute inset-0 opacity-10"
        style="background-image:repeating-linear-gradient(45deg,#C9A96E 0,#C9A96E 1px,transparent 0,transparent 50%);background-size:20px 20px;"></div>
   <div class="relative z-10 max-w-[1280px] mx-auto px-4 lg:px-8 flex items-center justify-between">
      <div>
         <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-2">Tailor Portal</p>
         <h1 class="font-display text-white text-[clamp(24px,3.5vw,40px)] font-semibold">My Dashboard</h1>
      </div>
      <a href="{{ url('/profile/'.session()->get('FRONT_USER_LOGIN')) }}"
         class="hidden sm:inline-flex items-center gap-2 border border-white/20 text-white font-body text-[10.5px] tracking-[0.18em] uppercase px-5 h-9 hover:bg-white/10 transition-colors">
         <i class="fa-solid fa-circle-user text-[12px]"></i> View Profile
      </a>
   </div>
</div>

{{-- ── Stats row ── --}}
<div class="bg-white border-b border-gray-100">
   <div class="max-w-[1280px] mx-auto px-4 lg:px-8">
      <div class="grid grid-cols-3 divide-x divide-gray-100">
         <div class="py-6 px-4 lg:px-8 text-center">
            <p class="font-body text-[10px] tracking-[3px] uppercase text-gray-400 mb-1">Completed Orders</p>
            <p class="font-display text-[32px] font-semibold text-[#1A1A1A] leading-none">{{ $total_completed_orders }}</p>
         </div>
         <div class="py-6 px-4 lg:px-8 text-center">
            <p class="font-body text-[10px] tracking-[3px] uppercase text-gray-400 mb-1">Total Earnings</p>
            <p class="font-display text-[32px] font-semibold text-gold leading-none">Rs {{ number_format($total_earning) }}</p>
         </div>
         <div class="py-6 px-4 lg:px-8 text-center">
            <p class="font-body text-[10px] tracking-[3px] uppercase text-gray-400 mb-1">Price Received</p>
            <p class="font-display text-[32px] font-semibold text-[#1A1A1A] leading-none">Rs {{ number_format($price_recieved) }}</p>
         </div>
      </div>
   </div>
</div>

{{-- ── Main layout ── --}}
<div class="max-w-[1280px] mx-auto px-4 lg:px-8 py-12">
   <div class="flex flex-col lg:flex-row gap-8">

      {{-- ── LEFT: Profile card ── --}}
      <aside class="lg:w-64 shrink-0">
         <div class="bg-white border border-gray-100 p-6 text-center">
            <div class="w-20 h-20 rounded-full mx-auto mb-4 overflow-hidden border-2 border-gray-100 bg-gray-100">
               <img src="{{ asset('/storage/media/customer/'.$user[0]->image) }}"
                    alt="{{ $user[0]->name }}"
                    class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($user[0]->name) }}&background=C9A96E&color=fff&size=80'">
            </div>
            <h2 class="font-display text-xl font-semibold text-[#1A1A1A] mb-1">{{ $user[0]->name }}</h2>
            @if($user[0]->tailor == 'yes')
            <p class="font-body text-[12.5px] text-gray-400 mb-3">{{ $user[0]->bio }}</p>
            <span class="inline-flex items-center gap-1.5 bg-gold/10 text-gold font-body text-[10px] tracking-[0.15em] uppercase px-3 py-1">
               <i class="fa-solid fa-scissors text-[9px]"></i> Tailor
            </span>
            @endif
         </div>

         <div class="mt-3 bg-white border border-gray-100 divide-y divide-gray-50">
            <div class="flex items-center gap-3 px-5 py-3.5">
               <i class="fa-solid fa-location-dot text-gold text-[12px] w-4"></i>
               <span class="font-body text-[13px] text-gray-600">{{ $user[0]->address }}</span>
            </div>
            <div class="flex items-center gap-3 px-5 py-3.5">
               <i class="fa-solid fa-calendar-days text-gold text-[12px] w-4"></i>
               <span class="font-body text-[13px] text-gray-600">Joined {{ $formattedDate }}</span>
            </div>
            <div class="flex items-center gap-3 px-5 py-3.5">
               <i class="fa-solid fa-circle-check text-gold text-[12px] w-4"></i>
               <span class="font-body text-[13px] text-gray-600">{{ $total_completed_orders }} completed</span>
            </div>
         </div>

         <div class="mt-3 space-y-2">
            <a href="{{ url('/form') }}"
               class="flex items-center justify-center gap-2 w-full h-10 bg-[#1A1A1A] text-white font-body text-[10.5px] tracking-[0.15em] uppercase hover:bg-gray-800 transition-colors">
               <i class="fa-solid fa-plus text-[10px]"></i> Add Service
            </a>
            <a href="{{ url('/edit_profile/'.session()->get('FRONT_USER_LOGIN')) }}"
               class="flex items-center justify-center gap-2 w-full h-10 border border-gray-300 text-[#1A1A1A] font-body text-[10.5px] tracking-[0.15em] uppercase hover:border-[#1A1A1A] transition-colors bg-white">
               <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit Profile
            </a>
         </div>
      </aside>

      {{-- ── RIGHT: Tabs ── --}}
      <div class="flex-1 min-w-0">

         {{-- Tab nav --}}
         <div class="flex border-b border-gray-200 mb-6">
            <button onclick="switchDashTab('requests', this)"
               class="tab-btn active px-6 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-gold text-[#1A1A1A] transition-colors hover:text-gold bg-transparent cursor-pointer">
               Order Requests
               @if(isset($order_detail[0]))
               <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-gold text-[#1A1A1A] font-body font-bold text-[9px]">
                  {{ count($order_detail) }}
               </span>
               @endif
            </button>
            <button onclick="switchDashTab('active', this)"
               class="tab-btn px-6 py-3 font-body text-[11.5px] tracking-[0.12em] uppercase border-b-2 border-transparent text-gray-400 transition-colors hover:text-gold bg-transparent cursor-pointer">
               Active Orders
               @if(isset($active_orders[0]))
               <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#1A1A1A] text-white font-body font-bold text-[9px]">
                  {{ count($active_orders) }}
               </span>
               @endif
            </button>
         </div>

         {{-- ── Order Requests tab ── --}}
         <div id="tab-requests" class="tab-panel active">
            @if(isset($order_detail[0]))
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
               @foreach($order_detail as $item)
               <div class="bg-white border border-gray-100 hover:shadow-md transition-shadow">
                  <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
                     <h4 class="font-display text-[17px] font-semibold text-[#1A1A1A]">Order #{{ $item->id }}</h4>
                     <span class="font-body text-[10px] tracking-wide uppercase text-gold bg-gold/10 px-2.5 py-1">New</span>
                  </div>
                  <div class="px-5 py-4 space-y-2">
                     <div class="flex items-center gap-2 font-body text-[13px] text-gray-600">
                        <i class="fa-solid fa-user text-gray-300 w-4 text-[11px]"></i>
                        {{ $order_user_detail[0]->name }}
                     </div>
                     <div class="flex items-center gap-2 font-body text-[13px] text-gray-600">
                        <i class="fa-solid fa-tag text-gray-300 w-4 text-[11px]"></i>
                        Rs {{ number_format($item->price) }}
                     </div>
                     <div class="flex items-center gap-2 font-body text-[13px] text-gray-600">
                        <i class="fa-solid fa-clock text-gray-300 w-4 text-[11px]"></i>
                        {{ $item->delivery_time }} days delivery
                     </div>
                     <div class="flex items-center gap-2 font-body text-[12px] text-gray-400">
                        <i class="fa-solid fa-calendar text-gray-300 w-4 text-[11px]"></i>
                        {{ $item->added_on }}
                     </div>
                  </div>
                  <div class="px-5 pb-5 flex gap-2">
                     <button onclick='action("{{ $item->id }}","yes")'
                        class="flex-1 h-9 bg-[#1A1A1A] text-white font-body text-[10.5px] tracking-[0.15em] uppercase border-none cursor-pointer hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-check mr-1 text-[10px]"></i> Confirm
                     </button>
                     <button onclick='action("{{ $item->id }}","no")'
                        class="flex-1 h-9 border border-gray-300 text-gray-500 font-body text-[10.5px] tracking-[0.15em] uppercase cursor-pointer hover:border-red-400 hover:text-red-500 transition-colors bg-white">
                        <i class="fa-solid fa-xmark mr-1 text-[10px]"></i> Cancel
                     </button>
                  </div>
               </div>
               @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-solid fa-inbox text-[52px] text-gray-200 mb-4 block"></i>
               <h3 class="font-display text-[22px] text-[#1A1A1A] mb-2">No Pending Requests</h3>
               <p class="font-body text-[13.5px] text-gray-400">New order requests will appear here.</p>
            </div>
            @endif
         </div>

         {{-- ── Active Orders tab ── --}}
         <div id="tab-active" class="tab-panel">
            @if(isset($active_orders[0]))
            <div class="bg-white border border-gray-100 overflow-hidden">
               <div class="overflow-x-auto">
                  <table class="w-full font-body text-[13px]">
                     <thead class="bg-[#F9F8F6]">
                        <tr>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">ID</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Product</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Price</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Delivery</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Status</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Action</th>
                           <th class="text-left px-4 py-3 text-[10.5px] tracking-[0.12em] uppercase text-gray-400 font-medium">Placed</th>
                        </tr>
                     </thead>
                     <tbody class="divide-y divide-gray-50">
                        @foreach($active_orders as $item)
                        <tr class="hover:bg-[#FAFAFA] transition-colors">
                           <td class="px-4 py-3 text-gray-500">#{{ $item->id }}</td>
                           <td class="px-4 py-3 text-gray-600">{{ $item->order_product_id }}</td>
                           <td class="px-4 py-3 font-semibold text-gold">Rs {{ number_format($item->price) }}</td>
                           <td class="px-4 py-3 text-gray-500">{{ $item->delivery_time }} days</td>
                           <td class="px-4 py-3">
                              <span class="inline-block px-2.5 py-1 text-[10.5px] font-medium uppercase tracking-wide
                                 {{ $item->status == 'completed' ? 'bg-green-50 text-green-700' : 'bg-blue-50 text-blue-700' }}">
                                 {{ $item->status }}
                              </span>
                           </td>
                           <td class="px-4 py-3">
                              @if($item->status == 'processing')
                              <button onclick='complete("{{ $item->id }}","yes")'
                                 class="inline-flex items-center gap-1.5 px-4 h-8 bg-[#1A1A1A] text-white font-body text-[10px] tracking-[0.12em] uppercase border-none cursor-pointer hover:bg-gray-800 transition-colors">
                                 Mark Done
                              </button>
                              @else
                              <span class="inline-flex items-center gap-1.5 font-body text-[11px] text-green-600">
                                 <i class="fa-solid fa-circle-check"></i> Delivered
                              </span>
                              @endif
                           </td>
                           <td class="px-4 py-3 text-gray-400 text-[12px]">{{ $item->added_on }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
            @else
            <div class="text-center py-16 bg-white border border-gray-100">
               <i class="fa-solid fa-scissors text-[52px] text-gray-200 mb-4 block"></i>
               <h3 class="font-display text-[22px] text-[#1A1A1A] mb-2">No Active Orders</h3>
               <p class="font-body text-[13.5px] text-gray-400">Confirmed orders will appear here.</p>
            </div>
            @endif
         </div>

      </div>
   </div>
</div>

@endsection

@section('scripts')
<script>
function switchDashTab(name, btn) {
   document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
   document.querySelectorAll('.tab-btn').forEach(b => {
      b.classList.remove('active', 'text-[#1A1A1A]');
      b.classList.add('text-gray-400');
      b.style.borderBottomColor = 'transparent';
   });
   document.getElementById('tab-' + name).classList.add('active');
   btn.classList.add('active', 'text-[#1A1A1A]');
   btn.classList.remove('text-gray-400');
   btn.style.borderBottomColor = '#C9A96E';
}
</script>
@endsection
