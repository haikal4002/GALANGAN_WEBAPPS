@extends('layouts.admin')

@section('title', 'History Belanja Stok - BangunTrack')

@section('header-title')
    <span class="text-slate-800 font-bold tracking-tight uppercase">HISTORY BELANJA</span>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-200">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-bold opacity-80 uppercase tracking-wider">Total Pembelian</p>
                <i class="fas fa-shopping-cart opacity-50 text-xl"></i>
            </div>
            <h3 class="text-2xl font-bold">{{ $purchases->total() }} Transaksi</h3>
        </div>
        <div class="bg-emerald-500 rounded-2xl p-6 text-white shadow-lg shadow-emerald-200">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-bold opacity-80 uppercase tracking-wider">Pembayaran Lunas</p>
                <i class="fas fa-check-circle opacity-50 text-xl"></i>
            </div>
            <h3 class="text-2xl font-bold">Rp {{ number_format(\App\Models\Purchase::where('status_pembayaran', 'Lunas')->sum('total_nominal'), 0, ',', '.') }}</h3>
        </div>
        <div class="bg-red-500 rounded-2xl p-6 text-white shadow-lg shadow-red-200">
            <div class="flex justify-between items-start mb-2">
                <p class="text-[11px] font-bold opacity-80 uppercase tracking-wider">Total Hutang</p>
                <i class="fas fa-exclamation-triangle opacity-50 text-xl"></i>
            </div>
            <h3 class="text-2xl font-bold">Rp {{ number_format(\App\Models\Purchase::where('status_pembayaran', 'Belum Lunas')->sum('total_nominal'), 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <i class="fas fa-list text-indigo-600"></i> LOG BELANJA STOK
            </h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider border-b border-slate-200">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">No. Resi</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4">Detail Barang</th>
                        <th class="px-6 py-4">Total Nominal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Jatuh Tempo</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($purchases as $purchase)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 text-slate-400 font-mono text-xs">{{ ($purchases->currentPage() - 1) * $purchases->perPage() + $loop->iteration }}</td>
                        <td class="px-6 py-4 font-medium">{{ \Carbon\Carbon::parse($purchase->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-indigo-600">{{ $purchase->nomor_resi }}</td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800">{{ $purchase->supplier->nama ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <ul class="space-y-1">
                                @foreach($purchase->purchaseDetails as $detail)
                                <li class="text-[11px] leading-tight">
                                    <span class="font-bold text-slate-600">{{ $detail->productUnit->masterProduct->nama ?? 'N/A' }}</span>
                                    <span class="text-slate-400">({{ $detail->qty }} {{ $detail->productUnit->masterUnit->nama ?? 'Unit' }})</span>
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp {{ number_format($purchase->total_nominal, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($purchase->status_pembayaran == 'Lunas')
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase border border-emerald-200">Lunas</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase border border-red-200">Hutang</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($purchase->status_pembayaran == 'Belum Lunas')
                                <span class="text-xs {{ \Carbon\Carbon::parse($purchase->jatuh_tempo)->isPast() ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                                    {{ \Carbon\Carbon::parse($purchase->jatuh_tempo)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($purchase->status_pembayaran == 'Belum Lunas')
                                <form action="{{ route('purchase.pay', $purchase->id) }}" method="POST" onsubmit="return confirm('Tandai transaksi ini sebagai LUNAS?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-[10px] font-bold rounded-lg hover:bg-indigo-700 transition-all shadow-sm">
                                        LUNASKAN
                                    </button>
                                </form>
                            @else
                                <span class="text-emerald-500"><i class="fas fa-check-double"></i> Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-slate-400 italic">Belum ada history transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($purchases->hasPages())
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
            {{ $purchases->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
