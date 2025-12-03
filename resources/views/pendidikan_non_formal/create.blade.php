@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-xl mx-auto">
  <div class="mb-3">
    <a href="{{ route('pendidikan_non_formal.index', absolute: false) }}" class="text-sm text-gray-600">Kembali</a>
    <h1 class="text-2xl font-semibold">Tambah Pendidikan Non-Formal</h1>
  </div>
  <form action="{{ route('pendidikan_non_formal.store', absolute: false) }}" method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow space-y-3">
    @csrf
    <div>
      <label class="block text-sm">Nama Lembaga</label>
      <input type="text" name="nama_lembaga" class="w-full p-2 border rounded" />
    </div>
    <div>
      <label class="block text-sm">Bidang Pelatihan</label>
      <select name="bidang_pelatihan" class="w-full p-2 border rounded">
        <option value="">-- Pilih --</option>
        @foreach($bidangOpts as $o)
          <option value="{{ $o }}">{{ $o }}</option>
        @endforeach
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
        <label class="block text-sm">No. Kontak</label>
        <input type="text" name="no_kontak" class="w-full p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm">Lingkungan</label>
        <select name="lingkungan" class="w-full p-2 border rounded">
          <option value="">-- Pilih --</option>
          @foreach($lingkunganOpts as $l)
            <option value="{{ $l }}">{{ $l }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm">Nama Pemilik</label>
        <input type="text" name="nama_pemilik" class="w-full p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm">Status Lembaga</label>
        <select name="stts_lembaga" class="w-full p-2 border rounded">
          <option value="">-- Pilih --</option>
          <option value="Aktif">Aktif</option>
          <option value="Tidak Aktif">Tidak Aktif</option>
        </select>
      </div>
    </div>
    <div>
      <label class="block text-sm">Jumlah Siswa</label>
      <input type="number" name="jumlah_siswa" class="w-full p-2 border rounded" />
    </div>
    <div>
      <label class="block text-sm">Foto Lembaga</label>
      <input type="file" name="photo" accept="image/*" class="w-full" />
    </div>
    <button class="w-full bg-blue-600 text-white p-2 rounded">Simpan</button>
  </form>
</div>
@endsection

