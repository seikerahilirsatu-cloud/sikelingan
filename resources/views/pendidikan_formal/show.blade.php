@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('pendidikan_formal.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    <h1 class="text-2xl font-semibold">Detail Pendidikan Formal</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    @if(!empty($item->photo_path))
      <img src="{{ asset('storage/'.$item->photo_path) }}" alt="{{ $item->nama_sekolah }}" class="mb-3 w-full rounded-md" style="max-height: 240px; object-fit: cover;" />
    @endif
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <div class="text-sm text-gray-600">Nama Sekolah</div>
        <div class="text-base font-semibold">@db($item->nama_sekolah)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Jenjang</div>
        <div class="text-base font-semibold">@db($item->jenjang)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Jenis Sekolah</div>
        <div class="text-base font-semibold">@db($item->jenis_sekolah)</div>
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
        <div class="text-sm text-gray-600">Lingkungan</div>
        <div class="text-base font-semibold">@db($item->lingkungan)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Status Sekolah</div>
        <div class="text-base font-semibold">@db($item->stts_sekolah)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Ruang Kelas</div>
        <div class="text-base font-semibold">@db($item->jlh_ruang_kelas)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Perpustakaan</div>
        <div class="text-base font-semibold">@db($item->jlh_perpustakaan)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Laboratorium</div>
        <div class="text-base font-semibold">@db($item->jlh_lab)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">WC</div>
        <div class="text-base font-semibold">@db($item->jlh_wc)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Kantin</div>
        <div class="text-base font-semibold">@db($item->kantin)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Kepala Sekolah</div>
        <div class="text-base font-semibold">@db($item->nama_kep_sekolah)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Guru/Pegawai</div>
        <div class="text-base font-semibold">@db($item->jlh_guru_pegawai)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Guru Honor</div>
        <div class="text-base font-semibold">@db($item->jlh_guru_honor)</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Jumlah Siswa</div>
        <div class="text-base font-semibold">@db($item->jumlah_siswa)</div>
      </div>
    </div>
    <div class="mt-4">
      <a href="{{ route('pendidikan_formal.edit', $item) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
    </div>
  </div>
</div>
@endsection

