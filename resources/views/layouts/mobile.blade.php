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
    <style>
      @media (max-width: 640px) {
        .page-title{font-size:.875rem!important;line-height:1.25rem!important}
      }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-200 via-sky-200 to-cyan-200 text-gray-800">
    
    <div class="min-h-screen max-w-lg mx-auto" x-data="{open:false}">
        <header class="bg-gray-100 text-gray-800 p-4 shadow sticky top-0 z-10 backdrop-blur-sm">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <a href="{{ route('dashboard', absolute: false) }}">
                  <x-application-logo class="h-8" />
                </a>
              </div>
              @auth
              <button type="button" class="text-sm text-gray-700" aria-label="Menu" @click="open=!open">
                <svg class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Menu</span>
              </button>
              @endauth
              @guest
              @if (Route::has('login') && request()->is('/'))
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-gradient-to-r from-indigo-200 to-cyan-200 text-gray-900 ring-1 ring-gray-300 shadow hover:from-indigo-300 hover:to-cyan-300 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-300/50" aria-label="Login">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h10a2 2 0 012 2v12a2 2 0 01-2 2H4" />
                    <circle cx="8" cy="12" r="1" fill="currentColor" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12l-4-4m4 4l-4 4M9 12h12" />
                  </svg>
                  <span class="sr-only">Login</span>
                </a>
              @endif
              @endguest
            </div>
        </header>

        <div x-show="open" class="fixed inset-0 z-30" x-cloak>
            <div class="absolute inset-0 bg-black/40" @click="open=false"></div>
            <div class="absolute top-0 right-0 bottom-0 w-80 bg-gradient-to-b from-indigo-50 via-sky-50 to-cyan-50 text-gray-800 shadow-xl border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-base font-semibold">{{ config('app.name','Kelurahan') }}</div>
                    <button type="button" class="p-1" aria-label="Tutup" @click="open=false">
                        <svg class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6"/></svg>
                    </button>
                </div>
                <nav class="space-y-2 text-sm">
                    @php $isDash = request()->routeIs('dashboard'); @endphp
                    <a href="{{ route('dashboard', absolute: false) }}" @click="open=false"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $isDash ? 'bg-gradient-to-r from-indigo-200 to-cyan-200 text-gray-900 shadow ring-1 ring-gray-300' : 'text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40' }}">
                        <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                          <svg class="w-5 h-5 {{ $isDash ? 'text-gray-900' : 'text-gray-700' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 9.75L12 3l9 6.75V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V9.75z" /></svg>
                        </span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('kelurahan.info', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                      <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8h.01M11 12h2v4h-2z"/></svg></span>
                      <span class="font-medium">Info Kelurahan</span>
                    </a>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5">
                            <span class="font-medium">Data Kependudukan</span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="mt-1 ms-4 space-y-1">
                        <a href="{{ route('data_keluarga.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                          <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="8" r="3" stroke-width="2"/><path stroke-width="2" d="M6 19v-1a6 6 0 0112 0v1"/></svg>
                          </span>
                          <span class="font-medium">Data Keluarga</span>
                        </a>
                        <a href="{{ route('biodata_warga.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                          <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-4 0-6 2-6 4v2h12v-2c0-2-2-4-6-4z" /></svg>
                          </span>
                          <span class="font-medium">Data Warga</span>
                        </a>
                        <a href="{{ route('pindah_keluar.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                          <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h7m0 0l-3-3m3 3l-3 3M3 13h13a4 4 0 014 4v2H3v-6z" /></svg>
                          </span>
                          <span class="font-medium">Pindah Keluar</span>
                        </a>
                        <a href="{{ route('pindah_masuk.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                          <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 7h7m0 0l-3-3m3 3l-3 3M3 13h13a4 4 0 014 4v2H3v-6z" /></svg>
                          </span>
                          <span class="font-medium">Pindah Masuk</span>
                        </a>
                        <a href="{{ route('warga_meninggal.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                          <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M5.07 19h13.86A2 2 0 0021 17.07V6.93A2 2 0 0018.93 5H5.07A2 2 0 003 6.93v10.14A2 2 0 005.07 19z" /></svg>
                          </span>
                          <span class="font-medium">Data Kematian</span>
                        </a>
                        @if(auth()->check() && in_array(auth()->user()->role ?? null, ['admin','staff']))
                        <a href="{{ route('stats.mutasi', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                          <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center">
                            <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 11h16M6 15h12v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" /></svg>
                          </span>
                          <span class="font-medium">Laporan Mutasi Penduduk</span>
                        </a>
                        @endif
                        </div>
                    </details>

                    <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                      <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l7 5v7a5 5 0 11-10 0V7l3-5z" /></svg></span>
                      <span class="font-medium">Rumah Ibadah</span>
                    </a>
                    <a href="{{ route('umkm.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                      <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 11h16M6 15h12v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" /></svg></span>
                      <span class="font-medium">UMKM</span>
                    </a>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5">
                            <span class="font-medium">Pengaduan Warga</span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="mt-1 ms-4 space-y-1">
                            <a href="{{ route('pengaduan.create', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                              <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M5.07 19h13.86A2 2 0 0021 17.07V6.93A2 2 0 0018.93 5H5.07A2 2 0 003 6.93v10.14A2 2 0 005.07 19z" /></svg></span>
                              <span class="font-medium">Ajukan Pengaduan</span>
                            </a>
                            <a href="{{ route('pengaduan.cek', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                              <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></span>
                              <span class="font-medium">Cek Status Pengaduan</span>
                            </a>
                        @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                        @if($canAdminOps)
                                <a href="{{ route('admin.pengaduan.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                                  <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v12H4zM4 20h16" /></svg></span>
                                  <span class="font-medium">Admin Pengaduan</span>
                                </a>
                        @endif
                        </div>
                    </details>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5">
                            <span class="font-medium">Sarana Pendidikan</span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="mt-1 ms-4 space-y-1">
                            <a href="{{ route('pendidikan_formal.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                              <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 3l9 5-9 5L3 8l9-5z" /></svg></span>
                              <span class="font-medium">Formal</span>
                            </a>
                            <a href="{{ route('pendidikan_non_formal.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                              <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 10v6a5 5 0 0010 0v-6" /></svg></span>
                              <span class="font-medium">Non-Formal</span>
                            </a>
                        </div>
                    </details>

                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false">
                              <span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 12l4-4m0 0l-4-4m4 4H6m6 4v8a2 2 0 11-4 0v-8" /></svg></span>
                              <span class="font-medium">Login</span>
                            </a>
                        @endif
                    @endguest

                    @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                    @if($canAdminOps)
                        <details class="group">
                            <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5">
                                <span class="font-medium">Export/Import Data</span>
                                <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                            </summary>
                            <div class="mt-1 ms-4 space-y-1">
                                <a href="{{ route('export.index', absolute: false) }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false"><span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4-4-4M21 21H3" /></svg></span><span class="font-medium">Export</span></a>
                                <a href="{{ route('import.form', absolute: false) ?? url('/import') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-gray-800 hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-indigo-300/40" @click="open=false"><span class="w-8 h-8 rounded-lg bg-black/5 grid place-items-center"><svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21V9m0 0l4 4m-4-4l-4 4M21 3H3" /></svg></span><span class="font-medium">Import</span></a>
                            </div>
                        </details>
                    @endif
                    @if(auth()->check() && method_exists(auth()->user(),'isAdmin') && auth()->user()->isAdmin())
                        <a href="{{ route('admin.users.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Manajemen Pengguna</a>
                    @endif
                    @auth
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Logout</button>
                    </form>
                    @endauth
                </nav>
            </div>
        </div>

        <main class="p-4 {{ auth()->check() ? 'pb-24' : '' }}" @if(auth()->check()) style="padding-bottom: calc(env(safe-area-inset-bottom) + 6rem);" @endif>
            @if(session('success'))
                <div class="mb-3 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>

        

        @auth
        <nav class="fixed bottom-0 left-0 right-0 bg-gray-100 border-t border-gray-200 shadow z-20 backdrop-blur-sm" role="navigation" aria-label="Bottom Navigation">
          <div class="max-w-screen-lg mx-auto overflow-x-auto">
            <div class="flex gap-2 min-w-max px-2 py-1">
              <a href="{{ route('data_keluarga.index', absolute: false) }}" aria-label="Keluarga"
                 @php $is = request()->routeIs('data_keluarga.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a4 4 0 10-8 0 4 4 0 008 0zm-9 8a7 7 0 0114 0H7z" />
                </svg>
                <span class="text-xs {{ $txt }}">Keluarga</span>
              </a>

              <a href="{{ route('biodata_warga.index', absolute: false) }}" aria-label="Warga"
                 @php $is = request()->routeIs('biodata_warga.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-4 0-6 2-6 4v2h12v-2c0-2-2-4-6-4z" />
                </svg>
                <span class="text-xs {{ $txt }}">Warga</span>
              </a>

              <a href="{{ route('pindah_keluar.index', absolute: false) }}" aria-label="Keluar"
                 @php $is = request()->routeIs('pindah_keluar.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h7m0 0l-3-3m3 3l-3 3M3 13h13a4 4 0 014 4v2H3v-6z" />
                </svg>
                <span class="text-xs {{ $txt }}">Keluar</span>
              </a>

              <a href="{{ route('pindah_masuk.index', absolute: false) }}" aria-label="Masuk"
                 @php $is = request()->routeIs('pindah_masuk.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 7h7m0 0l-3-3m3 3l-3 3M3 13h13a4 4 0 014 4v2H3v-6z" />
                </svg>
                <span class="text-xs {{ $txt }}">Masuk</span>
              </a>

              <a href="{{ route('warga_meninggal.index', absolute: false) }}" aria-label="Kematian"
                 @php $is = request()->routeIs('warga_meninggal.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M5.07 19h13.86A2 2 0 0021 17.07V6.93A2 2 0 0018.93 5H5.07A2 2 0 003 6.93v10.14A2 2 0 005.07 19z" />
                </svg>
                <span class="text-xs {{ $txt }}">Kematian</span>
              </a>

              <a href="{{ route('rumah_ibadah.index', absolute: false) }}" aria-label="Ibadah"
                 @php $is = request()->routeIs('rumah_ibadah.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l7 5v7a5 5 0 11-10 0V7l3-5z" />
                </svg>
                <span class="text-xs {{ $txt }}">Ibadah</span>
              </a>

              <a href="{{ route('umkm.index', absolute: false) }}" aria-label="UMKM"
                 @php $is = request()->routeIs('umkm.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                 class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 11h16M6 15h12v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="text-xs {{ $txt }}">UMKM</span>
              </a>

              @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
              @if($canAdminOps)
                <a href="{{ route('export.index', absolute: false) }}" aria-label="Export"
                   @php $is = request()->is('export*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                   class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                  <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4-4-4M3 21h18" />
                  </svg>
                  <span class="text-xs {{ $txt }}">Export</span>
                </a>
                <a href="{{ route('import.form', absolute: false) ?? url('/import') }}" aria-label="Import"
                   @php $is = request()->is('import*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                   class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                  <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4-4-4M21 21H3" />
                  </svg>
                  <span class="text-xs {{ $txt }}">Import</span>
                </a>
              @endif

              @if(auth()->check() && method_exists(auth()->user(),'isAdmin') && auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index', absolute: false) }}" aria-label="Pengguna"
                   @php $is = request()->routeIs('admin.users.*'); $txt = $is ? 'text-indigo-600' : 'text-gray-500'; $bg = $is ? 'bg-indigo-50' : ''; @endphp
                   class="inline-flex flex-col items-center justify-center h-14 px-3 rounded {{ $bg }}">
                  <svg class="w-6 h-6 mb-1 {{ $txt }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11a4 4 0 10-8 0 4 4 0 008 0zM3 20a7 7 0 0114 0H3zm14-9l3 3m0 0l3-3m-3 3V7" />
                  </svg>
                  <span class="text-xs {{ $txt }}">Pengguna</span>
                </a>
              @endif

              <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                @csrf
                <button type="submit" aria-label="Logout" class="inline-flex flex-col items-center justify-center h-14 px-3 rounded">
                  <svg class="w-6 h-6 mb-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H9M13 21H7a2 2 0 01-2-2V5a2 2 0 012-2h6" />
                  </svg>
                  <span class="text-xs text-gray-500">Logout</span>
                </button>
              </form>
            </div>
          </div>
        </nav>
        @endauth
    </div>

    {{-- Vite will inject scripts when manifest exists; otherwise we already loaded local js above --}}
</body>
</html>
