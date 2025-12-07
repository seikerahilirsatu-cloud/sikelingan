@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('dashboard', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    <h1 class="text-2xl font-semibold">Sarana Pendidikan Formal</h1>
  </div>

  <div class="flex items-center gap-3 mb-4">
    <form id="searchFormFormal" class="flex-1" action="{{ route('pendidikan_formal.index', absolute: false) }}" method="get">
      <div class="relative">
        <input id="searchInputFormal" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama, jenjang, alamat" class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 shadow-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-300/40 focus:border-indigo-300" />
        <span class="absolute left-3 top-2.5">
          <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 20l-3.5-3.5"/></svg>
        </span>
      </div>
    </form>
    <script>
    (function(){
      var f=document.getElementById('searchFormFormal');
      var i=document.getElementById('searchInputFormal');
      if(!f||!i) return;
      var t=null, last=i.value.trim();
      i.addEventListener('input', function(){
        var v=i.value.trim();
        if(t) clearTimeout(t);
        t=setTimeout(function(){ if(v!==last){ last=v; f.requestSubmit(); } }, 500);
      });
    })();
    </script>
    <a href="{{ route('pendidikan_formal.create', absolute: false) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300/50" role="button">Tambah</a>
  </div>

  @if($items->count() === 0)
    <div class="text-center text-gray-600 py-8">Data pendidikan formal belum ada</div>
  @else
    <div class="grid grid-cols-1 gap-3">
      @foreach($items as $p)
        <article class="bg-white p-4 rounded-lg shadow-sm">
          <div class="flex items-start justify-between">
            <div>
              @if(!empty($p->photo_path))
                <img src="{{ asset('storage/'.$p->photo_path) }}" alt="{{ $p->nama_sekolah }}" class="mb-3 w-full rounded-md" style="max-height: 90px; max-width: 50%; object-fit: cover;" data-placeholder="{{ asset('images/placeholder-ibadah.svg') }}" onerror="this.onerror=null;this.src=this.dataset.placeholder" />
              @else
                <img src="{{ asset('images/placeholder-ibadah.svg') }}" alt="{{ $p->nama_sekolah }}" class="mb-3 w-full rounded-md" style="max-height: 90px; max-width: 50%; object-fit: cover;" />
              @endif
              <div class="text-sm text-gray-500">Jenjang: <span class="font-medium">@db($p->jenjang)</span></div>
              <a href="{{ route('pendidikan_formal.show', $p) }}" class="block mt-1 text-lg font-semibold text-gray-800">@db($p->nama_sekolah)</a>
              <div class="text-xs text-gray-600 mt-1">@db($p->alamat)</div>
              <div class="text-xs text-gray-600 mt-1">Lingkungan: <span class="font-medium">@db($p->lingkungan ?? '-')</span></div>
              <div class="text-xs text-gray-600 mt-1">Status: @db($p->stts_sekolah)</div>
            </div>
            <div class="text-right">
              <a href="{{ route('pendidikan_formal.edit', $p) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
              <form action="{{ route('pendidikan_formal.destroy', $p) }}" method="post" class="mt-2">
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
