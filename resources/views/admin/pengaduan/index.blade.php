@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
  <div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-3 mb-4">
      <div class="h-10 w-10 rounded-2xl bg-blue-100 flex items-center justify-center">
        <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
      </div>
      <div>
        <div class="text-lg font-semibold">Daftar Pengaduan</div>
        <div class="text-xs text-gray-600">Filter sederhana berdasarkan status/kategori</div>
      </div>
    </div>

    <form method="get" class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
      <select name="status" class="rounded-lg border-gray-300">
        <option value="">Semua Status</option>
        @foreach(['baru','diproses','selesai','ditolak'] as $s)
          <option value="{{ $s }}" {{ request('status')===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
      </select>
      <select name="kategori" class="rounded-lg border-gray-300">
        <option value="">Semua Kategori</option>
        @foreach(['kebersihan','keamanan','administrasi','fasilitas','lainnya'] as $k)
          <option value="{{ $k }}" {{ request('kategori')===$k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
        @endforeach
      </select>
      <button class="px-4 py-2 rounded-lg bg-gray-800 text-white">Terapkan</button>
    </form>

    <section class="rounded-xl bg-white shadow">
      <div class="divide-y">
        @foreach($list as $item)
          <a href="{{ route('admin.pengaduan.show', $item->id) }}" class="block p-4 hover:bg-gray-50">
            <div class="flex items-center justify-between">
              <div class="font-semibold">{{ $item->judul }}</div>
              <div class="text-xs px-2 py-1 rounded bg-gray-100">{{ strtoupper($item->kode_tiket) }}</div>
            </div>
            <div class="text-sm text-gray-600">{{ ucfirst($item->kategori) }} • {{ ucfirst($item->status) }} • {{ $item->created_at->format('d M Y H:i') }}</div>
          </a>
        @endforeach
      </div>
      <div class="p-3">{{ $list->withQueryString()->links() }}</div>
    </section>
  </div>
  </div>
</div>
@endsection

