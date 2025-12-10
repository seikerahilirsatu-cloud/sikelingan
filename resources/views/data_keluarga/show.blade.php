@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    <h1 class="text-2xl font-semibold">Detail Data Kartu Keluarga (@db($family->no_kk) - @db($family->nama_kep))</h1>
  </div>
  <div class="rounded-2xl p-4 bg-gradient-to-b from-blue-100 to-cyan-100">
    <div class="space-y-4">

      <div class="bg-white rounded-xl shadow p-4">
        <div class="text-xs text-gray-600">KK: @db($family->no_kk)</div>
        <div class="text-xl font-semibold uppercase">@db($family->nama_kep)</div>
        <div class="text-sm text-gray-700">@db($family->alamat)</div>
        <div class="text-sm text-gray-600">Lingkungan: @db($family->lingkungan)</div>
        <div class="text-sm text-gray-600">Status: @if($family->status_keluarga==1) Warga Domisili @elseif($family->status_keluarga==2) Warga Luar Domisili @else Warga Domisili Baru @endif</div>
      </div>

      <div class="flex items-center justify-between">
        <div class="text-base font-semibold">Anggota Keluarga</div>
        <a href="{{ route('biodata_warga.create') }}?no_kk={{ $family->no_kk }}" data-modal="true" class="text-sm text-indigo-600">Tambah anggota</a>
      </div>
      <div class="space-y-3">
        @foreach($family->members as $m)
          <div class="bg-white rounded-xl shadow p-4">
            <div class="text-xs text-gray-600">NIK: @db($m->nik)</div>
            <div class="text-lg font-semibold uppercase">@db($m->nama_lgkp)</div>
            <div class="text-xs text-gray-600 uppercase">@db($m->stts_hub_keluarga)</div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
