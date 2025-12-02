@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-4">
  <header class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
      <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div class="text-lg font-semibold">Statistik Rumah Ibadah</div>
      <div class="text-xs text-gray-600">Sebaran jenis rumah ibadah</div>
    </div>
  </header>

  <div class="grid grid-cols-1 gap-3">
    <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
      <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
        <svg class="w-7 h-7 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l4 4v3h3v10H5V10h3V7l4-4z"/></svg>
      </div>
      <div>
        <div class="text-sm text-gray-600">Rumah Ibadah</div>
        <div class="text-2xl font-semibold mt-1">{{ number_format($totalIbadah,0,',','.') }}</div>
      </div>
    </div>
  </div>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Jenis</div>
    <div class="h-56 w-full"><canvas id="statIbadah" style="width:100%;height:100%" data-labels='{!! json_encode($jenisIbadahAll) !!}' data-data='{!! json_encode($ibadahDataArr) !!}' data-total='{{ $totalIbadah }}'></canvas></div>
    @php
      $labelsI = $jenisIbadahAll ?? [];
      $dataI = $ibadahDataArr ?? [];
      $colorsI = ['bg-blue-400','bg-sky-400','bg-pink-300','bg-amber-300','bg-emerald-400','bg-red-300','bg-cyan-300'];
    @endphp
    <div class="mt-4 space-y-2">
      @foreach($labelsI as $i => $label)
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
          <div class="flex items-center gap-2 text-sm text-gray-700">
            <span class="inline-block w-3 h-3 rounded-full {{ $colorsI[$i % count($colorsI)] }}"></span>
            {{ $label }}
          </div>
          <div class="text-sm font-semibold">{{ number_format($dataI[$i] ?? 0,0,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  (function(){
    const el = document.getElementById('statIbadah');
    if(!el) return;
    let labels = []; let data = [];
    try { labels = JSON.parse(el.dataset.labels || '[]'); } catch(e) {}
    try { data = JSON.parse(el.dataset.data || '[]'); } catch(e) {}
    const total = parseFloat(el.dataset.total || '0');
    const sum = (Array.isArray(data)?data:[]).reduce((a,b)=> a + (typeof b==='number'?b:parseFloat(b)||0), 0);
    const lbl = sum ? labels : ['Total'];
    const dat = sum ? data : [total];
    const colors = ['#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5','#99F6E4'];
    const bg = sum ? colors.slice(0, dat.length) : ['#60A5FA'];
    new Chart(el,{type:'doughnut',data:{labels:lbl,datasets:[{data:dat,backgroundColor:bg}]},options:{plugins:{legend:{position:'bottom'}},maintainAspectRatio:false,cutout:'65%'}});
  })();
  </script>
</div>
@endsection
