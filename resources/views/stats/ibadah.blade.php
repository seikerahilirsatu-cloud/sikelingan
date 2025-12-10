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

  @php $list = \App\Models\RumahIbadah::orderBy('nama')->limit(20)->get(); @endphp
  <section class="bg-white rounded-2xl shadow p-4">
    <div class="text-sm font-medium mb-2">Data Rumah Ibadah</div>
    @if($list->count() === 0)
      <div class="text-sm text-gray-600">Data rumah ibadah belum ada</div>
    @else
      @if(isset($is_mobile) && $is_mobile)
        <div class="grid grid-cols-1 gap-3">
          @foreach($list as $p)
          <article class="bg-white p-4 rounded-lg shadow-sm">
            <div class="flex items-start justify-between">
              <div>
                @if(!empty($p->photo_path))
                  <img src="{{ asset('storage/'.$p->photo_path) }}" alt="{{ $p->nama }}" class="mb-3 w-full rounded-md" style="max-height: 90px; max-width: 50%; object-fit: cover;" data-placeholder="{{ asset('images/placeholder-ibadah.svg') }}" onerror="this.onerror=null;this.src=this.dataset.placeholder" />
                @else
                  <img src="{{ asset('images/placeholder-ibadah.svg') }}" alt="{{ $p->nama }}" class="mb-3 w-full rounded-md" style="max-height: 90px; max-width: 50%; object-fit: cover;" />
                @endif
                <div class="text-sm text-gray-500">Jenis: <span class="font-medium">@db($p->jenis)</span></div>
                <a href="{{ route('rumah_ibadah.show', $p, absolute: false) }}" class="block mt-1 text-lg font-semibold text-gray-800">@db($p->nama)</a>
                <div class="text-xs text-gray-600 mt-1">@db($p->alamat)</div>
                <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">@db($p->lingkungan ?? '-') </span></div>
                <div class="text-xs text-gray-600 mt-1">Status: @db($p->status_operasional)</div>
              </div>
            </div>
          </article>
          @endforeach
        </div>
      @else
        <div class="table-responsive">
    <table class="table table-modern table-hover">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Alamat</th>
                <th>Lingkungan</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($list as $p)
              <tr>
                <td><a href="{{ route('rumah_ibadah.show', $p, absolute: false) }}">@db($p->nama)</a></td>
                <td>@db($p->jenis)</td>
                <td>@db($p->alamat)</td>
                <td>@db($p->lingkungan ?? '-') </td>
                <td>@db($p->status_operasional)</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    @endif
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
