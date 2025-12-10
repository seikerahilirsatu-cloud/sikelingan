@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-4">
    @if(isset($is_mobile) && $is_mobile)
    <a href="{{ route('biodata_warga.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
    @endif
    <h1 class="text-2xl font-semibold">Detail Data Warga (@db($resident->nik) - @db($resident->nama_lgkp))</h1>
  </div>

  <div class="bg-white rounded-2xl shadow p-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div><div class="text-sm text-gray-600">ID</div><div class="text-base font-semibold">@db($resident->id)</div></div>
      <div><div class="text-sm text-gray-600">Family ID</div><div class="text-base font-semibold">@db($resident->family_id)</div></div>
      <div><div class="text-sm text-gray-600">No. KK</div><div class="text-base font-semibold">@db($resident->no_kk)</div></div>
      <div><div class="text-sm text-gray-600">Lingkungan</div><div class="text-base font-semibold">@db($resident->lingkungan ?? ($resident->family?->lingkungan ?? ''))</div></div>
      <div class="sm:col-span-2"><div class="text-sm text-gray-600">Alamat</div><div class="text-base font-semibold">@db($resident->alamat)</div></div>
      <div><div class="text-sm text-gray-600">NIK</div><div class="text-base font-semibold">@db($resident->nik)</div></div>
      <div><div class="text-sm text_gray-600">Nama Lengkap</div><div class="text-base font-semibold">@db($resident->nama_lgkp)</div></div>
      <div><div class="text-sm text-gray-600">Jenis Kelamin</div><div class="text-base font-semibold">@db($resident->jenis_kelamin)</div></div>
      <div><div class="text-sm text-gray-600">Tempat Lahir</div><div class="text-base font-semibold">@db($resident->tmpt_lahir)</div></div>
      <div><div class="text-sm text-gray-600">Tanggal Lahir</div><div class="text-base font-semibold">@db($resident->tgl_lhr)</div></div>
      <div><div class="text-sm text-gray-600">Agama</div><div class="text-base font-semibold">@db($resident->agama)</div></div>
      <div><div class="text-sm text-gray-600">Pendidikan Terakhir</div><div class="text-base font-semibold">@db($resident->pendidikan_terakhir)</div></div>
      <div><div class="text-sm text-gray-600">Pekerjaan</div><div class="text-base font-semibold">@db($resident->pekerjaan)</div></div>
      <div><div class="text-sm text-gray-600">Status Kawin</div><div class="text-base font-semibold">@db($resident->stts_kawin)</div></div>
      <div><div class="text-sm text-gray-600">Hubungan Keluarga</div><div class="text-base font-semibold">@db($resident->stts_hub_keluarga)</div></div>
      <div><div class="text-sm text-gray-600">Status Warga</div><div class="text-base font-semibold">@db($resident->status_warga)</div></div>
      <div><div class="text-sm text-gray-600">Flag Status</div><div class="text-base font-semibold">@db($resident->flag_status)</div></div>
      <div><div class="text-sm text-gray-600">Created By</div><div class="text-base font-semibold">@db($resident->created_by)</div></div>
      <div><div class="text-sm text-gray-600">Updated By</div><div class="text-base font-semibold">@db($resident->updated_by)</div></div>
      <div><div class="text-sm text-gray-600">Dibuat</div><div class="text-base font-semibold">{{ $resident->created_at }}</div></div>
      <div><div class="text-sm text-gray-600">Diperbarui</div><div class="text-base font-semibold">{{ $resident->updated_at }}</div></div>
    </div>
    <div class="mt-4 flex gap-2">
      @if(isset($is_mobile) && $is_mobile)
      <a href="{{ route('biodata_warga.index') }}" class="px-3 py-2 border rounded">Kembali</a>
      @endif
      <a href="{{ route('biodata_warga.edit', $resident) }}" data-modal="true" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
    </div>
  </div>
</div>
@endsection
