@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('umkm.index', absolute: false) }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 mb-2">Kembali</a>
        <h1 class="text-2xl font-semibold">Tambah UMKM</h1>
    </div>
    <form method="post" action="{{ route('umkm.store', absolute: false) }}" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6 space-y-3">
        @csrf
        <div>
            <label class="block text-sm">Nama Usaha</label>
            <input name="nama_usaha" value="{{ old('nama_usaha') }}" class="w-full p-2 border rounded" />
            @error('nama_usaha')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm">Jenis</label>
            @php $jenisOpts = config('app_local.umkm_jenis', []); @endphp
            <select name="jenis" class="w-full p-2 border rounded">
                <option value="">Pilih Jenis Usaha</option>
                @foreach($jenisOpts as $j)
                    <option value="{{ $j }}" {{ old('jenis')==$j?'selected':'' }}>{{ $j }}</option>
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
        <div>
            <label class="block text-sm">Status Operasional</label>
            <input name="status_operasional" value="{{ old('status_operasional') }}" class="w-full p-2 border rounded" />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block text-sm">Pemilik NIK</label>
                <input name="pemilik_nik" value="{{ old('pemilik_nik') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">NPWP Pemilik</label>
                <input name="npwp_pemilik" value="{{ old('npwp_pemilik') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">No NIB</label>
                <input name="no_nib" value="{{ old('no_nib') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div>
            <label class="block text-sm">Kontak</label>
            <input name="kontak" value="{{ old('kontak') }}" class="w-full p-2 border rounded" />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm">Tanggal Berdiri</label>
                <input type="date" name="tanggal_berdiri" value="{{ old('tanggal_berdiri') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Omzet</label>
                <input name="omzet" type="number" step="0.01" value="{{ old('omzet') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm">Koordinat Lat</label>
                <input name="koordinat_lat" value="{{ old('koordinat_lat') }}" class="w-full p-2 border rounded" />
            </div>
            <div>
                <label class="block text-sm">Koordinat Lng</label>
                <input name="koordinat_lng" value="{{ old('koordinat_lng') }}" class="w-full p-2 border rounded" />
            </div>
        </div>
        
        <div>
            <label class="block text-sm">Foto</label>
            <div class="flex items-center gap-2 mb-2">
                <button type="button" id="btnUseCameraUmkm" class="px-4 py-2 bg-gray-700 text-white rounded">Gunakan Kamera</button>
                <button type="button" id="btnCancelCameraUmkm" class="px-4 py-2 bg-gray-600 text-white rounded hidden">Batal Kamera</button>
            </div>
            <input type="file" id="photoFileUmkm" name="photo" accept="image/*" class="block w-full" />
            <div id="cameraBoxUmkm" class="hidden space-y-2 mt-2">
                <video id="cameraVideoUmkm" autoplay playsinline class="w-full rounded bg-black"></video>
                <canvas id="cameraCanvasUmkm" class="hidden w-full rounded"></canvas>
                <div class="flex gap-2">
                    <button type="button" id="btnCaptureUmkm" class="px-4 py-2 bg-green-600 text-white rounded">Ambil Foto</button>
                    <button type="button" id="btnRetakeUmkm" class="px-4 py-2 bg-gray-600 text-white rounded hidden">Ulangi</button>
                </div>
            </div>
        </div>
        <button class="w-full bg-blue-600 text-white p-2 rounded">Simpan</button>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){
  var video=document.getElementById('cameraVideoUmkm');
  var canvas=document.getElementById('cameraCanvasUmkm');
  var btnCapture=document.getElementById('btnCaptureUmkm');
  var btnRetake=document.getElementById('btnRetakeUmkm');
  var btnUseCamera=document.getElementById('btnUseCameraUmkm');
  var btnCancelCamera=document.getElementById('btnCancelCameraUmkm');
  var fileInput=document.getElementById('photoFileUmkm');
  var cameraBox=document.getElementById('cameraBoxUmkm');
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
