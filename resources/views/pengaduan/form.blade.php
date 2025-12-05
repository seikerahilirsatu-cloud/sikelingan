@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
  <div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-4">
      <a href="{{ url('/') }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
        <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </a>
      <div>
        <div class="text-lg font-semibold">Form Pengaduan Warga</div>
        <div class="text-xs text-gray-600">Anonim diperbolehkan. Kontak membantu tindak lanjut.</div>
      </div>
    </div>

    @if(session('success'))
      <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="post" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div class="rounded-xl bg-white shadow p-4 space-y-3">
        <div class="flex items-center gap-2">
          <input type="checkbox" id="anonim" name="anonim" value="1" class="rounded" {{ old('anonim') ? 'checked' : '' }}>
          <label for="anonim" class="text-sm text-gray-700">Ajukan secara anonim</label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-sm text-gray-600">Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" class="mt-1 w-full rounded-lg border-gray-300" placeholder="Opsional">
            @error('nama')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
          </div>
          <div>
            <label class="text-sm text-gray-600">Kontak</label>
            <input type="text" name="kontak" value="{{ old('kontak') }}" class="mt-1 w-full rounded-lg border-gray-300" placeholder="Email/Telepon (opsional)">
            @error('kontak')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      <div class="rounded-xl bg-white shadow p-4 space-y-3">
        <div>
          <label class="text-sm text-gray-600">Kategori</label>
          <select name="kategori" class="mt-1 w-full rounded-lg border-gray-300">
            <option value="">Pilih kategori</option>
            @foreach(['kebersihan','keamanan','administrasi','fasilitas','lainnya'] as $k)
              <option value="{{ $k }}" {{ old('kategori')===$k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
            @endforeach
          </select>
          @error('kategori')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="text-sm text-gray-600">Judul</label>
          <input type="text" name="judul" value="{{ old('judul') }}" class="mt-1 w-full rounded-lg border-gray-300">
          @error('judul')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="text-sm text-gray-600">Isi Pengaduan</label>
          <textarea name="isi" rows="6" class="mt-1 w-full rounded-lg border-gray-300">{{ old('isi') }}</textarea>
          @error('isi')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="text-sm text-gray-600">Lokasi</label>
          <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="mt-1 w-full rounded-lg border-gray-300" placeholder="Jalan/Lingkungan (opsional)">
          @error('lokasi')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div>
          <label class="text-sm text-gray-600">Lampiran</label>
          <input type="file" name="lampiran[]" multiple accept="image/*,application/pdf" capture="environment" class="mt-1 w-full rounded-lg border-gray-300">
          <div class="text-xs text-gray-500 mt-1">jpg, png, pdf • maks 4MB/file</div>
          @error('lampiran.*')<div class="text-xs text-red-600 mt-1">{{ $message }}</div>@enderror
        </div>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="setuju" name="setuju" value="1" class="rounded" {{ old('setuju') ? 'checked' : '' }}>
          <label for="setuju" class="text-sm text-gray-700">Saya menyatakan data yang disampaikan benar dan setuju kebijakan privasi</label>
          @error('setuju')<div class="text-xs text-red-600 ms-2">{{ $message }}</div>@enderror
        </div>
        <div class="pt-2">
          <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Kirim Pengaduan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
