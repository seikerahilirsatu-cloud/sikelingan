@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-4" id="stat-pendidikan">
  <header class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
      <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div class="text-lg font-semibold">Statistik Sarana Pendidikan</div>
      <div class="text-xs text-gray-600">Pendidikan Formal dan Non-Formal</div>
    </div>
  </header>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="grid grid-cols-2 gap-3">
      <div class="bg-gray-50 rounded-xl p-4 text-center">
        <div class="text-sm text-gray-600">Jumlah SaranaPendidikan Formal</div>
        <div class="text-2xl font-bold">{{ number_format($totalFormal ?? 0,0,',','.') }}</div>
      </div>
      <div class="bg-gray-50 rounded-xl p-4 text-center">
        <div class="text-sm text-gray-600">Jumlah Sarana Pendidikan Non-Formal</div>
        <div class="text-2xl font-bold">{{ number_format($totalNonFormal ?? 0,0,',','.') }}</div>
      </div>
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Pendidikan Formal • Berdasarkan Jenjang</div>
    <div class="h-56 w-full"><canvas id="statFormalJenjang" style="width:100%;height:100%" data-labels='{!! json_encode($formalJenjangLabels ?? []) !!}' data-data='{!! json_encode($formalJenjangData ?? []) !!}' data-total='{{ $totalFormal ?? 0 }}'></canvas></div>
    @php
      $fjLabels = $formalJenjangLabels ?? [];
      $fjData = $formalJenjangData ?? [];
      $fjTotal = max(1, (int)($totalFormal ?? array_sum($fjData)));
      $dotColors = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500'];
      $txtColors = ['text-blue-600','text-emerald-600','text-amber-600','text-red-600','text-violet-600','text-pink-600'];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-4">
      @foreach($fjLabels as $i => $label)
        @php $val = (int)($fjData[$i] ?? 0); $pct = round(($val/$fjTotal)*100,1); @endphp
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
          <div>
            <div class="flex items-center gap-2 text-sm text-gray-700"><span class="inline-block w-3 h-3 rounded-full {{ $dotColors[$i % count($dotColors)] }}"></span>{{ $label }}</div>
            <div class="text-xl font-semibold">{{ number_format($val,0,',','.') }}</div>
          </div>
          <div class="text-xs {{ $txtColors[$i % count($txtColors)] }}">{{ $pct }}%</div>
        </div>
      @endforeach
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Pendidikan Formal • Berdasarkan Lingkungan</div>
    <div class="h-56 w-full"><canvas id="statFormalLing" style="width:100%;height:100%" data-labels='{!! json_encode($formalLingLabels ?? []) !!}' data-data='{!! json_encode($formalLingData ?? []) !!}' data-total='{{ $totalFormal ?? 0 }}'></canvas></div>
    @php
      $flLabels = $formalLingLabels ?? [];
      $flData = $formalLingData ?? [];
      $flTotal = max(1, (int)($totalFormal ?? array_sum($flData)));
      $colorsLingDot = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500','bg-orange-500','bg-cyan-500','bg-lime-500','bg-teal-500','bg-fuchsia-500','bg-sky-500','bg-rose-500'];
      $colorsLingTxt = ['text-blue-600','text-emerald-600','text-amber-600','text-red-600','text-violet-600','text-pink-600','text-orange-600','text-cyan-600','text-lime-600','text-teal-600','text-fuchsia-600','text-sky-600','text-rose-600'];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-4">
      @foreach($flLabels as $i => $label)
        @php $val = (int)($flData[$i] ?? 0); $pct = round(($val/$flTotal)*100,1); @endphp
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
          <div>
            <div class="flex items-center gap-2 text-sm text-gray-700"><span class="inline-block w-3 h-3 rounded-full {{ $colorsLingDot[$i % count($colorsLingDot)] }}"></span>{{ $label }}</div>
            <div class="text-xl font-semibold">{{ number_format($val,0,',','.') }}</div>
          </div>
          <div class="text-xs {{ $colorsLingTxt[$i % count($colorsLingTxt)] }}">{{ $pct }}%</div>
        </div>
      @endforeach
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Pendidikan Non-Formal • Berdasarkan Bidang</div>
    <div class="h-56 w-full"><canvas id="statNonBidang" style="width:100%;height:100%" data-labels='{!! json_encode($nonFormBidangLabels ?? []) !!}' data-data='{!! json_encode($nonFormBidangData ?? []) !!}' data-total='{{ $totalNonFormal ?? 0 }}'></canvas></div>
    @php
      $nbLabels = $nonFormBidangLabels ?? [];
      $nbData = $nonFormBidangData ?? [];
      $nbTotal = max(1, (int)($totalNonFormal ?? array_sum($nbData)));
      $dotColors2 = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500','bg-orange-500'];
      $txtColors2 = ['text-blue-600','text-emerald-600','text-amber-600','text-red-600','text-violet-600','text-pink-600','text-orange-600'];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-4">
      @foreach($nbLabels as $i => $label)
        @php $val = (int)($nbData[$i] ?? 0); $pct = round(($val/$nbTotal)*100,1); @endphp
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
          <div>
            <div class="flex items-center gap-2 text-sm text-gray-700"><span class="inline-block w-3 h-3 rounded-full {{ $dotColors2[$i % count($dotColors2)] }}"></span>{{ $label }}</div>
            <div class="text-xl font-semibold">{{ number_format($val,0,',','.') }}</div>
          </div>
          <div class="text-xs {{ $txtColors2[$i % count($txtColors2)] }}">{{ $pct }}%</div>
        </div>
      @endforeach
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Pendidikan Non-Formal • Berdasarkan Lingkungan</div>
    <div class="h-56 w-full"><canvas id="statNonLing" style="width:100%;height:100%" data-labels='{!! json_encode($nonFormLingLabels ?? []) !!}' data-data='{!! json_encode($nonFormLingData ?? []) !!}' data-total='{{ $totalNonFormal ?? 0 }}'></canvas></div>
    @php
      $nlLabels = $nonFormLingLabels ?? [];
      $nlData = $nonFormLingData ?? [];
      $nlTotal = max(1, (int)($totalNonFormal ?? array_sum($nlData)));
      $colorsLingDot2 = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500','bg-orange-500','bg-cyan-500','bg-lime-500','bg-teal-500','bg-fuchsia-500','bg-sky-500','bg-rose-500'];
      $colorsLingTxt2 = ['text-blue-600','text-emerald-600','text-amber-600','text-red-600','text-violet-600','text-pink-600','text-orange-600','text-cyan-600','text-lime-600','text-teal-600','text-fuchsia-600','text-sky-600','text-rose-600'];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-4">
      @foreach($nlLabels as $i => $label)
        @php $val = (int)($nlData[$i] ?? 0); $pct = round(($val/$nlTotal)*100,1); @endphp
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
          <div>
            <div class="flex items-center gap-2 text-sm text-gray-700"><span class="inline-block w-3 h-3 rounded-full {{ $colorsLingDot2[$i % count($colorsLingDot2)] }}"></span>{{ $label }}</div>
            <div class="text-xl font-semibold">{{ number_format($val,0,',','.') }}</div>
          </div>
          <div class="text-xs {{ $colorsLingTxt2[$i % count($colorsLingTxt2)] }}">{{ $pct }}%</div>
        </div>
      @endforeach
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
  (function(){
    const doughnut = (id, labels, data, colors) => {
      const el = document.getElementById(id); if(!el) return;
      new Chart(el,{type:'doughnut',data:{labels:labels,datasets:[{data:data,backgroundColor:colors}]},options:{plugins:{legend:{position:'bottom'}},maintainAspectRatio:false,cutout:'65%'}});
    };

    try {
      const el = document.getElementById('statFormalJenjang');
      const labels = JSON.parse(el.dataset.labels||'[]');
      const data = JSON.parse(el.dataset.data||'[]');
      const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899'];
      doughnut('statFormalJenjang', labels, data, colors.slice(0,data.length));
    } catch(e) {}

    try {
      const el = document.getElementById('statFormalLing');
      const labels = JSON.parse(el.dataset.labels||'[]');
      const data = JSON.parse(el.dataset.data||'[]');
      const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316','#22D3EE','#84CC16','#14B8A6','#A21CAF','#0EA5E9','#F43F5E'];
      doughnut('statFormalLing', labels, data, colors.slice(0,data.length));
    } catch(e) {}

    try {
      const el = document.getElementById('statNonBidang');
      const labels = JSON.parse(el.dataset.labels||'[]');
      const data = JSON.parse(el.dataset.data||'[]');
      const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316'];
      doughnut('statNonBidang', labels, data, colors.slice(0,data.length));
    } catch(e) {}

    try {
      const el = document.getElementById('statNonLing');
      const labels = JSON.parse(el.dataset.labels||'[]');
      const data = JSON.parse(el.dataset.data||'[]');
      const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316','#22D3EE','#84CC16','#14B8A6','#A21CAF','#0EA5E9','#F43F5E'];
      doughnut('statNonLing', labels, data, colors.slice(0,data.length));
    } catch(e) {}
  })();
  </script>
</div>
@endsection
