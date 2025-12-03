@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('pendidikan_non_formal.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    <h1 class="text-2xl font-semibold">Detail Pendidikan Non-Formal</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    @if(!empty($item->photo_path))
      <img src="{{ asset('storage/'.$item->photo_path) }}" alt="{{ $item->nama_lembaga }}" class="mb-3 w-full rounded-md" style="max-height: 240px; object-fit: cover;" />
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <div class="text-sm text-gray-600">Nama Lembaga</div>
        <div class="text-base font-semibold">@db($item->nama_lembaga)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Bidang Pelatihan</div>
        <div class="text-base font-semibold">@db($item->bidang_pelatihan)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Tahun Berdiri</div>
        <div class="text-base font-semibold">@db($item->tahun_berdiri)</div>
      </div>
      <div class="sm:col-span-2">
        <div class="text-sm text-gray-600">Alamat</div>
        <div class="text-base font-semibold">@db($item->alamat)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">No. Kontak</div>
        <div class="text-base font-semibold">@db($item->no_kontak)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Lingkungan</div>
        <div class="text-base font-semibold">@db($item->lingkungan)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Nama Pemilik</div>
        <div class="text-base font-semibold">@db($item->nama_pemilik)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Status Lembaga</div>
        <div class="text-base font-semibold">@db($item->stts_lembaga)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Jumlah Siswa</div>
        <div class="text-base font-semibold">@db($item->jumlah_siswa)</div>
      </div>
    </div>
    <div class="mt-4">
      <a href="{{ route('pendidikan_non_formal.edit', $item) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
    </div>
  </div>
</div>
@endsection

