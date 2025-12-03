@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-4">
  <header class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
      <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div class="text-lg font-semibold">Laporan Mutasi Warga per Lingkungan</div>
      <div class="text-xs text-gray-600">Lahir, Meninggal, Pindah Masuk, Pindah Keluar</div>
    </div>
  </header>

  <form method="get" action="{{ route('stats.mutasi', absolute: false) }}" class="bg-white rounded-2xl shadow p-4 grid grid-cols-1 sm:grid-cols-4 gap-3">
    <div>
      <label class="text-xs text-gray-600">Tanggal Mulai</label>
      <input type="date" name="start" value="{{ $start }}" class="w-full p-2 border rounded-lg" />
    </div>
    <div>
      <label class="text-xs text-gray-600">Tanggal Selesai</label>
      <input type="date" name="end" value="{{ $end }}" class="w-full p-2 border rounded-lg" />
    </div>
    <div class="flex items-end">
      <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Terapkan</button>
      <a href="{{ route('stats.mutasi.export_excel', ['start' => $start, 'end' => $end]) }}" class="px-4 py-2 ml-2 bg-green-600 text-white rounded-lg">Export Excel</a>
    </div>
  </form>

  @php
    $labels = $lingkunganLabels ?? [];
    $data = $rows ?? [];
    $total = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0];
    foreach ($data as $k => $v) { foreach ($total as $kk => $vv) { $total[$kk] += (int)($v[$kk] ?? 0); } }
  @endphp

  <section class="bg-white rounded-2xl shadow p-4 overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-gray-700">
          <th class="p-2">Lingkungan</th>
          <th class="p-2">Lahir L</th>
          <th class="p-2">Lahir P</th>
          <th class="p-2">Meninggal L</th>
          <th class="p-2">Meninggal P</th>
          <th class="p-2">Masuk L</th>
          <th class="p-2">Masuk P</th>
          <th class="p-2">Keluar L</th>
          <th class="p-2">Keluar P</th>
        </tr>
      </thead>
      <tbody>
        @foreach($labels as $ling)
        @php $r = $data[$ling] ?? ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; @endphp
        <tr class="border-t">
          <td class="p-2 font-medium">{{ $ling }}</td>
          <td class="p-2">{{ $r['lahir_L'] }}</td>
          <td class="p-2">{{ $r['lahir_P'] }}</td>
          <td class="p-2">{{ $r['meninggal_L'] }}</td>
          <td class="p-2">{{ $r['meninggal_P'] }}</td>
          <td class="p-2">{{ $r['masuk_L'] }}</td>
          <td class="p-2">{{ $r['masuk_P'] }}</td>
          <td class="p-2">{{ $r['keluar_L'] }}</td>
          <td class="p-2">{{ $r['keluar_P'] }}</td>
        </tr>
        @endforeach
        <tr class="border-t bg-gray-50">
          <td class="p-2 font-semibold">Total</td>
          <td class="p-2 font-semibold">{{ $total['lahir_L'] }}</td>
          <td class="p-2 font-semibold">{{ $total['lahir_P'] }}</td>
          <td class="p-2 font-semibold">{{ $total['meninggal_L'] }}</td>
          <td class="p-2 font-semibold">{{ $total['meninggal_P'] }}</td>
          <td class="p-2 font-semibold">{{ $total['masuk_L'] }}</td>
          <td class="p-2 font-semibold">{{ $total['masuk_P'] }}</td>
          <td class="p-2 font-semibold">{{ $total['keluar_L'] }}</td>
          <td class="p-2 font-semibold">{{ $total['keluar_P'] }}</td>
        </tr>
      </tbody>
    </table>
  </section>
</div>
@endsection
