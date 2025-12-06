@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
  <div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-4">
      <a href="{{ url('/') }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </a>
      <div>
        <div class="text-lg font-semibold">Pengaduan Baru Belum Diproses</div>
        <div class="text-xs text-gray-600">Daftar pengaduan yang baru masuk untuk ditinjau</div>
      </div>
    </div>

    @foreach($items as $p)
      <article class="rounded-xl bg-white shadow p-4 mb-4">
        <div class="text-sm text-gray-600">Kode Tiket</div>
        <div class="text-base font-semibold">{{ $p->kode_tiket }}</div>
        <div class="mt-3">
          <div class="text-sm text-gray-600">Judul</div>
          <div class="text-gray-800 font-medium">{{ $p->judul }}</div>
        </div>
        <div class="mt-3">
          <div class="text-sm text-gray-600">Isi Pengaduan</div>
          <div class="text-gray-800">{{ $p->isi }}</div>
        </div>
        @if(!empty($p->lokasi))
        <div class="mt-3">
          <div class="text-sm text-gray-600">Lokasi</div>
          <div class="text-gray-800">{{ $p->lokasi }}</div>
        </div>
        @endif

        @php
          $imgs = collect((array)$p->lampiran)->filter(function($path){
            return preg_match('/\.(jpg|jpeg|png)$/i', $path);
          })->values();
          $docs = collect((array)$p->lampiran)->filter(function($path){
            return preg_match('/\.(pdf)$/i', $path);
          })->values();
        @endphp

        @if($imgs->count() || $docs->count())
        <details class="mt-3">
          <summary class="cursor-pointer inline-flex items-center px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm">Lihat Foto/Lampiran</summary>
          <div class="mt-3 grid grid-cols-3 gap-3">
            @foreach($imgs as $img)
              <a href="{{ asset('storage/'.$img) }}" target="_blank" class="block">
                <img src="{{ asset('storage/'.$img) }}" alt="Lampiran" class="w-full h-24 object-cover rounded border" />
              </a>
            @endforeach
          </div>
          @if($docs->count())
          <div class="mt-3">
            @foreach($docs as $doc)
              <a href="{{ asset('storage/'.$doc) }}" target="_blank" class="inline-flex items-center px-3 py-2 rounded border me-2">PDF</a>
            @endforeach
          </div>
          @endif
        </details>
        @endif
      </article>
    @endforeach

    <div class="mt-4">{{ $items->links() }}</div>
  </div>
</div>
@endsection
