@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Manajemen Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded text-sm">
            Tambah Pengguna
        </a>
    </div>
    @if(session('success'))<div class="mb-3 p-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>@endif
    <div class="bg-white rounded shadow p-4">
        <table class="w-full text-sm">
            <thead><tr><th class="p-2 text-left">Nama</th><th class="p-2">Email</th><th class="p-2">Role</th><th class="p-2">Lingkungan</th><th class="p-2">Aksi</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr class="border-t">
                        <td class="p-2">@db($u->name)</td>
                        <td class="p-2">@db($u->email)</td>
                        <td class="p-2">@db($u->role)</td>
                        <td class="p-2">@db($u->lingkungan)</td>
                        <td class="p-2">
                            <form action="{{ route('admin.users.update', $u->id) }}" method="post" class="flex gap-2 items-center">
                                @csrf
                                @method('put')
                                <select name="role" class="p-1 border rounded">
                                    @foreach($roles as $r)
                                        <option value="{{ $r }}" {{ $u->role == $r ? 'selected' : '' }}>{{ $r }}</option>
                                    @endforeach
                                </select>
                                <select name="lingkungan" class="p-1 border rounded">
                                    <option value="">-</option>
                                    @foreach($lingkunganOptions as $ling)
                                        <option value="{{ $ling }}" {{ $u->lingkungan == $ling ? 'selected' : '' }}>{{ $ling }}</option>
                                    @endforeach
                                </select>
                                <button class="px-2 py-1 bg-blue-600 text-white rounded">Save</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
