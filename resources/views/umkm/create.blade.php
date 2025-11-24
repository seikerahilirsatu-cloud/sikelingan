@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('umkm.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
        <h1 class="text-2xl font-semibold">Tambah UMKM</h1>
    </div>
    <form method="post" action="{{ route('umkm.store', absolute: false) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-3">
        @csrf
        <div>
            <label class="block text-sm">Nama Usaha</label>
            <input name="nama_usaha" value="{{ old('nama_usaha') }}" class="w-full p-2 border rounded" />
            @error('nama_usaha')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Jenis</label>
            @php $jenisOpts = config('app_local.umkm_jenis', []); @endphp
            <select name="jenis" class="w-full p-2 border rounded">
                <option value="">Pilih Jenis Usaha</option>
                @foreach($jenisOpts as $j)
                    <option value="{{ $j }}" {{ old('jenis')==$j?'selected':'' }}>{{ $j }}</option>
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
        <div>
            <label class="block text-sm">Status Operasional</label>
            <input name="status_operasional" value="{{ old('status_operasional') }}" class="w-full p-2 border rounded" />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm">Pemilik NIK</label>
                <input name="pemilik_nik" value="{{ old('pemilik_nik') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">NPWP Pemilik</label>
                <input name="npwp_pemilik" value="{{ old('npwp_pemilik') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">No NIB</label>
                <input name="no_nib" value="{{ old('no_nib') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div>
            <label class="block text-sm">Kontak</label>
            <input name="kontak" value="{{ old('kontak') }}" class="w-full p-2 border rounded" />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm">Tanggal Berdiri</label>
                <input type="date" name="tanggal_berdiri" value="{{ old('tanggal_berdiri') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Omzet</label>
                <input name="omzet" type="number" step="0.01" value="{{ old('omzet') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm">Koordinat Lat</label>
                <input name="koordinat_lat" value="{{ old('koordinat_lat') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Koordinat Lng</label>
                <input name="koordinat_lng" value="{{ old('koordinat_lng') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        
        <div>
            <label class="block text-sm">Foto</label>
            <input type="file" name="photo" accept="image/*" class="w-full" />
        </div>
        <button class="w-full bg-blue-600 text-white p-2 rounded">Simpan</button>
    </form>
</div>
@endsection