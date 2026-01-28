@extends('layouts.admin')

@section('title', 'Catat Pengeluaran - BangunTrack')

@section('header-title')
    <i class="fas fa-money-bill-wave text-primary mr-2"></i> EXPENSES VIEW
@endsection

@section('content')

<div x-data="{ showCodeModal: false }" class="space-y-8">

    {{-- GRID UTAMA: FORM (KIRI) & SUMMARY (KANAN) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- 1. FORM INPUT PENGELUARAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-sm font-bold text-red-500 uppercase flex items-center gap-2">
                    <i class="fas fa-file-invoice"></i> Catat Pengeluaran
                </h3>
                <button @click="showCodeModal = true" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-[10px] font-bold uppercase transition-all">
                    # Kelola Kode
                </button>
            </div>

            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:outline-none focus:border-red-500">
                    </div>

                    {{-- Kode --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kode Pengeluaran</label>
                        <select name="transaction_code_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-red-500">
                            @foreach($codes as $code)
                                <option value="{{ $code->id }}"># {{ $code->code }} - {{ $code->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Keterangan</label>
                        <input type="text" name="keterangan" placeholder="Contoh: Bayar Listrik, Beli ATK..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-red-500" required>
                    </div>

                    {{-- Nominal --}}
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nominal (Rp)</label>
                        <div x-data="{ displayAmount: '' }">
                            <input type="text" 
                                   x-model="displayAmount"
                                   @input="
                                       let raw = $event.target.value.replace(/\D/g, '');
                                       let num = parseInt(raw) || 0;
                                       displayAmount = formatRupiah(num);
                                       $refs.amountHidden.value = num;
                                   "
                                   placeholder="0" 
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold focus:outline-none focus:border-red-500" required>
                            <input type="hidden" name="amount" x-ref="amountHidden">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#E11D48] hover:bg-red-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-red-500/30 transition-all">
                        <i class="fas fa-plus mr-1"></i> SIMPAN PENGELUARAN
                    </button>
                </div>
            </form>
        </div>

        {{-- 2. CARD TOTAL (MERAH BESAR) --}}
        <div class="bg-[#E11D48] rounded-2xl shadow-xl p-8 text-white flex flex-col justify-between relative overflow-hidden">
            {{-- Background Accent --}}
            <i class="fas fa-chart-area absolute -bottom-4 -right-4 text-9xl text-white opacity-10"></i>
            
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest opacity-80 mb-1">Total Seluruh Pengeluaran</h4>
                <p class="text-[10px] opacity-60">(Bulan Ini)</p>
                <h2 class="text-5xl font-extrabold mt-4">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h2>
            </div>

            <div class="mt-8 space-y-2">
                <div class="flex items-center gap-2 text-[10px] font-bold bg-white/20 px-3 py-2 rounded-lg w-max backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                    OTOMATIS TERCATAT DI CASH FLOW
                </div>
                <div class="flex items-center gap-2 text-[10px] font-bold bg-white/20 px-3 py-2 rounded-lg w-max backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                    GUNAKAN KODE YANG SESUAI UNTUK LAPORAN
                </div>
            </div>
        </div>
    </div>

    {{-- 3. TABEL RIWAYAT PENGELUARAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Riwayat Pengeluaran Terakhir</h4>
            <button @click="showCodeModal = true" class="text-[10px] font-bold text-blue-600 hover:underline"># KELOLA KODE</button>
        </div>
        
        <div class="overflow-x-auto w-full max-h-[500px] overflow-y-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] text-slate-400 uppercase font-bold tracking-wider border-b border-slate-200">
                        <th class="px-6 py-4 sticky top-0 bg-slate-50 z-10">No</th>
                        <th class="px-6 py-4 sticky top-0 bg-slate-50 z-10">Tanggal</th>
                        <th class="px-6 py-4 text-center sticky top-0 bg-slate-50 z-10">Kode</th>
                        <th class="px-6 py-4 sticky top-0 bg-slate-50 z-10">Keterangan</th>
                        <th class="px-6 py-4 text-right text-red-500 sticky top-0 bg-slate-50 z-10">Nominal</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-slate-600 divide-y divide-slate-100">
                    @forelse($expenses as $exp)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-slate-400 font-mono">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-bold">{{ \Carbon\Carbon::parse($exp->tanggal)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded text-[10px] font-bold text-white bg-{{ $exp->transactionCode->color ?? 'slate' }}-500">
                                {{ $exp->transactionCode->code ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium uppercase">{{ $exp->keterangan }}</td>
                        <td class="px-6 py-4 text-right font-bold text-red-500">Rp {{ number_format($exp->kredit, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-300 italic">Belum ada data pengeluaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. MODAL KELOLA KODE TRANSAKSI --}}
    <div x-show="showCodeModal" style="display: none;" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm"
         x-transition.opacity>
        
        <div @click.away="showCodeModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden flex flex-col max-h-[90vh]">
            
            {{-- Header --}}
            <div class="bg-[#4F46E5] px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-sm flex items-center gap-2">
                    <i class="fas fa-hashtag"></i> KELOLA KODE TRANSAKSI
                </h3>
                <button @click="showCodeModal = false" class="text-indigo-200 hover:text-white">&times;</button>
            </div>

            {{-- Body: Form Tambah --}}
            <div class="p-6 border-b border-slate-100 bg-slate-50">
                <form action="{{ route('codes.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kode (Prefix)</label>
                            <input type="text" name="code" placeholder="Ex: OUT-LAIN" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold focus:border-red-500 focus:outline-none" required>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Kategori</label>
                            <input type="text" name="label" placeholder="Ex: Biaya Sampah" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-xs focus:border-red-500 focus:outline-none" required>
                        </div>
                    </div>

                    {{-- Pilihan Warna --}}
                    <div class="mb-4">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Warna Teks UI</label>
                        <div class="flex gap-3">
                            @foreach(['danger', 'success', 'primary', 'warning', 'indigo', 'teal', 'slate'] as $color)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="{{ $color }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="w-6 h-6 rounded-full bg-{{ $color == 'primary' ? 'orange' : ($color == 'danger' ? 'red' : ($color == 'success' ? 'green' : ($color == 'warning' ? 'yellow' : $color))) }}-500 border-2 border-transparent peer-checked:border-slate-800 peer-checked:scale-110 transition-all shadow-sm"></div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#4F46E5] hover:bg-indigo-700 text-white rounded-lg font-bold text-xs shadow-lg shadow-indigo-500/30 transition-all">
                        TAMBAH KODE BARU
                    </button>
                </form>
            </div>

            {{-- List Kode --}}
            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-3">Daftar Kode Aktif</p>
                <div class="space-y-2">
                    @foreach($codes as $code)
                    <div class="flex items-center justify-between p-3 bg-white border border-slate-100 rounded-lg shadow-sm group">
                        <div class="flex items-center gap-3">
                            <span class="font-mono font-bold text-slate-800 text-sm">{{ $code->code }}</span>
                            <span class="text-xs font-bold text-{{ $code->color == 'primary' ? 'orange' : ($code->color == 'danger' ? 'red' : ($code->color == 'success' ? 'green' : ($code->color == 'warning' ? 'yellow' : $code->color))) }}-600 uppercase">{{ $code->label }}</span>
                        </div>
                        
                        {{-- Tombol Hapus (Hanya muncul jika bukan kode sistem) --}}
                        @if(!in_array($code->code, ['11', '12', '13', '14'])) {{-- Proteksi kode bawaan --}}
                            <form action="{{ route('codes.destroy', $code->id) }}" method="POST" onsubmit="return confirm('Hapus kode ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer Info --}}
            <div class="p-4 bg-slate-100 text-center border-t border-slate-200">
                <p class="text-[9px] text-slate-400 leading-tight">
                    Kode ini digunakan untuk mengelompokkan transaksi di Cash Flow & Laporan. 
                    <br>Sangat penting untuk konsistensi data.
                </p>
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