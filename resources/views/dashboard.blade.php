@extends(isset($is_mobile) ? ($is_mobile ? 'layouts.mobile' : 'layouts.desktop') : 'layouts.mobile')

@section('content')
<div class="py-6">
    <h2 class="font-semibold text-xl text-gray-800">{{ __('Dashboard') }}</h2>
    @php
        $user = auth()->user();
        $isHead = $user && method_exists($user,'isKepalaLingkungan') && $user->isKepalaLingkungan();
        $filterLkg = $isHead ? ($user->lingkungan ?? null) : null;
        $applyLkg = function($q, $col = 'lingkungan') use ($filterLkg) { return $filterLkg ? $q->where($col, $filterLkg) : $q; };

        $totalKeluarga = $applyLkg(\App\Models\DataKeluarga::query())->count();
        $totalWarga = $applyLkg(\App\Models\BiodataWarga::query())->count();
        $totalKeluar = $applyLkg(\App\Models\PindahKeluar::query())->count();
        $totalMasuk = $applyLkg(\App\Models\PindahMasuk::query())->count();
        $totalMeninggal = $applyLkg(\App\Models\WargaMeninggal::query())->count();
        $totalIbadah = $applyLkg(\App\Models\RumahIbadah::query())->count();
        $totalUmkm = $applyLkg(\App\Models\Umkm::query())->count();
        $totalFormal = $applyLkg(\App\Models\PendidikanFormal::query())->count();
        $totalNonFormal = $applyLkg(\App\Models\PendidikanNonFormal::query())->count();

        $kkDomisili = $applyLkg(\App\Models\DataKeluarga::where('status_keluarga','KK Domisili'))->count();
        $kkLuarDomisili = $applyLkg(\App\Models\DataKeluarga::where('status_keluarga','KK Luar Domisili'))->count();
        $kkDomisiliBaru = $applyLkg(\App\Models\DataKeluarga::whereIn('status_keluarga',['KK Domisili Baru','KK Domisli Baru']))->count();

        $ibadahByJenis = $applyLkg(\App\Models\RumahIbadah::select('jenis')->selectRaw('COUNT(*) as total'))
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->get();
        $umkmByJenis = $applyLkg(\App\Models\Umkm::selectRaw('COALESCE(NULLIF(jenis, ""), "Tidak diketahui") as jenis')->selectRaw('COUNT(*) as total'))
            ->groupBy('jenis')
            ->orderBy('jenis')
            ->get();
        $statusByFlag = $applyLkg(\App\Models\BiodataWarga::selectRaw('COALESCE(NULLIF(flag_status, ""), "Tidak diketahui") as status')->selectRaw('COUNT(*) as total'))
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

    <div class="mt-4 grid grid-cols-1 gap-3">
        <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
            <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-6 8v-1a6 6 0 0112 0v1H6z"/></svg>
            </div>
            <div>
                <div class="text-sm text-gray-600">Total Penduduk</div>
                <div class="text-2xl font-semibold mt-1">{{ number_format($totalWarga,0,',','.') }}</div>
            </div>
        </div>
        <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
            <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l4 4v3h3v10H5V10h3V7l4-4z"/></svg>
            </div>
            <div>
                <div class="text-sm text-gray-600">Rumah Ibadah</div>
                <div class="text-2xl font-semibold mt-1">{{ number_format($totalIbadah,0,',','.') }}</div>
            </div>
        </div>
        <div class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
            <div class="h-12 w-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16l-1 5H5L4 7zm1 5v7h14v-7"/></svg>
            </div>
            <div>
                <div class="text-sm text-gray-600">UMKM Terdaftar</div>
                <div class="text-2xl font-semibold mt-1">{{ number_format($totalUmkm,0,',','.') }}</div>
            </div>
        </div>
        <a href="{{ route('stats.pendidikan') }}#stat-pendidikan" class="flex items-center gap-3 bg-white rounded-2xl shadow p-4">
            <div class="h-12 w-12 rounded-xl bg-amber-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l9 5-9 5L3 8l9-5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13v6"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10v6a5 5 0 0010 0v-6"/></svg>
            </div>
            <div>
                <div class="text-sm text-gray-600">Sarana Pendidikan</div>
                <div class="text-2xl font-semibold mt-1">{{ number_format($totalFormal,0,',','.') }}</div>
            </div>
        </a>
    </div>

    <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl shadow p-4" id="stat-penduduk">
            <div class="text-sm font-medium mb-3">Statistisk Data Kependudukan</div>
            @php
                $totalLaki = $applyLkg(\App\Models\BiodataWarga::whereIn('jenis_kelamin', ['L','LAKI-LAKI','Laki-laki','laki-laki']))->count();
                $totalPerempuan = $applyLkg(\App\Models\BiodataWarga::whereIn('jenis_kelamin', ['P','PEREMPUAN','Perempuan','perempuan']))->count();
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

            @php
                // Detail: Kelompok Umur
                $ageBuckets = [
                    ['label' => '0-4',  'min' => 0,  'max' => 4],
                    ['label' => '5-9',  'min' => 5,  'max' => 9],
                    ['label' => '10-14','min' => 10, 'max' => 14],
                    ['label' => '15-19','min' => 15, 'max' => 19],
                    ['label' => '20-24','min' => 20, 'max' => 24],
                    ['label' => '25-29','min' => 25, 'max' => 29],
                    ['label' => '30-34','min' => 30, 'max' => 34],
                    ['label' => '35-39','min' => 35, 'max' => 39],
                    ['label' => '40-44','min' => 40, 'max' => 44],
                    ['label' => '45-49','min' => 45, 'max' => 49],
                    ['label' => '50-54','min' => 50, 'max' => 54],
                    ['label' => '55-59','min' => 55, 'max' => 59],
                    ['label' => '60+',  'min' => 60, 'max' => null],
                ];
                $ageLabels = array_map(fn($b) => $b['label'], $ageBuckets);
                $ageData = [];
                foreach ($ageBuckets as $b) {
                    $q = \App\Models\BiodataWarga::query();
                    $q = $applyLkg($q);
                    $q->whereNotNull('tgl_lhr');
                    if ($b['max'] === null) {
                        $q->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lhr, CURDATE()) >= ?', [$b['min']]);
                    } else {
                        $q->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lhr, CURDATE()) BETWEEN ? AND ?', [$b['min'], $b['max']]);
                    }
                    $ageData[] = $q->count();
                }

                // Detail: Agama
                $agamaOrdered = config('biodata_config.agama', []);
                $agamaRaw = $applyLkg(\App\Models\BiodataWarga::selectRaw('COALESCE(NULLIF(agama, ""), "Lainnya") as label')->selectRaw('COUNT(*) as total'))
                    ->groupBy('label')->get();
                $mapAgama = [];
                foreach ($agamaRaw as $row) { $mapAgama[trim($row->label)] = (int)($row->total ?? 0); }
                $agamaLabels = []; $agamaData = []; $lainnyaSum = 0;
                foreach ($agamaOrdered as $lbl) { $agamaLabels[] = $lbl; $agamaData[] = $mapAgama[$lbl] ?? 0; unset($mapAgama[$lbl]); }
                foreach ($mapAgama as $lbl => $cnt) { $lainnyaSum += $cnt; }
                $agamaLabels[] = 'Lainnya'; $agamaData[] = $lainnyaSum;

                // Detail: Pendidikan
                $eduOrdered = config('biodata_config.pendidikan_terakhir', []);
                $eduRaw = $applyLkg(\App\Models\BiodataWarga::selectRaw('COALESCE(NULLIF(pendidikan_terakhir, ""), "Tidak diketahui") as label')->selectRaw('COUNT(*) as total'))
                    ->groupBy('label')->get();
                $mapEdu = [];
                foreach ($eduRaw as $row) { $mapEdu[trim($row->label)] = (int)($row->total ?? 0); }
                $eduLabels = []; $eduData = []; $unknownEdu = 0;
                foreach ($eduOrdered as $lbl) { $eduLabels[] = $lbl; $eduData[] = $mapEdu[$lbl] ?? 0; unset($mapEdu[$lbl]); }
                foreach ($mapEdu as $lbl => $cnt) { $unknownEdu += $cnt; }
                $eduLabels[] = 'Tidak diketahui'; $eduData[] = $unknownEdu;

                // Detail: Pekerjaan
                $jobOrdered = config('biodata_config.pekerjaan', []);
                $jobRaw = $applyLkg(\App\Models\BiodataWarga::selectRaw('COALESCE(NULLIF(pekerjaan, ""), "Tidak diketahui") as label')->selectRaw('COUNT(*) as total'))
                    ->groupBy('label')->get();
                $mapJob = [];
                foreach ($jobRaw as $row) { $mapJob[trim($row->label)] = (int)($row->total ?? 0); }
                $jobLabels = []; $jobData = []; $unknownJob = 0;
                foreach ($jobOrdered as $lbl) { $jobLabels[] = $lbl; $jobData[] = $mapJob[$lbl] ?? 0; unset($mapJob[$lbl]); }
                foreach ($mapJob as $lbl => $cnt) { $unknownJob += $cnt; }
                $jobLabels[] = 'Tidak diketahui'; $jobData[] = $unknownJob;
            @endphp

            <div class="mt-6 space-y-6">
                <div>
                    <div class="text-sm font-medium mb-2">Berdasarkan Kelompok Umur</div>
                    <div class="h-56 w-full"><canvas id="statUmur" style="width:100%;height:100%" data-labels='{!! json_encode($ageLabels) !!}' data-data='{!! json_encode($ageData) !!}'></canvas></div>
                </div>

                <div>
                    <div class="text-sm font-medium mb-2">Berdasarkan Agama</div>
                    <div class="h-56 w-full"><canvas id="statAgama" style="width:100%;height:100%" data-labels='{!! json_encode($agamaLabels) !!}' data-data='{!! json_encode($agamaData) !!}'></canvas></div>
                    <div class="mt-4 space-y-2">
                        @foreach($agamaLabels as $i => $label)
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                                <div class="text-sm text-gray-700">{{ $label }}</div>
                                <div class="text-sm font-semibold">{{ number_format($agamaData[$i] ?? 0,0,',','.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="text-sm font-medium mb-2">Berdasarkan Pendidikan Terakhir</div>
                    <div class="h-56 w-full"><canvas id="statEdu" style="width:100%;height:100%" data-labels='{!! json_encode($eduLabels) !!}' data-data='{!! json_encode($eduData) !!}'></canvas></div>
                    @php $colorsEdu = ['bg-blue-500','bg-emerald-500','bg-amber-500','bg-red-500','bg-violet-500','bg-pink-500','bg-orange-500','bg-cyan-500']; @endphp
                    <div class="mt-4 space-y-2">
                        @foreach($eduLabels as $i => $label)
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                                <div class="flex items-center gap-2 text-sm text-gray-700">
                                    <span class="inline-block w-3 h-3 rounded-full {{ $colorsEdu[$i % count($colorsEdu)] }}"></span>
                                    {{ $label }}
                                </div>
                                <div class="text-sm font-semibold">{{ number_format($eduData[$i] ?? 0,0,',','.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="text-sm font-medium mb-2">Berdasarkan Pekerjaan</div>
                    <div class="h-56 w-full"><canvas id="statJob" style="width:100%;height:100%" data-labels='{!! json_encode($jobLabels) !!}' data-data='{!! json_encode($jobData) !!}'></canvas></div>
                    <div class="mt-4 space-y-2">
                        @foreach($jobLabels as $i => $label)
                            <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                                <div class="text-sm text-gray-700">{{ $label }}</div>
                                <div class="text-sm font-semibold">{{ number_format($jobData[$i] ?? 0,0,',','.') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4" id="stat-ibadah">
            <div class="text-sm font-medium mb-2">Statistik Data Rumah Ibadah</div>
            <div class="mt-4 h-56 w-full"><canvas id="chartIbadah" style="width:100%;height:100%" data-labels='{!! json_encode($jenisIbadahAll) !!}' data-data='{!! json_encode($ibadahDataArr) !!}' data-total='{{ $totalIbadah }}' data-fallback-label='Rumah Ibadah'></canvas></div>
            @php
                $labelsI = $jenisIbadahAll ?? [];
                $dataI = $ibadahDataArr ?? [];
                $colorsI = ['bg-blue-400','bg-sky-400','bg-pink-300','bg-amber-300','bg-emerald-400','bg-red-300','bg-cyan-300'];
            @endphp
            <div class="mt-4 space-y-2">
                @foreach($labelsI as $i => $label)
                    <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <span class="inline-block w-3 h-3 rounded-full {{ $colorsI[$i % count($colorsI)] }}"></span>
                            {{ $label }}
                        </div>
                        <div class="text-sm font-semibold">{{ number_format($dataI[$i] ?? 0,0,',','.') }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4" id="stat-umkm">
            <div class="text-sm font-medium mb-2">Stattistik Data UMKM</div>
            <div class="mt-4 h-56 w-full"><canvas id="chartUmkm" style="width:100%;height:100%" data-labels='{!! json_encode($jenisUmkmAll) !!}' data-data='{!! json_encode($umkmDataArr) !!}' data-total='{{ $totalUmkm }}' data-fallback-label='UMKM'></canvas></div>
            @php
                $labelsU = $jenisUmkmAll ?? [];
                $dataU = $umkmDataArr ?? [];
                $colorsU = ['bg-amber-400','bg-orange-400','bg-red-400','bg-emerald-400','bg-blue-400','bg-cyan-400','bg-fuchsia-400'];
            @endphp
            <div class="mt-4 space-y-2">
                @foreach($labelsU as $i => $label)
                    <div class="flex items-center justify-between bg-gray-50 rounded-xl p-3">
                        <div class="flex items-center gap-2 text-sm text-gray-700">
                            <span class="inline-block w-3 h-3 rounded-full {{ $colorsU[$i % count($colorsU)] }}"></span>
                            {{ $label }}
                        </div>
                        <div class="text-sm font-semibold">{{ number_format($dataU[$i] ?? 0,0,',','.') }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4" id="stat-pendidikan">
            <div class="text-sm font-medium mb-2">Statistik Data Sarana Pendidikan</div>
            @php
                $jenjangOrdered = config('pendidikan.jenjang', []);
                $formalByJenjang = $applyLkg(\App\Models\PendidikanFormal::select('jenjang')->selectRaw('COUNT(*) as total'))
                    ->groupBy('jenjang')->get();
                $mapJenjang = [];
                foreach ($formalByJenjang as $r) { $lbl = trim($r->jenjang ?? ''); if ($lbl==='') continue; $mapJenjang[$lbl] = (int)($r->total ?? 0); }
                $formalJenjangLabels = $jenjangOrdered;
                $formalJenjangData = array_map(fn($j) => $mapJenjang[$j] ?? 0, $formalJenjangLabels);

                $bidangOrdered = config('pendidikan.bidang_pelatihan', []);
                $nonFormalByBidang = $applyLkg(\App\Models\PendidikanNonFormal::select('bidang_pelatihan')->selectRaw('COUNT(*) as total'))
                    ->groupBy('bidang_pelatihan')->get();
                $mapBidang = [];
                foreach ($nonFormalByBidang as $r) { $lbl = trim($r->bidang_pelatihan ?? ''); if ($lbl==='') continue; $mapBidang[$lbl] = (int)($r->total ?? 0); }
                $nonFormBidangLabels = $bidangOrdered;
                $nonFormBidangData = array_map(fn($b) => $mapBidang[$b] ?? 0, $nonFormBidangLabels);
            @endphp
            <div class="mt-4 h-56 w-full"><canvas id="chartFormalJenjang" style="width:100%;height:100%" data-labels='{!! json_encode($formalJenjangLabels) !!}' data-data='{!! json_encode($formalJenjangData) !!}' data-total='{{ $totalFormal }}' data-fallback-label='Formal'></canvas></div>
            <div class="mt-4 h-56 w-full"><canvas id="chartNonBidang" style="width:100%;height:100%" data-labels='{!! json_encode($nonFormBidangLabels) !!}' data-data='{!! json_encode($nonFormBidangData) !!}' data-total='{{ $totalNonFormal }}' data-fallback-label='Non-Formal'></canvas></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    (function(){
        const doughnut = (id) => {
            const el = document.getElementById(id); if(!el) return;
            const labels = JSON.parse(el.dataset.labels||'[]');
            const data = JSON.parse(el.dataset.data||'[]');
            const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316','#22D3EE'];
            new Chart(el,{type:'doughnut',data:{labels:labels,datasets:[{data:data,backgroundColor:colors.slice(0,data.length)}]},options:{plugins:{legend:{position:'bottom'}},maintainAspectRatio:false,cutout:'65%'}});
        };
        try { doughnut('chartFormalJenjang'); } catch(e){}
        try { doughnut('chartNonBidang'); } catch(e){}
    })();
    </script>
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
        const doughnut = (id, labels, data, colors) => {
            const el = document.getElementById(id); if(!el) return;
            new Chart(el,{type:'doughnut',data:{labels:labels,datasets:[{data:data,backgroundColor:colors}]},options:{plugins:{legend:{position:'bottom'}},maintainAspectRatio:false,cutout:'65%'}});
        };
        const bar = (id, labels, data, color) => {
            const el = document.getElementById(id); if(!el) return;
            new Chart(el,{type:'bar',data:{labels:labels,datasets:[{label:'Total',data:data,backgroundColor:color}]} ,options:{plugins:{legend:{display:false}},maintainAspectRatio:false}});
        };
        const hbar = (id, labels, data, color) => {
            const el = document.getElementById(id); if(!el) return;
            new Chart(el,{type:'bar',data:{labels:labels,datasets:[{label:'Total',data:data,backgroundColor:color}]} ,options:{indexAxis:'y',plugins:{legend:{display:false}},maintainAspectRatio:false}});
        };

        buildChart('chartKependudukan', ['#3B82F6','#EC4899']);
        buildChart('chartKeluarga', ['#A7F3D0','#6EE7B7','#2DD4BF']);
        buildChart('chartStatusWarga', ['#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5','#99F6E4']);
        buildChart('chartIbadah', ['#93C5FD','#67E8F9','#FBCFE8','#FDE68A','#A7F3D0','#FCA5A5','#99F6E4']);
        buildChart('chartUmkm', ['#FDE68A','#FDBA74','#FCA5A5','#A7F3D0','#93C5FD','#67E8F9','#F5D0FE']);

        try {
            const aEl = document.getElementById('statUmur');
            const aLabels = JSON.parse(aEl.dataset.labels||'[]');
            const aData = JSON.parse(aEl.dataset.data||'[]');
            bar('statUmur', aLabels, aData, '#3B82F6');
        } catch(e) {}
        try {
            const rEl = document.getElementById('statAgama');
            const rLabels = JSON.parse(rEl.dataset.labels||'[]');
            const rData = JSON.parse(rEl.dataset.data||'[]');
            hbar('statAgama', rLabels, rData, '#10B981');
        } catch(e) {}
        try {
            const eEl = document.getElementById('statEdu');
            const eLabels = JSON.parse(eEl.dataset.labels||'[]');
            const eData = JSON.parse(eEl.dataset.data||'[]');
            const colors = ['#60A5FA','#10B981','#F59E0B','#EF4444','#8B5CF6','#EC4899','#F97316','#22D3EE'];
            doughnut('statEdu', eLabels, eData, colors.slice(0,eData.length));
        } catch(e) {}
        try {
            const jEl = document.getElementById('statJob');
            const jLabels = JSON.parse(jEl.dataset.labels||'[]');
            const jData = JSON.parse(jEl.dataset.data||'[]');
            hbar('statJob', jLabels, jData, '#6366F1');
        } catch(e) {}
    })();
    </script>
    
</div>
@endsection
