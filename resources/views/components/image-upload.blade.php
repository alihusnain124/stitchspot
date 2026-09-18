@props([
    'name',
    'label' => 'Image',
    'value' => null,      // existing image URL, if any
    'required' => false,
    'maxMb' => 8,
    'variant' => 'admin', // 'admin' or 'front' - picks the colour palette
    'inputId' => null,    // fixed id, when page JS needs to find the input
    'showLabel' => true,  // off when the page already renders its own label
])

@php
    $id = $inputId ?: $name.'-'.Str::random(6);
@endphp

<div class="img-up @if($variant === 'front') img-up--front @endif"
     data-img-up data-max-mb="{{ $maxMb }}" @if($inputId) data-fixed-id="{{ $inputId }}" @endif>
    @if($showLabel)
        <label class="img-up__label" for="{{ $id }}">
            {{ $label }} @if($required)<span aria-hidden="true">*</span>@endif
        </label>
    @endif

    <label class="img-up__zone" for="{{ $id }}" data-zone tabindex="0">
        <img class="img-up__preview" data-preview
             src="{{ $value ?: '' }}" alt=""
             @style(['display: none' => ! $value])>

        <div class="img-up__empty" data-empty @style(['display: none' => (bool) $value])>
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M12 16V4m0 0L8 8m4-4 4 4"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
            </svg>
            <span class="img-up__hint"><strong>Choose a file</strong> or drag it here</span>
            <span class="img-up__note">JPG, PNG, WebP or GIF &middot; up to {{ $maxMb }}MB</span>
        </div>

        <button type="button" class="img-up__clear" data-clear
                aria-label="Remove image" @style(['display: none' => ! $value])>&times;</button>
    </label>

    {{-- No native `required` here: the input is visually hidden, and browsers
         refuse to focus a hidden invalid control, which silently blocks submit.
         The asterisk marks it for the user; the server rule enforces it. --}}
    <input id="{{ $id }}" name="{{ $name }}" type="file" data-input
           accept="image/jpeg,image/png,image/webp,image/gif"
           class="img-up__input"
           {{ $attributes->except(['class']) }}>

    <p class="img-up__meta" data-meta hidden></p>
    <p class="img-up__error" data-error hidden></p>
</div>

{{-- Emitted once per page, however many uploaders it contains. --}}
@once
<style>
.img-up{margin-bottom:1rem;
  --iu-border:#cbd5e1;--iu-bg:#f8fafc;--iu-accent:#6366f1;--iu-accent-bg:#eef2ff;
  --iu-text:#64748b;--iu-muted:#94a3b8;--iu-radius:.6rem;--iu-font:inherit}
.img-up--front{
  --iu-border:#e5e7eb;--iu-bg:#ffffff;--iu-accent:#C9A96E;--iu-accent-bg:#FAF8F4;
  --iu-text:#9ca3af;--iu-muted:#d1d5db;--iu-radius:0;--iu-font:'DM Sans',sans-serif}
.img-up--front .img-up__label{font-size:10.5px;letter-spacing:2.5px;text-transform:uppercase;
  color:#9ca3af;font-weight:400}
.img-up--front .img-up__zone:hover,.img-up--front .img-up__zone:focus-visible{border-color:#1A1A1A}
.img-up--front .img-up__hint strong{color:#1A1A1A}
.img-up__label{display:block;font-size:.875rem;font-weight:600;margin-bottom:.4rem;font-family:var(--iu-font)}
.img-up__zone{position:relative;display:flex;align-items:center;justify-content:center;
  min-height:150px;padding:1rem;border:1px dashed var(--iu-border);border-radius:var(--iu-radius);
  background:var(--iu-bg);cursor:pointer;font-family:var(--iu-font);transition:border-color .15s,background .15s;overflow:hidden}
.img-up__zone:hover,.img-up__zone:focus-visible{border-color:var(--iu-accent);outline:none}
.img-up__zone.is-drag{border-color:var(--iu-accent);background:var(--iu-accent-bg)}
.img-up__zone.is-invalid{border-color:#dc2626;background:#fef2f2}
.img-up__empty{display:flex;flex-direction:column;align-items:center;gap:.35rem;color:var(--iu-text);text-align:center}
.img-up__hint{font-size:.875rem}
.img-up__note{font-size:.75rem;color:var(--iu-muted)}
.img-up__preview{max-height:190px;max-width:100%;object-fit:contain;border-radius:var(--iu-radius);display:block}
.img-up__clear{position:absolute;top:.5rem;right:.5rem;width:26px;height:26px;line-height:1;
  border:0;border-radius:50%;background:rgba(15,23,42,.72);color:#fff;font-size:1.1rem;cursor:pointer}
.img-up__clear:hover{background:#dc2626}
.img-up__input{position:absolute;width:1px;height:1px;opacity:0;pointer-events:none}
.img-up__meta{margin:.4rem 0 0;font-size:.75rem;color:var(--iu-text);font-family:var(--iu-font)}
.img-up__error{margin:.4rem 0 0;font-size:.8rem;color:#dc2626}
@media (max-width:576px){.img-up__zone{min-height:120px}.img-up__preview{max-height:140px}}
</style>

<script>
(function () {
  function kb(n){ return n < 1048576 ? (n/1024).toFixed(0)+' KB' : (n/1048576).toFixed(2)+' MB'; }

  var seq = 0;

  function wire(root) {
    if (root.dataset.wired) return;
    root.dataset.wired = '1';

    // Cloned uploaders (new variant rows) would otherwise repeat the template's
    // id, which breaks the label -> input association for every copy after the
    // first. Give each instance a fresh one as it is wired.
    var lbl = root.querySelector('[data-zone]'),
        fld = root.querySelector('[data-input]');

    // A fixed id is kept as-is, because page scripts look the input up by it.
    if (!root.dataset.fixedId) {
      var uid = 'img-up-' + (++seq) + '-' + Date.now().toString(36);
      fld.id = uid;
      if (lbl) lbl.setAttribute('for', uid);
      root.querySelectorAll('.img-up__label').forEach(function (l) { l.setAttribute('for', uid); });
    }

    var input   = root.querySelector('[data-input]'),
        zone    = root.querySelector('[data-zone]'),
        preview = root.querySelector('[data-preview]'),
        empty   = root.querySelector('[data-empty]'),
        clear   = root.querySelector('[data-clear]'),
        meta    = root.querySelector('[data-meta]'),
        error   = root.querySelector('[data-error]'),
        maxMb   = parseFloat(root.dataset.maxMb || '8'),
        ok      = ['image/jpeg','image/png','image/webp','image/gif'];

    function fail(msg) {
      error.textContent = msg; error.hidden = false;
      zone.classList.add('is-invalid');
      input.value = ''; meta.hidden = true;
    }

    function reset() {
      error.hidden = true; zone.classList.remove('is-invalid');
    }

    function show(file) {
      reset();
      if (ok.indexOf(file.type) === -1) return fail('That file is not a JPG, PNG, WebP or GIF.');
      if (file.size > maxMb * 1048576) return fail('That image is ' + kb(file.size) + '. The limit is ' + maxMb + 'MB.');

      var reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
        empty.style.display = 'none';
        clear.style.display = 'block';
      };
      reader.readAsDataURL(file);

      meta.textContent = file.name + ' · ' + kb(file.size) + ' · will be resized and compressed on upload';
      meta.hidden = false;

      emit(file);
    }

    // Pages with their own preview panels listen for this.
    function emit(file) {
      root.dispatchEvent(new CustomEvent('image-upload:change', {
        bubbles: true,
        detail: { file: file, input: input },
      }));
    }

    input.addEventListener('change', function () {
      if (input.files && input.files[0]) show(input.files[0]);
    });

    clear.addEventListener('click', function (e) {
      e.preventDefault(); e.stopPropagation();
      input.value = ''; preview.src = ''; preview.style.display = 'none';
      empty.style.display = 'flex'; clear.style.display = 'none';
      meta.hidden = true; reset();
      emit(null);
    });

    ['dragenter','dragover'].forEach(function (ev) {
      zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.add('is-drag'); });
    });
    ['dragleave','drop'].forEach(function (ev) {
      zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.remove('is-drag'); });
    });
    zone.addEventListener('drop', function (e) {
      var f = e.dataTransfer && e.dataTransfer.files[0];
      if (!f) return;
      // Hand the dropped file to the real input so normal form submission carries it.
      var dt = new DataTransfer(); dt.items.add(f); input.files = dt.files;
      show(f);
    });
    zone.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
    });
  }

  function init(){
    document.querySelectorAll('[data-img-up]').forEach(function (el) {
      // Uploaders sitting inside a <template> are blueprints, not live fields.
      if (!el.closest('template')) wire(el);
    });
  }

  // Exposed so code that injects uploaders at runtime can wire them up.
  window.ssWireImageUploads = init;

  document.addEventListener('DOMContentLoaded', init);
  init();
})();
</script>
@endonce
