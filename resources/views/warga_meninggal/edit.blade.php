<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-sm sm:text-xl text-gray-800 leading-tight page-title">Ubah Pencatatan Warga Meninggal</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto p-4">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="mb-4">
                    @if(!filter_var(request('modal'), FILTER_VALIDATE_BOOLEAN))
                        <a href="{{ route('warga_meninggal.index') }}" class="inline-flex items-center px-3 py-2 border rounded-lg text-sm text-gray-700 mb-4">Kembali</a>
                    @endif
                </div>

                <form method="POST" action="{{ route('warga_meninggal.update', $item) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Warga</label>
                        <div class="mt-1 text-gray-800">{{ $item->warga?->nik ?? '-' }} — {{ $item->warga?->nama_lgkp ?? $item->warga?->nama ?? '—' }}</div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                               <label class="block text-sm font-medium text-gray-700">Tanggal Meninggal</label>
                               <input type="date" name="tanggal_meninggal" value="{{ old('tanggal_meninggal', optional($item->tanggal_meninggal)->format('Y-m-d')) }}" required class="block w-full rounded-md border-gray-300 px-3 py-2" />
                        </div>
                        <div>
                               <label class="block text-sm font-medium text-gray-700">Waktu Meninggal</label>
                               <input type="time" name="waktu_meninggal" value="{{ old('waktu_meninggal', $item->waktu_meninggal) }}" class="block w-full rounded-md border-gray-300 px-3 py-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Tempat Meninggal</label>
                        <select name="tempat_meninggal" class="block w-full rounded-md border-gray-300 px-3 py-2">
                            <option value="">-- Pilih tempat --</option>
                            <option value="Rumah Sakit" {{ old('tempat_meninggal', $item->tempat_meninggal)=='Rumah Sakit' ? 'selected':'' }}>Rumah Sakit</option>
                            <option value="Rumah" {{ old('tempat_meninggal', $item->tempat_meninggal)=='Rumah' ? 'selected':'' }}>Rumah</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Sebab Meninggal</label>
                        <textarea name="sebab_meninggal" rows="2" class="block w-full rounded-md border-gray-300 px-3 py-2">{{ old('sebab_meninggal', $item->sebab_meninggal) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Tanggal Dikebumikan</label>
                        <input type="date" name="tanggal_dikebumikan" value="{{ old('tanggal_dikebumikan', optional($item->tanggal_dikebumikan)->format('Y-m-d')) }}" class="block w-full rounded-md border-gray-300 px-3 py-2" />
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="block w-full rounded-md border-gray-300 px-3 py-2">{{ old('keterangan', $item->keterangan) }}</textarea>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('warga_meninggal.index') }}" class="mr-2 px-4 py-2 border rounded">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
