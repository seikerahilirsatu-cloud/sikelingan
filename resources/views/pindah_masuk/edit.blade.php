<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ubah Pencatatan Pindah Masuk</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto p-4">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('pindah_masuk.index') }}" class="inline-flex items-center px-3 py-2 border rounded-lg text-sm text-gray-700 mb-4">Kembali</a>
                </div>

                <form method="POST" action="{{ route('pindah_masuk.update', $item) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Warga</label>
                        <div class="mt-1 text-gray-800">{{ $item->warga?->nik ?? '-' }} — {{ $item->warga?->nama_lgkp ?? $item->warga?->nama ?? '—' }}</div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                               <label class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                               <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', optional($item->tanggal_masuk)->format('Y-m-d')) }}" required class="block w-full rounded-md border-gray-300 px-3 py-2" />
                        </div>
                        <div>
                               <label class="block text-sm font-medium text-gray-700">Jenis Masuk</label>
                               <select name="jenis_masuk" class="block w-full rounded-md border-gray-300 px-3 py-2">
                                <option value="">-- Pilih jenis pindah --</option>
                                @foreach(config('pindah_masuk.jenis') as $jenis)
                                     <option value="{{ $jenis }}" {{ old('jenis_masuk', $item->jenis_masuk)==$jenis ? 'selected':'' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Asal</label>
                        <input type="text" name="asal" value="{{ old('asal', $item->asal) }}" class="block w-full rounded-md border-gray-300 px-3 py-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="block w-full rounded-md border-gray-300 px-3 py-2">{{ old('keterangan', $item->keterangan) }}</textarea>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('pindah_masuk.index') }}" class="mr-2 px-4 py-2 border rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
