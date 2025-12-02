@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
        <h1 class="text-2xl font-semibold">Tambah Rumah Ibadah</h1>
    </div>
    <form method="post" action="{{ route('rumah_ibadah.store', absolute: false) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-3">
        @csrf
        <div>
            <label class="block text-sm">Nama</label>
            <input name="nama" value="{{ old('nama') }}" class="w-full p-2 border rounded" />
            @error('nama')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Jenis</label>
            <select name="jenis" class="w-full p-2 border rounded">
                @foreach(['Masjid','Gereja','Pura','Vihara','Klenteng','Mushalla','Lainnya'] as $j)
                    <option value="{{ $j }}">{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Alamat</label>
            <textarea name="alamat" class="w-full p-2 border rounded">{{ old('alamat') }}</textarea>
        </div>
        <div>
            <label class="block text-sm">Lingkungan</label>
            @php $opts = config('app_local.lingkungan_opts'); $defaultLkg = old('lingkungan') ?? (auth()->user()->lingkungan ?? ''); @endphp
            <select name="lingkungan" class="w-full p-2 border rounded">
                <option value="">Pilih Lingkungan</option>
                @foreach($opts as $l)
                    <option value="{{ $l }}" {{ $defaultLkg==$l ? 'selected':'' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Status Operasional</label>
                <select name="status_operasional" class="w-full p-2 border rounded">
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <div>
                <label class="block text-sm">Kapasitas</label>
                <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Tanggal Berdiri</label>
                <input type="date" name="tanggal_berdiri" value="{{ old('tanggal_berdiri') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Pengurus NIK</label>
                <input name="pengurus_nik" value="{{ old('pengurus_nik') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm">Kontak</label>
                <input name="kontak" value="{{ old('kontak') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Koordinat Lat</label>
                <input name="koordinat_lat" value="{{ old('koordinat_lat') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div>
            <label class="block text-sm">Koordinat Lng</label>
            <input name="koordinat_lng" value="{{ old('koordinat_lng') }}" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Photo Path</label>
            <input name="photo_path" value="{{ old('photo_path') }}" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Foto</label>
            <div class="flex items-center gap-2 mb-2">
                <button type="button" id="btnUseCamera" class="px-4 py-2 bg-gray-700 text-white rounded">Gunakan Kamera</button>
                <button type="button" id="btnCancelCamera" class="px-4 py-2 bg-gray-600 text-white rounded hidden">Batal Kamera</button>
            </div>
            <input type="file" id="photoFile" name="photo" accept="image/*" class="block w-full" />
            <div id="cameraBox" class="hidden space-y-2 mt-2">
                <video id="cameraVideo" autoplay playsinline class="w-full rounded bg-black"></video>
                <canvas id="cameraCanvas" class="hidden w-full rounded"></canvas>
                <div class="flex gap-2">
                    <button type="button" id="btnCapture" class="px-4 py-2 bg-green-600 text-white rounded">Ambil Foto</button>
                    <button type="button" id="btnRetake" class="px-4 py-2 bg-gray-600 text-white rounded hidden">Ulangi</button>
                </div>
            </div>
        </div>
        <div class="pt-2">
            <button class="w-full bg-blue-600 text-white p-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){
  var video=document.getElementById('cameraVideo');
  var canvas=document.getElementById('cameraCanvas');
  var btnCapture=document.getElementById('btnCapture');
  var btnRetake=document.getElementById('btnRetake');
  var btnUseCamera=document.getElementById('btnUseCamera');
  var btnCancelCamera=document.getElementById('btnCancelCamera');
  var fileInput=document.getElementById('photoFile');
  var cameraBox=document.getElementById('cameraBox');
  function start(){
    var fm={ideal:'environment'};
    navigator.mediaDevices.getUserMedia({video:{facingMode:fm}}).then(function(stream){
      video.srcObject=stream;
      cameraBox.classList.remove('hidden');
      fileInput.classList.add('hidden');
      btnUseCamera.classList.add('hidden');
      btnCancelCamera.classList.remove('hidden');
    }).catch(function(){
      cameraBox.classList.add('hidden');
      fileInput.classList.remove('hidden');
      btnUseCamera.classList.remove('hidden');
      btnCancelCamera.classList.add('hidden');
    });
  }
  function stop(){
    var s=video.srcObject; if(s&&s.getTracks){ s.getTracks().forEach(function(t){t.stop();}); }
    video.srcObject=null;
  }
  btnUseCamera.addEventListener('click',function(){ start(); });
  btnCancelCamera.addEventListener('click',function(){
    stop();
    cameraBox.classList.add('hidden');
    fileInput.classList.remove('hidden');
    btnUseCamera.classList.remove('hidden');
    btnCancelCamera.classList.add('hidden');
  });
  btnCapture.addEventListener('click',function(){
    var w=video.videoWidth||640; var h=video.videoHeight||480;
    canvas.width=w; canvas.height=h;
    var ctx=canvas.getContext('2d');
    ctx.drawImage(video,0,0,w,h);
    canvas.classList.remove('hidden');
    video.classList.add('hidden');
    btnRetake.classList.remove('hidden');
    btnCapture.classList.add('hidden');
    canvas.toBlob(function(blob){
      var file=new File([blob],'photo.jpg',{type:'image/jpeg'});
      var dt=new DataTransfer();
      dt.items.add(file);
      fileInput.files=dt.files;
    },'image/jpeg',0.92);
    stop();
  });
  btnRetake.addEventListener('click',function(){
    fileInput.value='';
    canvas.classList.add('hidden');
    video.classList.remove('hidden');
    btnRetake.classList.add('hidden');
    btnCapture.classList.remove('hidden');
  });
});
</script>
@endsection
