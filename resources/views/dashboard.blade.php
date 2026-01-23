@extends('layouts.admin')

@section('title', 'Dashboard - BangunTrack')
@section('header-title')
    <span class="text-slate-800 font-bold tracking-tight">DASHBOARD VIEW</span>
@endsection

@section('content')
    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 italic">DASHBOARD ANALITIK</h2>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-1">TOKO BANGUNAN - PANTAUAN REAL-TIME</p>
        </div>
        <div class="bg-white px-4 py-1.5 rounded-full border border-slate-200 shadow-sm flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            <span class="text-xs font-bold text-slate-600">DATA TERKINI</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.1)] relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Aset Stok</p>
                    <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalAset, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                <div class="bg-blue-500 w-[75%] h-full rounded-full"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-red-100 shadow-[0_2px_10px_-3px_rgba(239,68,68,0.1)] hover:shadow-lg transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Belum Lunas</p>
                    <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalHutang, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-lg">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                <div class="bg-red-500 w-[45%] h-full rounded-full"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-[0_2px_10px_-3px_rgba(16,185,129,0.1)] hover:shadow-lg transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Barang Ready</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $barangReady }} Item</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fas fa-box-open"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                <div class="bg-emerald-500 w-[80%] h-full rounded-full"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-orange-100 shadow-[0_2px_10px_-3px_rgba(249,115,22,0.1)] hover:shadow-lg transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Rata-rata Margin</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ number_format($avgMargin, 1) }}%</h3>
                </div>
                <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-lg">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="w-full bg-slate-100 h-1 rounded-full overflow-hidden">
                <div class="bg-orange-500 w-[60%] h-full rounded-full"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-500"></i> TREN OMSET BULANAN
                </h4>
                <select onchange="window.location.href='?year='+this.value" 
                    class="text-xs border-none bg-slate-50 text-slate-600 font-bold rounded-lg py-1 px-3 focus:ring-0 cursor-pointer hover:bg-slate-100">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>TAHUN {{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
            <p class="text-[10px] text-slate-400 mt-4 italic">* BATANG BERGERAK DINAMIS MENGIKUTI OMSET TERTINGGI</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                <i class="fas fa-pie-chart text-orange-500"></i> STATUS INVENTORI
            </h4>
            
            <div class="relative h-48 w-full flex justify-center">
                <canvas id="stockChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-3xl font-bold text-slate-800">{{ $skuAktif }}</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase">SKU Aktif</span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span class="text-xs font-bold text-slate-600">READY STOCK</span>
                    </div>
                    <span class="text-xs font-bold text-blue-600">{{ $barangReady }} Item</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                        <span class="text-xs font-bold text-slate-600">STOK KOSONG</span>
                    </div>
                    <span class="text-xs font-bold text-red-600">{{ $stokKosong }} Item</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <h4 class="text-sm font-bold text-slate-700 mb-6 flex items-center gap-2">
                <i class="fas fa-cube text-purple-500"></i> PRODUK TERLARIS (REVENUE)
            </h4>
            
            <div class="space-y-4">
                @forelse($topProducts as $top)
                <div class="flex items-center justify-between group cursor-pointer p-2 hover:bg-slate-50 rounded-lg transition-all">
                    <div class="flex items-center gap-4">
                        <span class="text-2xl font-bold text-slate-200 group-hover:text-primary transition-colors">#{{ $loop->iteration }}</span>
                        <div>
                            <h5 class="text-sm font-bold text-slate-700">{{ $top->stockItem->masterProduct->nama ?? 'Unknown' }}</h5>
                            <p class="text-xs text-slate-400">{{ $top->total_qty }} UNIT TERJUAL</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($top->total_revenue, 0, ',', '.') }}</p>
                        <p class="text-[10px] font-bold text-emerald-400 flex items-center justify-end gap-1"><i class="fas fa-arrow-up"></i> REVENUE</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-slate-400 text-xs py-4">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-slate-900 p-8 rounded-3xl text-white relative overflow-hidden shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary opacity-10 blur-3xl rounded-full -mr-10 -mt-10"></div>
            
            <h4 class="text-lg font-bold italic mb-8 relative z-10 text-blue-300">SMART INSIGHTS</h4>

            <div class="space-y-6 relative z-10">
                <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700 backdrop-blur-sm">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-exclamation-circle text-yellow-400"></i>
                        <h5 class="text-xs font-bold text-slate-300 uppercase tracking-wide">Analisis Stok</h5>
                    </div>
                    <p class="text-sm text-slate-200 leading-relaxed">
                        Terdapat <span class="text-yellow-400 font-bold">{{ $lowStockCount }} produk</span> dengan stok di bawah 20 unit.
                    </p>
                </div>
            </div>
            <div class="mt-8 flex justify-between items-center relative z-10">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    <span class="text-[10px] text-slate-500 font-bold uppercase">Analytics Core Active</span>
                </div>
                <span class="text-[10px] bg-slate-800 border border-slate-700 px-2 py-1 rounded text-slate-400 font-mono">V2.5.0-STABLE</span>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // 1. CHART OMSET BULANAN
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const gradientSales = ctxSales.createLinearGradient(0, 0, 0, 400);
    gradientSales.addColorStop(0, '#3B82F6'); 
    gradientSales.addColorStop(1, '#60A5FA'); 

    new Chart(ctxSales, {
        type: 'bar',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'],
            datasets: [{
                label: 'Omset',
                data: @json($chartData), 
                backgroundColor: '#63A0FF',
                borderRadius: 6,
                barThickness: 25,
                hoverBackgroundColor: '#2563EB'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false, grid: { display: false } },
                x: { grid: { display: false, drawBorder: false }, ticks: { font: { size: 10, family: 'Inter' }, color: '#94A3B8' } }
            }
        }
    });

    // 2. CHART STATUS INVENTORI
    const ctxStock = document.getElementById('stockChart').getContext('2d');
    new Chart(ctxStock, {
        type: 'doughnut',
        data: {
            labels: ['Ready Stock', 'Stok Kosong'],
            datasets: [{
                data: [{{ $barangReady }}, {{ $stokKosong }}],
                backgroundColor: ['#3B82F6', '#EF4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush