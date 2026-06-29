@extends('front.layout')
@section('title', 'Add Service – StitchSpot')

@section('extra-css')
   /* Step visibility — toggled by index.js */
   .form-step          { display: none; }
   .form-step.active   { display: block; }

   /* Progress track */
   .progress-bar {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 40px;
   }
   .progress-bar::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      height: 2px;
      width: 100%;
      background: #E5E7EB;
      z-index: 0;
   }
   #progress {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      height: 2px;
      background: #C9A96E;
      width: 0%;
      transition: width .4s ease;
      z-index: 1;
   }
   .progress-step {
      position: relative;
      z-index: 2;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
   }
   .progress-step::before {
      content: '';
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: #fff;
      border: 2px solid #E5E7EB;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .3s ease;
   }
   .progress-step.active::before {
      background: #C9A96E;
      border-color: #C9A96E;
   }
   .progress-step::after {
      content: attr(data-title);
      font-family: 'DM Sans', sans-serif;
      font-size: 10px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #9CA3AF;
      white-space: nowrap;
      transition: color .3s ease;
   }
   .progress-step.active::after { color: #C9A96E; font-weight: 500; }
@endsection

@section('content')

{{-- ── Header ── --}}
<div class="bg-[#1A1A1A] py-12 relative overflow-hidden">
   <div class="absolute inset-0 opacity-10"
        style="background-image:repeating-linear-gradient(45deg,#C9A96E 0,#C9A96E 1px,transparent 0,transparent 50%);background-size:20px 20px;"></div>
   <div class="relative z-10 max-w-[1280px] mx-auto px-4 lg:px-8">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-2">
         <a href="{{ url('/customers_dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
         <span class="mx-2 text-white/30">/</span> Add Service
      </p>
      <h1 class="font-display text-white text-[clamp(24px,3.5vw,40px)] font-semibold">Create a New Service</h1>
   </div>
</div>

<div class="py-14 bg-[#F9F8F6]">
<div class="max-w-2xl mx-auto px-4">

   <div class="bg-white border border-gray-100 p-8 lg:p-10">

      {{-- ── Progress bar ── --}}
      <div class="progress-bar mb-10">
         <div id="progress"></div>
         <div class="progress-step active" data-title="Service"></div>
         <div class="progress-step"        data-title="Pricing"></div>
         <div class="progress-step"        data-title="Description"></div>
         <div class="progress-step"        data-title="Gallery"></div>
         <div class="progress-step"        data-title="Publish"></div>
      </div>

      <form action="{{ url('add_service') }}" method="POST" class="form" enctype="multipart/form-data">
         @csrf

         {{-- ══ STEP 1: Service Info ══ --}}
         <div class="form-step active">
            <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-1">Step 1 of 5</p>
            <h2 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-1">Service Information</h2>
            <p class="font-body text-sm text-gray-400 mb-8">Tell customers what you're offering.</p>

            <div class="space-y-5">
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Service Title <span class="text-gold">*</span>
                  </label>
                  <input type="text" name="service_title" placeholder="e.g. Custom Shalwar Kameez Stitching"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
               </div>

               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Category <span class="text-gold">*</span>
                  </label>
                  <div class="relative">
                     <select name="category"
                        class="w-full h-11 px-4 pr-9 font-body text-sm text-[#1A1A1A] bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors appearance-none cursor-pointer">
                        <option value="">Select a category…</option>
                        @foreach($category as $item)
                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                        @endforeach
                     </select>
                     <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none"></i>
                  </div>
               </div>

               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Search Tags
                     <span id="tag-count-label" class="ml-2 text-gray-300 normal-case tracking-normal">0 / 5</span>
                  </label>

                  {{-- Tag chip display + input box --}}
                  <div id="tag-box"
                     onclick="document.getElementById('tag-input').focus()"
                     class="min-h-[46px] flex flex-wrap items-center gap-2 px-3 py-2 border border-gray-200 bg-white cursor-text focus-within:border-[#1A1A1A] transition-colors">
                     {{-- chips injected here by JS --}}
                     <input id="tag-input" type="text"
                        placeholder="Type a tag and press Enter…"
                        class="flex-1 min-w-[140px] h-7 font-body text-sm text-[#1A1A1A] placeholder-gray-300 outline-none border-none bg-transparent"
                        onkeydown="handleTagKey(event)">
                  </div>

                  {{-- Hidden input carries comma-separated tags to server --}}
                  <input type="hidden" name="tags" id="tags-hidden">

                  <p class="font-body text-[11px] text-gray-400 mt-1.5">
                      Max 5 tags
                  </p>
               </div>
            </div>

            <div class="mt-8 flex justify-end">
               <a class="btn-next inline-flex items-center gap-2 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.2em] uppercase px-8 h-11 hover:bg-gray-800 transition-colors cursor-pointer">
                  Continue <i class="fa-solid fa-arrow-right text-[9px]"></i>
               </a>
            </div>
         </div>

         {{-- ══ STEP 2: Pricing ══ --}}
         <div class="form-step">
            <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-1">Step 2 of 5</p>
            <h2 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-1">Pricing & Delivery</h2>
            <p class="font-body text-sm text-gray-400 mb-8">Set your price range and delivery timeframes.</p>

            <div class="space-y-5">
               <div class="grid grid-cols-2 gap-4">
                  <div>
                     <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Min Price (Rs) <span class="text-gold">*</span></label>
                     <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-body text-[12px] text-gray-400">Rs</span>
                        <input type="number" name="min_price" placeholder="500"
                           class="w-full h-11 pl-9 pr-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                     </div>
                  </div>
                  <div>
                     <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Max Price (Rs) <span class="text-gold">*</span></label>
                     <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 font-body text-[12px] text-gray-400">Rs</span>
                        <input type="number" name="max_price" placeholder="5000"
                           class="w-full h-11 pl-9 pr-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                     </div>
                  </div>
               </div>

               <div class="grid grid-cols-2 gap-4">
                  <div>
                     <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Min Delivery (days) <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-solid fa-clock absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-[11px] pointer-events-none"></i>
                        <input type="number" name="min_delivery_time" placeholder="3"
                           class="w-full h-11 pl-9 pr-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                     </div>
                  </div>
                  <div>
                     <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Max Delivery (days) <span class="text-gold">*</span></label>
                     <div class="relative">
                        <i class="fa-solid fa-clock absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 text-[11px] pointer-events-none"></i>
                        <input type="number" name="max_delivery_time" placeholder="14"
                           class="w-full h-11 pl-9 pr-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                     </div>
                  </div>
               </div>

               {{-- Price guide note --}}
               <div class="bg-gold/8 border border-gold/20 px-4 py-3 flex items-start gap-3" style="background:rgba(201,169,110,0.06)">
                  <i class="fa-solid fa-circle-info text-gold text-[13px] mt-0.5 shrink-0"></i>
                  <p class="font-body text-[12.5px] text-gray-500">Set a competitive range. Customers will see "Starting at Rs [min]".</p>
               </div>
            </div>

            <div class="mt-8 flex items-center justify-between">
               <a class="btn-prev inline-flex items-center gap-2 border border-gray-300 text-gray-500 font-body text-[11px] tracking-[0.2em] uppercase px-6 h-11 hover:border-[#1A1A1A] hover:text-[#1A1A1A] transition-colors cursor-pointer bg-white">
                  <i class="fa-solid fa-arrow-left text-[9px]"></i> Back
               </a>
               <a class="btn-next inline-flex items-center gap-2 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.2em] uppercase px-8 h-11 hover:bg-gray-800 transition-colors cursor-pointer">
                  Continue <i class="fa-solid fa-arrow-right text-[9px]"></i>
               </a>
            </div>
         </div>

         {{-- ══ STEP 3: Description ══ --}}
         <div class="form-step">
            <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-1">Step 3 of 5</p>
            <h2 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-1">Description</h2>
            <p class="font-body text-sm text-gray-400 mb-8">Describe your service and what customers need to provide.</p>

            <div class="space-y-5">
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Service Description <span class="text-gold">*</span>
                  </label>
                  <textarea name="desc" rows="6" placeholder="Describe your service in detail — what's included, your process, quality guarantees…"
                     class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none"></textarea>
               </div>
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Requirements from Customer</label>
                  <textarea name="requirement" rows="4" placeholder="What measurements, fabric, or photos do you need from the customer?"
                     class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none"></textarea>
               </div>
            </div>

            <div class="mt-8 flex items-center justify-between">
               <a class="btn-prev inline-flex items-center gap-2 border border-gray-300 text-gray-500 font-body text-[11px] tracking-[0.2em] uppercase px-6 h-11 hover:border-[#1A1A1A] hover:text-[#1A1A1A] transition-colors cursor-pointer bg-white">
                  <i class="fa-solid fa-arrow-left text-[9px]"></i> Back
               </a>
               <a class="btn-next inline-flex items-center gap-2 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.2em] uppercase px-8 h-11 hover:bg-gray-800 transition-colors cursor-pointer">
                  Continue <i class="fa-solid fa-arrow-right text-[9px]"></i>
               </a>
            </div>
         </div>

         {{-- ══ STEP 4: Gallery ══ --}}
         <div class="form-step">
            <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-1">Step 4 of 5</p>
            <h2 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-1">Service Photo</h2>
            <p class="font-body text-sm text-gray-400 mb-8">Add a cover image for your service listing.</p>

            <div class="experiences-group">
               <div class="experience-item">
                  <label class="block w-full border-2 border-dashed border-gray-200 hover:border-gold transition-colors cursor-pointer p-10 text-center"
                         id="drop-zone">
                     <i class="fa-solid fa-cloud-arrow-up text-[40px] text-gray-300 mb-3 block"></i>
                     <p class="font-body text-[13px] text-gray-400 mb-1">Click to upload or drag &amp; drop</p>
                     <p class="font-body text-[11px] text-gray-300">JPG, PNG, WEBP — recommended 800×600px</p>
                     <p id="file-name" class="font-body text-[12px] text-gold mt-3 hidden"></p>
                     <input type="file" name="image" accept="image/*" class="hidden"
                        onchange="document.getElementById('file-name').textContent = this.files[0]?.name; document.getElementById('file-name').classList.remove('hidden')">
                  </label>
               </div>
            </div>

            <div class="mt-8 flex items-center justify-between">
               <a class="btn-prev inline-flex items-center gap-2 border border-gray-300 text-gray-500 font-body text-[11px] tracking-[0.2em] uppercase px-6 h-11 hover:border-[#1A1A1A] hover:text-[#1A1A1A] transition-colors cursor-pointer bg-white">
                  <i class="fa-solid fa-arrow-left text-[9px]"></i> Back
               </a>
               <a class="btn-next inline-flex items-center gap-2 bg-[#1A1A1A] text-white font-body text-[11px] tracking-[0.2em] uppercase px-8 h-11 hover:bg-gray-800 transition-colors cursor-pointer">
                  Continue <i class="fa-solid fa-arrow-right text-[9px]"></i>
               </a>
            </div>
         </div>

         {{-- ══ STEP 5: Publish ══ --}}
         <div class="form-step">
            <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gray-400 mb-1">Step 5 of 5</p>
            <h2 class="font-display text-[28px] font-semibold text-[#1A1A1A] mb-1">Ready to Publish?</h2>
            <p class="font-body text-sm text-gray-400 mb-8">Review everything before making your service live.</p>

            <div class="bg-[#F9F8F6] border border-gray-100 p-6 space-y-3 mb-8">
               <div class="flex items-center gap-3">
                  <i class="fa-solid fa-circle-check text-gold text-[14px] w-5"></i>
                  <span class="font-body text-[13.5px] text-gray-600">Service title, category &amp; tags filled</span>
               </div>
               <div class="flex items-center gap-3">
                  <i class="fa-solid fa-circle-check text-gold text-[14px] w-5"></i>
                  <span class="font-body text-[13.5px] text-gray-600">Pricing and delivery time set</span>
               </div>
               <div class="flex items-center gap-3">
                  <i class="fa-solid fa-circle-check text-gold text-[14px] w-5"></i>
                  <span class="font-body text-[13.5px] text-gray-600">Description and requirements added</span>
               </div>
               <div class="flex items-center gap-3">
                  <i class="fa-solid fa-circle-check text-gold text-[14px] w-5"></i>
                  <span class="font-body text-[13.5px] text-gray-600">Cover photo uploaded</span>
               </div>
            </div>

            <div class="flex items-center justify-between">
               <a class="btn-prev inline-flex items-center gap-2 border border-gray-300 text-gray-500 font-body text-[11px] tracking-[0.2em] uppercase px-6 h-11 hover:border-[#1A1A1A] hover:text-[#1A1A1A] transition-colors cursor-pointer bg-white">
                  <i class="fa-solid fa-arrow-left text-[9px]"></i> Back
               </a>
               <input type="submit" name="complete" value="Publish Service"
                  class="btn-complete inline-flex items-center gap-2 bg-gold text-[#1A1A1A] font-body font-semibold text-[11px] tracking-[0.2em] uppercase px-10 h-11 hover:bg-[#A88948] transition-colors cursor-pointer border-none">
            </div>
         </div>

      </form>
   </div>

</div>
</div>

@endsection

@section('scripts')
<script>
/* ── Tag chip system ── */
const MAX_TAGS = 5;
let tags = [];

function renderTags() {
   const box   = document.getElementById('tag-box');
   const input = document.getElementById('tag-input');

   // Remove existing chips (keep the input)
   box.querySelectorAll('.tag-chip').forEach(c => c.remove());

   tags.forEach(function(tag, idx) {
      const chip = document.createElement('span');
      chip.className = 'tag-chip';
      chip.style.cssText = 'display:inline-flex;align-items:center;gap:6px;background:#F3F4F6;border:1px solid #E5E7EB;padding:0 10px;height:28px;font-family:"DM Sans",sans-serif;font-size:12px;color:#1A1A1A;cursor:default;user-select:none;';
      chip.innerHTML =
         '<span style="color:#1A1A1A">' + escHtml(tag) + '</span>' +
         '<button type="button" onclick="removeTag(' + idx + ')" ' +
         'style="display:inline-flex;align-items:center;justify-content:center;width:14px;height:14px;border-radius:50%;background:#D1D5DB;border:none;cursor:pointer;color:#6B7280;font-size:11px;line-height:1;padding:0;font-family:sans-serif;" ' +
         'onmouseover="this.style.background=\'#EF4444\';this.style.color=\'#fff\'" ' +
         'onmouseout="this.style.background=\'#D1D5DB\';this.style.color=\'#6B7280\'">' +
         '&times;</button>';
      box.insertBefore(chip, input);
   });

   // Update hidden input and counter
   document.getElementById('tags-hidden').value = tags.join(',');
   document.getElementById('tag-count-label').textContent = tags.length + ' / ' + MAX_TAGS;

   // Dim input when full
   const countLabel = document.getElementById('tag-count-label');
   if (tags.length >= MAX_TAGS) {
      input.placeholder = '';
      input.disabled = true;
      input.style.display = 'none';
      countLabel.style.color = '#C9A96E';
   } else {
      input.placeholder = 'Type a tag and press Enter…';
      input.disabled = false;
      input.style.display = '';
      countLabel.style.color = '#D1D5DB';
   }
}

function handleTagKey(e) {
   if (e.key !== 'Enter') return;
   e.preventDefault();

   const val = e.target.value.trim().toLowerCase().replace(/[^a-z0-9\s\-]/g, '');
   if (!val) return;
   if (tags.length >= MAX_TAGS) return;
   if (tags.includes(val)) { e.target.value = ''; return; } // no duplicates

   tags.push(val);
   e.target.value = '';
   renderTags();
}

function removeTag(idx) {
   tags.splice(idx, 1);
   renderTags();
}

function escHtml(str) {
   return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
<script src="{{ asset('front-assets/js/index.js') }}"></script>
@endsection
