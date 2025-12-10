<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm sm:text-xl text-gray-800 leading-tight page-title">Ubah Pencatatan Pindah Keluar</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto p-4">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-4">
                    @if(!filter_var(request('modal'), FILTER_VALIDATE_BOOLEAN))
                        <a href="{{ route('pindah_keluar.index') }}" class="inline-flex items-center px-3 py-2 border rounded-lg text-sm text-gray-700 mb-4">Kembali</a>
                    @endif
                </div>

                <form method="POST" action="{{ route('pindah_keluar.update', $item) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Warga</label>
                        <div class="mt-1 text-gray-800">{{ $item->warga?->nik ?? '-' }} — {{ $item->warga?->nama_lgkp ?? $item->warga?->nama ?? '—' }}</div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pindah</label>
                            <input type="date" name="tanggal_pindah" value="{{ old('tanggal_pindah', optional($item->tanggal_pindah)->format('Y-m-d')) }}" required class="block w-full rounded-md border-gray-300 px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Pindah</label>
                            <select name="jenis_pindah" class="block w-full rounded-md border-gray-300 px-3 py-2">
                                <option value="">-- Pilih jenis pindah --</option>
                                @foreach(config('pindah_keluar.jenis') as $jenis)
                                    <option value="{{ $jenis }}" {{ old('jenis_pindah', $item->jenis_pindah)==$jenis ? 'selected':'' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                        <input type="text" name="tujuan" value="{{ old('tujuan', $item->tujuan) }}" class="block w-full rounded-md border-gray-300 px-3 py-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="block w-full rounded-md border-gray-300 px-3 py-2">{{ old('keterangan', $item->keterangan) }}</textarea>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('pindah_keluar.index') }}" class="mr-2 px-4 py-2 border rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
