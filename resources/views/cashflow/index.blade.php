@extends('layouts.admin')

@section('title', 'Cash Flow - BangunTrack')

@section('header-title')
    <i class="fas fa-wallet text-primary mr-2"></i> CASHFLOW VIEW
@endsection

@section('content')

{{-- TOP METRICS --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    {{-- Card Saldo --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
            <i class="fas fa-wallet text-2xl"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Saldo Kas Saat Ini</p>
            <h3 class="text-3xl font-extrabold text-slate-800">Rp {{ number_format($saldoSaatIni, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- Card Profit --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
            <i class="fas fa-chart-line text-2xl"></i>
        </div>
        <div>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Profit (Bulan Ini)</p>
            <h3 class="text-3xl font-extrabold text-slate-800">Rp {{ number_format($profitBulanIni, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- KOLOM KIRI (UTAMA) --}}
    <div class="lg:col-span-2 space-y-8">
        
        {{-- 1. FORM MUTASI KAS HARIAN --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h4 class="text-sm font-bold text-slate-700 uppercase border-l-4 border-primary pl-3">Mutasi Kas Harian</h4>
                
                {{-- Legend Kode (Hanya Tampilan) --}}
                <div class="hidden md:flex gap-3 text-[10px] font-medium text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg">
                    @foreach($codes->take(4) as $code)
                        <span><b class="text-primary">{{ $code->code }}:</b> {{ Str::limit($code->label, 10) }}</span>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('cashflow.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    
                    {{-- Tanggal --}}
                    <div class="md:col-span-2">
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold p-3 focus:outline-none focus:border-primary">
                    </div>

                    {{-- Kode Transaksi --}}
                    <div class="md:col-span-3">
                        <select name="transaction_code_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold p-3 focus:outline-none focus:border-primary">
                            @foreach($codes as $code)
                                <option value="{{ $code->id }}">{{ $code->code }} - {{ $code->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Keterangan --}}
                    <div class="md:col-span-3">
                        <input type="text" name="keterangan" placeholder="Keterangan..." class="w-full bg-slate-50 border border-slate-200 rounded-lg text-xs p-3 focus:outline-none focus:border-primary" required>
                    </div>

                    {{-- Nominal --}}
                    <div class="md:col-span-3">
                        <input type="number" name="amount" placeholder="Nominal Rp 0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold p-3 focus:outline-none focus:border-primary" required>
                    </div>

                    {{-- Tombol --}}
                    <div class="md:col-span-1">
                        <button type="submit" class="w-full bg-primary hover:bg-orange-700 text-white rounded-lg p-3 flex items-center justify-center transition-all shadow-lg shadow-orange-500/30">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- 2. TABEL MUTASI --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-[10px] text-slate-400 uppercase font-bold tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Kode</th>
                            <th class="px-6 py-4">Keterangan</th>
                            <th class="px-6 py-4 text-right text-green-600">Debit (Masuk)</th>
                            <th class="px-6 py-4 text-right text-red-500">Kredit (Keluar)</th>
                            <th class="px-6 py-4 text-right font-extrabold text-slate-700">Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs text-slate-600 divide-y divide-slate-100">
                        @forelse($cashflows as $cf)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-slate-400 font-mono">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-bold">{{ \Carbon\Carbon::parse($cf->tanggal)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded border border-slate-200 font-bold text-[10px]">
                                    {{ $cf->transactionCode->code ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 uppercase font-medium text-slate-700">{{ $cf->keterangan }}</td>
                            
                            {{-- Debit --}}
                            <td class="px-6 py-4 text-right">
                                @if($cf->debit > 0)
                                    <span class="text-green-600 font-bold">Rp {{ number_format($cf->debit, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            {{-- Kredit --}}
                            <td class="px-6 py-4 text-right">
                                @if($cf->kredit > 0)
                                    <span class="text-red-500 font-bold">Rp {{ number_format($cf->kredit, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>

                            {{-- Saldo Berjalan --}}
                            <td class="px-6 py-4 text-right font-extrabold text-slate-800">
                                Rp {{ number_format($cf->saldo_berjalan, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400">Belum ada data mutasi kas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- KOLOM KANAN (WIDGET RINGKASAN) --}}
    <div class="lg:col-span-1">
        <div class="bg-[#0B1120] rounded-2xl shadow-xl overflow-hidden text-white sticky top-24">
            <div class="p-5 border-b border-slate-700 bg-slate-800/50">
                <h4 class="text-sm font-bold uppercase tracking-wider">Ringkasan Performa</h4>
                <p class="text-[10px] text-slate-400 mt-1">Cashflow 12 Bulan Terakhir</p>
            </div>
            
            <div class="p-2 overflow-y-auto max-h-[500px] custom-scrollbar">
                <table class="w-full text-xs">
                    <thead class="text-slate-500 font-bold border-b border-slate-700">
                        <tr>
                            <th class="py-3 pl-4 text-left">Bulan</th>
                            <th class="py-3 text-right">Omset</th>
                            <th class="py-3 pr-4 text-right">Profit (Cash)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($monthlyStats as $stat)
                        <tr class="hover:bg-slate-800/50 transition-colors group">
                            <td class="py-3 pl-4 font-bold text-slate-400 group-hover:text-white uppercase text-[9px]">
                                {{ $stat->month_label }}
                            </td>
                            <td class="py-3 text-right text-green-400 font-bold">
                                Rp {{ number_format($stat->omset, 0, ',', '.') }}
                            </td>
                            <td class="py-3 pr-4 text-right text-blue-400 font-bold">
                                Rp {{ number_format($stat->profit, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 bg-slate-800/50 border-t border-slate-700 text-center">
                <p class="text-[10px] text-slate-500">Data berdasarkan cash in/out aktual.</p>
            </div>
        </div>
    </div>

</div>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
     class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-bold flex items-center gap-3 z-50">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@endsection