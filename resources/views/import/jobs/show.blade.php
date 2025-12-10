@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-lg font-semibold mb-4">Detail Import #{{ $job->id }}</h1>
    <div class="bg-white rounded shadow p-4">
        <div class="mb-2"><strong>File:</strong> {{ $job->filename }}</div>
        <div class="mb-2"><strong>User ID:</strong> {{ $job->user_id }}</div>
        <div class="mb-2"><strong>Summary:</strong> Created: {{ $job->summary['created'] ?? 0 }}, Updated: {{ $job->summary['updated'] ?? 0 }}, Skipped: {{ $job->summary['skipped'] ?? 0 }}</div>
        <div class="mb-2"><strong>Errors:</strong></div>
        <pre class="text-xs bg-gray-50 p-2 rounded">{{ json_encode($job->errors, JSON_PRETTY_PRINT) }}</pre>
        <div class="mt-3"><a href="{{ route('import.jobs.download', $job->id) }}" class="inline-block bg-blue-600 text-white px-3 py-1 rounded">Download Errors</a></div>
    </div>
    @if(isset($is_mobile) && $is_mobile)
    <div class="mt-3"><a href="{{ route('import.jobs.index') }}" class="text-sm text-gray-600">Back</a></div>
    @endif
</div>
@endsection
