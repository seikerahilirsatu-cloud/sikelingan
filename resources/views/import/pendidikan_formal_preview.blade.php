@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
  <div class="mb-3">
    <a href="{{ route('import.pendidikan_formal.form', absolute: false) }}" class="text-sm text-gray-600">Kembali</a>
    <h1 class="text-2xl font-semibold">Preview Import Pendidikan Formal</h1>
  </div>
  <form method="post" action="{{ route('import.pendidikan_formal.commit', absolute: false) }}" class="bg-white p-4 rounded shadow">
    @csrf
    <input type="hidden" name="items" value='{{ json_encode($items) }}'>
    <div class="text-sm mb-2">Total baris: {{ count($items) }}</div>
    <div class="grid grid-cols-1 gap-3">
      @foreach($items as $i)
        <div class="border rounded p-3">
          <div class="text-xs">Aksi: <span class="font-medium">{{ $i['action'] }}</span></div>
          <div class="text-sm font-semibold">{{ $i['data']['nama_sekolah'] ?? '-' }}</div>
          <div class="text-xs text-gray-600">{{ $i['data']['alamat'] ?? '-' }}</div>
          <div class="text-xs text-gray-600">{{ $i['data']['jenjang'] ?? '-' }} • Jenis: {{ $i['data']['jenis_sekolah'] ?? '-' }} • Lkg: {{ $i['data']['lingkungan'] ?? '-' }}</div>
        </div>
      @endforeach
    </div>
    <div class="mt-3">
      <button class="w-full bg-green-600 text-white p-2 rounded">Commit Import</button>
    </div>
  </form>
</div>
@endsection

