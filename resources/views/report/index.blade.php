@extends('layouts.admin')

@section('title', 'Laporan Bulanan - BangunTrack')

@section('header-title')
    <i class="fas fa-file-invoice-dollar text-primary mr-2"></i> REPORT VIEW
@endsection

@section('content')

<div class="space-y-8">

    {{-- HEADER & FILTER --}}
    <div class="bg-[#0B1120] p-6 rounded-2xl shadow-lg border border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-white font-bold text-xl flex items-center gap-2">
                <i class="fas fa-chart-pie text-blue-400"></i> LAPORAN EKSEKUTIF
            </h2>
            <p class="text-slate-400 text-xs mt-1 uppercase tracking-wider">Analisis Performa Bulanan Toko</p>
        </div>

        <form action="{{ route('report.index') }}" method="GET" class="flex items-center gap-3">
            <a href="{{ route('report.export', ['year' => $year]) }}" 
               class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase transition-all flex items-center gap-2">
                <i class="fas fa-file-excel"></i> Export Excel {{ $year }}
            </a>
            
            <div class="flex items-center bg-slate-800 rounded-lg p-1 border border-slate-600">
                {{-- Tombol Previous Month --}}
                <a href="{{ route('report.index', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}" 
                   class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-700 rounded-md transition-all">
                    <i class="fas fa-chevron-left"></i>
                </a>
                
                {{-- Bulan Aktif --}}
                <span class="px-4 text-white font-bold text-sm uppercase min-w-[140px] text-center">
                    {{ $monthName }}
                </span>

                {{-- Tombol Next Month --}}
                <a href="{{ route('report.index', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}" 
                   class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-700 rounded-md transition-all">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- TABEL 1: LAPORAN BARANG TERJUAL --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-500"></i> LAPORAN BULANAN BARANG TERJUAL
            </h3>
            <span class="text-[10px] bg-slate-100 text-slate-500 px-3 py-1 rounded-full font-bold uppercase">
                Total {{ count($reportItems) }} Produk
            </span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] text-slate-400 uppercase font-bold tracking-wider border-b border-slate-200">
                        <th class="px-6 py-4">Nama Barang</th>
                        <th class="px-6 py-4 text-center">Total Terjual</th>
                        <th class="px-6 py-4 text-right">Total Modal (HPP)</th>
                        <th class="px-6 py-4 text-right">Total Jual (Omset)</th>
                        <th class="px-6 py-4 text-right text-green-600">Profit / Laba</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100">
                    @forelse($reportItems as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800 uppercase text-xs">{{ $item['name'] }}</td>
                        <td class="px-6 py-4 text-center font-bold">{{ $item['qty'] }}</td>
                        <td class="px-6 py-4 text-right text-slate-500 italic">Rp {{ number_format($item['modal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-slate-700">Rp {{ number_format($item['omset'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-green-600">Rp {{ number_format($item['laba'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-xs">Belum ada penjualan bulan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                {{-- SUBTOTAL ROW --}}
                @if(count($reportItems) > 0)
                <tfoot class="bg-slate-50 border-t-2 border-slate-200">
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-500 italic text-xs uppercase">Subtotal Barang</td>
                        <td class="px-6 py-4 text-center font-bold text-slate-700">{{ $subtotalBarang['qty'] }}</td>
                        <td class="px-6 py-4 text-right font-bold text-slate-500 italic">Rp {{ number_format($subtotalBarang['modal'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-slate-700">Rp {{ number_format($subtotalBarang['omset'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold text-green-600 italic">Rp {{ number_format($subtotalBarang['laba'], 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- TABEL 2: LAPORAN KEUANGAN (FINANCIAL SNAPSHOT) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-[#0B1120] px-6 py-4 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <i class="fas fa-wallet text-yellow-400"></i> LAPORAN KEUANGAN BULANAN
            </h3>
            <div class="flex items-center gap-2 text-[10px] text-green-400 font-bold uppercase tracking-wider">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Financial Snapshot
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] text-slate-400 uppercase font-bold tracking-wider border-b border-slate-200">
                        <th class="px-6 py-4">Nama Bulan</th>
                        <th class="px-6 py-4 text-center">Total Pemasukan</th>
                        <th class="px-6 py-4 text-center">Total Operasional & Pengeluaran</th>
                        <th class="px-6 py-4 text-center">Modal Total (HPP)</th>
                        <th class="px-6 py-4 text-center">Net Profit / Laba Bersih</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-6 font-bold text-slate-600 uppercase flex items-center gap-3">
                            <i class="far fa-calendar-alt text-lg text-slate-400"></i> {{ $monthName }}
                        </td>
                        
                        <td class="px-6 py-6 text-center">
                            <div class="font-bold text-green-600 text-lg">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                            <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wide">↗ Penjualan + Kas Masuk</span>
                        </td>

                        <td class="px-6 py-6 text-center">
                            <div class="font-bold text-red-500 text-lg">(Rp {{ number_format($totalOperasional, 0, ',', '.') }})</div>
                            <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wide">↘ Biaya Operasional</span>
                        </td>

                        <td class="px-6 py-6 text-center">
                            <div class="font-bold text-orange-500 text-lg">(Rp {{ number_format($totalHPP, 0, ',', '.') }})</div>
                            <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wide">↺ Harga Pokok Barang</span>
                        </td>

                        <td class="px-6 py-6 text-center">
                            <div class="inline-block px-6 py-2 rounded-xl bg-green-50 border border-green-200">
                                <div class="font-extrabold text-green-700 text-xl">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- INFO BOX --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-4 items-start">
        <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
        <div>
            <h4 class="text-xs font-bold text-blue-700 uppercase mb-1">Informasi Perhitungan</h4>
            <p class="text-[11px] text-blue-600/80 leading-relaxed">
                <span class="font-bold">Net Profit</span> dihitung dengan rumus: 
                (<i>Total Pemasukan Barang & Kas Kode 11</i>) - (<i>Total Operasional Kode 14 & Expenses</i>) - (<i>Total Modal Barang Terjual</i>). 
                Pastikan semua modal kulak barang telah diinput dengan benar di Master Stock agar nilai HPP akurat.
            </p>
        </div>
    </div>

</div>

@endsection