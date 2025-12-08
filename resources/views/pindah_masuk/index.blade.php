@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <h1 class="text-2xl font-semibold">Daftar Warga Pindah Masuk</h1>

        <a href="{{ url('/dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2 mt-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <div class="mb-4 mt-2">
            <form action="{{ route('pindah_masuk.index') }}" method="get" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="relative flex-1 min-w-0">
                    <input name="q" value="{{ $q ?? '' }}" placeholder="Cari NIK atau nama" class="w-full pl-10 pr-4 h-10 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                    <div class="absolute left-3 top-2 text-gray-400">🔍</div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex flex-col text-sm">
                        <label class="text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="from" value="{{ $from ?? '' }}" class="h-10 px-3 border rounded-lg" />
                    </div>

                    <div class="flex flex-col text-sm">
                        <label class="text-gray-600 mb-1">Sampai Dengan</label>
                        <input type="date" name="to" value="{{ $to ?? '' }}" class="h-10 px-3 border rounded-lg" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="h-10 px-4 bg-indigo-600 text-white rounded-lg">Cari</button>
                    <a href="{{ route('pindah_masuk.index') }}" class="h-10 inline-flex items-center px-4 border border-red-300 bg-red-50 text-red-700 rounded-lg text-sm hover:bg-red-100">Reset</a>
                    <a href="{{ route('pindah_masuk.create') }}" class="h-10 inline-flex items-center px-4 bg-indigo-600 text-white rounded-lg" role="button" aria-label="Tambah pencatatan">Tambah</a>
                </div>
            </form>
        </div>
    </div>

    @if($items->count())
        @if(!empty($from) || !empty($to))
            <div class="mb-2 text-sm text-gray-700">Menampilkan <span class="font-semibold">{{ $items->total() }}</span> hasil untuk rentang tanggal: <span class="font-medium">{{ $from ?? '-' }}</span> — <span class="font-medium">{{ $to ?? '-' }}</span></div>
        @endif

        <div class="grid grid-cols-1 gap-3">
            @foreach($items as $it)
                <article class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm text-gray-500">NIK: <span class="font-medium">@db($it->warga?->nik ?? '-')</span></div>
                            <a href="{{ route('pindah_masuk.show', $it) }}" class="block mt-1 text-lg font-semibold text-gray-800">@db($it->warga?->nama_lgkp ?? $it->warga?->nama ?? '—')</a>
                            <div class="text-xs text-gray-600 mt-2">Tanggal Masuk: <span class="font-medium">{{ optional($it->tanggal_masuk)->format('Y-m-d') ?? '-' }}</span></div>
                            <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">@db($it->lingkungan ?? ($it->warga?->lingkungan ?? '-'))</span></div>
                            <div class="text-xs text-gray-600 mt-1">Alamat: <span class="font-medium">@db($it->alamat ?? ($it->warga?->alamat ?? '-'))</span></div>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-gray-600">Pencatat</div>
                            <div class="text-sm font-medium">@db($it->creator?->name ?? '-')</div>
                            <div class="mt-2 flex items-center gap-2">
                                @if(Route::has('pindah_masuk.edit'))
                                    <a href="{{ route('pindah_masuk.edit', $it) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600">Edit</a>
                                @endif

                                <form action="{{ route('pindah_masuk.destroy', $it) }}" method="POST" onsubmit="return confirm('Hapus pencatatan pindah masuk untuk @db($it->warga?->nama_lgkp ?? $it->warga?->nama)?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">{{ $items->withQueryString()->links() }}</div>
    @else
        @if(isset($q) && $q !== null && $q !== '')
            <div class="text-sm text-gray-600">Data tidak ditemukan.</div>
        @elseif((isset($from) && $from) || (isset($to) && $to))
            <div class="text-sm text-gray-600">Tidak ada warga pindah dari tanggal <span class="font-medium">{{ $from ?? '-' }}</span> s.d <span class="font-medium">{{ $to ?? '-' }}</span>.</div>
        @else
            <div class="text-sm text-gray-600">Belum ada pencatatan pindah masuk.</div>
        @endif
    @endif
</div>
@endsection
