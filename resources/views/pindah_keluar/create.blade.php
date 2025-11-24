<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Pencatatan Pindah Keluar</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto p-4">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <a href="{{ route('pindah_keluar.index') }}" class="inline-flex items-center px-3 py-2 border rounded-lg text-sm text-gray-700 mb-4">Kembali</a>

                <form method="GET" action="{{ route('pindah_keluar.create') }}" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Cari Warga (NIK atau Nama)</label>
                    <div class="flex gap-2 mt-1">
                        <input type="text" name="q" value="{{ old('q', $q ?? '') }}" class="block w-full rounded-md border-gray-300 px-3 py-2" placeholder="Masukkan NIK atau nama" />
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Cari</button>
                    </div>
                </form>

                @if(isset($selectedWarga) && $selectedWarga)
                    <form method="POST" action="{{ route('pindah_keluar.store') }}">
                        @csrf
                        <input type="hidden" name="warga_id" value="{{ $selectedWarga->id }}" />

                        <div class="mb-4 p-3 bg-white rounded border">
                            <div class="text-sm text-gray-500">NIK: <span class="font-medium">{{ $selectedWarga->nik }}</span></div>
                            <div class="mt-1 text-lg font-semibold text-gray-800">{{ $selectedWarga->nama_lgkp ?? $selectedWarga->nama }}</div>
                            @if(!empty($selectedWarga->no_kk))
                                <div class="text-xs text-gray-600 mt-1">KK: {{ $selectedWarga->no_kk }}</div>
                            @endif
                            <div class="text-xs text-gray-600 mt-2">{{ $selectedWarga->alamat ?? ($selectedWarga->family?->alamat ?? '') }}</div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pindah</label>
                                <input type="date" name="tanggal_pindah" required class="block w-full rounded-md border-gray-300 px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Pindah</label>
                                <select name="jenis_pindah" class="block w-full rounded-md border-gray-300 px-3 py-2">
                                    <option value="">-- Pilih jenis pindah --</option>
                                    @foreach(config('pindah_keluar.jenis') as $jenis)
                                        <option value="{{ $jenis }}">{{ $jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Tujuan</label>
                            <input type="text" name="tujuan" class="block w-full rounded-md border-gray-300 px-3 py-2" />
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="block w-full rounded-md border-gray-300 px-3 py-2"></textarea>
                        </div>

                        <div class="mt-4 flex justify-between">
                            <a href="{{ route('pindah_keluar.create', ['q' => $q ?? '']) }}" class="px-3 py-2 border rounded text-sm text-gray-700">Kembali ke daftar</a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan Pencatatan</button>
                        </div>
                    </form>
                @else
                    @if(isset($wargas) && $wargas->count())
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Hasil Pencarian</label>
                            <div id="wargaCards" class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                                @foreach($wargas as $w)
                                    <a href="{{ route('pindah_keluar.create', ['warga_id' => $w->id, 'q' => $q ?? '']) }}" class="block select-warga-card bg-white p-3 rounded-lg border border-transparent hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                        <div class="text-sm text-gray-500">NIK: <span class="font-medium">{{ $w->nik }}</span></div>
                                        <div class="mt-1 text-lg font-semibold text-gray-800">{{ $w->nama_lgkp ?? $w->nama }}</div>
                                        @if(!empty($w->no_kk))
                                            <div class="text-xs text-gray-600 mt-1">KK: {{ $w->no_kk }}</div>
                                        @endif
                                        <div class="text-xs text-gray-600 mt-2">{{ Str::limit($w->alamat ?? ($w->family?->alamat ?? ''), 80) }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        @if(!empty($q))
                            <div class="text-sm text-gray-600">Data tidak ditemukan</div>
                        @else
                            <div class="text-sm text-gray-600">Masukkan NIK atau nama lalu klik "Cari" untuk memilih warga.</div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
