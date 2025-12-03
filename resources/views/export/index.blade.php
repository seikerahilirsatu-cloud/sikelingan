@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    <h1 class="text-2xl font-semibold">Export Data</h1>
    <div class="text-sm text-gray-600">Unduh data dalam format Excel</div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
    <div class="bg-white rounded-lg shadow p-4">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">Biodata Warga</div>
      <a href="{{ route('export.biodata_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">Data Keluarga</div>
      <a href="{{ route('export.keluarga_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">Rumah Ibadah</div>
      <a href="{{ route('export.rumah_ibadah_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">UMKM</div>
      <a href="{{ route('export.umkm_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">Pendidikan Formal</div>
      <a href="{{ route('export.pendidikan_formal_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">Pendidikan Non-Formal</div>
      <a href="{{ route('export.pendidikan_non_formal_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
    <div class="bg-white rounded-lg shadow p-4 sm:col-span-2">
      <div class="text-sm text-gray-600">Export Excel</div>
      <div class="mt-1 text-lg font-semibold text-gray-800">Laporan Mutasi Penduduk</div>
      <a href="{{ route('stats.mutasi.export_excel', absolute: false) }}" class="mt-3 inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded">Download</a>
    </div>
  </div>
</div>
@endsection

