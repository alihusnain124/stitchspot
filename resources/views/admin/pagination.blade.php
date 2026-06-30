@if ($paginator->hasPages())
<style>
  .adm-pag { display:flex; align-items:center; justify-content:space-between; padding:14px 20px 6px; font-family:'DM Sans',sans-serif; font-size:12px; color:#888; flex-wrap:wrap; gap:10px; }
  .adm-pag-info { white-space:nowrap; }
  .adm-pag-btns { display:flex; flex-wrap:wrap; gap:4px; align-items:center; }
  .adm-pag-btn { padding:6px 11px; border:1px solid #E5E7EB; color:#1A1A1A; text-decoration:none; font-size:12px; font-family:'DM Sans',sans-serif; cursor:pointer; transition:background .18s,color .18s,border-color .18s; background:transparent; display:inline-block; }
  .adm-pag-btn:hover { background:#C9A96E; color:#fff; border-color:#C9A96E; }
  .adm-pag-btn.active { background:#C9A96E; color:#fff; border-color:#C9A96E; font-weight:600; cursor:default; }
  .adm-pag-btn.disabled { color:#D1D5DB; cursor:default; }
  .adm-pag-btn.disabled:hover { background:transparent; color:#D1D5DB; border-color:#E5E7EB; }
  .adm-pag-dots { padding:6px 4px; color:#D1D5DB; font-size:12px; }
  @media (max-width: 540px) {
    .adm-pag { justify-content:center; }
    .adm-pag-info { width:100%; text-align:center; }
    .adm-pag-btns { justify-content:center; }
    .adm-pag-btn.hide-mobile { display:none; }
  }
</style>
<div class="adm-pag">
  <div class="adm-pag-info">
    Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} results
  </div>
  <div class="adm-pag-btns">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
      <span class="adm-pag-btn disabled">&lsaquo;</span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" class="adm-pag-btn">&lsaquo;</a>
    @endif

    {{-- Page numbers --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="adm-pag-dots hide-mobile">{{ $element }}</span>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @php
            $current = $paginator->currentPage();
            $isCurrent = $page == $current;
            $isNearby  = abs($page - $current) <= 1;
          @endphp
          @if ($isCurrent)
            <span class="adm-pag-btn active">{{ $page }}</span>
          @elseif ($isNearby)
            <a href="{{ $url }}" class="adm-pag-btn">{{ $page }}</a>
          @else
            <a href="{{ $url }}" class="adm-pag-btn hide-mobile">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" class="adm-pag-btn">&rsaquo;</a>
    @else
      <span class="adm-pag-btn disabled">&rsaquo;</span>
    @endif

  </div>
</div>
@endif
