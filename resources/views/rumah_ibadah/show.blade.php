@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    @if(isset($is_mobile) && $is_mobile)
    <a href="{{ auth()->check() ? route('rumah_ibadah.index', absolute: false) : (url()->previous() ?? url('/')) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    @endif
    <h1 class="text-2xl font-semibold page-title">Detail data @db($place->nama)</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    @if($place->photo_path)
      <img src="{{ asset('storage/'.$place->photo_path) }}" alt="Foto" class="mb-3 w-full rounded-md" style="max-height: 240px; object-fit: cover;" data-placeholder="{{ asset('images/placeholder-ibadah.svg') }}" onerror="this.onerror=null;this.src=this.dataset.placeholder" />
    @else
      <img src="{{ asset('images/placeholder-ibadah.svg') }}" alt="Foto" class="mb-3 w-full rounded-md" style="max-height: 240px; object-fit: cover;" />
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div><div class="text-sm text-gray-600">Jenis</div><div class="text-base font-semibold">@db($place->jenis)</div></div>
      <div><div class="text-sm text-gray-600">Nama</div><div class="text-base font-semibold">@db($place->nama)</div></div>
      <div class="sm:col-span-2"><div class="text-sm text-gray-600">Alamat</div><div class="text-base font-semibold">@db($place->alamat)</div></div>
      <div><div class="text-sm text-gray-600">Lingkungan</div><div class="text-base font-semibold">@db($place->lingkungan ?? '-')</div></div>
      <div><div class="text-sm text-gray-600">Status Operasional</div><div class="text-base font-semibold">@db($place->status_operasional)</div></div>
      <div><div class="text-sm text-gray-600">Kapasitas</div><div class="text-base font-semibold">@db($place->kapasitas ?? '-')</div></div>
      <div><div class="text-sm text-gray-600">Tanggal Berdiri</div><div class="text-base font-semibold">@db($place->tanggal_berdiri)</div></div>
      <div><div class="text-sm text-gray-600">Kontak</div><div class="text-base font-semibold">@db($place->kontak)</div></div>
      <div class="sm:col-span-2"><div class="text-sm text-gray-600">Pengurus</div><div class="text-base font-semibold">@db($place->pengurus?->nama_lgkp ?? ($place->pengurus_nik ?? '-'))</div></div>
      <div>
        <div class="text-sm text-gray-600">Koordinat</div>
        <div class="text-base font-semibold">@db($place->koordinat_lat) , @db($place->koordinat_lng)</div>
        @if($place->koordinat_lat && $place->koordinat_lng)
          <div class="mt-1"><a href="https://www.google.com/maps?q={{ $place->koordinat_lat }},{{ $place->koordinat_lng }}" target="_blank" rel="noopener" class="text-sm text-blue-600">Lihat di Maps</a></div>
        @endif
      </div>
    </div>
    <div class="mt-4 flex gap-2">
      @if(isset($is_mobile) && $is_mobile)
      <a href="{{ auth()->check() ? route('rumah_ibadah.index') : (url()->previous() ?? url('/')) }}" class="px-3 py-2 border rounded">Kembali</a>
      @endif
      @if(auth()->check())
      <a href="{{ route('rumah_ibadah.edit', $place) }}" data-modal="true" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
      @endif
    </div>
  </div>
</div>
@endsection
