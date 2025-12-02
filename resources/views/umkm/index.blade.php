@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('dashboard', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
        <h1 class="text-2xl font-semibold">Daftar UMKM</h1>
    </div>

    <div class="flex items-center justify-between mb-4">
        <form id="searchForm" class="flex items-center gap-2" action="{{ route('umkm.index', absolute: false) }}" method="get">
            <input id="searchInput" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama usaha atau jenis" class="w-72 p-2 border rounded-lg" />
        </form>
        <script>
        (function(){
          var f=document.getElementById('searchForm');
          var i=document.getElementById('searchInput');
          if(!f||!i) return;
          var t=null, last=i.value.trim();
          i.addEventListener('input', function(){
            var v=i.value.trim();
            if(t) clearTimeout(t);
            t=setTimeout(function(){
              if(v!==last){ last=v; f.requestSubmit(); }
            }, 500);
          });
        })();
        </script>
        <a href="{{ route('umkm.create', absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg" role="button">Tambah</a>
    </div>

    @if($items->count() === 0)
        <div class="text-center text-gray-600 py-8">Data UMKM belum ada</div>
    @else
        <div class="grid grid-cols-1 gap-3">
            @foreach($items as $p)
                <article class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            @if(!empty($p->photo_path))
                                @php $photoUrl = Illuminate\Support\Facades\Storage::disk('public')->exists($p->photo_path) ? Illuminate\Support\Facades\Storage::url($p->photo_path) : null; @endphp
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $p->nama_usaha }}" class="mb-3 w-full rounded-md" style="max-height: 90px; max-width: 50%; object-fit: cover;"/>
                                @endif
                            @endif
                            <div class="text-sm text-gray-500">Jenis: <span class="font-medium">{{ $p->jenis }}</span></div>
                            <a href="{{ route('umkm.show', $p) }}" class="block mt-1 text-lg font-semibold text-gray-800">{{ $p->nama_usaha }}</a>
                            <div class="text-xs text-gray-600 mt-1">{{ $p->alamat }}</div>
                            <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">{{ $p->lingkungan ?? '-' }}</span></div>
                            <div class="text-xs text-gray-600 mt-1">Status: {{ $p->status_operasional }}</div>
                            @if($p->pemilik_nik)
                                <div class="text-xs text-gray-600 mt-1">Pemilik NIK: {{ $p->pemilik_nik }}</div>
                            @endif
                            @if($p->npwp_pemilik)
                                <div class="text-xs text-gray-600 mt-1">NPWP: {{ $p->npwp_pemilik }}</div>
                            @endif
                            @if($p->no_nib)
                                <div class="text-xs text-gray-600 mt-1">NIB: {{ $p->no_nib }}</div>
                            @endif
                        </div>
                        <div class="text-right">
                            <a href="{{ route('umkm.edit', $p) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
                            <form action="{{ route('umkm.destroy', $p) }}" method="post" class="mt-2">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md text-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">{{ $items->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
