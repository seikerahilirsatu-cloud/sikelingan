@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-3">
        <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="text-sm text-gray-600">Kembali</a>
        <h1 class="text-2xl font-semibold">Import Rumah Ibadah (CSV)</h1>
    </div>
    <form class="bg-white p-4 rounded shadow space-y-3" action="{{ route('import.rumah_ibadah.preview', absolute: false) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="block text-sm">File CSV</label>
            <input type="file" name="file" class="w-full" accept=".csv" />
        </div>
        <div class="text-xs text-gray-600">Header: nama,jenis,alamat,lingkungan,status_operasional,kapasitas,tanggal_berdiri,pengurus_nik,kontak,koordinat_lat,koordinat_lng,photo_path</div>
        <div>
            <a href="{{ route('import.rumah_ibadah.template', absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded">Download Template CSV</a>
        </div>
        <button class="w-full bg-blue-600 text-white p-2 rounded">Preview</button>
    </form>
</div>
@endsection