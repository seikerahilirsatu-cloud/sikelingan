@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
  <div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-4">
      <a href="{{ url('/') }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
        <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </a>
      <div>
        <div class="text-lg font-semibold">Cek Status Pengaduan</div>
        <div class="text-xs text-gray-600">Masukkan kode tiket untuk melihat progres</div>
      </div>
    </div>

    <div class="mb-4 flex items-center gap-2">
      <a href="{{ route('pengaduan.create', absolute: false) }}" class="inline-flex items-center px-3 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700">
        <svg class="w-4 h-4 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M5.07 19h13.86A2 2 0 0021 17.07V6.93A2 2 0 0018.93 5H5.07A2 2 0 003 6.93v10.14A2 2 0 005.07 19z"/></svg>
        Ajukan Pengaduan
      </a>
    </div>

    @if(session('success'))
      <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="get" action="{{ route('pengaduan.cek') }}" class="rounded-xl bg-white shadow p-4 mb-4">
      <label class="text-sm text-gray-600">Kode Tiket</label>
      <div class="mt-1 flex gap-2">
        <input type="text" name="kode" value="{{ $kode }}" class="flex-1 rounded-lg border-gray-300" placeholder="Mis. PD-251205-ABC123">
        <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Cek</button>
      </div>
    </form>

    @if($pengaduan)
      <section class="rounded-xl bg-white shadow p-4">
        <div class="text-sm text-gray-600">Kode Tiket</div>
        <div class="text-base font-semibold">{{ $pengaduan->kode_tiket }}</div>
        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <div class="text-sm text-gray-600">Status</div>
            @php
              $st = strtolower($pengaduan->status);
              $badgeClass = [
                'baru' => 'bg-gray-500 text-white',
                'diproses' => 'bg-amber-500 text-white',
                'selesai' => 'bg-emerald-600 text-white',
                'ditolak' => 'bg-red-600 text-white',
              ][$st] ?? 'bg-gray-500 text-white';
            @endphp
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold shadow-sm {{ $badgeClass }}">
              @if($st==='baru')
                <svg class="w-3.5 h-3.5 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
              @elseif($st==='diproses')
                <span class="inline-block w-3.5 h-3.5 me-1 border-2 border-current border-t-transparent rounded-full animate-spin"></span>
              @elseif($st==='selesai')
                <svg class="w-3.5 h-3.5 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              @elseif($st==='ditolak')
                <svg class="w-3.5 h-3.5 me-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              @endif
              {{ ucfirst($pengaduan->status) }}
            </span>
          </div>
          <div>
            <div class="text-sm text-gray-600">Kategori</div>
            <div class="text-base font-semibold">{{ ucfirst($pengaduan->kategori) }}</div>
          </div>
        </div>
        <div class="mt-3">
          <div class="text-sm text-gray-600">Judul</div>
          <div class="text-base font-semibold">{{ $pengaduan->judul }}</div>
        </div>
        <div class="mt-3">
          <div class="text-sm text-gray-600">Isi</div>
          <div class="text-gray-700">{{ $pengaduan->isi }}</div>
        </div>
        <div class="mt-3">
          <div class="text-sm text-gray-600">Lokasi</div>
          <div class="text-gray-700">{{ $pengaduan->lokasi ?: '—' }}</div>
        </div>
        <div class="mt-3">
          <div class="text-sm text-gray-600">Catatan Proses</div>
          <div class="text-gray-700">{{ $pengaduan->public_notes ?: '—' }}</div>
        </div>
      </section>
    @elseif($kode)
      <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-red-700">Kode tiket tidak ditemukan</div>
    @endif
  </div>
</div>
@endsection
