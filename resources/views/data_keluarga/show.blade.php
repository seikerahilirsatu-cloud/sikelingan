@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-3">
    <div class="bg-white p-3 rounded">
        <div class="text-sm text-gray-500">KK: @db($family->no_kk)</div>
        <div class="font-medium">@db($family->nama_kep)</div>
        <div class="text-xs text-gray-600">@db($family->alamat)</div>
        <div class="text-xs text-gray-600">Lingkungan: @db($family->lingkungan)</div>
        <div class="text-xs text-gray-600">Status: @if($family->status_keluarga==1) Warga Domisili @elseif($family->status_keluarga==2) Warga Luar Domisili @else Warga Domisili Baru @endif</div>
    </div>

    <div>
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-medium">Anggota Keluarga</h3>
            <a href="{{ route('biodata_warga.create') }}?no_kk={{ $family->no_kk }}" class="text-sm text-blue-600">Tambah anggota</a>
        </div>
        <ul class="space-y-2">
            @foreach($family->members as $m)
                <li class="bg-white p-3 rounded">
                    <div class="text-sm text-gray-500">NIK: @db($m->nik)</div>
                    <div class="font-medium">@db($m->nama_lgkp)</div>
                    <div class="text-xs text-gray-600">@db($m->stts_hub_keluarga)</div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
