@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-3">
    <div class="bg-white p-3 rounded">
        @if($place->photo_path)
            <img src="{{ asset('storage/'.$place->photo_path) }}" alt="Foto" class="w-full max-h-64 object-cover rounded mb-2" data-placeholder="{{ asset('images/placeholder-ibadah.svg') }}" onerror="this.onerror=null;this.src=this.dataset.placeholder" />
        @else
            <img src="{{ asset('images/placeholder-ibadah.svg') }}" alt="Foto" class="w-full max-h-64 object-cover rounded mb-2" />
        @endif
        <div class="text-sm text-gray-500">Jenis: @db($place->jenis)</div>
        <div class="font-medium">@db($place->nama)</div>
        <div class="text-xs text-gray-600">@db($place->alamat)</div>
        <div class="text-xs text-gray-600">Lingkungan: @db($place->lingkungan ?? '-')</div>
        <div class="text-xs text-gray-600">Status: @db($place->status_operasional)</div>
        <div class="text-xs text-gray-600">Kapasitas: @db($place->kapasitas ?? '-')</div>
        <div class="text-xs text-gray-600">Pengurus: @db($place->pengurus?->nama_lgkp ?? ($place->pengurus_nik ?? '-'))</div>
        @if($place->koordinat_lat && $place->koordinat_lng)
            <div class="text-xs text-blue-600"><a href="https://www.google.com/maps?q={{ $place->koordinat_lat }},{{ $place->koordinat_lng }}" target="_blank" rel="noopener">Lihat di Maps</a></div>
        @endif
    </div>
    <div>
        <a href="{{ route('rumah_ibadah.edit', $place, absolute: false) }}" class="inline-block px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
</div>
@endsection
