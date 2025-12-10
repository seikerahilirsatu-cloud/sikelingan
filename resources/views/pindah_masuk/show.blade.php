@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    @if(isset($is_mobile) && $is_mobile)
    <a href="{{ route('pindah_masuk.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    @endif
    <h1 class="text-2xl font-semibold page-title">Detail Pindah Masuk</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
      <div><div class="text-gray-600">Warga</div><div class="font-medium">@db($item->warga?->nik) — @db($item->warga?->nama_lgkp ?? $item->warga?->nama)</div></div>
      <div><div class="text-gray-600">Family ID</div><div class="font-medium">@db($item->family_id)</div></div>
      <div><div class="text-gray-600">No. KK</div><div class="font-medium">@db($item->no_kk)</div></div>
      <div><div class="text-gray-600">Lingkungan</div><div class="font-medium">@db($item->lingkungan)</div></div>
      <div class="sm:col-span-2"><div class="text-gray-600">Alamat</div><div class="font-medium">@db($item->alamat)</div></div>
      <div><div class="text-gray-600">Tanggal Pindah Masuk</div><div class="font-medium">{{ optional($item->tanggal_masuk)->format('Y-m-d') }}</div></div>
      <div><div class="text-gray-600">Jenis Pindah Masuk</div><div class="font-medium">@db($item->jenis_masuk)</div></div>
      <div class="sm:col-span-2"><div class="text-gray-600">Daerah Asal</div><div class="font-medium">@db($item->asal)</div></div>
      <div class="sm:col-span-2"><div class="text-gray-600">Keterangan</div><div class="font-medium">@db($item->keterangan)</div></div>
      <div><div class="text-gray-600">Pencatat</div><div class="font-medium">@db($item->creator?->name)</div></div>
      <div><div class="text-gray-600">Dibuat</div><div class="font-medium">{{ $item->created_at }}</div></div>
      <div><div class="text-gray-600">Diperbarui</div><div class="font-medium">{{ $item->updated_at }}</div></div>
    </div>
    <div class="mt-4 flex gap-2">
      @if(isset($is_mobile) && $is_mobile)
      <a href="{{ route('pindah_masuk.index') }}" class="px-3 py-2 border rounded">Kembali</a>
      @endif
      <a href="{{ route('pindah_masuk.edit', $item) }}" data-modal="true" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
  </div>
</div>
@endsection
