@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
  <div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-4">
      <a href="{{ route('admin.pengaduan.index') }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
        <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      </a>
      <div>
        <div class="text-lg font-semibold">Detail Pengaduan</div>
        <div class="text-xs text-gray-600">{{ strtoupper($p->kode_tiket) }}</div>
      </div>
    </div>

    <section class="rounded-xl bg-white shadow p-4 space-y-3">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <div class="text-sm text-gray-600">Status</div>
          <div class="text-base font-semibold">{{ ucfirst($p->status) }}</div>
        </div>
        <div>
          <div class="text-sm text-gray-600">Kategori</div>
          <div class="text-base font-semibold">{{ ucfirst($p->kategori) }}</div>
        </div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Judul</div>
        <div class="text-base font-semibold">{{ $p->judul }}</div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Isi</div>
        <div class="text-gray-700">{{ $p->isi }}</div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <div class="text-sm text-gray-600">Nama</div>
          <div class="text-gray-700">{{ $p->nama ?: '—' }}</div>
        </div>
        <div>
          <div class="text-sm text-gray-600">Kontak</div>
          <div class="text-gray-700">
            @if($p->kontak)
              @php $k = trim($p->kontak); $isEmail = filter_var($k, FILTER_VALIDATE_EMAIL); $isPhone = preg_match('/^[+0-9\s\-()]{6,}$/', $k); $tel = preg_replace('/[^+0-9]/','',$k); @endphp
              @if($isEmail)
                <a href="mailto:{{ $k }}" class="text-blue-600 hover:underline">{{ $k }}</a>
              @elseif($isPhone)
                <a href="tel:{{ $tel }}" class="text-blue-600 hover:underline">{{ $k }}</a>
              @else
                {{ $k }}
              @endif
            @else
              —
            @endif
          </div>
        </div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Lampiran</div>
        <div class="mt-1 grid grid-cols-2 sm:grid-cols-3 gap-3">
          @foreach(($p->lampiran ?? []) as $path)
            <a href="{{ Storage::url($path) }}" target="_blank" class="block rounded-lg border p-2 text-sm hover:bg-gray-50">{{ basename($path) }}</a>
          @endforeach
          @if(empty($p->lampiran))
            <div class="text-gray-700">—</div>
          @endif
        </div>
      </div>
      <div>
        <div class="text-sm text-gray-600">Catatan Publik</div>
        <div class="text-gray-700">{{ $p->public_notes ?: '—' }}</div>
      </div>
    </section>

    <form method="post" action="{{ route('admin.pengaduan.update', $p->id) }}" class="mt-4 rounded-xl bg-white shadow p-4 space-y-3">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div>
          <label class="text-sm text-gray-600">Ubah Status</label>
          <select name="status" class="mt-1 w-full rounded-lg border-gray-300">
            @foreach(['baru','diproses','selesai','ditolak'] as $s)
              <option value="{{ $s }}" {{ $p->status===$s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="text-sm text-gray-600">Catatan Penanganan</label>
          <input type="text" name="handled_notes" value="{{ old('handled_notes', $p->handled_notes) }}" class="mt-1 w-full rounded-lg border-gray-300">
        </div>
        <div>
          <label class="text-sm text-gray-600">Catatan Publik</label>
          <input type="text" name="public_notes" value="{{ old('public_notes', $p->public_notes) }}" class="mt-1 w-full rounded-lg border-gray-300">
        </div>
      </div>
      <div class="pt-2">
        <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">Simpan</button>
      </div>
    </form>
    @php $role = auth()->user()->role ?? null; $isAdmin = (method_exists(auth()->user(),'isAdmin') ? auth()->user()->isAdmin() : ($role === 'admin')); @endphp
    @if($isAdmin)
    <form method="POST" action="{{ route('admin.pengaduan.destroy', $p->id) }}" class="mt-2" onsubmit="return confirm('Hapus pengaduan {{ strtoupper($p->kode_tiket) }} — {{ addslashes($p->judul) }}?')">
      @csrf
      @method('DELETE')
      <button class="px-4 py-2 rounded-lg bg-red-600 text-white">Hapus Pengaduan</button>
    </form>
    @endif
  </div>
</div>
@endsection
