@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
    <h2 class="font-semibold text-xl text-gray-800">{{ __('Dashboard') }}</h2>
    @php
        $totalKeluarga = \App\Models\DataKeluarga::count();
        $totalWarga = \App\Models\BiodataWarga::count();
        $totalKeluar = \App\Models\PindahKeluar::count();
        $totalMasuk = \App\Models\PindahMasuk::count();
        $totalMeninggal = \App\Models\WargaMeninggal::count();
        $totalIbadah = \App\Models\RumahIbadah::count();
        $totalUmkm = \App\Models\Umkm::count();

        $kkDomisili = \App\Models\DataKeluarga::where('status_keluarga','KK Domisili')->count();
        $kkLuarDomisili = \App\Models\DataKeluarga::where('status_keluarga','KK Luar Domisili')->count();
        $kkDomisiliBaru = \App\Models\DataKeluarga::whereIn('status_keluarga',['KK Domisili Baru','KK Domisli Baru'])->count();

        $ibadahByJenis = \App\Models\RumahIbadah::select('jenis')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->get();
        $umkmByJenis = \App\Models\Umkm::selectRaw('COALESCE(NULLIF(jenis, ""), "Tidak diketahui") as jenis')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->get();
        $statusByFlag = \App\Models\BiodataWarga::selectRaw('COALESCE(NULLIF(flag_status, ""), "Tidak diketahui") as status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        $jenisIbadahAll = ['Masjid','Gereja','Pura','Vihara','Klenteng','Mushalla','Lainnya'];
        $jenisUmkmAll = array_values(array_unique(array_merge(config('app_local.umkm_jenis', []), ['Tidak diketahui'])));
        $countsIbadah = $ibadahByJenis->pluck('total','jenis')->toArray();
        $countsUmkm = $umkmByJenis->pluck('total','jenis')->toArray();
        $countsIbadahNorm = [];
        foreach ($ibadahByJenis as $row) { $countsIbadahNorm[strtolower(trim($row->jenis ?? ''))] = (int)($row->total ?? 0); }
        $ibadahDataArr = array_map(function($j) use ($countsIbadahNorm) { $key = strtolower(trim($j)); return $countsIbadahNorm[$key] ?? 0; }, $jenisIbadahAll);
        $countsUmkmNorm = [];
        foreach ($umkmByJenis as $row) { $countsUmkmNorm[strtolower(trim($row->jenis ?? ''))] = (int)($row->total ?? 0); }
        $umkmDataArr = array_map(function($j) use ($countsUmkmNorm) { $key = strtolower(trim($j)); return $countsUmkmNorm[$key] ?? 0; }, $jenisUmkmAll);
        $statusLabels = $statusByFlag->pluck('status')->toArray();
        $statusDataChart = $statusByFlag->pluck('total')->toArray();
    @endphp

    <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="text-sm font-medium mb-3">Statistisk Data Kependudukan</div>
            @php
                $totalLaki = \App\Models\BiodataWarga::whereIn('jenis_kelamin', ['L','LAKI-LAKI','Laki-laki','laki-laki'])->count();
                $totalPerempuan = \App\Models\BiodataWarga::whereIn('jenis_kelamin', ['P','PEREMPUAN','Perempuan','perempuan'])->count();
                $totalMutasi = $totalKeluar + $totalMasuk;
                $genderLabels = ['Pria','Wanita'];
                $genderDataChart = [$totalLaki, $totalPerempuan];
                $mutasiLabels = ['Masuk','Keluar'];
                $mutasiDataChart = [$totalMasuk, $totalKeluar];
                $kkLabels = ['KK Domisili','KK Luar Domisili','KK Domisili Baru'];
                $kkDataChart = [$kkDomisili, $kkLuarDomisili, $kkDomisiliBaru];
            @endphp
            <div class="mt-4">
                <div class="h-56 w-full"><canvas id="chartKependudukan" style="width:100%;height:100%" data-labels='{!! json_encode($genderLabels) !!}' data-data='{!! json_encode($genderDataChart) !!}' data-total='{{ $totalLaki + $totalPerempuan }}' data-fallback-label='Penduduk'></canvas></div>
                <div class="h-56 w-full mt-4"><canvas id="chartStatusWarga" style="width:100%;height:100%" data-labels='{!! json_encode($statusLabels) !!}' data-data='{!! json_encode($statusDataChart) !!}' data-total='{{ $totalWarga }}' data-fallback-label='Warga'></canvas></div>
                <div class="h-56 w-full mt-4"><canvas id="chartKeluarga" style="width:100%;height:100%" data-labels='{!! json_encode($kkLabels) !!}' data-data='{!! json_encode($kkDataChart) !!}' data-total='{{ $totalKeluarga }}' data-fallback-label='KK'></canvas></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <div class="text-sm font-medium mb-2">Statistik Data Rumah Ibadah</div>
            <div class="mt-4 h-56 w-full"><canvas id="chartIbadah" style="width:100%;height:100%" data-labels='{!! json_encode($jenisIbadahAll) !!}' data-data='{!! json_encode($ibadahDataArr) !!}' data-total='{{ $totalIbadah }}' data-fallback-label='Rumah Ibadah'></canvas></div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <div class="text-sm font-medium mb-2">Stattistik Data UMKM</div>
            <div class="mt-4 h-56 w-full"><canvas id="chartUmkm" style="width:100%;height:100%" data-labels='{!! json_encode($jenisUmkmAll) !!}' data-data='{!! json_encode($umkmDataArr) !!}' data-total='{{ $totalUmkm }}' data-fallback-label='UMKM'></canvas></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    (function(){
        const CenterTextPlugin = {
            id:'centerText',
            afterDraw(chart){
                const opt = chart.options && chart.options.plugins && chart.options.plugins.centerText;
                const text = opt && opt.text;
                if(!text) return;
                const ctx = chart.ctx;
                const ca = chart.chartArea;
                const x = (ca.left + ca.right) / 2;
                const y = (ca.top + ca.bottom) / 2;
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = '#374151';
                ctx.font = '600 14px system-ui, -apple-system, Segoe UI, Roboto';
                ctx.fillText(text, x, y);
                ctx.restore();
            }
        };
        Chart.register(CenterTextPlugin);
        const buildChart = (canvasId, colors) => {
            const el = document.getElementById(canvasId);
            if(!el) return;
            let labels = [];
            let data = [];
            try { labels = JSON.parse(el.dataset.labels || '[]'); } catch(e) {}
            try { data = JSON.parse(el.dataset.data || '[]'); } catch(e) {}
            const sumRaw = (Array.isArray(data) ? data : []).reduce((a,b)=> a + (typeof b === 'number' ? b : parseFloat(b) || 0), 0);
            let bg = colors;
            let lbl = labels;
            let dat = data;
            let total = 0;
            try { total = parseFloat(el.dataset.total || '0'); } catch(e) {}
            const fallbackLabel = el.dataset.fallbackLabel || 'Total';
            if(!sumRaw){
                if(total > 0){
                    lbl = [fallbackLabel];
                    dat = [total];
                    bg = [colors[0] || '#60A5FA'];
                } else {
                    lbl = ['Tidak ada data'];
                    dat = [1];
                    bg = ['#E5E7EB'];
                }
            }
            const centerText = (sumRaw || total) ? ((sumRaw || total).toLocaleString('id-ID')) : 'Tidak ada data';
            new Chart(el, {type:'doughnut', data:{labels: lbl, datasets:[{data: dat, backgroundColor: bg}]}, options:{plugins:{legend:{position:'bottom'}, centerText:{text:centerText}}, maintainAspectRatio:false, cutout: '65%'}});
        };
        buildChart('chartKependudukan', ['#60A5FA','#F472B6']);
        buildChart('chartKeluarga', ['#A7F3D0','#6EE7B7','#2DD4BF']);
        buildChart('chartStatusWarga', ['#93C5FD','#FCA5A5','#FDE68A','#A7F3D0','#99F6E4','#F5D0FE','#6EE7B7','#FDBA74','#D1D5DB','#C4B5FD','#F9A8D4','#86EFAC']);
        buildChart('chartIbadah', ['#C7D2FE','#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5','#99F6E4','#A5F3FC','#F5D0FE','#6EE7B7','#FDBA74']);
        buildChart('chartUmkm', ['#C7D2FE','#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5','#99F6E4','#A5F3FC','#F5D0FE','#6EE7B7','#FDBA74']);
    })();
    </script>
    
</div>
@endsection
