@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <h1 class="text-2xl font-semibold">Import Data</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
        <a href="{{ route('import.rumah_ibadah.form', absolute: false) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition">
            <div class="text-sm text-gray-600">Import</div>
            <div class="mt-1 text-lg font-semibold text-gray-800">Rumah Ibadah</div>
            <div class="mt-2 text-xs text-gray-500">Unggah file sesuai template Rumah Ibadah</div>
        </a>
        <a href="{{ route('import.umkm.form', absolute: false) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition">
            <div class="text-sm text-gray-600">Import</div>
            <div class="mt-1 text-lg font-semibold text-gray-800">UMKM</div>
            <div class="mt-2 text-xs text-gray-500">Unggah file sesuai template UMKM</div>
        </a>
        <a href="{{ route('import.data_keluarga.form', absolute: false) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition">
            <div class="text-sm text-gray-600">Import</div>
            <div class="mt-1 text-lg font-semibold text-gray-800">Data Keluarga</div>
            <div class="mt-2 text-xs text-gray-500">Unggah file sesuai template Data Keluarga</div>
        </a>
        <a href="{{ route('import.biodata.form', absolute: false) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition">
            <div class="text-sm text-gray-600">Import</div>
            <div class="mt-1 text-lg font-semibold text-gray-800">Biodata Warga</div>
            <div class="mt-2 text-xs text-gray-500">Unggah file sesuai template Biodata Warga</div>
        </a>
    </div>

    

    
</div>
@endsection
