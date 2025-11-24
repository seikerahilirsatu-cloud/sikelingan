@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div>
    <form action="{{ route('import.preview') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <label class="block text-sm">Unggah CSV</label>
            <input type="file" name="csv" accept=".csv" class="w-full p-2 border rounded" />
            <div class="text-xs text-gray-500 mt-1">Format header: no_kk,nik,nama_lgkp,jenis_kelamin,tgl_lhr,agama,pendidikan_terakhir,pekerjaan,stts_kawin,stts_hub_keluarga</div>
        </div>
        <div class="pt-3">
            <button class="w-full bg-blue-600 text-white p-2 rounded">Preview</button>
        </div>
    </form>
</div>
@endsection
