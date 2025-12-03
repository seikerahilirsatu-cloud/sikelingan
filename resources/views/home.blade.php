@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-6">
    @php
        $totalWarga = \App\Models\BiodataWarga::count();
        $totalIbadah = \App\Models\RumahIbadah::count();
        $totalUmkm = \App\Models\Umkm::count();
        $totalFormal = \App\Models\PendidikanFormal::count();
        $totalNonFormal = \App\Models\PendidikanNonFormal::count();
    @endphp

    <section class="space-y-6">
        <div class="rounded-2xl shadow p-6 bg-gradient-to-b from-white to-indigo-50 text-gray-800">
            <div class="text-sm text-gray-600">Selamat Datang di Kelurahan Sei Kera Hilir I</div>
            <div class="text-xl font-semibold mt-1">Layanan administrasi dan informasi Kelurahan</div>
        </div>

        <div class="flex flex-wrap gap-4">
            <a href="#" class="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="mx-auto w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow ring-1 ring-white/30">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20Z" stroke-width="2" />
                        <path d="M12 8v8" stroke-width="2" stroke-linecap="round" />
                        <circle cx="12" cy="6" r="1.5" fill="currentColor" />
                    </svg>
                </div>
                <div class="mt-1 text-xs font-medium">Info Kelurahan</div>
            </a>
            <a href="#" class="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="mx-auto w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow ring-1 ring-white/30">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <rect x="7" y="8" width="10" height="10" rx="2" stroke-width="2" />
                        <rect x="9" y="5" width="6" height="3" rx="1" stroke-width="2" />
                        <path d="M9 11h6M9 14h6" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="mt-1 text-xs font-medium">Layanan Administrasi</div>
            </a>
            <a href="#" class="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="mx-auto w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white shadow ring-1 ring-white/30">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M12 4l8 14H4L12 4z" stroke-width="2" stroke-linejoin="round" />
                        <path d="M12 10v4" stroke-width="2" stroke-linecap="round" />
                        <circle cx="12" cy="16.5" r="1.2" fill="currentColor" />
                    </svg>
                </div>
                <div class="mt-1 text-xs font-medium">Pengaduan</div>
            </a>
            <a href="#" class="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="mx-auto w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white shadow ring-1 ring-white/30">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M5 5h14v10a2 2 0 0 1-2 2H9l-4 3V7a2 2 0 0 1 2-2z" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="mt-1 text-xs font-medium">Kontak</div>
            </a>
            <a href="#" class="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="mx-auto w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 text-white shadow ring-1 ring-white/30">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <rect x="5" y="7" width="14" height="11" rx="2" stroke-width="2" />
                        <path d="M8 4v4M16 4v4M5 11h14" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <div class="mt-1 text-xs font-medium">Agenda Kegiatan</div>
            </a>
            <a href="#" class="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
                <div class="mx-auto w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 text-white shadow ring-1 ring-white/30">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M12 5a5 5 0 0 1 5 5v4l1 2H6l1-2v-4a5 5 0 0 1 5-5z" stroke-width="2" stroke-linejoin="round" />
                        <circle cx="12" cy="19" r="1.8" fill="currentColor" />
                    </svg>
                </div>
                <div class="mt-1 text-xs font-medium">Informasi Penting</div>
            </a>
        </div>

        <section class="bg-white rounded-2xl shadow p-4">
            <div class="text-sm font-medium mb-2">Sei Kera Hilir I Dalam Angka</div>
            <div class="space-y-3">
            <a href="{{ route('stats.penduduk') }}#stat-penduduk" class="flex items-center gap-3 bg-white rounded-2xl shadow p-4 hover:bg-gray-50">
                <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-6 8v-1a6 6 0 0112 0v1H6z"/></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Total Penduduk</div>
                    <div class="text-2xl font-semibold mt-1">{{ number_format($totalWarga,0,',','.') }}</div>
                </div>
            </a>
            <a href="{{ route('stats.ibadah') }}#stat-ibadah" class="flex items-center gap-3 bg-white rounded-2xl shadow p-4 hover:bg-gray-50">
                <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l4 4v3h3v10H5V10h3V7l4-4z"/></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Rumah Ibadah</div>
                    <div class="text-2xl font-semibold mt-1">{{ number_format($totalIbadah,0,',','.') }}</div>
                </div>
            </a>
            <a href="{{ route('stats.umkm') }}#stat-umkm" class="flex items-center gap-3 bg-white rounded-2xl shadow p-4 hover:bg-gray-50">
                <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16l-1 5H5L4 7zm1 5v7h14v-7"/></svg>
                </div>
                <div>
                    <div class="text-sm text-gray-600">UMKM Terdaftar</div>
                    <div class="text-2xl font-semibold mt-1">{{ number_format($totalUmkm,0,',','.') }}</div>
                </div>
            </a>
            <a href="{{ route('stats.pendidikan') }}#stat-pendidikan" class="flex items-center gap-3 bg-white rounded-2xl shadow p-4 hover:bg-gray-50">
                <div class="h-12 w-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l9 5-9 5L3 8l9-5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13v6" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10v6a5 5 0 0010 0v-6" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Sarana Pendidikan</div>
                    <div class="text-2xl font-semibold mt-1">{{ number_format($totalFormal,0,',','.') }}</div>
                </div>
            </a>
            <a href="{{ route('stats.olahraga') }}#stat-olahraga" class="block bg-white rounded-2xl shadow p-4 hover:bg-gray-50">
                <div class="text-sm text-gray-600">Jumlah Sarana Olahraga</div>
                <div class="mt-2 inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-gradient-to-r from-amber-50 to-orange-100 text-amber-700 border border-amber-100 shadow-sm ring-1 ring-amber-100/50">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <svg class="w-5 h-5 text-amber-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l10 6-10 6L2 8 12 2z"/>
                        <path d="M3 13h18v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3z"/>
                        <path d="M7 18h10v2H7z"/>
                    </svg>
                    <span class="text-xs font-semibold">Under Construction</span>
                </div>
            </a>
            <a href="{{ route('stats.pasar') }}#stat-pasar" class="block bg-white rounded-2xl shadow p-4 hover:bg-gray-50">
                <div class="text-sm text-gray-600">Jumlah Pasar</div>
                <div class="mt-2 inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-gradient-to-r from-amber-50 to-orange-100 text-amber-700 border border-amber-100 shadow-sm ring-1 ring-amber-100/50">
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                    <svg class="w-5 h-5 text-amber-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l10 6-10 6L2 8 12 2z"/>
                        <path d="M3 13h18v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3z"/>
                        <path d="M7 18h10v2H7z"/>
                    </svg>
                    <span class="text-xs font-semibold">Under Construction</span>
                </div>
            </a>
            </div>
        </section>
        

        
    </section>

    <footer class="mt-8 bg-gradient-to-b from-white to-indigo-50 text-gray-700">
        <div>
            <div class="max-w-4xl mx-auto px-4 py-10 space-y-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 2a8 8 0 018 8c0 5-8 12-8 12S4 15 4 10a8 8 0 018-8zm0 11a3 3 0 100-6 3 3 0 000 6z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <div class="text-xl font-semibold text-gray-800">Kelurahan Sei Kera Hilir I</div>
                        <div class="text-sm text-gray-600">Kecamatan Medan Perjuangan</div>
                        <div class="text-sm text-gray-600 mt-3">Melayani masyarakat dengan sepenuh hati untuk kemajuan bersama dan kesejahteraan warga kelurahan.</div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 rounded-2xl bg-white/60 p-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414a4 4 0 10-1.414 1.414l4.243 4.243"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6a4 4 0 110 8 4 4 0 010-8z"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600">Alamat Kantor</div>
                            <div class="text-sm font-semibold text-gray-800">Jl. Pimpinan No. 79 Medan.</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl bg-white/60 p-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600">Email</div>
                            <div class="text-sm font-semibold text-gray-800">seikerahilirsatu@gmail.com</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-2xl bg-white/60 p-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v5l3 3"/><circle cx="12" cy="12" r="10" stroke-width="2"/></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600">Jam Pelayanan</div>
                            <div class="text-sm font-semibold text-gray-800">Senin - Jumat: 08.00 - 16.00 WIB</div>
                            <div class="text-xs text-gray-600">Sabtu - Minggu: Tutup</div>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="text-sm text-gray-600">Ikuti Kami</div>
                    <div class="flex items-center gap-3">
                        <a href="#" aria-label="Facebook" class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center hover:bg-indigo-50">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 10-11.6 9.9v-7H7.6V12h2.8V9.7c0-2.8 1.7-4.3 4.2-4.3 1.2 0 2.4.2 2.4.2v2.6h-1.3c-1.3 0-1.7.8-1.7 1.6V12h2.9l-.5 2.9h-2.4v7A10 10 0 0022 12z"/></svg>
                        </a>
                        <a href="#" aria-label="Instagram" class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center hover:bg-indigo-50">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="5" ry="5" stroke-width="2"></rect><circle cx="12" cy="12" r="4" stroke-width="2"></circle><circle cx="17" cy="7" r="1" fill="currentColor"></circle></svg>
                        </a>
                        <a href="#" aria-label="Twitter" class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center hover:bg-indigo-50">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 7.5v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83z"/></svg>
                        </a>
                        <a href="#" aria-label="YouTube" class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center hover:bg-indigo-50">
                            <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor"><path d="M10 15l5.19-3L10 9v6z"/><path d="M21.8 8s-.2-1.4-.8-2c-.8-.8-1.6-.8-2.1-.9C16.9 5 12 5 12 5s-4.9 0-6.9.1c-.5.1-1.3.1-2.1-.9-.6-.6-.8 2-.8 2S1 9.5 1 11v2c0 1.5.2 3 .2 3s.2 1.4.8 2c.8.8 1.8.8 2.2.9C6.9 19 12 19 12 19s4.9 0 6.9-.1c.5-.1 1.3-.1 2.1-.9.6-.6.8-2 .8-2s.2-1.5.2-3v-2c0-1.5-.2-3-.2-3z"/></svg>
                        </a>
                    </div>
                </div>

                <hr class="border-indigo-100 mt-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                    <div class="space-y-2 text-gray-700">
                        <a href="#" class="block">Tentang Kami</a>
                        <a href="#" class="block">Berita</a>
                        <a href="#" class="block">FAQ</a>
                    </div>
                    <div class="space-y-2 text-gray-700">
                        <a href="#" class="block">Layanan</a>
                        <a href="#" class="block">Pengaduan</a>
                        <a href="#" class="block">Kontak</a>
                    </div>
                </div>
            </div>
            <div class="bg-indigo-50 text-center text-indigo-700 text-sm px-4 py-6">
                <div>© {{ date('Y') }} Kelurahan Sei Kera Hilir I. All rights reserved.</div>
                <div class="mt-1">Dikembangkan dengan <span class="text-red-500">❤️</span> untuk melayani masyarakat</div>
            </div>
        </div>
    </footer>
</div>

 
@endsection
