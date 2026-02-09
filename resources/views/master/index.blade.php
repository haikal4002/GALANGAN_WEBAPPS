@extends('layouts.admin')

@section('title', 'Master Data - BangunTrack')

@section('header-title')
    <span class="text-slate-800 font-bold tracking-tight uppercase">MASTER DATA</span>
@endsection

@section('content')
<div x-data="{ 
    showManageModal: false, 
    showUnitModal: false,
    showSupplierModal: false,
    searchQuery: '',
    searchUnit: '',
    searchSupplier: ''
}">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Card Kelola Barang --}}
        <div @click="showManageModal = true" class="group cursor-pointer bg-white rounded-2xl p-8 border border-orange-100 shadow-sm hover:shadow-xl hover:border-primary/30 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-orange-50 rounded-full group-hover:scale-110 transition-transform duration-500 opacity-50"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-primary group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-box text-3xl text-primary group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Kelola Barang</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Kelola daftar master barang, tambah barang baru, atau ubah nama barang yang sudah ada.</p>
                <div class="mt-6 flex items-center text-primary font-bold text-sm">
                    Buka Pengaturan <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </div>

        {{-- Card Kelola Satuan --}}
        <div @click="showUnitModal = true" class="group cursor-pointer bg-white rounded-2xl p-8 border border-teal-100 shadow-sm hover:shadow-xl hover:border-teal-500/30 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-teal-50 rounded-full group-hover:scale-110 transition-transform duration-500 opacity-50"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-teal-600 group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-ruler-combined text-3xl text-teal-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Kelola Satuan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Atur berbagai jenis satuan barang seperti Pcs, Dus, Meter, atau satuan custom lainnya.</p>
                <div class="mt-6 flex items-center text-teal-600 font-bold text-sm">
                    Buka Pengaturan <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </div>

        {{-- Card Kelola Supplier --}}
        <div @click="showSupplierModal = true" class="group cursor-pointer bg-white rounded-2xl p-8 border border-blue-100 shadow-sm hover:shadow-xl hover:border-blue-500/30 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-blue-50 rounded-full group-hover:scale-110 transition-transform duration-500 opacity-50"></div>
            <div class="relative z-10">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:rotate-6 transition-all duration-300">
                    <i class="fas fa-truck-moving text-3xl text-blue-600 group-hover:text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Kelola Supplier</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Data lengkap supplier atau pemasok barang untuk memudahkan proses belanja stok.</p>
                <div class="mt-6 flex items-center text-blue-600 font-bold text-sm">
                    Buka Pengaturan <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL KELOLA BARANG, SATUAN & SUPPLIER --}}
    @include('stock.partials.modals_master')
</div>
@endsection
