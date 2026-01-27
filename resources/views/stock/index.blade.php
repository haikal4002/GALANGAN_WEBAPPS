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
            <input type="text" 
                   @input.debounce.300ms="$dispatch('search-stok', $el.value)"
                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border-none rounded-full text-sm focus:ring-2 focus:ring-slate-200 focus:bg-white transition-all placeholder-slate-400" 
                   placeholder="Cari stok...">
        </div>

        <button @click="$dispatch('open-manage-modal')" class="px-4 py-2 rounded-lg border border-orange-200 text-primary bg-white text-xs font-bold hover:bg-orange-50 transition-all flex items-center gap-2">
            <i class="fas fa-tag"></i> KELOLA BARANG
        </button>

        <button @click="$dispatch('open-unit-modal')" class="px-4 py-2 rounded-lg border border-teal-200 text-teal-600 bg-white text-xs font-bold hover:bg-teal-50 transition-all flex items-center gap-2">
            <i class="fas fa-ruler"></i> KELOLA SATUAN
        </button>

        <button @click="$dispatch('open-supplier-modal')" class="px-4 py-2 rounded-lg bg-slate-800 text-white text-xs font-bold hover:bg-slate-700 transition-all flex items-center gap-2">
            <i class="fas fa-truck"></i> SUPPLIER
        </button>

        <button @click="$dispatch('open-history-modal')" class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition-all flex items-center gap-2">
            <i class="fas fa-history"></i> HISTORY
        </button>

        <button @click="$dispatch('open-add-stock-modal')" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold hover:bg-orange-700 transition-all shadow-lg shadow-orange-500/30 flex items-center gap-2">
            <i class="fas fa-plus"></i> BELANJA STOK
        </button>
    </div>
@endsection

@section('content')

    {{-- UPDATE 1: Menambahkan 'target_unit' di x-data agar Modal bisa membacanya --}}
    <div x-data="{ 
            showManageModal: false, 
            showUnitModal: false,
            showSupplierModal: false,
            showAddStockModal: false,
            showBreakModal: false,
            showHistoryModal: false,
            breakItem: { id: '', name: '', unit: '', conversion: 1, target_unit: 'Pcs', target_unit_id: '', has_base_unit: false }, 
            availableTargets: [], // <--- Array untuk menampung pilihan dropdown
            selectedTargetId: '', // <--- ID yang dipilih user
            searchQuery: '',
            searchUnit: '',
            searchSupplier: '',
            inputHargaBeli: 0,
            inputMargin: 20,
            bisaDiecer: false,
            inputKonversi: 1,
            ecerMasterUnitId: '',
            ecerMargin: 20
         }"
         @open-manage-modal.window="showManageModal = true"
         @open-unit-modal.window="showUnitModal = true"
         @open-supplier-modal.window="showSupplierModal = true"
         @open-add-stock-modal.window="showAddStockModal = true"
         @open-history-modal.window="showHistoryModal = true"
         @search-stok.window="searchQuery = $event.detail"
         @open-break-modal.window="showBreakModal = true; breakItem = $event.detail; selectedTargetId = $event.detail.target_unit_id || '';">

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
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hutang ke Supplier</p>
                    <i class="fas fa-exclamation-triangle text-red-500 bg-red-50 p-2 rounded-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalHutang, 0, ',', '.') }}</h3>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-emerald-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Varian Ready</p>
                    <i class="fas fa-box-open text-emerald-500 bg-emerald-50 p-2 rounded-lg"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $barangReady }} Unit</h3>
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
                    <i class="fas fa-th-large text-primary"></i> INVENTORI REAL-TIME
                </h4>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider border-b border-slate-200">
                            <th class="px-6 py-4 whitespace-nowrap">No</th>
                            <th class="px-6 py-4 whitespace-nowrap">Nama Barang</th>
                            <th class="px-6 py-4 whitespace-nowrap">Satuan</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Unit Ecer</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Stok</th>
                            <th class="px-6 py-4 whitespace-nowrap">HPP Terakhir</th>
                            <th class="px-6 py-4 whitespace-nowrap text-blue-500">Nominal</th>
                            <th class="px-6 py-4 whitespace-nowrap text-orange-500">Margin</th>
                            <th class="px-6 py-4 whitespace-nowrap text-green-600">Harga Jual</th>
                            <th class="px-6 py-4 whitespace-nowrap text-blue-600">Harga Atas</th>
                            <th class="px-6 py-4 whitespace-nowrap text-center">Aksi / Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($units as $item)
                        
                        {{-- UPDATE 2: Logika mencari nama satuan Eceran (Target) --}}
                        @php
                            // Cari barang lain yang induknya sama, tapi dia adalah Base Unit (Eceran)
                            $baseUnit = $units->where('master_product_id', $item->master_product_id)
                                              ->where('is_base_unit', true)
                                              ->first();
                            
                            // Cari semua satuan lain untuk produk yang sama (selain item ini)
                            $otherUnits = $units->where('master_product_id', $item->master_product_id)
                                                ->where('id', '!=', $item->id)
                                                ->values();
                            
                            // Jika ketemu base unit, ambil namanya
                            $hasBaseUnit = $baseUnit ? true : false;
                            $namaSatuanTujuan = $baseUnit && $baseUnit->masterUnit ? $baseUnit->masterUnit->nama : '';
                            $targetMasterUnitId = $baseUnit ? $baseUnit->master_unit_id : '';
                        @endphp

                        <tr x-show="searchQuery === '' || '{{ strtolower($item->masterProduct->nama ?? '') }}'.includes(searchQuery.toLowerCase())" 
                            class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-400 font-mono text-xs">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-800">{{ $item->masterProduct->nama ?? '-' }}</td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded text-xs font-bold text-slate-600">
                                    {{ $item->masterUnit->nama ?? '-' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->is_base_unit)
                                    <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold border border-emerald-200 uppercase">Ya</span>
                                @else
                                    <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-[10px] font-bold border border-slate-200 uppercase">Tidak</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold {{ $item->stok == 0 ? 'text-red-500' : 'text-slate-700' }}">
                                {{ $item->stok }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->harga_beli_terakhir, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-600">Rp {{ number_format($item->stok * $item->harga_beli_terakhir, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-orange-600 font-bold">{{ $item->margin }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-bold">Rp {{ number_format($item->harga_atas, 0, ',', '.') }}</td>
                            
                            {{-- UPDATE 3: Logika Tombol & Mengirim 'target_unit' --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($item->stok <= 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-100">
                                        Kosong
                                    </span>

                                @elseif(!$item->is_base_unit)
                                    {{-- JIKA INI SATUAN BESAR (Pack/Dus) --}}
                                    <div class="flex flex-col gap-2 items-center">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                            Ready
                                        </span>
                                        {{-- Tombol Buka Pack --}}
                                        <button type="button"
                                                @click="selectedTargetId = '{{ $targetMasterUnitId }}'; $dispatch('open-break-modal', { 
                                                    id: '{{ $item->id }}', 
                                                    master_product_id: '{{ $item->master_product_id }}',
                                                    name: '{{ addslashes($item->masterProduct->nama ?? '-') }}',
                                                    unit: '{{ $item->masterUnit->nama ?? '-' }}',
                                                    conversion: {{ $item->nilai_konversi }},
                                                    target_unit: '{{ $namaSatuanTujuan }}',
                                                    target_unit_id: '{{ $targetMasterUnitId }}',
                                                    has_base_unit: {{ $hasBaseUnit ? 'true' : 'false' }}
                                                })"
                                                class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-[10px] font-bold hover:bg-purple-200 border border-purple-200 flex items-center gap-1 transition-all shadow-sm">
                                            <i class="fas fa-box-open"></i> BUKA {{ $item->masterUnit->nama ?? '-' }}
                                        </button>
                                    </div>

                                @else
                                    {{-- JIKA INI SATUAN KECIL (Eceran) --}}
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">
                                        Ready ({{ $item->masterUnit->nama ?? '-' }})
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-slate-400">Belum ada data stok. Klik "Belanja Stok" untuk memulai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL KELOLA BARANG & SUPPLIER --}}
        @include('stock.partials.modals_master') 

        {{-- MODAL BELANJA STOK --}}
        <div x-show="showAddStockModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
             style="display: none;">

            <div @click.away="showAddStockModal = false"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">Form Belanja Stok (Kulakan)</h3>
                        <p class="text-xs text-slate-500 mt-1">Stok akan bertambah dan riwayat pembelian tercatat.</p>
                    </div>
                    <button @click="showAddStockModal = false" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar">
                    <form id="addStockForm" action="{{ route('stok.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                                <h4 class="text-xs font-bold text-primary uppercase mb-3">Data Faktur Supplier</h4>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Tanggal Faktur</label>
                                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full bg-white border border-slate-300 rounded-lg text-sm p-2">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Supplier</label>
                                        <select name="supplier_id" class="w-full bg-white border border-slate-300 rounded-lg text-sm p-2">
                                            @foreach($suppliers as $sup)
                                                <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">No. Resi / Nota</label>
                                        <input type="text" name="nomor_resi" placeholder="INV-001" class="w-full bg-white border border-slate-300 rounded-lg text-sm p-2">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Barang (Master)</label>
                                <select name="master_product_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                                    @foreach($masterProducts as $product)
                                        <option value="{{ $product->id }}">{{ $product->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Satuan (Unit Utama)</label>
                                <select name="master_unit_id" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                                    <option value="">-- Pilih Satuan --</option>
                                    @foreach($allUnits as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[9px] text-slate-400 mt-1">Pilih satuan utama (misal: Sak, Dus, Pack).</p>
                            </div>

                            <div class="flex items-center gap-3 pt-6">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="bisa_diecer" x-model="bisaDiecer" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                    <span class="ml-3 text-[10px] font-bold text-slate-500 uppercase">Apakah bisa diecer?</span>
                                </label>
                            </div>

                            {{-- Form Eceran (Muncul jika dicentang) --}}
                            <div x-show="bisaDiecer" x-transition class="col-span-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 p-4 bg-orange-50 rounded-xl border border-orange-100">
                                <div>
                                    <label class="block text-[10px] font-bold text-orange-600 uppercase mb-2">Satuan Eceran</label>
                                    <select name="ecer_master_unit_id" x-model="ecerMasterUnitId" class="w-full bg-white border border-orange-200 rounded-lg text-sm p-2">
                                        <option value="">-- Pilih Satuan Ecer --</option>
                                        @foreach($allUnits as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-orange-600 uppercase mb-2">Isi per Kemasan</label>
                                    <input type="number" name="nilai_konversi" x-model.number="inputKonversi" min="1" class="w-full bg-white border border-orange-200 rounded-lg text-sm p-2">
                                    <p class="text-[9px] text-orange-400 mt-1">Misal: 1 Sak = 50 Kg, maka isi 50.</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-orange-600 uppercase mb-2">HPP Eceran (Otomatis)</label>
                                    <div class="w-full bg-orange-100/50 border border-orange-200 rounded-lg text-sm p-2 font-bold text-orange-700">
                                        Rp <span x-text="Math.round(inputHargaBeli / (inputKonversi || 1)).toLocaleString('id-ID')"></span>
                                    </div>
                                    <input type="hidden" name="ecer_harga_beli" :value="Math.round(inputHargaBeli / (inputKonversi || 1))">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-orange-600 uppercase mb-2">Margin Ecer (%)</label>
                                    <input type="number" name="ecer_margin" x-model.number="ecerMargin" class="w-full bg-white border border-orange-200 rounded-lg text-sm p-2">
                                    <p class="text-[9px] text-slate-400 mt-1">
                                        Jual Ecer: <span class="font-bold">Rp <span x-text="Math.round((inputHargaBeli / (inputKonversi || 1)) + ((inputHargaBeli / (inputKonversi || 1)) * ecerMargin / 100)).toLocaleString('id-ID')"></span></span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-orange-600 uppercase mb-2">Harga Atas Ecer</label>
                                    <input type="number" name="ecer_harga_atas" placeholder="Rp 0" class="w-full bg-white border border-orange-200 rounded-lg text-sm p-2">
                                    <p class="text-[9px] text-orange-400 mt-1">Opsional: Batas harga jual ecer.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Jumlah Beli (Qty)</label>
                                <input type="number" name="qty" placeholder="0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Harga Beli Satuan</label>
                                <input type="number" name="harga_beli" x-model.number="inputHargaBeli" placeholder="Rp 0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Margin Keuntungan (%)</label>
                                <input type="number" name="margin" x-model.number="inputMargin" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                                <p class="text-[10px] text-slate-400 mt-1">
                                    Preview Harga Jual: <span class="font-bold">Rp <span x-text="Math.round(inputHargaBeli + (inputHargaBeli * inputMargin / 100)).toLocaleString('id-ID')"></span></span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Harga Atas (Batas Harga Jual)</label>
                                <input type="number" name="harga_atas" placeholder="Rp 0" class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                                <p class="text-[9px] text-slate-400 mt-1">Opsional: Isi untuk menentukan batas atas harga jual.</p>
                            </div>

                            <div x-data="{ statusBayar: 'Lunas' }">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Pembayaran</label>
                                <select name="status_pembayaran" 
                                        x-model="statusBayar"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-lg text-sm p-2.5">
                                    <option value="Lunas">Lunas (Cash)</option>
                                    <option value="Belum Lunas">Hutang (Tempo)</option>
                                </select>
                                
                                {{-- Tanggal Jatuh Tempo (muncul jika Hutang) --}}
                                <div x-show="statusBayar === 'Belum Lunas'" x-transition class="mt-3">
                                    <label class="block text-[10px] font-bold text-red-400 uppercase mb-2">
                                        <i class="fas fa-calendar-alt mr-1"></i> Jatuh Tempo
                                    </label>
                                    <input type="date" name="jatuh_tempo" 
                                           class="w-full bg-red-50 border border-red-200 rounded-lg text-sm p-2.5 text-red-700 font-bold focus:ring-2 focus:ring-red-300">
                                    <p class="text-[9px] text-red-400 mt-1">
                                        <i class="fas fa-exclamation-circle"></i> Wajib diisi untuk pembayaran tempo/hutang.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                    <button @click="showAddStockModal = false" class="px-5 py-2.5 rounded-lg text-slate-500 font-bold text-sm hover:bg-slate-200 transition-all">Batal</button>
                    <button onclick="document.getElementById('addStockForm').submit()" class="px-6 py-2.5 rounded-lg bg-primary text-white font-bold text-sm hover:bg-orange-700 shadow-lg shadow-orange-500/30 transition-all">Simpan Transaksi</button>
                </div>
            </div>
        </div>

        {{-- MODAL PECAH SATUAN (BREAK UNIT) --}}
        <div x-show="showBreakModal"
             style="display: none;"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center">
            
            <div @click.away="showBreakModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="bg-purple-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-sm tracking-wide flex items-center gap-2">
                        <i class="fas fa-box-open"></i> KONVERSI STOK
                    </h3>
                    <button @click="showBreakModal = false" class="text-purple-200 hover:text-white"><i class="fas fa-times"></i></button>
                </div>

                <div class="p-6">
                    <form action="{{ route('stok.break') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_unit_id" x-model="breakItem.id">

                        <div class="bg-purple-50 p-4 rounded-xl border border-purple-100 mb-6 text-center">
                            <p class="text-xs text-purple-600 font-bold mb-1">MEMBUKA KEMASAN:</p>
                            <h4 class="text-lg font-bold text-slate-800" x-text="breakItem.name"></h4>
                            
                            {{-- Tampilkan info konversi jika ada base unit --}}
                            <template x-if="breakItem.has_base_unit && breakItem.target_unit">
                                <span class="text-xs bg-white border border-purple-200 px-2 py-1 rounded text-purple-600 mt-2 inline-block">
                                    1 <span x-text="breakItem.unit"></span> = <span x-text="breakItem.conversion"></span> <span x-text="breakItem.target_unit"></span>
                                </span>
                            </template>
                            
                            {{-- Tampilkan peringatan jika tidak ada base unit --}}
                            <template x-if="!breakItem.has_base_unit">
                                <span class="text-xs bg-yellow-50 border border-yellow-200 px-2 py-1 rounded text-yellow-700 mt-2 inline-block">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Pilih satuan tujuan di bawah
                                </span>
                            </template>
                        </div>

                        {{-- Target Konversi Otomatis --}}
                        <div class="mb-6" x-show="breakItem.has_base_unit">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">
                                Dikonversi Menjadi (Satuan Ecer):
                            </label>
                            <div class="bg-slate-100 border border-slate-200 rounded-lg p-3 flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-700" x-text="breakItem.target_unit"></span>
                                <input type="hidden" name="target_master_unit_id" x-model="selectedTargetId">
                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold uppercase">Otomatis</span>
                            </div>
                        </div>

                        {{-- Dropdown pilih satuan tujuan (Hanya jika belum ada base unit) --}}
                        <div class="mb-6" x-show="!breakItem.has_base_unit">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">
                                Satuan Tujuan Konversi:
                            </label>
                            
                            {{-- Dropdown dari Master Units --}}
                            <select name="target_master_unit_id" x-model="selectedTargetId" 
                                    @change="
                                        let opt = $el.options[$el.selectedIndex];
                                        breakItem.target_unit = opt.text;
                                    "
                                    class="w-full bg-white border border-slate-300 rounded-lg p-2.5 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-purple-300 focus:border-purple-400">
                                <option value="">-- Pilih Satuan Tujuan --</option>
                                @foreach($allUnits as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                                @endforeach
                            </select>
                            
                            <p class="text-[9px] text-slate-400 mt-1">
                                <i class="fas fa-info-circle"></i> Satuan ecer belum terdeteksi. Pilih secara manual.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">
                                Jumlah <span x-text="breakItem.unit"></span> yang dibuka:
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="qty_to_break" x-ref="qtyInput" value="1" min="1" 
                                       @input="$refs.resultQty.textContent = $event.target.value * breakItem.conversion"
                                       class="flex-1 bg-white border border-slate-300 rounded-lg p-2.5 text-center font-bold">
                                <i class="fas fa-arrow-right text-slate-300"></i>
                                <div class="flex-1 bg-slate-100 border border-slate-200 rounded-lg p-2.5 text-center text-slate-500 text-sm">
                                    Menjadi 
                                    <strong x-ref="resultQty" class="text-green-600 text-lg" x-text="1 * breakItem.conversion"></strong> 
                                    <span x-text="breakItem.target_unit || 'unit'" class="font-bold"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" 
                                :disabled="!selectedTargetId"
                                :class="selectedTargetId ? 'bg-purple-600 hover:bg-purple-700' : 'bg-slate-300 cursor-not-allowed'"
                                class="w-full py-3 text-white font-bold rounded-xl shadow-lg transition-all">
                            <i class="fas fa-exchange-alt mr-2"></i> PROSES KONVERSI
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL HISTORY BELANJA --}}
        <div x-show="showHistoryModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             style="display: none;"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            
            <div @click.away="showHistoryModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl overflow-hidden flex flex-col max-h-[90vh]">
                <div class="bg-indigo-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold text-sm tracking-wide flex items-center gap-2">
                        <i class="fas fa-history"></i> HISTORY BELANJA / KULAKAN
                    </h3>
                    <button @click="showHistoryModal = false" class="text-indigo-200 hover:text-white"><i class="fas fa-times"></i></button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider border-b border-slate-200">
                                    <th class="px-4 py-3 whitespace-nowrap">No</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Tanggal</th>
                                    <th class="px-4 py-3 whitespace-nowrap">No. Resi</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Supplier</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Barang</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-center">Qty</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Harga Satuan</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Total</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-center">Status</th>
                                    <th class="px-4 py-3 whitespace-nowrap">Jatuh Tempo</th>
                                    <th class="px-4 py-3 whitespace-nowrap text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                                @forelse($purchases as $purchase)
                                    @foreach($purchase->purchaseDetails as $detail)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-slate-400 font-mono text-xs">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs">{{ \Carbon\Carbon::parse($purchase->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-mono text-xs text-indigo-600">{{ $purchase->nomor_resi }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-bold">{{ $purchase->supplier->nama ?? '-' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="font-bold">{{ $detail->productUnit->masterProduct->nama ?? '-' }}</span>
                                            <span class="text-xs text-slate-400">({{ $detail->productUnit->masterUnit->nama ?? '-' }})</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center font-bold">{{ $detail->qty }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">Rp {{ number_format($detail->harga_beli_satuan, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-bold text-slate-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            @if($purchase->status_pembayaran == 'Lunas')
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">
                                                    <i class="fas fa-check-circle"></i> Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-100">
                                                    <i class="fas fa-clock"></i> Belum Lunas
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-xs text-center font-bold">
                                            {{ $purchase->status_pembayaran == 'Lunas' ? '-' : ($purchase->jatuh_tempo ? \Carbon\Carbon::parse($purchase->jatuh_tempo)->format('d/m/Y') : '-') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            @if($purchase->status_pembayaran == 'Belum Lunas')
                                                <form action="{{ route('purchase.pay', $purchase->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melunasi transaksi ini secara manual?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="p-1 px-2 bg-green-500 text-white rounded text-[10px] font-bold hover:bg-green-600 transition-all flex items-center gap-1 mx-auto">
                                                        <i class="fas fa-hand-holding-usd"></i> LUNAS
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-slate-300"><i class="fas fa-check-double text-xs"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                <tr>
                                    <td colspan="11" class="px-4 py-10 text-center text-slate-400">Belum ada history pembelian.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Summary --}}
                    @if($purchases->count() > 0)
                    <div class="mt-6 grid grid-cols-3 gap-4">
                        <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase">Total Transaksi</p>
                            <p class="text-xl font-bold text-indigo-600">{{ $purchases->count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                            <p class="text-[10px] font-bold text-green-400 uppercase">Total Lunas</p>
                            <p class="text-xl font-bold text-green-600">Rp {{ number_format($purchases->where('status_pembayaran', 'Lunas')->sum('total_nominal'), 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-xl border border-red-100">
                            <p class="text-[10px] font-bold text-red-400 uppercase">Total Hutang</p>
                            <p class="text-xl font-bold text-red-600">Rp {{ number_format($purchases->where('status_pembayaran', 'Belum Lunas')->sum('total_nominal'), 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                    <button @click="showHistoryModal = false" class="px-5 py-2.5 rounded-lg text-slate-500 font-bold text-sm hover:bg-slate-200 transition-all">Tutup</button>
                </div>
            </div>
        </div>

    </div>
    
    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-bold flex items-center gap-3 z-50">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
             class="fixed bottom-5 right-5 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg text-sm font-bold flex items-center gap-3 z-50">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

@endsection