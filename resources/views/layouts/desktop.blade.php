<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('app.name','Kelurahan') }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
    @endif
</head>
<body class="bg-gray-50 text-gray-800">
    
    <div class="min-h-screen max-w-7xl mx-auto grid grid-cols-12 gap-6">
        <aside class="col-span-3 hidden lg:block bg-white border-r p-4 min-h-screen sticky top-0">
            <h2 class="text-lg font-semibold mb-4">{{ config('app.name','Kelurahan') }}</h2>
            <nav class="space-y-2 text-sm">
                <a href="{{ route('dashboard', absolute: false) }}" class="inline-flex items-center gap-2 text-blue-600">
                    <svg class="h-4 w-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z" /></svg>
                    <span>Dashboard</span>
                </a>
                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer px-2 py-1 rounded hover:bg-gray-50">
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="8" r="3" stroke-width="2"/><path stroke-width="2" d="M6 19v-1a6 6 0 0112 0v1"/></svg>
                            <span>Data Kependudukan</span>
                        </span>
                        <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                    </summary>
                    <div class="mt-2 ms-4 space-y-1">
                        <a href="{{ route('data_keluarga.index', absolute: false) }}" class="block">Kartu Keluarga</a>
                        <a href="{{ route('biodata_warga.index', absolute: false) }}" class="block">Data Individu</a>
                        <a href="{{ route('pindah_keluar.index') }}" class="block">Pindah Keluar</a>
                        <a href="{{ route('pindah_masuk.index') }}" class="block">Pindah Masuk</a>
                        <a href="{{ route('warga_meninggal.index') }}" class="block">Data Kematian</a>
                        @if(auth()->check() && in_array(auth()->user()->role ?? null, ['admin','staff']))
                            <a href="{{ route('stats.mutasi', absolute: false) }}" class="block">Laporan Mutasi Penduduk</a>
                        @endif
                    </div>
                </details>
                <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l7 5v7a5 5 0 11-10 0V7l3-5z" /></svg>
                    <span>Rumah Ibadah</span>
                </a>
                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer px-2 py-1 rounded hover:bg-gray-50">
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l9 5-9 5L3 8l9-5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13v6" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10v6a5 5 0 0010 0v-6" /></svg>
                            <span>Sarana Pendidikan</span>
                        </span>
                        <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                    </summary>
                    <div class="mt-2 ms-4 space-y-1">
                        <a href="{{ route('pendidikan_formal.index', absolute: false) }}" class="block">Formal</a>
                        <a href="{{ route('pendidikan_non_formal.index', absolute: false) }}" class="block">Non-Formal</a>
                    </div>
                </details>
                <a href="{{ route('umkm.index', absolute: false) }}" class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 11h16M6 15h12v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" /></svg>
                    <span>UMKM</span>
                </a>
                <a href="{{ route('kelurahan.info', absolute: false) }}" class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8h.01M11 12h2v4h-2z"/></svg>
                    <span>Info Kelurahan</span>
                </a>
                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer px-2 py-1 rounded hover:bg-gray-50">
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M5.07 19h13.86A2 2 0 0021 17.07V6.93A2 2 0 0018.93 5H5.07A2 2 0 003 6.93v10.14A2 2 0 005.07 19z"/></svg>
                            <span>Pengaduan Warga</span>
                        </span>
                        <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                    </summary>
                    <div class="mt-2 ms-4 space-y-1">
                        <a href="{{ route('pengaduan.create', absolute: false) }}" class="block">Ajukan Pengaduan</a>
                        <a href="{{ route('pengaduan.cek', absolute: false) }}" class="block">Cek Status Pengaduan</a>
                        @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                        @if($canAdminOps)
                            <a href="{{ route('admin.pengaduan.index', absolute: false) }}" class="block">Admin Pengaduan</a>
                        @endif
                    </div>
                </details>
                @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                @if($canAdminOps)
                <details class="group">
                    <summary class="flex items-center justify-between cursor-pointer px-2 py-1 rounded hover:bg-gray-50">
                        <span class="flex items-center gap-2 font-medium">
                            <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4-4-4M21 21H3" /></svg>
                            <span>Export/Import Data</span>
                        </span>
                        <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                    </summary>
                    <div class="mt-2 ms-4 space-y-1">
                        <a href="{{ route('export.index', absolute: false) }}" class="block">Export</a>
                        <a href="{{ route('import.form', absolute: false) }}" class="block">Import</a>
                    </div>
                </details>
                @endif
                @if(auth()->check() && method_exists(auth()->user(),'isAdmin') && auth()->user()->isAdmin())
               
                    <a href="{{ route('admin.users.index', absolute: false) }}" class="block">Manajemen Pengguna</a>
               
                @endif
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="block text-red-600 hover:text-red-800">Logout</button>
                    </form>
                @endauth
               
            </nav>
        </aside>

        <main class="col-span-12 lg:col-span-9 p-6">
            <header class="mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard', absolute: false) }}">
                            <x-application-logo class="h-8" />
                        </a>
                        
                </div>
                <a href="{{ route('dashboard', absolute: false) }}" class="text-sm text-blue-600" aria-label="Dashboard">
                    <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z" />
                    </svg>
                        <span class="sr-only">Dashboard</span>
                    </a>
                </div>
            </header>

            @if(session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
