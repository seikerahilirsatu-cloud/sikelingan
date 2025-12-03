@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="mb-3">
        <a href="{{ route('import.form', absolute: false) }}" class="text-sm text-gray-600">Kembali</a>
        <h1 class="text-2xl font-semibold">Import Biodata Warga</h1>
    </div>
    <div class="mb-4">
        <a href="{{ route('import.biodata.template', absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded">Download Template CSV</a>
    </div>
    <form action="{{ route('import.biodata.preview', absolute: false) }}" method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow space-y-3">
        @csrf
        <div>
            <label class="block text-sm">File CSV</label>
            <input type="file" name="csv" accept=".csv" class="w-full" />
        </div>
        <div class="text-xs text-gray-600">Header: no_kk,nik,nama_lgkp,jenis_kelamin,tgl_lhr,agama,pendidikan_terakhir,pekerjaan,stts_kawin,stts_hub_keluarga</div>
        <button class="w-full bg-blue-600 text-white p-2 rounded">Preview</button>
    </form>
</div>
@endsection
