@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('page_title','Daftar Data Warga')
@section('content')
<div class="{{ (isset($is_mobile) && $is_mobile) ? 'max-w-3xl mx-auto' : 'container-fluid px-0' }}">
    <div class="mb-4">
        
    </div>

    <div class="flex items-center gap-3 mb-4">
        <form class="flex-1" action="{{ route('biodata_warga.index') }}" method="get">
            <div class="relative">
                <input name="q" value="{{ $q ?? '' }}" placeholder="Cari NIK, nama atau No KK" class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 shadow-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40 focus:border-indigo-300" />
                <span class="absolute left-3 top-2.5">
                  <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 20l-3.5-3.5"/></svg>
                </span>
            </div>
        </form>
        <a href="{{ route('biodata_warga.create', absolute: false) }}" data-modal="true" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300/50" role="button" aria-label="Tambah warga">Tambah</a>
        
    </div>

    @if(isset($is_mobile) && $is_mobile)
        <div class="grid grid-cols-1 gap-3">
            @foreach($residents as $r)
                <article class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm text-gray-500">NIK: <span class="font-medium">@db($r->nik)</span></div>
                            <a href="{{ route('biodata_warga.show', $r) }}" class="block mt-1 text-lg font-semibold text-gray-800">@db($r->nama_lgkp)</a>
                            <div class="text-xs text-gray-600 mt-1">KK: @db($r->no_kk) • @db($r->stts_hub_keluarga)</div>
                            <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">@db($r->lingkungan ?? ($r->family?->lingkungan ?? '-'))</span></div>
                            <div class="text-xs text-gray-600 mt-1">Tgl Entri: <span class="font-medium">{{ $r->created_at }}</span></div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('biodata_warga.edit', $r) }}" data-modal="true" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('biodata_warga.destroy', $r) }}" method="post" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700" onclick="return confirm('Hapus warga ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-modern table-hover center-data-5 col-actions-last">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>No KK</th>
                        <th>Hubungan</th>
                        <th>Lingkungan</th>
                        <th>Tgl Entri</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($residents as $r)
                        <tr>
                            <td>@db($r->nik)</td>
                            <td>@db($r->nama_lgkp)</td>
                            <td>@db($r->no_kk)</td>
                            <td>@db($r->stts_hub_keluarga)</td>
                            <td>@db($r->lingkungan ?? ($r->family?->lingkungan ?? '-'))</td>
                            <td>{{ $r->created_at }}</td>
                            <td>
                                <a href="{{ route('biodata_warga.show', $r) }}" data-modal="true" class="btn btn-sm btn-primary">Detail</a>
                                <a href="{{ route('biodata_warga.edit', $r) }}" data-modal="true" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('biodata_warga.destroy', $r) }}" method="post" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus warga ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-4">{{ $residents->withQueryString()->links() }}</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var sk = document.querySelectorAll('.skeleton-placeholder');
        sk.forEach(function(el){ el.remove(); });
    });
</script>
@endsection
