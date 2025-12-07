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
        <h1 class="text-2xl font-semibold">Daftar Kartu Keluarga</h1>
    </div>

    <div class="flex items-center gap-3 mb-4">
        <form id="searchForm" class="flex-1" action="{{ route('data_keluarga.index', absolute: false) }}" method="get">
            <div class="relative">
                <input id="searchInput" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama kep. keluarga atau alamat" class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 shadow-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40 focus:border-indigo-300" />
                <span class="absolute left-3 top-2.5">
                  <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 20l-3.5-3.5"/></svg>
                </span>
            </div>
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
        <a href="{{ route('data_keluarga.create', absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300/50" role="button" aria-label="Tambah keluarga">Tambah</a>
    </div>

    <ul class="space-y-3">
        @foreach($families as $f)
            <li class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-sm text-gray-500">KK: <span class="font-medium">@db($f->no_kk)</span></div>
                        <a href="{{ route('data_keluarga.show', $f) }}" class="block mt-1 text-lg font-semibold text-gray-800">@db($f->nama_kep)</a>
                        <div class="text-xs text-gray-600 mt-2">@db(Str::limit($f->alamat,60))</div>
                        <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">@db($f->lingkungan)</span></div>
                        @if ($f->status_keluarga==1)
                            <div class="text-xs text-gray-600 mt-1">Status: <span class="font-medium">Warga Domisili</span></div>
                        @elseif ($f->status_keluarga==2)
                            <div class="text-xs text-gray-600 mt-1">Status: <span class="font-medium">Warga Luar Domisili</span></div>
                        @else
                            <div class="text-xs text-gray-600 mt-1">Status: <span class="font-medium">Warga Domisili Baru</span></div>
                        @endif
                        <div class="text-xs text-gray-600 mt-1">Tgl Entri: <span class="font-medium">{{ $f->created_at }}</span></div>
                    </div>

                        <div class="text-right">
                            <a href="{{ route('data_keluarga.edit', $f) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm hover:bg-yellow-600">Edit</a>
                        </div>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-4">{{ $families->withQueryString()->links() }}</div>
</div>
@endsection
