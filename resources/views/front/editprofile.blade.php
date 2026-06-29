@extends('front.layout')
@section('title', 'Edit Profile – StitchSpot')

@section('content')

{{-- Header --}}
<div class="bg-[#1A1A1A] py-14 text-center relative overflow-hidden">
   <div class="absolute inset-0 opacity-10"
        style="background-image:repeating-linear-gradient(45deg,#C9A96E 0,#C9A96E 1px,transparent 0,transparent 50%);background-size:20px 20px;"></div>
   <div class="relative z-10">
      <p class="font-body text-[10.5px] tracking-[4px] uppercase text-gold mb-3">
         <a href="{{ url('/profile/'.$customer[0]->id) }}" class="hover:text-white transition-colors">Profile</a>
         <span class="mx-2 text-white/30">/</span>
         Edit
      </p>
      <h1 class="font-display text-white text-[clamp(28px,4vw,44px)] font-semibold">Edit Profile</h1>
   </div>
</div>

<div class="py-16 bg-[#F9F8F6]">
   <div class="max-w-2xl mx-auto px-4 lg:px-0">

      <div class="bg-white border border-gray-100">

         {{-- Current avatar preview --}}
         <div class="flex flex-col items-center pt-8 pb-6 border-b border-gray-50">
            <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-100 mb-3 bg-gray-100">
               <img src="{{ asset('/storage/media/customer/'.$customer[0]->image) }}"
                    alt="{{ $customer[0]->name }}"
                    id="avatar-preview"
                    class="w-full h-full object-cover"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($customer[0]->name) }}&background=C9A96E&color=fff&size=80'">
            </div>
            <p class="font-body text-[12px] text-gray-400">Current profile photo</p>
         </div>

         <form action="{{ url('registration_process') }}" id="reg_form" method="POST" enctype="multipart/form-data"
               class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="id" value="{{ $customer[0]->id }}">

            {{-- Row: Name + Email --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Username <span class="text-gold">*</span>
                  </label>
                  <input type="text" name="name" value="{{ $customer[0]->name }}" placeholder="Your name"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="name_error"></span>
               </div>
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Email <span class="text-gold">*</span>
                  </label>
                  <input type="text" name="email" value="{{ $customer[0]->email }}" placeholder="you@email.com"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="email_error"></span>
               </div>
            </div>

            {{-- Row: Mobile + Address --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Mobile <span class="text-gold">*</span>
                  </label>
                  <input type="text" name="mobile" value="{{ $customer[0]->mobile }}" placeholder="+92 300 0000000"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="mobile_error"></span>
               </div>
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Address <span class="text-gold">*</span>
                  </label>
                  <input type="text" name="address" value="{{ $customer[0]->address }}" placeholder="City, Pakistan"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="address_error"></span>
               </div>
            </div>

            {{-- Row: Password + Tailor select --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     New Password <span class="text-gold">*</span>
                  </label>
                  <input type="password" name="password" placeholder="Leave blank to keep current"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
                  <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="password_error"></span>
               </div>
               <div>
                  <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                     Joining as Tailor <span class="text-gold">*</span>
                  </label>
                  <select name="tailor"
                     class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors appearance-none cursor-pointer">
                     <option value="">Select</option>
                     @if($customer[0]->tailor == 'yes')
                        <option value="yes" selected>Yes</option>
                        <option value="no">No</option>
                     @else
                        <option value="yes">Yes</option>
                        <option value="no" selected>No</option>
                     @endif
                  </select>
                  <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="tailor_error"></span>
               </div>
            </div>

            {{-- Bio --}}
            <div>
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Short Bio</label>
               <input type="text" name="bio" value="{{ $customer[0]->bio }}" placeholder="One-line description of yourself"
                  class="w-full h-11 px-4 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors">
               <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="bio_error"></span>
            </div>

            {{-- Profile image --}}
            <div>
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                  Profile Photo <span class="text-gold">*</span>
               </label>
               <label class="flex items-center gap-3 w-full h-11 px-4 border border-gray-200 bg-white cursor-pointer hover:border-[#1A1A1A] transition-colors">
                  <i class="fa-solid fa-camera text-gray-400 text-sm"></i>
                  <span id="image-label" class="font-body text-sm text-gray-400">Choose new photo…</span>
                  <input type="file" name="image" id="image" accept="image/*"
                     class="hidden"
                     onchange="previewAvatar(this)">
               </label>
               <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="image_error"></span>
            </div>

            {{-- About --}}
            <div>
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                  About <span class="text-gold">*</span>
               </label>
               <textarea name="about" rows="4" placeholder="Tell customers about yourself…"
                  class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none">{{ $customer[0]->about }}</textarea>
               <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="about_error"></span>
            </div>

            {{-- Skills --}}
            <div>
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">Skills</label>
               <textarea name="skills" rows="3" placeholder="e.g. Embroidery, Stitching, Alterations…"
                  class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none">{{ $customer[0]->skills }}</textarea>
               <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="skills_error"></span>
            </div>

            {{-- Language --}}
            <div>
               <label class="block font-body text-[10.5px] tracking-[2.5px] uppercase text-gray-400 mb-2">
                  Language <span class="text-gold">*</span>
               </label>
               <textarea name="language" rows="2" placeholder="e.g. Urdu, English"
                  class="w-full px-4 py-3 font-body text-sm text-[#1A1A1A] placeholder-gray-300 bg-white border border-gray-200 outline-none focus:border-[#1A1A1A] transition-colors resize-none">{{ $customer[0]->language }}</textarea>
               <span class="font-body text-[11px] text-red-500 mt-1 block field_error" id="language_error"></span>
            </div>

            {{-- Submit --}}
            <div class="pt-2">
               <button type="submit" id="reg_btn"
                  class="w-full h-12 bg-[#1A1A1A] text-white font-body font-semibold text-[11px] tracking-[0.22em] uppercase hover:bg-gray-800 transition-colors border-none cursor-pointer">
                  Save Changes
               </button>
               <div class="reg_msg font-body text-sm text-green-600 text-center mt-3 font-medium"></div>
            </div>

         </form>
      </div>

   </div>
</div>

@endsection

@section('scripts')
<script>
function previewAvatar(input) {
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
         document.getElementById('avatar-preview').src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
      document.getElementById('image-label').textContent = input.files[0].name;
   }
}
</script>
@endsection
