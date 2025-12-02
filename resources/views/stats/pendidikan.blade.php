@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-4" id="stat-pendidikan">
  <header class="flex items-center gap-3">
    <a href="{{ url()->previous() }}" class="p-2 rounded bg-gray-100" aria-label="Kembali">
      <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <div class="text-lg font-semibold">Statistik Sarana Pendidikan</div>
      <div class="text-xs text-gray-600">Halaman dalam pengembangan</div>
    </div>
  </header>

  <section class="bg-white rounded-2xl shadow p-6">
    <div class="flex flex-col items-center text-center gap-3">
      <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center ring-1 ring-amber-200">
        <svg class="w-10 h-10 text-amber-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
          <path d="M12 2l10 6-10 6L2 8 12 2z"/>
          <path d="M3 13h18v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3z"/>
          <path d="M7 18h10v2H7z"/>
        </svg>
      </div>
      <div class="text-base font-semibold text-amber-700">Under Construction</div>
      <div class="text-sm text-gray-600">Konten statistik sarana pendidikan sedang disiapkan.</div>
    </div>
  </section>
</div>
@endsection
