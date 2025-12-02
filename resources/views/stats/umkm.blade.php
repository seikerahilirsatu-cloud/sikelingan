@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-4">
  <header class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
      <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div class="text-lg font-semibold">Statistik UMKM</div>
      <div class="text-xs text-gray-600">Sebaran jenis usaha</div>
    </div>
  </header>

  <div class="grid grid-cols-1 gap-3">
    <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
      <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center">
        <svg class="w-7 h-7 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16l-1 5H5L4 7zm1 5v7h14v-7"/></svg>
      </div>
      <div>
        <div class="text-sm text-gray-600">UMKM Terdaftar</div>
        <div class="text-2xl font-semibold mt-1">{{ number_format($totalUmkm,0,',','.') }}</div>
      </div>
    </div>
  </div>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Jenis</div>
    <div class="h-56 w-full"><canvas id="statUmkm" style="width:100%;height:100%" data-labels='{!! json_encode($jenisUmkmAll) !!}' data-data='{!! json_encode($umkmDataArr) !!}' data-total='{{ $totalUmkm }}'></canvas></div>
    @php
      $labelsU = $jenisUmkmAll ?? [];
      $dataU = $umkmDataArr ?? [];
      $colorsU = ['bg-amber-400','bg-orange-400','bg-red-400','bg-emerald-400','bg-blue-400','bg-cyan-400','bg-fuchsia-400'];
    @endphp
    <div class="mt-4 space-y-2">
      @foreach($labelsU as $i => $label)
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
          <div class="flex items-center gap-2 text-sm text-gray-700">
            <span class="inline-block w-3 h-3 rounded-full {{ $colorsU[$i % count($colorsU)] }}"></span>
            {{ $label }}
          </div>
          <div class="text-sm font-semibold">{{ number_format($dataU[$i] ?? 0,0,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  (function(){
    const el = document.getElementById('statUmkm');
    if(!el) return;
    let labels = []; let data = [];
    try { labels = JSON.parse(el.dataset.labels || '[]'); } catch(e) {}
    try { data = JSON.parse(el.dataset.data || '[]'); } catch(e) {}
    const total = parseFloat(el.dataset.total || '0');
    const sum = (Array.isArray(data)?data:[]).reduce((a,b)=> a + (typeof b==='number'?b:parseFloat(b)||0), 0);
    const lbl = sum ? labels : ['Total'];
    const dat = sum ? data : [total];
    const colors = ['#FDE68A','#FDBA74','#FCA5A5','#A7F3D0','#93C5FD','#67E8F9','#F5D0FE'];
    const bg = sum ? colors.slice(0, dat.length) : ['#F59E0B'];
    new Chart(el,{type:'doughnut',data:{labels:lbl,datasets:[{data:dat,backgroundColor:bg}]},options:{plugins:{legend:{position:'bottom'}},maintainAspectRatio:false,cutout:'65%'}});
  })();
  </script>
</div>
@endsection
