@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
        <h1 class="text-2xl font-semibold">Tambah Rumah Ibadah</h1>
    </div>
    <form method="post" action="{{ route('rumah_ibadah.store', absolute: false) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-3">
        @csrf
        <div>
            <label class="block text-sm">Nama</label>
            <input name="nama" value="{{ old('nama') }}" class="w-full p-2 border rounded" />
            @error('nama')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Jenis</label>
            <select name="jenis" class="w-full p-2 border rounded">
                @foreach(['Masjid','Gereja','Pura','Vihara','Klenteng','Mushalla','Lainnya'] as $j)
                    <option value="{{ $j }}">{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Alamat</label>
            <textarea name="alamat" class="w-full p-2 border rounded">{{ old('alamat') }}</textarea>
        </div>
        <div>
            <label class="block text-sm">Lingkungan</label>
            @php $opts = config('app_local.lingkungan_opts'); $defaultLkg = old('lingkungan') ?? (auth()->user()->lingkungan ?? ''); @endphp
            <select name="lingkungan" class="w-full p-2 border rounded">
                <option value="">Pilih Lingkungan</option>
                @foreach($opts as $l)
                    <option value="{{ $l }}" {{ $defaultLkg==$l ? 'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Status Operasional</label>
                <select name="status_operasional" class="w-full p-2 border rounded">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label class="block text-sm">Kapasitas</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Tanggal Berdiri</label>
                <input type="date" name="tanggal_berdiri" value="{{ old('tanggal_berdiri') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Pengurus NIK</label>
                <input name="pengurus_nik" value="{{ old('pengurus_nik') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Kontak</label>
                <input name="kontak" value="{{ old('kontak') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Koordinat Lat</label>
                <input name="koordinat_lat" value="{{ old('koordinat_lat') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div>
            <label class="block text-sm">Koordinat Lng</label>
            <input name="koordinat_lng" value="{{ old('koordinat_lng') }}" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Photo Path</label>
            <input name="photo_path" value="{{ old('photo_path') }}" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Unggah Foto</label>
            <input type="file" name="photo" accept="image/*" capture="environment" class="w-full p-2 border rounded" />
        </div>
        <div class="pt-2">
            <button class="w-full bg-blue-600 text-white p-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection