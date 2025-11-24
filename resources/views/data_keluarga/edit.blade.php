@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ url()->previous() }}" onclick="event.preventDefault(); window.history.back();" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-semibold">Edit Data Keluarga</h1>
    </div>
    <form method="post" action="{{ route('data_keluarga.update', $family) }}" class="bg-white shadow-md rounded-lg p-6 space-y-3">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm">No. KK</label>
            <input name="no_kk" value="{{ old('no_kk',$family->no_kk) }}" class="w-full p-2 border rounded" />
            @error('no_kk')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Nama Kepala</label>
            <input name="nama_kep" value="{{ old('nama_kep',$family->nama_kep) }}" class="w-full p-2 border rounded" />
            @error('nama_kep')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Alamat</label>
            <textarea name="alamat" class="w-full p-2 border rounded">{{ old('alamat',$family->alamat) }}</textarea>
            @error('alamat')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Lingkungan</label>
            @php $opts = config('app_local.lingkungan_opts'); @endphp
            <select name="lingkungan" class="w-full p-2 border rounded">
                <option value="">-- Pilih Lingkungan --</option>
                @foreach($opts as $ling)
                    <option value="{{ $ling }}" {{ (old('lingkungan',$family->lingkungan) == $ling) ? 'selected' : '' }}>{{ $ling }}</option>
                @endforeach
            </select>
            @error('lingkungan')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Status Keluarga</label>
            <select name="status_keluarga" class="w-full p-2 border rounded">
                <option value="1" {{ $family->status_keluarga==1? 'selected':'' }}>Warga Domisili</option>
                <option value="2" {{ $family->status_keluarga==2? 'selected':'' }}>Warga Luar Domisili</option>
                <option value="3" {{ $family->status_keluarga==3? 'selected':'' }}>Warga Domisili Baru</option>
            </select>
        </div>
        <div class="pt-2">
            <button class="w-full bg-blue-600 text-white p-2 rounded-lg">Perbarui</button>
        </div>
    </form>
</div>
@endsection
