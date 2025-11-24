@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="space-y-6">
    @php
        $totalKeluarga = \App\Models\DataKeluarga::count();
        $totalWarga = \App\Models\BiodataWarga::count();
        $totalIbadah = \App\Models\RumahIbadah::count();
        $totalUmkm = \App\Models\Umkm::count();

                $totalLaki = \App\Models\BiodataWarga::whereIn('jenis_kelamin', ['L','LAKI-LAKI','Laki-laki','laki-laki'])->count();
                $totalPerempuan = \App\Models\BiodataWarga::whereIn('jenis_kelamin', ['P','PEREMPUAN','Perempuan','perempuan'])->count();
                $genderLabels = ['Pria','Wanita'];
                $genderDataChart = [$totalLaki, $totalPerempuan];

                $statusByFlag = \App\Models\BiodataWarga::selectRaw('COALESCE(NULLIF(flag_status, ""), "Tidak diketahui") as status')
                    ->selectRaw('COUNT(*) as total')
                    ->groupBy('status')
                    ->orderBy('status')
                    ->get();
                $statusLabels = $statusByFlag->pluck('status')->toArray();
                $statusDataChart = $statusByFlag->pluck('total')->toArray();

                $ibadahByJenis = \App\Models\RumahIbadah::select('jenis')->selectRaw('COUNT(*) as total')->groupBy('jenis')->orderBy('jenis')->get();
                $jenisIbadahAll = ['Masjid','Gereja','Pura','Vihara','Klenteng','Mushalla','Lainnya'];
                $countsIbadahNorm = [];
                foreach ($ibadahByJenis as $row) { $countsIbadahNorm[strtolower(trim($row->jenis ?? ''))] = (int)($row->total ?? 0); }
                $ibadahDataArr = array_map(function($j) use ($countsIbadahNorm) { $key = strtolower(trim($j)); return $countsIbadahNorm[$key] ?? 0; }, $jenisIbadahAll);

                $umkmByJenis = \App\Models\Umkm::selectRaw('COALESCE(NULLIF(jenis, ""), "Tidak diketahui") as jenis')->selectRaw('COUNT(*) as total')->groupBy('jenis')->orderBy('jenis')->get();
                $jenisUmkmAll = array_values(array_unique(array_merge(config('app_local.umkm_jenis', []), ['Tidak diketahui'])));
                $countsUmkmNorm = [];
                foreach ($umkmByJenis as $row) { $countsUmkmNorm[strtolower(trim($row->jenis ?? ''))] = (int)($row->total ?? 0); }
                $umkmDataArr = array_map(function($j) use ($countsUmkmNorm) { $key = strtolower(trim($j)); return $countsUmkmNorm[$key] ?? 0; }, $jenisUmkmAll);
    @endphp

    <section class="bg-white rounded-2xl shadow p-6">
        <div class="mb-2">
            <div class="text-sm text-gray-500">Selamat datang di</div>
            <div class="text-2xl font-semibold">Kelurahan Sei Kera Hilir I</div>
            <div class="text-sm text-gray-600 mt-1">Informasi Umum Kelurahan & Lingkungan</div>
        </div>

        

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="text-sm font-medium mb-2 text-center">Statistisk Data Kependudukan</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="h-56 w-full"><canvas id="homeChartGender" style="width:100%;height:100%" data-labels='{!! json_encode($genderLabels) !!}' data-data='{!! json_encode($genderDataChart) !!}' data-total='{{ $totalLaki + $totalPerempuan }}' data-fallback-label='Penduduk'></canvas></div>
                    <div class="h-56 w-full"><canvas id="homeChartStatus" style="width:100%;height:100%" data-labels='{!! json_encode($statusLabels) !!}' data-data='{!! json_encode($statusDataChart) !!}' data-total='{{ $totalWarga }}' data-fallback-label='Warga'></canvas></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="text-sm font-medium mb-2 text-center">Statistik Data Rumah Ibadah</div>
                <div class="h-56 w-full"><canvas id="homeChartIbadah" style="width:100%;height:100%" data-labels='{!! json_encode($jenisIbadahAll) !!}' data-data='{!! json_encode($ibadahDataArr) !!}' data-total='{{ $totalIbadah }}' data-fallback-label='Rumah Ibadah'></canvas></div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <div class="bg-white rounded-2xl shadow p-4">
                <div class="text-sm font-medium mb-2 text-center">Stattistik Data UMKM</div>
                <div class="h-56 w-full"><canvas id="homeChartUmkm" style="width:100%;height:100%" data-labels='{!! json_encode($jenisUmkmAll) !!}' data-data='{!! json_encode($umkmDataArr) !!}' data-total='{{ $totalUmkm }}' data-fallback-label='UMKM'></canvas></div>
            </div>
        </div>

        @php $pengumuman = []; $agenda = []; @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <section class="bg-white border rounded p-4">
                <div class="text-sm font-medium mb-2">Pengumuman</div>
                @if(count($pengumuman))
                    <ul class="space-y-2">
                        @foreach($pengumuman as $p)
                            <li class="text-sm text-gray-700">{{ $p }}</li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-sm text-gray-600">Belum ada pengumuman.</div>
                @endif
            </section>
            <section class="bg-white border rounded p-4">
                <div class="text-sm font-medium mb-2">Agenda</div>
                @if(count($agenda))
                    <ul class="space-y-2">
                        @foreach($agenda as $a)
                            <li class="text-sm text-gray-700">{{ $a }}</li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-sm text-gray-600">Belum ada agenda.</div>
                @endif
            </section>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <a href="{{ route('rumah_ibadah.index', absolute: false) }}" class="p-4 bg-white border rounded hover:bg-gray-50">
                <div class="text-sm text-gray-600">Direktori</div>
                <div class="font-semibold">Rumah Ibadah</div>
            </a>
            <a href="{{ route('umkm.index', absolute: false) }}" class="p-4 bg-white border rounded hover:bg-gray-50">
                <div class="text-sm text-gray-600">Direktori</div>
                <div class="font-semibold">UMKM</div>
            </a>
            <a href="{{ route('login') }}" class="p-4 bg-white border rounded hover:bg-gray-50 inline-flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-700" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 4a2 2 0 012-2h7a2 2 0 012 2v16a2 2 0 01-2 2h-7a2 2 0 01-2-2v-3h2v3h7V4h-7v3h-2V4zm-1 7l-4 4 4 4v-3h8v-2H9v-3z"/></svg>
                <span class="font-semibold">Masuk Dashboard</span>
            </a>
        </div>
    </section>

    <footer class="-mt-6 text-sm text-gray-800">
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a3 3 0 100-6 3 3 0 000 6zm0 2c-3.866 0-7 3.134-7 7h14c0-3.866-3.134-7-7-7z" />
                    </svg>
                    <div>
                        <div class="font-semibold">Alamat</div>
                        <div class="text-gray-700">Jl. Pimpinan No. 79 Medan</div>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v5l3 3M12 2a10 10 0 100 20 10 10 0 000-20z" />
                    </svg>
                    <div>
                        <div class="font-semibold">Jam Kerja</div>
                        <div class="text-gray-700">Senin–Jumat: 08.00–16.30 WIB</div>
                        <div class="text-gray-700">Jum'at: 08.00–17.00 WIB</div>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-3">
                    <div class="font-semibold">Kontak</div>
                    <div class="flex items-center gap-3">
                        <a href="#" aria-label="Facebook" class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-indigo-200 bg-white/70 hover:bg-white">
                            <svg class="w-5 h-5 text-indigo-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M22 12a10 10 0 10-11.6 9.9v-7H7.6V12h2.8V9.7c0-2.8 1.7-4.3 4.2-4.3 1.2 0 2.4.2 2.4.2v2.6h-1.3c-1.3 0-1.7.8-1.7 1.6V12h2.9l-.5 2.9h-2.4v7A10 10 0 0022 12z"></path>
                            </svg>
                        </a>
                        <a href="#" aria-label="Instagram" class="inline-flex items-center justify-center w-8 h-8 rounded-full border border-indigo-200 bg-white/70 hover:bg-white">
                            <svg class="w-5 h-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5" ry="5" stroke-width="2"></rect>
                                <circle cx="12" cy="12" r="4" stroke-width="2"></circle>
                                <circle cx="17" cy="7" r="1" fill="currentColor"></circle>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    const CenterTextPlugin={id:'centerText',afterDraw(chart){const o=chart.options&&chart.options.plugins&&chart.options.plugins.centerText;const t=o&&o.text;if(!t)return;const c=chart.ctx,a=chart.chartArea,x=(a.left+a.right)/2,y=(a.top+a.bottom)/2;c.save();c.textAlign='center';c.textBaseline='middle';c.fillStyle='#374151';c.font='600 14px system-ui, -apple-system, Segoe UI, Roboto';c.fillText(t,x,y);c.restore();}};Chart.register(CenterTextPlugin);
    const buildChart=(id,colors)=>{const el=document.getElementById(id);if(!el)return;let labels=[],data=[];try{labels=JSON.parse(el.dataset.labels||'[]');}catch(e){}try{data=JSON.parse(el.dataset.data||'[]');}catch(e){}const sum=(Array.isArray(data)?data:[]).reduce((a,b)=>a+(typeof b==='number'?b:parseFloat(b)||0),0);let bg=colors,lbl=labels,dat=data;let total=0;try{total=parseFloat(el.dataset.total||'0');}catch(e){}const fallbackLabel=el.dataset.fallbackLabel||'Total';if(!sum){if(total>0){lbl=[fallbackLabel];dat=[total];bg=[colors[0]||'#60A5FA'];}else{lbl=['Tidak ada data'];dat=[1];bg=['#E5E7EB'];}}const centerText=(sum||total)?((sum||total).toLocaleString('id-ID')):'Tidak ada data';new Chart(el,{type:'doughnut',data:{labels:lbl,datasets:[{data:dat,backgroundColor:bg}]},options:{plugins:{legend:{position:'bottom'},centerText:{text:centerText}},maintainAspectRatio:false,cutout:'65%'}})};
    buildChart('homeChartGender',['#60A5FA','#F472B6']);
    buildChart('homeChartStatus',['#93C5FD','#FCA5A5','#FDE68A','#A7F3D0','#99F6E4','#F5D0FE','#6EE7B7','#FDBA74','#D1D5DB']);
    buildChart('homeChartIbadah',['#C7D2FE','#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5']);
    buildChart('homeChartUmkm',['#C7D2FE','#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5','#99F6E4','#A5F3FC','#F5D0FE','#6EE7B7','#FDBA74']);
})();
</script>
@endsection
