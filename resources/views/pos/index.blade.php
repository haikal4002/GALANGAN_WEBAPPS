@extends('layouts.admin')

@section('title', 'Point of Sale - BangunTrack')

@section('header-title')
    <i class="fas fa-shopping-cart text-primary mr-2"></i> POS VIEW
@endsection

{{-- Kita kosongkan header kanan agar fokus kasir tidak terganggu --}}
@section('header-right')
    <div class="text-right">
        <p class="text-xs text-slate-400 uppercase font-bold">Kasir Bertugas</p>
        <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
    </div>
@endsection

@section('content')

<div x-data="posApp()" x-init="init()" class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-140px)]">
    
    {{-- KOLOM KIRI: DAFTAR PRODUK --}}
    <div class="flex-1 flex flex-col h-full">
        
        {{-- Search Bar --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-4 sticky top-0 z-10">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 text-lg"></i>
                </span>
                <input type="text" x-model="search" 
                       class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary focus:bg-white transition-all placeholder-slate-400" 
                       placeholder="Cari nama barang atau scan barcode...">
            </div>
        </div>

        {{-- Grid Produk --}}
        <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar pb-20">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                
                <template x-for="product in filteredProducts" :key="product.id">
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 hover:shadow-lg hover:border-primary/50 transition-all cursor-pointer group flex flex-col justify-between h-full"
                         @click="addToCart(product)">
                        
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="text-xs font-bold text-slate-700 uppercase leading-tight" x-text="product.name"></h4>
                            </div>
                            
                            <p class="text-primary font-bold text-sm mb-1" x-text="formatRupiah(product.price)"></p>
                            
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-[10px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded border border-slate-200" x-text="'Stok: ' + product.stock + ' ' + product.unit"></span>
                            </div>
                        </div>

                        <button class="w-full py-2 rounded-lg bg-slate-50 text-slate-400 font-bold text-lg group-hover:bg-primary group-hover:text-white transition-all flex items-center justify-center">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </template>

                {{-- Empty State jika pencarian tidak ditemukan --}}
                <div x-show="filteredProducts.length === 0" class="col-span-full py-20 text-center text-slate-400">
                    <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                    <p>Barang tidak ditemukan.</p>
                </div>

            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: KERANJANG (CART) --}}
    <div class="w-full lg:w-96 bg-white border border-slate-200 rounded-2xl shadow-xl flex flex-col h-full sticky top-0">
        
        {{-- Header Keranjang --}}
        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-2xl">
            <div class="flex items-center gap-2">
                <i class="fas fa-shopping-basket text-primary"></i>
                <h3 class="font-bold text-slate-800">KERANJANG</h3>
            </div>
            <span class="px-2 py-1 bg-primary text-white text-xs font-bold rounded-lg" x-text="cartTotalItems + ' ITEM'"></span>
        </div>

        {{-- List Item Keranjang --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
            
            <template x-for="(item, index) in cart" :key="item.id">
                <div class="flex gap-3 items-start p-3 bg-white border border-slate-100 rounded-xl shadow-sm hover:border-primary/30 transition-colors">
                    <div class="flex-1">
                        <h5 class="text-xs font-bold text-slate-700 mb-1" x-text="item.name"></h5>
                        <p class="text-[10px] text-slate-400 mb-2" x-text="item.unit + ' @ ' + formatRupiah(item.price)"></p>
                        
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold text-primary" x-text="formatRupiah(item.price * item.qty)"></p>
                            
                            {{-- Qty Control --}}
                            <div class="flex items-center bg-slate-100 rounded-lg border border-slate-200">
                                <button @click.stop="updateQty(item.id, -1)" class="w-7 h-7 flex items-center justify-center text-slate-500 hover:text-red-500 hover:bg-red-50 rounded-l-lg transition-colors">
                                    <i class="fas fa-minus text-[10px]"></i>
                                </button>
                                <span class="w-8 text-center text-xs font-bold text-slate-700" x-text="item.qty"></span>
                                <button @click.stop="updateQty(item.id, 1)" class="w-7 h-7 flex items-center justify-center text-slate-500 hover:text-green-500 hover:bg-green-50 rounded-r-lg transition-colors">
                                    <i class="fas fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Empty State Keranjang --}}
            <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-slate-300 pb-20">
                <i class="fas fa-shopping-cart text-5xl mb-4 opacity-20"></i>
                <p class="text-xs font-bold uppercase tracking-wider">Keranjang Kosong</p>
                <p class="text-[10px] mt-1">Pilih barang di sebelah kiri</p>
            </div>

        </div>

        {{-- Footer Total & Bayar --}}
        <div class="p-5 border-t border-slate-100 bg-[#0B1120] text-white rounded-b-2xl">
            <div class="flex justify-between items-end mb-4">
                <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Bayar</span>
                <span class="text-2xl font-bold text-white tracking-tight" x-text="formatRupiah(cartTotalPrice)"></span>
            </div>
            
            <button @click="processPayment()" 
                    :disabled="cart.length === 0"
                    :class="cart.length === 0 ? 'bg-slate-700 cursor-not-allowed text-slate-500' : 'bg-primary hover:bg-orange-600 text-white shadow-lg shadow-orange-500/30'"
                    class="w-full py-3.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2">
                <span>PROSES BAYAR</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

    </div>
</div>

<script>
    function posApp() {
        return {
            search: '',
            products: @json($products), // Ambil data dari controller
            cart: [],

            init() {
                // Bisa load cart dari localStorage jika ingin persistent
            },

            get filteredProducts() {
                if (this.search === '') return this.products;
                return this.products.filter(product => {
                    return product.name.toLowerCase().includes(this.search.toLowerCase());
                });
            },

            get cartTotalItems() {
                return this.cart.reduce((total, item) => total + item.qty, 0);
            },

            get cartTotalPrice() {
                return this.cart.reduce((total, item) => total + (item.price * item.qty), 0);
            },

            addToCart(product) {
                // Cek apakah barang sudah ada di keranjang
                const existingItem = this.cart.find(item => item.id === product.id);

                if (existingItem) {
                    // Jika ada, cek stok dulu
                    if (existingItem.qty < product.stock) {
                        existingItem.qty++;
                    } else {
                        alert('Stok tidak mencukupi!');
                    }
                } else {
                    // Jika belum ada, masukkan baru
                    this.cart.push({
                        ...product,
                        qty: 1
                    });
                }
            },

            updateQty(id, amount) {
                const item = this.cart.find(i => i.id === id);
                if (!item) return;

                const newQty = item.qty + amount;

                // Cek stok limit
                if (newQty > item.stock) {
                    alert('Stok mentok gan!');
                    return;
                }

                if (newQty > 0) {
                    item.qty = newQty;
                } else {
                    // Jika 0, hapus dari keranjang
                    this.cart = this.cart.filter(i => i.id !== id);
                }
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            },

            processPayment() {
                if (this.cart.length === 0) return;
                
                // Disini nanti logika kirim data ke backend untuk disimpan
                // Untuk sekarang kita alert dulu atau redirect
                alert('Fitur pembayaran akan segera diimplementasikan. Total: ' + this.formatRupiah(this.cartTotalPrice));
                console.log(this.cart);
            }
        }
    }
</script>
@endsection