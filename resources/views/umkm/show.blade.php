@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    @if(isset($is_mobile) && $is_mobile)
    <a href="{{ route('umkm.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    @endif
    <h1 class="text-2xl font-semibold">Detail data @db($item->nama_usaha)</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    @if($item->photo_path)
      <img src="{{ asset('storage/'.$item->photo_path) }}" alt="Foto" class="mb-3 w-full rounded-md" style="max-height: 240px; object-fit: cover;" data-placeholder="{{ asset('images/placeholder-umkm.svg') }}" onerror="this.onerror=null;this.src=this.dataset.placeholder" />
    @else
      <img src="{{ asset('images/placeholder-umkm.svg') }}" alt="Foto" class="mb-3 w-full rounded-md" style="max-height: 240px; object-fit: cover;" />
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div><div class="text-sm text-gray-600">Jenis</div><div class="text-base font-semibold">@db($item->jenis)</div></div>
      <div><div class="text-sm text-gray-600">Nama Usaha</div><div class="text-base font-semibold">@db($item->nama_usaha)</div></div>
      <div class="sm:col-span-2"><div class="text-sm text-gray-600">Alamat</div><div class="text-base font-semibold">@db($item->alamat)</div></div>
      <div><div class="text-sm text-gray-600">Lingkungan</div><div class="text-base font-semibold">@db($item->lingkungan ?? '-')</div></div>
      <div><div class="text-sm text-gray-600">Status Operasional</div><div class="text-base font-semibold">@db($item->status_operasional)</div></div>
      <div><div class="text-sm text-gray-600">Kontak</div><div class="text-base font-semibold">@db($item->kontak)</div></div>
      <div><div class="text-sm text-gray-600">Tanggal Berdiri</div><div class="text-base font-semibold">@db($item->tanggal_berdiri)</div></div>
      <div><div class="text-sm text-gray-600">Omzet</div><div class="text-base font-semibold">@db($item->omzet)</div></div>
      <div><div class="text-sm text-gray-600">Pemilik NIK</div><div class="text-base font-semibold">@db($item->pemilik_nik ?? '-')</div></div>
      <div><div class="text-sm text-gray-600">NPWP Pemilik</div><div class="text-base font-semibold">@db($item->npwp_pemilik ?? '-')</div></div>
      <div><div class="text-sm text-gray-600">No NIB</div><div class="text-base font-semibold">@db($item->no_nib ?? '-')</div></div>
      <div>
        <div class="text-sm text-gray-600">Koordinat</div>
        <div class="text-base font-semibold">@db($item->koordinat_lat) , @db($item->koordinat_lng)</div>
        @if($item->koordinat_lat && $item->koordinat_lng)
          <div class="mt-1"><a href="https://www.google.com/maps?q={{ $item->koordinat_lat }},{{ $item->koordinat_lng }}" target="_blank" rel="noopener" class="text-sm text-blue-600">Lihat di Maps</a></div>
        @endif
      </div>
    </div>
    <div class="mt-4 flex gap-2">
      @if(isset($is_mobile) && $is_mobile)
      <a href="{{ route('umkm.index') }}" class="px-3 py-2 border rounded">Kembali</a>
      @endif
      <a href="{{ route('umkm.edit', $item) }}" data-modal="true" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
  </div>
</div>
@endsection
