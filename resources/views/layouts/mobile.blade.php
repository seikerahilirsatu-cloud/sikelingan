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
<body class="bg-gradient-to-br from-indigo-200 via-sky-200 to-cyan-200 text-gray-800">
    
    <div class="min-h-screen max-w-lg mx-auto" x-data="{open:false}">
        <header class="bg-gray-100 text-gray-800 p-4 shadow sticky top-0 z-10 backdrop-blur-sm">
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <a href="{{ route('dashboard', absolute: false) }}">
                  <x-application-logo class="h-8" />
                </a>
              </div>
              <button type="button" class="text-sm text-gray-700" aria-label="Menu" @click="open=!open">
                <svg class="h-6 w-6 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="sr-only">Menu</span>
              </button>
            </div>
        </header>

        <div x-show="open" class="fixed inset-0 z-30" x-cloak>
            <div class="absolute inset-0 bg-black/30" @click="open=false"></div>
            <div class="absolute top-0 right-0 bottom-0 w-72 bg-white shadow-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="font-semibold">Menu</div>
                    <button type="button" class="p-1" aria-label="Tutup" @click="open=false">
                        <svg class="h-5 w-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6"/></svg>
                    </button>
                </div>
                <nav class="space-y-1 text-sm">
                    <a href="{{ route('dashboard', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Dashboard</a>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded hover:bg-gray-50">
                            <span class="font-medium">Data Kependudukan</span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="mt-1 ms-4 space-y-1">
                            <a href="{{ route('data_keluarga.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Data Keluarga</a>
                            <a href="{{ route('biodata_warga.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Data Warga</a>
                            <a href="{{ route('pindah_keluar.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Pindah Keluar</a>
                            <a href="{{ route('pindah_masuk.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Pindah Masuk</a>
                            <a href="{{ route('warga_meninggal.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Data Kematian</a>
                            @if(auth()->check() && in_array(auth()->user()->role ?? null, ['admin','staff']))
                                <a href="{{ route('stats.mutasi', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Laporan Mutasi Penduduk</a>
                            @endif
                        </div>
                    </details>

                    <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Rumah Ibadah</a>
                    <a href="{{ route('umkm.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">UMKM</a>
                    <a href="{{ route('kelurahan.info', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Info Kelurahan</a>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded hover:bg-gray-50">
                            <span class="font-medium">Pengaduan Warga</span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="mt-1 ms-4 space-y-1">
                            <a href="{{ route('pengaduan.create', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Ajukan Pengaduan</a>
                            <a href="{{ route('pengaduan.cek', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Cek Status Pengaduan</a>
                            @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                            @if($canAdminOps)
                                <a href="{{ route('admin.pengaduan.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Admin Pengaduan</a>
                            @endif
                        </div>
                    </details>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded hover:bg-gray-50">
                            <span class="font-medium">Sarana Pendidikan</span>
                            <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="mt-1 ms-4 space-y-1">
                            <a href="{{ route('pendidikan_formal.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Formal</a>
                            <a href="{{ route('pendidikan_non_formal.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Non-Formal</a>
                        </div>
                    </details>

                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Login</a>
                        @endif
                    @endguest

                    @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                    @if($canAdminOps)
                        <details class="group">
                            <summary class="flex items-center justify-between cursor-pointer px-3 py-2 rounded hover:bg-gray-50">
                                <span class="font-medium">Export/Import Data</span>
                                <svg class="h-4 w-4 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z" clip-rule="evenodd"/></svg>
                            </summary>
                            <div class="mt-1 ms-4 space-y-1">
                                <a href="{{ route('export.index', absolute: false) }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Export</a>
                                <a href="{{ route('import.form', absolute: false) ?? url('/import') }}" class="block px-3 py-2 rounded hover:bg-gray-50" @click="open=false">Import</a>
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
