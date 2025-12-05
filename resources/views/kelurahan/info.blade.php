@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6" x-data="{preview:false,url:''}">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-800">{{ config('kelurahan.nama') }}</h1>
    <div class="text-sm text-gray-600 mt-1">Kecamatan {{ config('kelurahan.kecamatan') }}</div>
    <div class="mt-4">
      <a href="{{ url()->previous() }}" class="inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
        <svg class="w-4 h-4 me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
      </a>
    </div>

    <section class="mt-6 bg-white rounded-xl shadow p-6 space-y-3">
      <h2 class="text-lg font-semibold">Sejarah Singkat</h2>
      <p class="text-gray-700 leading-relaxed">{{ config('kelurahan.sejarah') ?: '—' }}</p>
    </section>

    <section class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="rounded-xl shadow p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200">
        <h2 class="text-lg font-semibold text-blue-700">Visi</h2>
        <p class="mt-2 text-blue-800">{{ config('kelurahan.visi') ?: '—' }}</p>
      </div>
      <div class="rounded-xl shadow p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-200">
        <h2 class="text-lg font-semibold text-emerald-700">Misi</h2>
        @php $misi = array_filter((array)config('kelurahan.misi')); @endphp
        <ul class="mt-2 list-disc ms-5 text-emerald-800 space-y-1">
          @if(count($misi)===0)
            <li>—</li>
          @else
            @foreach($misi as $item)
              <li>{{ $item }}</li>
            @endforeach
          @endif
        </ul>
      </div>
    </section>

    <section class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="bg-white rounded-xl shadow p-6">
        <div class="text-sm text-gray-600">Luas Wilayah</div>
        <div class="mt-1 text-base font-semibold">{{ config('kelurahan.luas_wilayah') ?: '—' }}</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <div class="text-sm text-gray-600">Alamat Kantor</div>
        <div class="mt-1 text-base font-semibold">{{ config('kelurahan.alamat') ?: '—' }}</div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <div class="text-sm text-gray-600">Jam Layanan</div>
        <div class="mt-1 text-base font-semibold">{{ config('kelurahan.jam_layanan') ?: '—' }}</div>
      </div>
    </section>

    <section class="mt-6">
      <div class="flex items-center gap-3 mb-3">
        <div class="h-10 w-10 rounded-2xl bg-orange-100 flex items-center justify-center">
          <svg class="w-6 h-6 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a4 4 0 10-8 0 4 4 0 008 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 20a7 7 0 0114 0H3z" /></svg>
        </div>
        <h2 class="text-lg font-semibold">Perangkat Kelurahan</h2>
      </div>
      @php $perangkat = (array)config('kelurahan.perangkat'); @endphp
      <div class="mt-2 space-y-4">
        @foreach($perangkat as $p)
          @php $isLurah = strtolower($p['jabatan'] ?? '') === 'lurah'; @endphp
          <div class="mb-2 p-4 rounded-2xl border {{ $isLurah ? 'bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200' : 'bg-white border-gray-200' }}">
            <div class="flex items-center gap-4">
              <div class="w-12 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-200">
                @if(!empty($p['foto_url']))
                  <img src="{{ $p['foto_url'] }}" alt="{{ $p['jabatan'] }}" class="w-full h-full object-cover cursor-zoom-in" onerror="this.style.display='none'" @click="url=$el.src; preview=true" />
                @endif
              </div>
              <div class="flex-1">
                <p class="text-xs {{ $isLurah ? 'text-blue-600' : 'text-gray-500' }} mb-1">{{ $p['jabatan'] ?? '' }}</p>
                <p class="font-medium">{{ $p['nama'] ?: '—' }}</p>
                <p class="text-xs text-gray-500">Sejak {{ $p['masa_tugas'] ?: '—' }} - Sekarang</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>

    <section class="mt-6 bg-white rounded-xl shadow p-6">
      <h2 class="text-lg font-semibold">Kepala Lingkungan</h2>
      @php $kepling = (array)config('kelurahan.kepala_lingkungan'); @endphp
      <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @for($i=1; $i<=13; $i++)
          @php $k = $kepling[$i] ?? ['nama' => '', 'foto_url' => '']; @endphp
          <div class="mb-2 p-4 rounded-2xl border bg-white border-gray-200">
            <div class="flex items-center gap-4">
              <div class="w-12 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-200">
                @if(!empty($k['foto_url']))
                  <img src="{{ $k['foto_url'] }}" alt="Kepling {{ $i }}" class="w-full h-full object-cover cursor-zoom-in" onerror="this.style.display='none'" @click="url=$el.src; preview=true" />
                @endif
              </div>
              <div class="flex-1">
                <p class="text-xs text-gray-500 mb-1">Kepala Lingkungan {{ $i }}</p>
                <p class="font-medium">{{ $k['nama'] ?: '—' }}</p>
              </div>
            </div>
          </div>
        @endfor
      </div>
    </section>

    <div x-show="preview" x-cloak class="fixed inset-0 z-50">
      <div class="absolute inset-0 bg-black/60" @click="preview=false"></div>
      <div class="absolute inset-0 flex items-center justify-center p-4" @keydown.escape.window="preview=false">
        <div class="bg-white rounded-2xl overflow-hidden shadow-xl max-w-3xl w-full">
          <img :src="url" alt="Preview Foto" class="w-full max-h-[80vh] object-contain bg-black" />
          <div class="p-2 flex justify-end bg-white">
            <button type="button" class="px-3 py-1 text-sm bg-gray-800 text-white rounded" @click="preview=false">Tutup</button>
          </div>
        </div>
      </div>
    </div>

    <section class="mt-6 bg-white rounded-xl shadow p-6">
      <h2 class="text-lg font-semibold">Peta Wilayah Kelurahan</h2>
      <div class="mt-4 aspect-video rounded-xl overflow-hidden border">
        <iframe src="{{ config('kelurahan.peta_embed_url') }}" width="100%" height="100%" style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </section>
  </div>
</div>
@endsection
