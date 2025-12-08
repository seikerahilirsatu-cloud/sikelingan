@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-3">
    <div class="bg-white p-3 rounded">
        @if($item->photo_path)
            <img src="{{ asset('storage/'.$item->photo_path) }}" alt="Foto" class="w-full max-h-64 object-cover rounded mb-2" data-placeholder="{{ asset('images/placeholder-umkm.svg') }}" onerror="this.onerror=null;this.src=this.dataset.placeholder" />
        @else
            <img src="{{ asset('images/placeholder-umkm.svg') }}" alt="Foto" class="w-full max-h-64 object-cover rounded mb-2" />
        @endif
        <div class="text-sm text-gray-500">Jenis: @db($item->jenis)</div>
        <div class="font-medium">@db($item->nama_usaha)</div>
        <div class="text-xs text-gray-600">@db($item->alamat)</div>
        <div class="text-xs text-gray-600">Lingkungan: @db($item->lingkungan ?? '-')</div>
        <div class="text-xs text-gray-600">Status: @db($item->status_operasional)</div>
        <div class="text-xs text-gray-600">Kontak: @db($item->kontak)</div>
        <div class="text-xs text-gray-600">Tgl Berdiri: @db($item->tanggal_berdiri)</div>
        <div class="text-xs text-gray-600">Omzet: @db($item->omzet)</div>
        <div class="text-xs text-gray-600">Pemilik NIK: @db($item->pemilik_nik ?? '-') </div>
        <div class="text-xs text-gray-600">NPWP Pemilik: @db($item->npwp_pemilik ?? '-') </div>
        <div class="text-xs text-gray-600">No NIB: @db($item->no_nib ?? '-') </div>
        @if($item->koordinat_lat || $item->koordinat_lng)
        <div class="text-xs text-gray-600">Koordinat: @db($item->koordinat_lat) , @db($item->koordinat_lng)</div>
        @endif
        @if($item->koordinat_lat && $item->koordinat_lng)
            <div class="text-xs text-blue-600"><a href="https://www.google.com/maps?q={{ $item->koordinat_lat }},{{ $item->koordinat_lng }}" target="_blank" rel="noopener">Lihat di Maps</a></div>
        @endif
    </div>
    <div>
        <a href="{{ route('umkm.edit', $item, absolute: false) }}" class="inline-block px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
</div>
@endsection
