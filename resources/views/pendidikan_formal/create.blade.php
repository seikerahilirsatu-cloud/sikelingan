@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-xl mx-auto">
  <div class="mb-3">
    <a href="{{ route('pendidikan_formal.index', absolute: false) }}" class="text-sm text-gray-600">Kembali</a>
    <h1 class="text-2xl font-semibold page-title">Tambah Pendidikan Formal</h1>
  </div>
  <form action="{{ route('pendidikan_formal.store', absolute: false) }}" method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
      <label class="block text-sm">Nama Sekolah</label>
      <input type="text" name="nama_sekolah" class="w-full p-2 border rounded" />
    </div>
    <div>
      <label class="block text-sm">Jenjang</label>
      <select name="jenjang" class="w-full p-2 border rounded">
        <option value="">-- Pilih --</option>
        @foreach($jenjangOpts as $o)
          <option value="{{ $o }}">{{ $o }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm">Jenis Sekolah</label>
      <select name="jenis_sekolah" class="w-full p-2 border rounded">
        <option value="">-- Pilih --</option>
        <option value="Negeri">Negeri</option>
        <option value="Swasta">Swasta</option>
      </select>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Tahun Berdiri</label>
        <input type="number" name="tahun_berdiri" class="w-full p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm">SK Pendirian</label>
        <input type="text" name="sk_pendirian" class="w-full p-2 border rounded" />
      </div>
    </div>
    <div>
      <label class="block text-sm">Alamat</label>
      <textarea name="alamat" class="w-full p-2 border rounded"></textarea>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Lingkungan</label>
        <select name="lingkungan" class="w-full p-2 border rounded">
          <option value="">-- Pilih --</option>
          @foreach($lingkunganOpts as $l)
            <option value="{{ $l }}">{{ $l }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm">Status Sekolah</label>
        <select name="stts_sekolah" class="w-full p-2 border rounded">
          <option value="">-- Pilih --</option>
          <option value="Aktif">Aktif</option>
          <option value="Tidak Aktif">Tidak Aktif</option>
        </select>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Jlh Ruang Kelas</label>
        <input type="number" name="jlh_ruang_kelas" class="w-full p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm">Jlh Perpustakaan</label>
        <input type="number" name="jlh_perpustakaan" class="w-full p-2 border rounded" />
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Jlh Laboratorium</label>
        <input type="number" name="jlh_lab" class="w-full p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm">Jlh WC</label>
        <input type="number" name="jlh_wc" class="w-full p-2 border rounded" />
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Kantin</label>
        <select name="kantin" class="w-full p-2 border rounded">
          <option value="">-- Pilih --</option>
          <option value="Ada">Ada</option>
          <option value="Tidak Ada">Tidak Ada</option>
        </select>
      </div>
      <div>
        <label class="block text-sm">Nama Kepala Sekolah</label>
        <input type="text" name="nama_kep_sekolah" class="w-full p-2 border rounded" />
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Jlh Guru/Pegawai</label>
        <input type="number" name="jlh_guru_pegawai" class="w-full p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm">Jlh Guru Honor</label>
        <input type="number" name="jlh_guru_honor" class="w-full p-2 border rounded" />
      </div>
    </div>
    <div>
      <label class="block text-sm">Jumlah Siswa</label>
      <input type="number" name="jumlah_siswa" class="w-full p-2 border rounded" />
    </div>
    <div>
      <label class="block text-sm">Foto Sekolah</label>
      <input type="file" name="photo" accept="image/*" class="w-full" />
    </div>
    <button class="w-full bg-blue-600 text-white p-2 rounded">Simpan</button>
  </form>
</div>
@endsection
