@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-3">
    <div class="bg-white p-4 rounded">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Detail Warga</h2>
        <div class="grid grid-cols-1 gap-2 text-sm text-gray-700">
            <div><span class="text-gray-500">ID:</span> <span class="font-medium">@db($resident->id)</span></div>
            <div><span class="text-gray-500">Family ID:</span> <span class="font-medium">@db($resident->family_id)</span></div>
            <div><span class="text-gray-500">No. KK:</span> <span class="font-medium">@db($resident->no_kk)</span></div>
            <div><span class="text-gray-500">Lingkungan:</span> <span class="font-medium">@db($resident->lingkungan ?? ($resident->family?->lingkungan ?? ''))</span></div>
            <div><span class="text-gray-500">Alamat:</span> <span class="font-medium">@db($resident->alamat)</span></div>
            <div><span class="text-gray-500">NIK:</span> <span class="font-medium">@db($resident->nik)</span></div>
            <div><span class="text-gray-500">Nama Lengkap:</span> <span class="font-medium">@db($resident->nama_lgkp)</span></div>
            <div><span class="text-gray-500">Jenis Kelamin:</span> <span class="font-medium">@db($resident->jenis_kelamin)</span></div>
            <div><span class="text-gray-500">Tempat Lahir:</span> <span class="font-medium">@db($resident->tmpt_lahir)</span></div>
            <div><span class="text-gray-500">Tanggal Lahir:</span> <span class="font-medium">@db($resident->tgl_lhr)</span></div>
            <div><span class="text-gray-500">Agama:</span> <span class="font-medium">@db($resident->agama)</span></div>
            <div><span class="text-gray-500">Pendidikan Terakhir:</span> <span class="font-medium">@db($resident->pendidikan_terakhir)</span></div>
            <div><span class="text-gray-500">Pekerjaan:</span> <span class="font-medium">@db($resident->pekerjaan)</span></div>
            <div><span class="text-gray-500">Status Kawin:</span> <span class="font-medium">@db($resident->stts_kawin)</span></div>
            <div><span class="text-gray-500">Hubungan Keluarga:</span> <span class="font-medium">@db($resident->stts_hub_keluarga)</span></div>
            <div><span class="text-gray-500">Status Warga:</span> <span class="font-medium">@db($resident->status_warga)</span></div>
            <div><span class="text-gray-500">Flag Status:</span> <span class="font-medium">@db($resident->flag_status)</span></div>
            <div><span class="text-gray-500">Created By:</span> <span class="font-medium">@db($resident->created_by)</span></div>
            <div><span class="text-gray-500">Updated By:</span> <span class="font-medium">@db($resident->updated_by)</span></div>
            <div><span class="text-gray-500">Dibuat:</span> <span class="font-medium">{{ $resident->created_at }}</span></div>
            <div><span class="text-gray-500">Diperbarui:</span> <span class="font-medium">{{ $resident->updated_at }}</span></div>
        </div>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('biodata_warga.index') }}" class="flex-1 text-center px-3 py-2 border rounded">Kembali</a>
        <a href="{{ route('biodata_warga.edit', $resident) }}" class="flex-1 text-center px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
</div>
@endsection
