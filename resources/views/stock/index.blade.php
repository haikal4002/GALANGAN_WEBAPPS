@extends('layouts.admin')

@section('title', 'Master Stock - BangunTrack')

@section('header-title')
    <span class="text-slate-800 font-bold tracking-tight uppercase">MASTER VIEW</span>
@endsection

@section('header-right')
    <div class="flex items-center gap-3" x-data> 
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-300"></i>
            </span>
            <input type="text" class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-full text-sm focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all placeholder-slate-400" placeholder="Cari data...">
        </div>

        <button @click="$dispatch('open-manage-modal')" 
                class="px-4 py-2 rounded-lg border border-orange-200 text-primary bg-white text-xs font-bold hover:bg-orange-50 transition-all flex items-center gap-2">
            <i class="fas fa-tag"></i> KELOLA BARANG
        </button>

        <button @click="$dispatch('open-supplier-modal')"
                class="px-4 py-2 rounded-lg bg-slate-800 text-white text-xs font-bold hover:bg-slate-700 transition-all flex items-center gap-2">
            <i class="fas fa-truck"></i> SUPPLIER
        </button>

        <button @click="$dispatch('open-add-stock-modal')"
                class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold hover:bg-orange-700 transition-all shadow-lg shadow-orange-500/30 flex items-center gap-2">
            <i class="fas fa-plus"></i> TAMBAH STOK
        </button>
    </div>
@endsection

@section('content')

    {{-- STATE MANAGEMENT UTAMA --}}
    <div x-data="{ 
            showManageModal: false, 
            showSupplierModal: false,
            showAddStockModal: false,
            showEditStockModal: false,
            editData: {},
            searchQuery: '',
            searchSupplier: '' 
         }"
         @open-manage-modal.window="showManageModal = true"
         @open-supplier-modal.window="showSupplierModal = true"
         @open-add-stock-modal.window="showAddStockModal = true"
         @open-edit-stock-modal.window="showEditStockModal = true; editData = $event.detail">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-blue-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Aset Stok</p>
                    <i class="fas fa-wallet text-blue-500 bg-blue-50 p-2 rounded-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalAset, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-red-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Belum Lunas</p>
                    <i class="fas fa-exclamation-triangle text-red-500 bg-red-50 p-2 rounded-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalHutang, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Barang Ready</p>
                    <i class="fas fa-box-open text-emerald-500 bg-emerald-50 p-2 rounded-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $barangReady }} Item</h3>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-orange-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Margin</p>
                    <i class="fas fa-chart-line text-orange-500 bg-orange-50 p-2 rounded-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($avgMargin, 1) }}%</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                    <i class="fas fa-th-large text-primary"></i> INVENTORI MASTER STOCK
                </h4>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4 whitespace-nowrap">No</th>
                            <th class="px-6 py-4 whitespace-nowrap">Nama Barang</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Qty</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Stok Awal</th>
                            <th class="px-6 py-4 whitespace-nowrap">Harga Beli</th>
                            <th class="px-6 py-4 whitespace-nowrap">Nominal</th>
                            <th class="px-6 py-4 whitespace-nowrap text-orange-500">Margin</th>
                            <th class="px-6 py-4 whitespace-nowrap text-green-600">Harga Jual</th>
                            <th class="px-6 py-4 whitespace-nowrap">Supplier</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Status</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($stocks as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-400 font-mono text-xs">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-800">{{ $item->masterProduct->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold {{ $item->qty == 0 ? 'text-red-500' : 'text-slate-700' }}">{{ $item->qty }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-slate-400 text-xs">{{ $item->stok_awal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-orange-600 font-bold">{{ $item->margin }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">{{ $item->supplier->nama ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->status_pembayaran == 'Lunas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600 border border-green-200"><i class="fas fa-check-circle"></i> Lunas</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-600 border border-red-200"><i class="fas fa-clock"></i> Belum</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                    <button @click="$dispatch('open-edit-stock-modal', {
                                        id: {{ $item->id }},
                                        tanggal: '{{ $item->tanggal }}',
                                        nomor_resi: '{{ $item->nomor_resi }}',
                                        master_product_id: {{ $item->master_product_id }},
                                        stok_awal: {{ $item->stok_awal }},
                                        qty: {{ $item->qty }},
                                        harga_beli: {{ $item->harga_beli }},
                                        margin: {{ $item->margin }},
                                        harga_atas: {{ $item->harga_atas }},
                                        supplier_id: {{ $item->supplier_id }},
                                        status_pembayaran: '{{ $item->status_pembayaran }}',
                                        status_barang: '{{ $item->status_barang }}',
                                        jatuh_tempo: '{{ $item->jatuh_tempo }}',
                                        qty_kulak: {{ $item->qty_kulak }}
                                    })" class="w-8 h-8 rounded-lg border border-slate-200 text-blue-500 hover:bg-blue-50 hover:border-blue-500 transition-all flex items-center justify-center shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>

                                    <form action="{{ route('stok.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data stok ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg border border-slate-200 text-red-500 hover:bg-red-50 hover:border-red-500 transition-all flex items-center justify-center shadow-sm">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="px-6 py-10 text-center text-slate-400">Belum ada data stok.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 1: KELOLA MASTER BARANG (KECIL)  --}}
        {{-- ========================================== --}}
        <div x-show="showManageModal" 
             style="display: none;"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center">
            
            <div @click.away="showManageModal = false"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
                
                <div class="bg-slate-800 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-sm tracking-wide flex items-center gap-2">
                        <i class="fas fa-tags text-orange-500"></i> KELOLA MASTER BARANG
                    </h3>
                    <button @click="showManageModal = false" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-times text-lg"></i></button>
                </div>

                <div class="p-6">
                    <form action="{{ route('master-product.store') }}" method="POST" class="flex gap-2 mb-6">
                        @csrf
                        <input type="text" name="nama" required 
                               class="flex-1 bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-primary focus:border-primary block p-2.5 placeholder-slate-400" 
                               placeholder="Input nama barang baru...">
                        <button type="submit" class="p-2.5 bg-primary text-white rounded-lg hover:bg-orange-700 transition-colors shadow-lg shadow-orange-500/30">
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>

                    <div class="mb-3 relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-slate-300 text-xs"></i></span>
                        <input type="text" x-model="searchQuery" class="w-full pl-8 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-lg text-xs focus:ring-1 focus:ring-slate-200 uppercase" placeholder="CARI MASTER BARANG...">
                    </div>

                    <div class="max-h-64 overflow-y-auto pr-1 space-y-2 no-scrollbar">
                        @foreach($masterProducts as $product)
                            <div class="bg-slate-50 border border-slate-100 p-3 rounded-lg flex justify-between items-center group hover:bg-white hover:border-orange-200 transition-all"
                                 x-show="'{{ strtoupper($product->nama) }}'.includes(searchQuery.toUpperCase())">
                                <span class="text-xs font-bold text-slate-700 uppercase">{{ $product->nama }}</span>
                                <form action="{{ route('master-product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus master barang ini? Data stok yang menggunakan barang ini tidak akan terpengaruh namun master barang akan terhapus jika tidak ada relasi.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 2: KELOLA SUPPLIER (KECIL)       --}}
        {{-- ========================================== --}}
        <div x-show="showSupplierModal" 
             style="display: none;"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center">

            <div @click.away="showSupplierModal = false"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
                
                <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-sm tracking-wide flex items-center gap-2">
                        <i class="fas fa-users text-blue-500"></i> KELOLA SUPPLIER
                    </h3>
                    <button @click="showSupplierModal = false" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-times text-lg"></i></button>
                </div>

                <div class="p-6">
                    <form action="{{ route('supplier.store') }}" method="POST" class="flex gap-2 mb-6">
                        @csrf
                        <input type="text" name="nama" required 
                               class="flex-1 bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 placeholder-slate-400" 
                               placeholder="Nama supplier baru...">
                        <button type="submit" class="p-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>

                    <div class="mb-3 relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-slate-300 text-xs"></i></span>
                        <input type="text" x-model="searchSupplier" class="w-full pl-8 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-lg text-xs focus:ring-1 focus:ring-slate-200 uppercase" placeholder="CARI SUPPLIER...">
                    </div>

                    <div class="max-h-64 overflow-y-auto pr-1 space-y-2 no-scrollbar">
                        @foreach($suppliers as $supplier)
                            <div class="bg-slate-50 border border-slate-100 p-3 rounded-lg flex justify-between items-center group hover:bg-white hover:border-blue-200 transition-all"
                                 x-show="'{{ strtoupper($supplier->nama) }}'.includes(searchSupplier.toUpperCase())">
                                <span class="text-xs font-bold text-slate-700 uppercase">{{ $supplier->nama }}</span>
                                <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 3: TAMBAH STOK BARU (BESAR)      --}}
        {{-- ========================================== --}}
        <div x-show="showAddStockModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">

            <div @click.away="showAddStockModal = false"
                 x-show="showAddStockModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Tambah Stok Baru</h3>
                        <p class="text-xs text-slate-500 mt-1">Masukkan detail barang ke master stock</p>
                    </div>
                    <button @click="showAddStockModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar">
                    <form id="addStockForm" action="{{ route('stok.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Tanggal Input</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Nomor Resi</label>
                                <input type="text" name="nomor_resi" placeholder="Contoh: INV/2026/100" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">🏷️ Nama Barang</label>
                                <select name="master_product_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    <option value="" disabled selected>Pilih Barang...</option>
                                    @foreach($masterProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Stok Awal</label>
                                <input type="number" name="stok_awal" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Qty Saat Ini</label>
                                <input type="number" name="qty" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Harga Beli (Satuan)</label>
                                <input type="number" name="harga_beli" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Margin (%)</label>
                                <input type="number" name="margin" value="10" min="0" step="0.1" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Harga Atas (Limit)</label>
                                <input type="number" name="harga_atas" value="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Supplier</label>
                                <select name="supplier_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    <option value="" disabled selected>Pilih Supplier...</option>
                                    @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Status Pembayaran</label>
                                <select name="status_pembayaran" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    <option value="Belum Lunas">Belum Lunas</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Status Barang</label>
                                <select name="status_barang" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    <option value="Ready">Ready</option>
                                    <option value="Indent">Indent</option>
                                    <option value="Kosong">Kosong</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Jatuh Tempo</label>
                                <input type="date" name="jatuh_tempo" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Qty Kulak (Rencana Order)</label>
                            <input type="number" name="qty_kulak" value="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                        </div>

                    </form>
                </div>

            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MODAL 4: EDIT DATA STOK (BESAR)        --}}
        {{-- ========================================== --}}
        <div x-show="showEditStockModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">

            <div @click.away="showEditStockModal = false"
                 x-show="showEditStockModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Edit Data Stok</h3>
                        <p class="text-xs text-slate-500 mt-1">Perbarui informasi barang yang sudah ada</p>
                    </div>
                    <button @click="showEditStockModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar">
                    <form :action="'{{ url('stok') }}/' + editData.id" method="POST" id="editStockForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Tanggal Input</label>
                                <input type="date" name="tanggal" x-model="editData.tanggal" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Nomor Resi</label>
                                <input type="text" name="nomor_resi" x-model="editData.nomor_resi" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">🏷️ Nama Barang</label>
                                <select name="master_product_id" x-model="editData.master_product_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    @foreach($masterProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Stok Awal</label>
                                <input type="number" name="stok_awal" x-model="editData.stok_awal" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Qty Saat Ini</label>
                                <input type="number" name="qty" x-model="editData.qty" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Harga Beli (Satuan)</label>
                                <input type="number" name="harga_beli" x-model="editData.harga_beli" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Margin (%)</label>
                                <input type="number" name="margin" x-model="editData.margin" min="0" step="0.1" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Harga Atas (Limit)</label>
                                <input type="number" name="harga_atas" x-model="editData.harga_atas" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Supplier</label>
                                <select name="supplier_id" x-model="editData.supplier_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    @foreach($suppliers as $sup)
                                        <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Status Pembayaran</label>
                                <select name="status_pembayaran" x-model="editData.status_pembayaran" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    <option value="Belum Lunas">Belum Lunas</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Status Barang</label>
                                <select name="status_barang" x-model="editData.status_barang" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                                    <option value="Ready">Ready</option>
                                    <option value="Indent">Indent</option>
                                    <option value="Kosong">Kosong</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Jatuh Tempo</label>
                                <input type="date" name="jatuh_tempo" x-model="editData.jatuh_tempo" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-2">Qty Kulak (Rencana Order)</label>
                            <input type="number" name="qty_kulak" x-model="editData.qty_kulak" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 p-2.5 focus:ring-primary focus:border-primary">
                        </div>

                    </form>
                </div>

                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                    <button @click="showEditStockModal = false" class="px-5 py-2.5 rounded-lg text-slate-500 font-bold text-sm hover:bg-slate-200 transition-all">
                        Batal
                    </button>
                    <button onclick="document.getElementById('editStockForm').submit()" class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>

    </div>
    
    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-bold flex items-center gap-3 z-50">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

@endsection