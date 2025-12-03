@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ url('/dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-semibold">Daftar Data Warga</h1>
    </div>

    <div class="flex items-center gap-3 mb-4">
        <form class="flex-1" action="{{ route('biodata_warga.index') }}" method="get">
            <div class="relative">
                <input name="q" value="{{ $q ?? '' }}" placeholder="Cari NIK, nama atau No KK" class="w-full pl-10 pr-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                <div class="absolute left-3 top-2 text-gray-400">🔍</div>
            </div>
        </form>
        <a href="{{ route('biodata_warga.create', absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg shadow" role="button" aria-label="Tambah warga">Tambah</a>
        @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
        @if($canAdminOps)
            <a href="{{ route('export.biodata', ['q' => $q], absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg shadow" role="button" aria-label="Export biodata">Export CSV</a>
        @endif
    </div>

    <div class="grid grid-cols-1 gap-3">
        @foreach($residents as $r)
            <article class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-sm text-gray-500">NIK: <span class="font-medium">@db($r->nik)</span></div>
                        <a href="{{ route('biodata_warga.show', $r) }}" class="block mt-1 text-lg font-semibold text-gray-800">@db($r->nama_lgkp)</a>
                        <div class="text-xs text-gray-600 mt-1">KK: @db($r->no_kk) • @db($r->stts_hub_keluarga)</div>
                        <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">@db($r->lingkungan ?? ($r->family?->lingkungan ?? '-'))</span></div>
                        <div class="text-sm text-gray-600 mt-2">@db($r->pekerjaan)</div>
                        <div class="text-xs text-gray-600 mt-1">Tgl Entri: <span class="font-medium">{{ $r->created_at }}</span></div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('biodata_warga.edit', $r) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('biodata_warga.destroy', $r) }}" method="post" class="mt-2">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700" onclick="return confirm('Hapus warga ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-4">{{ $residents->withQueryString()->links() }}</div>
</div>
<script>
    // Remove skeleton placeholders when real content is loaded
    document.addEventListener('DOMContentLoaded', function () {
        var sk = document.querySelectorAll('.skeleton-placeholder');
        sk.forEach(function(el){ el.remove(); });
    });
</script>
@endsection
