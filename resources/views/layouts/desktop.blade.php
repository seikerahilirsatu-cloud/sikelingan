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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <style>
    .main-sidebar .nav-sidebar .nav-link{color:#cbd5e1;border-radius:12px;margin:4px 12px}
    .main-sidebar .nav-sidebar .nav-link .nav-icon{color:#cbd5e1;margin-right:8px}
    .main-sidebar .nav-sidebar .nav-link:hover{background:rgba(255,255,255,.06);color:#e5e7eb}
    .main-sidebar .nav-sidebar .nav-link.active{background-image:linear-gradient(135deg,#6366F1,#3B82F6);color:#fff;box-shadow:0 6px 16px rgba(59,130,246,.35)}
    .main-sidebar .nav-sidebar .nav-link.active .nav-icon{color:#fff}
    .main-sidebar .nav-header{font-size:.75rem;letter-spacing:.08em;color:#9ca3af;padding:.75rem 1rem;margin-top:.5rem}
    .brand-link,.brand-link .brand-text{color:#e5e7eb}

    /* Table styles to match reference */
    .table{border-collapse:separate;border-spacing:0;border-radius:12px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,.06);background:#fff;width:100%}
    .table thead th{background:#F9FAFB;color:#6B7280;font-weight:600;text-transform:uppercase;font-size:.8rem;padding:12px 16px;border-bottom:1px solid #E5E7EB;text-align:left}
    .table tbody td{font-size:.9rem;color:#1F2937;padding:14px 16px;vertical-align:middle;border-top:1px solid #EEF2F7}
    .table tbody tr:first-child td{border-top:none}
    .table td:first-child{font-weight:400;color:#111827}
    .table-hover tbody tr:hover{background:#F8FAFC}
    /* common column widths to avoid hidden columns */
    .table th,.table td{white-space:nowrap}
    .table .col-actions{width:220px}
    .table .col-status{width:140px}
    .table .col-date{width:160px}
    .table .col-address{min-width:360px;white-space:normal}

    /* Status pill */
    .status-badge{display:inline-block;padding:6px 12px;border-radius:9999px;font-size:.8rem;font-weight:600}
    .status-badge.status-active{background:#D1FAE5;color:#047857}
    .status-badge.status-danger{background:#FEE2E2;color:#B91C1C}
    .status-badge.status-warning{background:#FEF3C7;color:#92400E}

    /* Action buttons (Bootstrap) */
    .table .btn{border:none;border-radius:8px;padding:6px 12px;font-weight:600;font-size:.8rem}
    .table .btn-primary{background:#2563EB}
    .table .btn-warning{background:#F59E0B;color:#111827}
    .table .btn-danger{background:#EF4444}

    /* column helpers by index */
    .table.col-actions-last th:last-child,.table.col-actions-last td:last-child{width:140px}
    .table.col-date-3 th:nth-child(3),.table.col-date-3 td:nth-child(3){width:160px}
    .table.col-date-6 th:nth-child(6),.table.col-date-6 td:nth-child(6){width:160px}
    .table.col-status-5 th:nth-child(5),.table.col-status-5 td:nth-child(5){width:140px}
    .table.col-address-3 th:nth-child(3),.table.col-address-3 td:nth-child(3){min-width:360px;white-space:normal}
    .table.col-address-5 th:nth-child(5),.table.col-address-5 td:nth-child(5){min-width:360px;white-space:normal}
    .table.col-address-6 th:nth-child(6),.table.col-address-6 td:nth-child(6){min-width:360px;white-space:normal}

    .content-wrapper .container-fluid.px-0{padding-left:30px!important;padding-right:30px!important}
    .content-header{padding-top:8px;padding-bottom:8px;margin-bottom:8px}
    .content-wrapper .content{padding-top:8px}
    
    /* center data helpers by index */
    .table.center-data-4 th:nth-child(4),.table.center-data-4 td:nth-child(4){text-align:center}
    .table.center-data-5 th:nth-child(5),.table.center-data-5 td:nth-child(5){text-align:center}
    .modal-iframe{width:100%;height:80vh;border:0}
    /* opt-in hide modal title text in desktop */
    .modal.hide-title .modal-header .modal-title{display:none}
    /* hide chrome when inside modal */
    body.is-modal .main-header,
    body.is-modal .main-sidebar,
    body.is-modal .main-footer{display:none!important}
    body.is-modal .content-wrapper{margin-left:0!important;background:#fff}
    </style>
    <style>
    .main-sidebar .nav-sidebar .nav-link{color:#cbd5e1;border-radius:12px;margin:4px 12px}
    .main-sidebar .nav-sidebar .nav-link .nav-icon{color:#cbd5e1;margin-right:8px}
    .main-sidebar .nav-sidebar .nav-link:hover{background:rgba(255,255,255,.06);color:#e5e7eb}
    .main-sidebar .nav-sidebar .nav-link.active{background-image:linear-gradient(135deg,#6366F1,#3B82F6);color:#fff;box-shadow:0 6px 16px rgba(59,130,246,.35)}
    .main-sidebar .nav-sidebar .nav-link.active .nav-icon{color:#fff}
    .main-sidebar .nav-header{font-size:.75rem;letter-spacing:.08em;color:#9ca3af;padding:.75rem 1rem;margin-top:.5rem}
    .brand-link,.brand-link .brand-text{color:#e5e7eb}
    </style>
</head>
<body class="hold-transition sidebar-mini">
    
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-light" style="background:#ffffff; box-shadow:0 1px 6px rgba(0,0,0,.08); border-bottom:none;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link" style="font-weight:600;font-size:1.125rem;color:#111827;">@yield('page_title')</span>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @auth
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
                @endguest
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-image: linear-gradient(180deg, #0F172A 0%, #111827 50%, #1F2937 100%);">
            <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center" style="background: transparent; border-bottom: none;">
                @php
                    $logo = null;
                    foreach (['images/kelurahan-logo.png','images/kelurahan-logo.svg','images/logo-kelurahan.png','images/logo.png'] as $p) {
                        if (file_exists(public_path($p))) { $logo = asset($p); break; }
                    }
                @endphp
                @if($logo)
                    <img src="{{ $logo }}" alt="Logo Kelurahan" class="brand-image img-circle elevation-3" style="opacity:.8">
                @else
                    <span class="brand-image img-circle elevation-3 bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:33px;height:33px;font-weight:bold">Si</span>
                @endif
                <span class="brand-text font-weight-bold ml-2">SIKELINGAN</span>
            </a>
            <div class="px-3 pb-2 text-xs" style="color:#ffffff">Sistem Informasi Kelurahan Lingkungan</div>
            <div class="sidebar" style="background: transparent;">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard', absolute: false) }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kelurahan.info', absolute: false) }}" class="nav-link {{ request()->routeIs('kelurahan.info') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Info Kelurahan</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Data Kependudukan<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="{{ route('data_keluarga.index', absolute: false) }}" class="nav-link"><p>Kartu Keluarga</p></a></li>
                                <li class="nav-item"><a href="{{ route('biodata_warga.index', absolute: false) }}" class="nav-link"><p>Data Individu</p></a></li>
                                <li class="nav-item"><a href="{{ route('pindah_keluar.index') }}" class="nav-link"><p>Pindah Keluar</p></a></li>
                                <li class="nav-item"><a href="{{ route('pindah_masuk.index') }}" class="nav-link"><p>Pindah Masuk</p></a></li>
                                <li class="nav-item"><a href="{{ route('warga_meninggal.index') }}" class="nav-link"><p>Data Kematian</p></a></li>
                                @if(auth()->check() && in_array(auth()->user()->role ?? null, ['admin','staff']))
                                <li class="nav-item"><a href="{{ route('stats.mutasi', absolute: false) }}" class="nav-link"><p>Laporan Mutasi Penduduk</p></a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="nav-link {{ request()->routeIs('rumah_ibadah.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-place-of-worship"></i>
                                <p>Rumah Ibadah</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Sarana Pendidikan<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="{{ route('pendidikan_formal.index', absolute: false) }}" class="nav-link {{ request()->routeIs('pendidikan_formal.*') ? 'active' : '' }}"><p>Formal</p></a></li>
                                <li class="nav-item"><a href="{{ route('pendidikan_non_formal.index', absolute: false) }}" class="nav-link {{ request()->routeIs('pendidikan_non_formal.*') ? 'active' : '' }}"><p>Non-Formal</p></a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('umkm.index', absolute: false) }}" class="nav-link {{ request()->routeIs('umkm.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-store"></i>
                                <p>UMKM</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Pengaduan Warga<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="{{ route('pengaduan.create', absolute: false) }}" class="nav-link {{ request()->routeIs('pengaduan.create') ? 'active' : '' }}"><p>Ajukan Pengaduan</p></a></li>
                                <li class="nav-item"><a href="{{ route('pengaduan.cek', absolute: false) }}" class="nav-link {{ request()->routeIs('pengaduan.cek') ? 'active' : '' }}"><p>Cek Status Pengaduan</p></a></li>
                                @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                                @if($canAdminOps)
                                <li class="nav-item"><a href="{{ route('admin.pengaduan.index', absolute: false) }}" class="nav-link {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}"><p>Admin Pengaduan</p></a></li>
                                @endif
                            </ul>
                        </li>
                        @php $role = auth()->user()->role ?? null; $canAdminOps = in_array($role, ['admin','staff']); @endphp
                        @if($canAdminOps)
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-exchange-alt"></i>
                                <p>Export/Import Data<i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="{{ route('export.index', absolute: false) }}" class="nav-link {{ request()->routeIs('export.index') ? 'active' : '' }}"><p>Export</p></a></li>
                                <li class="nav-item"><a href="{{ route('import.form', absolute: false) }}" class="nav-link {{ request()->routeIs('import.form') ? 'active' : '' }}"><p>Import</p></a></li>
                            </ul>
                        </li>
                        @endif
                        @if(auth()->check() && method_exists(auth()->user(),'isAdmin') && auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index', absolute: false) }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>Manajemen Pengguna</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper" style="background-image: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);">
            <section class="content-header">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        <footer class="main-footer" style="background:#ffffff; box-shadow:0 -1px 6px rgba(0,0,0,.06); border-top:none; color:#1F2937;">
            <div class="float-right d-none d-sm-inline">{{ config('app.name','Kelurahan') }}</div>
            <strong>&copy; {{ now()->year }}.</strong>
        </footer>
        <div class="modal fade" id="globalModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="globalModalTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="globalModalContent"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script>
    $(function(){
        var $modal = $('#globalModal');
        var $content = $('#globalModalContent');
        var $title = $('#globalModalTitle');

        function extractContent(html){
            var $tmp = $('<div>').html(html);
            var $sel = $tmp.find('section.content .container-fluid');
            if(!$sel.length){ $sel = $tmp.find('section.content'); }
            if(!$sel.length){ $sel = $tmp.find('main'); }
            if(!$sel.length){ $sel = $tmp.find('.py-6'); }
            if(!$sel.length){ $sel = $tmp.find('.min-h-screen'); }
            if(!$sel.length){ $sel = $tmp.find('body'); }
            $sel.find('header').first().remove();
            return $sel.html() || html;
        }

        $(document).on('click','a[data-modal=true]',function(e){
            e.preventDefault();
            var raw = $(this).attr('href');
            var t = $(this).data('title') || $(this).text().trim();
            try {
              var url = new URL(raw, window.location.origin);
              url.searchParams.set('modal','1');
              raw = url.toString();
            } catch (err) {}
            try {
              var openUrl = new URL(raw, window.location.origin);
              var path = openUrl.pathname;
              var modalType = null;
              if(/\/pindah_keluar\/create/.test(path)) modalType = 'pk';
              else if(/\/pindah_masuk\/create/.test(path)) modalType = 'pm';
              else if(/\/warga_meninggal\/create/.test(path)) modalType = 'wm';
              if(modalType){
                  $modal.removeClass('hide-title');
                  $title.text(modalType==='pk'?'Pencatatan Data Pindah Keluar':(modalType==='pm'?'Pencatatan Data Pindah Masuk':'Pencatatan Warga Meninggal'));
              } else {
                  $modal.addClass('hide-title');
                  $title.text(t);
              }
            } catch(err){ $modal.addClass('hide-title'); $title.text(t); }
            $content.html('<div class="p-4 text-center text-gray-600">Memuat...</div>');
            $.ajax({url: raw, method: 'GET', dataType: 'html'}).done(function(res){
                $content.html(extractContent(res));
                try {
                  var openUrl = new URL(raw, window.location.origin);
                  var path = openUrl.pathname;
                  var modalType = null;
                  if(/\/pindah_keluar\/create/.test(path)) modalType = 'pk';
                  else if(/\/pindah_masuk\/create/.test(path)) modalType = 'pm';
                  else if(/\/warga_meninggal\/create/.test(path)) modalType = 'wm';
                  if(modalType){
                      var nik = $('#globalModalContent').find('div:contains("NIK:") span.font-medium').first().text().trim();
                      var name = $('#globalModalContent').find('.text-lg').first().text().trim();
                      var suffix = '';
                      if(nik){ suffix = nik; }
                      if(name){ suffix = suffix ? (suffix + ' - ' + name) : name; }
                      $modal.removeClass('hide-title');
                      var base = modalType==='pk'?'Pencatatan Data Pindah Keluar':(modalType==='pm'?'Pencatatan Data Pindah Masuk':'Pencatatan Warga Meninggal');
                      $title.text(base + (suffix ? ' - ' + suffix : ''));
                  }
                } catch(err) {}
                $modal.modal('show');
            }).fail(function(){
                $content.html('<div class="p-4 text-center text-red-600">Gagal memuat konten</div>');
                $modal.modal('show');
            });
        });

        $(document).on('submit','#globalModalContent form', function(e){
            e.preventDefault();
            var $form = $(this);
            var action = $form.attr('action');
            var method = ($form.attr('method') || 'POST').toUpperCase();
            var isGet = method === 'GET';
            var data = isGet ? $form.serialize() : new FormData(this);
            $content.addClass('position-relative').append('<div class="position-absolute w-100 h-100" style="left:0;top:0;background:rgba(255,255,255,.6)"></div>');
            $.ajax({
                url: action,
                method: method,
                data: data,
                processData: isGet,
                contentType: isGet ? 'application/x-www-form-urlencoded; charset=UTF-8' : false,
                dataType: 'html'
            }).done(function(res, status, xhr){
                var finalUrl = (xhr && xhr.responseURL) ? xhr.responseURL : '';
                var redirected = finalUrl && finalUrl !== action;
                var hasSuccess = /alert\s+alert\-success|class=\"alert alert\-success\"/i.test(res);
                var hasPostForm = /<form[^>]*method=["']post["']/i.test(res);
                if (redirected || hasSuccess || !hasPostForm) {
                    $modal.modal('hide');
                    try { window.location.reload(); } catch(e) {}
                    return;
                }
                $content.html(extractContent(res));
            }).fail(function(xhr){
                var res = xhr.responseText || '<div class="p-4 text-center text-red-600">Gagal mengirim data</div>';
                $content.html(extractContent(res));
            });
        });

        // internal navigation inside modal (keep content within modal)
        $(document).on('click','#globalModalContent a', function(e){
            var href = $(this).attr('href');
            var target = $(this).attr('target');
            if(!href || href === '#' || (target && target !== '')){ return; }
            if(/^javascript:/i.test(href)){ return; }
            if(this.hasAttribute('download')){ return; }
            try {
              var url = new URL(href, window.location.origin);
              if(url.origin !== window.location.origin){ return; }
              e.preventDefault();
              url.searchParams.set('modal','1');
              var path = url.pathname;
              var modalType = null;
              if(/\/pindah_keluar\/create/.test(path)) modalType = 'pk';
              else if(/\/pindah_masuk\/create/.test(path)) modalType = 'pm';
              else if(/\/warga_meninggal\/create/.test(path)) modalType = 'wm';
              if(modalType){
                  var nik = $(this).find('div:contains("NIK:") span.font-medium').first().text().trim();
                  var name = $(this).find('.text-lg').first().text().trim();
                  var suffix = '';
                  if(nik){ suffix = nik; }
                  if(name){ suffix = suffix ? (suffix + ' - ' + name) : name; }
                  $modal.removeClass('hide-title');
                  var base = modalType==='pk'?'Pencatatan Data Pindah Keluar':(modalType==='pm'?'Pencatatan Data Pindah Masuk':'Pencatatan Warga Meninggal');
                  $title.text(base + (suffix ? ' - ' + suffix : ''));
              } else {
                  $modal.addClass('hide-title');
              }
              $content.html('<div class="p-4 text-center text-gray-600">Memuat...</div>');
              $.ajax({url: url.toString(), method: 'GET', dataType: 'html'}).done(function(res){
                  $content.html(extractContent(res));
                  if(modalType){
                      var nik = $('#globalModalContent').find('div:contains("NIK:") span.font-medium').first().text().trim();
                      var name = $('#globalModalContent').find('.text-lg').first().text().trim();
                      var suffix = '';
                      if(nik){ suffix = nik; }
                      if(name){ suffix = suffix ? (suffix + ' - ' + name) : name; }
                      $modal.removeClass('hide-title');
                      var base = modalType==='pk'?'Pencatatan Data Pindah Keluar':(modalType==='pm'?'Pencatatan Data Pindah Masuk':'Pencatatan Warga Meninggal');
                      $title.text(base + (suffix ? ' - ' + suffix : ''));
                  }
              }).fail(function(){
                  $content.html('<div class=\"p-4 text-center text-red-600\">Gagal memuat konten</div>');
              });
            } catch(err) {
              // fall through to default navigation
            }
        });
    });
    </script>
</body>
</html>
