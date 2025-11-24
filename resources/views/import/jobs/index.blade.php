@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-lg font-semibold mb-4">Riwayat Import</h1>
    <div class="bg-white rounded shadow">
        <table class="w-full text-sm">
            <thead><tr><th class="p-2">ID</th><th class="p-2">File</th><th class="p-2">User</th><th class="p-2">Summary</th><th class="p-2">Waktu</th><th class="p-2">Aksi</th></tr></thead>
            <tbody>
                @foreach($jobs as $j)
                    <tr class="border-t">
                        <td class="p-2">{{ $j->id }}</td>
                        <td class="p-2">{{ $j->filename }}</td>
                        <td class="p-2">{{ $j->user_id ?? '-' }}</td>
                        <td class="p-2">@php $s = json_decode($j->summary,true) ?? []; echo 'C:'.($s['created']??0).' U:'.($s['updated']??0).' S:'.($s['skipped']??0); @endphp</td>
                        <td class="p-2">{{ $j->created_at }}</td>
                        <td class="p-2"><a href="{{ route('import.jobs.show', $j->id) }}" class="text-blue-600">Detail</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $jobs->links() }}</div>
</div>
@endsection
