@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    <a href="{{ route('warga_meninggal.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    <h1 class="text-2xl font-semibold">Detail Warga Meninggal</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
      <div><div class="text-gray-600">Warga</div><div class="font-medium">@db($item->warga?->nik) — @db($item->warga?->nama_lgkp ?? $item->warga?->nama)</div></div>
      <div><div class="text-gray-600">Family ID</div><div class="font-medium">@db($item->family_id)</div></div>
      <div><div class="text-gray-600">No. KK</div><div class="font-medium">@db($item->no_kk)</div></div>
      <div><div class="text-gray-600">Lingkungan</div><div class="font-medium">@db($item->lingkungan)</div></div>
      <div class="sm:col-span-2"><div class="text-gray-600">Alamat</div><div class="font-medium">@db($item->alamat)</div></div>
      <div><div class="text-gray-600">Tanggal Meninggal</div><div class="font-medium">{{ optional($item->tanggal_meninggal)->format('Y-m-d') }}</div></div>
      <div><div class="text-gray-600">Waktu Meninggal</div><div class="font-medium">@db($item->waktu_meninggal)</div></div>
      <div><div class="text-gray-600">Tempat Meninggal</div><div class="font-medium">@db($item->tempat_meninggal)</div></div>
      <div><div class="text-gray-600">Sebab Meninggal</div><div class="font-medium">@db($item->sebab_meninggal)</div></div>
      <div><div class="text-gray-600">Tanggal Dikebumikan</div><div class="font-medium">{{ optional($item->tanggal_dikebumikan)->format('Y-m-d') }}</div></div>
      <div class="sm:col-span-2"><div class="text-gray-600">Keterangan</div><div class="font-medium">@db($item->keterangan)</div></div>
      <div><div class="text-gray-600">Pencatat</div><div class="font-medium">@db($item->creator?->name)</div></div>
      <div><div class="text-gray-600">Dibuat</div><div class="font-medium">{{ $item->created_at }}</div></div>
      <div><div class="text-gray-600">Diperbarui</div><div class="font-medium">{{ $item->updated_at }}</div></div>
    </div>
    <div class="mt-4">
      <a href="{{ route('warga_meninggal.edit', $item) }}" class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
    </div>
  </div>
</div>
@endsection
