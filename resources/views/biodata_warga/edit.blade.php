@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ url()->previous() }}" onclick="event.preventDefault(); window.history.back();" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-semibold">Edit Data Warga</h1>
    </div>
    <form method="post" action="{{ route('biodata_warga.update', $resident) }}" class="bg-white shadow-md rounded-lg p-6 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">No. KK</label>
                <div class="flex gap-2">
                    <select name="family_id" class="flex-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                        <option value="">-- Pilih KK --</option>
                        @foreach($families as $f)
                            <option value="{{ $f->id }}" data-lingkungan="{{ $f->lingkungan }}" {{ $resident->family_id == $f->id ? 'selected':'' }}>{{ $f->no_kk }} — {{ $f->nama_kep }}</option>
                        @endforeach
                    </select>
                    <input name="no_kk" value="{{ old('no_kk',$resident->no_kk) }}" class="w-40 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Lingkungan</label>
                @php $opts = config('app_local.lingkungan_opts'); $defaultLkg = old('lingkungan', $resident->lingkungan ?? (auth()->user()->lingkungan ?? '')); @endphp
                <select name="lingkungan" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Pilih Lingkungan</option>
                    @foreach($opts as $l)
                        <option value="{{ $l }}" {{ $defaultLkg==$l ? 'selected':'' }}>{{ $l }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input name="nik" value="{{ old('nik',$resident->nik) }}" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input name="nama_lgkp" value="{{ old('nama_lgkp',$resident->nama_lgkp) }}" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Pilih...</option>
                    <option value="L" {{ $resident->jenis_kelamin=='L'?'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ $resident->jenis_kelamin=='P'?'selected':'' }}>Perempuan</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tgl_lhr" value="{{ old('tgl_lhr',$resident->tgl_lhr) }}" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Pilih...</option>
                    @foreach(config('biodata_config.agama') as $a)
                        <option value="{{ $a }}" {{ old('agama',$resident->agama)==$a ? 'selected':'' }}>{{ $a }}</option>
                    @endforeach
                </select>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tmpt_lahir" value="{{ old('tmpt_lahir', $resident->tmpt_lahir) }}" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                <select name="pendidikan_terakhir" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Pilih...</option>
                    @foreach(config('biodata_config.pendidikan_terakhir') as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_terakhir',$resident->pendidikan_terakhir)==$p ? 'selected':'' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <select name="pekerjaan" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Pilih...</option>
                    @foreach(config('biodata_config.pekerjaan') as $p)
                        <option value="{{ $p }}" {{ old('pekerjaan',$resident->pekerjaan)==$p ? 'selected':'' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status Kawin</label>
                <select name="stts_kawin" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">Pilih...</option>
                    @foreach(config('biodata_config.stts_kawin') as $s)
                        <option value="{{ $s }}" {{ old('stts_kawin',$resident->stts_kawin)==$s ? 'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Hubungan Dalam Keluarga</label>
            <select name="stts_hub_keluarga" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                <option value="">Pilih...</option>
                @foreach(config('biodata_config.stts_hub_keluarga') as $h)
                    <option value="{{ $h }}" {{ old('stts_hub_keluarga',$resident->stts_hub_keluarga)==$h ? 'selected':'' }}>{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('biodata_warga.index') }}" class="flex-1 text-center py-2 border border-gray-300 rounded-lg">Batal</a>
            <button class="flex-1 py-2 bg-indigo-600 text-white rounded-lg">Perbarui Warga</button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var fam = document.querySelector('select[name="family_id"]');
  var lkg = document.querySelector('select[name="lingkungan"]');
  function sync(){
    if (!fam || !lkg) return;
    var val = fam.value;
    if (val) {
      var opt = fam.options[fam.selectedIndex];
      var lk = opt && opt.getAttribute('data-lingkungan');
      if (lk) { lkg.value = lk; }
      lkg.disabled = true;
    } else {
      lkg.disabled = false;
    }
  }
  sync();
  if (fam) fam.addEventListener('change', sync);
});
</script>
@endsection
