@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold">Buat Pengguna Baru</h1>
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600">Kembali</a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('admin.users.store') }}" class="bg-white shadow rounded p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm">Nama</label>
            <input name="name" value="{{ old('name') }}" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Email</label>
            <input name="email" value="{{ old('email') }}" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Password</label>
            <input name="password" type="password" class="w-full p-2 border rounded" />
        </div>
        <div>
            <label class="block text-sm">Role</label>
            <select name="role" class="w-full p-2 border rounded">
                @foreach($roles as $r)
                    <option value="{{ $r }}" {{ old('role') == $r ? 'selected' : '' }}>{{ $r }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Lingkungan (opsional)</label>
            <select name="lingkungan" class="w-full p-2 border rounded">
                <option value="">-</option>
                @foreach($lingkunganOptions as $ling)
                    <option value="{{ $ling }}" {{ old('lingkungan') == $ling ? 'selected' : '' }}>{{ $ling }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="flex-1 text-center py-2 border rounded">Batal</a>
            <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded">Buat Pengguna</button>
        </div>
    </form>
</div>
@endsection
