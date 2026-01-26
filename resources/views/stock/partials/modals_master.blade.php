{{-- ========================================== --}}
{{-- MODAL 1: KELOLA MASTER BARANG (KECIL)  --}}
{{-- ========================================== --}}
<div x-show="showManageModal" 
     style="display: none;"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center">
    
    <div @click.away="showManageModal = false"
         x-show="showManageModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
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
                        <i class="fas fa-box text-slate-300 group-hover:text-primary transition-colors text-xs"></i>
                    </div>
                @endforeach
                @if($masterProducts->isEmpty())
                    <p class="text-center text-xs text-slate-400 py-4 italic">Belum ada data master barang.</p>
                @endif
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 font-bold tracking-wide uppercase">
                    DAFTAR INI AKAN MUNCUL SEBAGAI PILIHAN SAAT BELANJA STOK
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL 2: KELOLA SUPPLIER (KECIL)       --}}
{{-- ========================================== --}}
<div x-show="showSupplierModal" 
     style="display: none;"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center">

    <div @click.away="showSupplierModal = false"
         x-show="showSupplierModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        
        <div class="bg-slate-900 px-6 py-4 flex items-center justify-between">
            <h3 class="text-white font-bold text-sm tracking-wide flex items-center gap-2">
                <i class="fas fa-users text-blue-500"></i> KELOLA SUPPLIER
            </h3>
            <button @click="showSupplierModal = false" class="text-slate-400 hover:text-white transition-colors"><i class="fas fa-times text-lg"></i></button>
        </div>

        <div class="p-6">
            <form action="{{ route('supplier.store') }}" method="POST" class="space-y-3 mb-6 bg-slate-50 p-4 rounded-xl border border-slate-100">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Supplier <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" required 
                           class="w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 placeholder-slate-400" 
                           placeholder="PT. Bangun Jaya / Toko Besi...">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kontak (HP/Telp)</label>
                        <input type="text" name="kontak" 
                               class="w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 placeholder-slate-400" 
                               placeholder="0812...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Alamat Singkat</label>
                        <input type="text" name="alamat" 
                               class="w-full bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 placeholder-slate-400" 
                               placeholder="Kota / Jalan...">
                    </div>
                </div>

                <button type="submit" class="w-full p-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30 text-sm font-bold flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> SIMPAN SUPPLIER
                </button>
            </form>

            <div class="mb-3 relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-slate-300 text-xs"></i></span>
                <input type="text" x-model="searchSupplier" class="w-full pl-8 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:ring-1 focus:ring-slate-300 uppercase shadow-sm" placeholder="CARI DATA SUPPLIER...">
            </div>

            <div class="max-h-64 overflow-y-auto pr-1 space-y-2 no-scrollbar">
                @foreach($suppliers as $supplier)
                    <div class="bg-white border border-slate-100 p-3 rounded-lg flex justify-between items-start group hover:border-blue-300 hover:shadow-md transition-all cursor-default"
                         x-show="'{{ strtoupper($supplier->nama) }}'.includes(searchSupplier.toUpperCase())">
                        
                        <div>
                            <h4 class="text-xs font-bold text-slate-700 uppercase mb-1">{{ $supplier->nama }}</h4>
                            
                            <div class="flex flex-col gap-0.5">
                                <span class="text-[10px] text-slate-500 flex items-center gap-1">
                                    <i class="fas fa-phone-alt text-[9px] w-3"></i> {{ $supplier->kontak }}
                                </span>
                                <span class="text-[10px] text-slate-500 flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[9px] w-3"></i> {{ Str::limit($supplier->alamat, 25) }}
                                </span>
                            </div>
                        </div>

                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <i class="fas fa-building text-xs"></i>
                        </div>
                    </div>
                @endforeach
                
                @if($suppliers->isEmpty())
                    <p class="text-center text-xs text-slate-400 py-4 italic">Belum ada data supplier.</p>
                @endif
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 font-bold tracking-wide uppercase">
                    DATA SUPPLIER AKAN MUNCUL SAAT INPUT FAKTUR
                </p>
            </div>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL 3: KELOLA MASTER SATUAN (KECIL)  --}}
{{-- ========================================== --}}
<div x-show="showUnitModal" 
     style="display: none;"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center">
    
    <div @click.away="showUnitModal = false"
         x-show="showUnitModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
        
        <div class="bg-teal-600 px-6 py-4 flex items-center justify-between">
            <h3 class="text-white font-bold text-sm tracking-wide flex items-center gap-2">
                <i class="fas fa-ruler text-teal-200"></i> KELOLA MASTER SATUAN
            </h3>
            <button @click="showUnitModal = false" class="text-teal-200 hover:text-white transition-colors"><i class="fas fa-times text-lg"></i></button>
        </div>

        <div class="p-6">
            <form action="{{ route('master-unit.store') }}" method="POST" class="flex gap-2 mb-6">
                @csrf
                <input type="text" name="nama" required 
                       class="flex-1 bg-white border border-slate-300 text-slate-700 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block p-2.5 placeholder-slate-400" 
                       placeholder="Input nama satuan baru (e.g. PCS, BOX)...">
                <button type="submit" class="p-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors shadow-lg shadow-teal-500/30">
                    <i class="fas fa-plus"></i>
                </button>
            </form>

            <div class="mb-3 relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-slate-300 text-xs"></i></span>
                <input type="text" x-model="searchUnit" class="w-full pl-8 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-lg text-xs focus:ring-1 focus:ring-teal-200 uppercase" placeholder="CARI MASTER SATUAN...">
            </div>

            <div class="max-h-64 overflow-y-auto pr-1 space-y-2 no-scrollbar">
                @foreach($allUnits as $unit)
                    <div class="bg-slate-50 border border-slate-100 p-3 rounded-lg flex justify-between items-center group hover:bg-white hover:border-teal-200 transition-all"
                         x-show="'{{ strtoupper($unit->nama) }}'.includes(searchUnit.toUpperCase())"
                         x-data="{ editing: false, unitName: '{{ $unit->nama }}' }">
                        
                        <div class="flex-1">
                            <template x-if="!editing">
                                <span class="text-xs font-bold text-slate-700 uppercase" x-text="unitName"></span>
                            </template>
                            <template x-if="editing">
                                <form action="{{ route('master-unit.update', $unit->id) }}" method="POST" class="flex gap-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="nama" x-model="unitName" class="flex-1 bg-white border border-teal-300 text-slate-700 text-[10px] rounded px-2 py-1 focus:ring-1 focus:ring-teal-500">
                                    <button type="submit" class="text-teal-600 hover:text-teal-700"><i class="fas fa-check text-xs"></i></button>
                                    <button type="button" @click="editing = false" class="text-slate-400 hover:text-red-500"><i class="fas fa-times text-xs"></i></button>
                                </form>
                            </template>
                        </div>
                        
                        <div class="flex items-center gap-2" x-show="!editing">
                            <button @click="editing = true" class="text-slate-300 hover:text-blue-500 transition-colors">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            @if($unit->product_units_count == 0)
                                <form action="{{ route('master-unit.destroy', $unit->id) }}" method="POST" onsubmit="return confirm('Hapus satuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-[9px] bg-slate-200 text-slate-500 px-2 py-0.5 rounded-full font-bold uppercase">Digunakan</span>
                                <i class="fas fa-lock text-slate-300 text-[10px]"></i>
                            @endif
                        </div>
                    </div>
                @endforeach
                @if($allUnits->isEmpty())
                    <p class="text-center text-xs text-slate-400 py-4 italic">Belum ada data master satuan.</p>
                @endif
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 font-bold tracking-wide uppercase">
                    SATUAN INI DIGUNAKAN UNTUK MENGELOMPOKKAN BARANG
                </p>
            </div>
        </div>
    </div>
</div>