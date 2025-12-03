@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-3">
    <div class="bg-white p-3 rounded">
        <div class="text-sm text-gray-500">NIK: @db($resident->nik)</div>
        <div class="font-medium">@db($resident->nama_lgkp)</div>
        <div class="text-xs text-gray-600">KK: @db($resident->no_kk) — @db($resident->pekerjaan)</div>
        <div class="text-xs text-gray-600">Status: @db($resident->flag_status)</div>
    </div>
    <div>
        <a href="{{ route('biodata_warga.edit', $resident) }}" class="inline-block px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
</div>
@endsection
