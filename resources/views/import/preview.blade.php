@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div>
    <h3 class="mb-3 font-medium">Preview Import</h3>
    <form method="post" action="{{ route('import.commit') }}">
        @csrf
        <div class="overflow-auto bg-white rounded p-2">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left"><th class="p-1">Do</th><th class="p-1">Status</th><th class="p-1">NIK</th><th class="p-1">No KK</th><th class="p-1">Nama</th><th class="p-1">Errors</th></tr>
                </thead>
                <tbody>
                    @foreach($preview as $i => $p)
                        <?php $r = $p['row']; ?>
                        <tr class="border-t align-top">
                            <td class="p-1">
                                <input type="checkbox" name="do[{{ $i }}]" value="1" {{ empty($p['skip']) ? 'checked' : '' }} />
                            </td>
                            <td class="p-1">{{ $p['status'] }}</td>
                            <td class="p-1">{{ $r['nik'] ?? '' }}</td>
                            <td class="p-1">{{ $r['no_kk'] ?? '' }}</td>
                            <td class="p-1">{{ $r['nama_lgkp'] ?? $r['nama'] ?? '' }}</td>
                            <td class="p-1 text-xs text-red-600">
                                @if(!empty($p['errors']))
                                    {{ implode(', ', $p['errors']) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-3">
            <button class="w-full bg-green-600 text-white p-2 rounded">Commit Import</button>
        </div>
    </form>
</div>
@endsection
