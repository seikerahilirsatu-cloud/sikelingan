@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-4">
  <header class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
      <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div class="text-lg font-semibold">Statistik Kependudukan</div>
      <div class="text-xs text-gray-600">Data lengkap penduduk kelurahan</div>
    </div>
  </header>

  <div class="grid grid-cols-1 gap-3">
    <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
      <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
        <svg class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-6 8v-1a6 6 0 0112 0v1H6z"/></svg>
      </div>
      <div>
        <div class="text-sm text-gray-600">Total Penduduk</div>
        <div class="text-2xl font-semibold mt-1">{{ number_format($totalWarga,0,',','.') }}</div>
      </div>
    </div>
    <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
      <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
        <svg class="w-7 h-7 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 20v-1a8 8 0 0116 0v1H4z"/></svg>
      </div>
      <div>
        <div class="text-sm text-gray-600">Kepala Keluarga</div>
        <div class="text-2xl font-semibold mt-1">{{ number_format($totalKeluarga,0,',','.') }}</div>
      </div>
    </div>
  </div>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Lingkungan</div>
    <div class="h-56 w-full"><canvas id="statLingkungan" style="width:100%;height:100%" data-labels='{!! json_encode($lingkunganLabels ?? []) !!}' data-data='{!! json_encode($lingkunganDataChart ?? []) !!}' data-total='{{ $totalWarga }}'></canvas></div>
    @php
      $lLabels = $lingkunganLabels ?? [];
      $lData = $lingkunganDataChart ?? [];
      $lTotal = max(1, (int)($totalWarga ?? array_sum($lData)));
      $colorsLingDot = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500','bg-orange-500','bg-cyan-500','bg-lime-500','bg-teal-500','bg-fuchsia-500','bg-sky-500','bg-rose-500'];
      $colorsLingTxt = ['text-blue-600','text-emerald-600','text-amber-600','text-red-600','text-violet-600','text-pink-600','text-orange-600','text-cyan-600','text-lime-600','text-teal-600','text-fuchsia-600','text-sky-600','text-rose-600'];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-4">
      @foreach($lLabels as $i => $label)
        @php $val = (int)($lData[$i] ?? 0); $pct = round(($val/$lTotal)*100,1); @endphp
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
    <div class="text-sm font-medium mb-2">Berdasarkan Jenis Kelamin</div>
    <div class="h-56 w-full"><canvas id="statGender" style="width:100%;height:100%" data-labels='{!! json_encode($genderLabels) !!}' data-data='{!! json_encode($genderDataChart) !!}' data-total='{{ $totalWarga }}'></canvas></div>
    @php
      $gLabels = $genderLabels ?? [];
      $gData = $genderDataChart ?? [];
      $gTotal = max(1, (int)($totalWarga ?? array_sum($gData)));
      $g1 = isset($gData[0]) ? (int)$gData[0] : 0; $g2 = isset($gData[1]) ? (int)$gData[1] : 0;
      $p1 = round(($g1/$gTotal)*100,1); $p2 = round(($g2/$gTotal)*100,1);
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
      <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
        <div>
          <div class="flex items-center gap-2 text-sm text-gray-700"><span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>{{ $gLabels[0] ?? 'Laki-laki' }}</div>
          <div class="text-xl font-semibold">{{ number_format($g1,0,',','.') }}</div>
        </div>
        <div class="text-xs text-blue-600">{{ $p1 }}%</div>
      </div>
      <div class="flex items-center justify-between bg-gray-50 rounded-xl p-4">
        <div>
          <div class="flex items-center gap-2 text-sm text-gray-700"><span class="inline-block w-3 h-3 rounded-full bg-pink-500"></span>{{ $gLabels[1] ?? 'Perempuan' }}</div>
          <div class="text-xl font-semibold">{{ number_format($g2,0,',','.') }}</div>
        </div>
        <div class="text-xs text-pink-600">{{ $p2 }}%</div>
      </div>
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Kelompok Umur</div>
    <div class="h-56 w-full"><canvas id="statUmur" style="width:100%;height:100%" data-labels='{!! json_encode($ageLabels) !!}' data-data='{!! json_encode($ageData) !!}'></canvas></div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Agama</div>
    <div class="h-56 w-full"><canvas id="statAgama" style="width:100%;height:100%" data-labels='{!! json_encode($agamaLabels) !!}' data-data='{!! json_encode($agamaData) !!}'></canvas></div>
    @php
      $agLabels = $agamaLabels ?? [];
      $agData = $agamaData ?? [];
    @endphp
    <div class="mt-4 space-y-2">
      @foreach($agLabels as $i => $label)
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
          <div class="text-sm text-gray-700">{{ $label }}</div>
          <div class="text-sm font-semibold">{{ number_format($agData[$i] ?? 0,0,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Pendidikan Terakhir</div>
    <div class="h-56 w-full"><canvas id="statEdu" style="width:100%;height:100%" data-labels='{!! json_encode($eduLabels) !!}' data-data='{!! json_encode($eduData) !!}'></canvas></div>
    @php
      $eduLabelsArr = $eduLabels ?? [];
      $eduDataArr = $eduData ?? [];
      $colorsEdu = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500','bg-orange-500','bg-cyan-500'];
    @endphp
    <div class="mt-4 space-y-2">
      @foreach($eduLabelsArr as $i => $label)
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
          <div class="flex items-center gap-2 text-sm text-gray-700">
            <span class="inline-block w-3 h-3 rounded-full {{ $colorsEdu[$i % count($colorsEdu)] }}"></span>
            {{ $label }}
          </div>
          <div class="text-sm font-semibold">{{ number_format($eduDataArr[$i] ?? 0,0,',','.') }}</div>
        </div>
      @endforeach
    </div>
  </section>

  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Berdasarkan Pekerjaan</div>
    <div class="h-56 w-full"><canvas id="statJob" style="width:100%;height:100%" data-labels='{!! json_encode($jobLabels) !!}' data-data='{!! json_encode($jobData) !!}'></canvas></div>
    @php
      $jbLabels = $jobLabels ?? [];
      $jbData = $jobData ?? [];
    @endphp
    <div class="mt-4 space-y-2">
      @foreach($jbLabels as $i => $label)
        <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
          <div class="text-sm text-gray-700">{{ $label }}</div>
          <div class="text-sm font-semibold">{{ number_format($jbData[$i] ?? 0,0,',','.') }}</div>
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
    const bar = (id, labels, data, color) => {
      const el = document.getElementById(id); if(!el) return;
      new Chart(el,{type:'bar',data:{labels:labels,datasets:[{label:'Total',data:data,backgroundColor:color}]} ,options:{plugins:{legend:{display:false}},maintainAspectRatio:false}});
    };
    const hbar = (id, labels, data, color) => {
      const el = document.getElementById(id); if(!el) return;
      new Chart(el,{type:'bar',data:{labels:labels,datasets:[{label:'Total',data:data,backgroundColor:color}]} ,options:{indexAxis:'y',plugins:{legend:{display:false}},maintainAspectRatio:false}});
    };

    try {
      const lEl = document.getElementById('statLingkungan');
      const lLabels = JSON.parse(lEl.dataset.labels||'[]');
      const lData = JSON.parse(lEl.dataset.data||'[]');
      const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316','#22D3EE','#84CC16','#14B8A6','#A21CAF','#0EA5E9','#F43F5E'];
      doughnut('statLingkungan', lLabels, lData, colors.slice(0,lData.length));
    } catch(e) {}

    try {
      const gEl = document.getElementById('statGender');
      const gLabels = JSON.parse(gEl.dataset.labels||'[]');
      const gData = JSON.parse(gEl.dataset.data||'[]');
      const total = parseFloat(gEl.dataset.total||'0');
      const sum = (Array.isArray(gData)?gData:[]).reduce((a,b)=> a+(typeof b==='number'?b:parseFloat(b)||0),0);
      const lbl = sum?gLabels:['Total'];
      const dat = sum?gData:[total];
      doughnut('statGender', lbl, dat, ['#3B82F6','#EC4899']);
    } catch(e) {}

    try {
      const aEl = document.getElementById('statUmur');
      const aLabels = JSON.parse(aEl.dataset.labels||'[]');
      const aData = JSON.parse(aEl.dataset.data||'[]');
      bar('statUmur', aLabels, aData, '#3B82F6');
    } catch(e) {}

    try {
      const rEl = document.getElementById('statAgama');
      const rLabels = JSON.parse(rEl.dataset.labels||'[]');
      const rData = JSON.parse(rEl.dataset.data||'[]');
      hbar('statAgama', rLabels, rData, '#10B981');
    } catch(e) {}

    try {
      const eEl = document.getElementById('statEdu');
      const eLabels = JSON.parse(eEl.dataset.labels||'[]');
      const eData = JSON.parse(eEl.dataset.data||'[]');
      const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316','#22D3EE'];
      doughnut('statEdu', eLabels, eData, colors.slice(0,eData.length));
    } catch(e) {}

    try {
      const jEl = document.getElementById('statJob');
      const jLabels = JSON.parse(jEl.dataset.labels||'[]');
      const jData = JSON.parse(jEl.dataset.data||'[]');
      hbar('statJob', jLabels, jData, '#6366F1');
    } catch(e) {}
  })();
  </script>
</div>
@endsection
