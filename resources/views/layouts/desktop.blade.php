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
                <a href="{{ route('dashboard', absolute: false) }}" class="block text-blue-600">Dashboard</a>
                <a href="{{ route('data_keluarga.index', absolute: false) }}" class="block">Data Keluarga</a>
                <a href="{{ route('biodata_warga.index', absolute: false) }}" class="block">Data Warga</a>
                <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="block">Rumah Ibadah</a>
                <a href="{{ route('umkm.index', absolute: false) }}" class="block">UMKM</a>
                <a href="{{ route('pindah_keluar.index') }}" class="block">Pindah Keluar</a>
                <a href="{{ route('pindah_masuk.index') }}" class="block">Pindah Masuk</a>
                <a href="{{ route('warga_meninggal.index') }}" class="block">Data Kematian</a>
                @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                @if($canAdminOps)
                    <a href="{{ route('import.form', absolute: false) }}" class="block">Import</a>
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
                        <h1 class="ms-3 text-2xl font-bold hidden lg:block">@yield('title', config('app.name'))</h1>
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
