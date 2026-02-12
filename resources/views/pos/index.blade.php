@extends('layouts.admin')

@section('title', 'Point of Sale - BangunTrack')

@section('header-title')
    <i class="fas fa-shopping-cart text-primary mr-2"></i> POS VIEW
@endsection

@section('header-right')
    <div class="text-right">
        <p class="text-xs text-slate-400 uppercase font-bold">Kasir Bertugas</p>
        <p class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</p>
    </div>
@endsection

@section('content')

<style>
    @media print {
        body * { visibility: hidden; }
        #receipt-print, #receipt-print * { visibility: visible; }
        #receipt-print { position: absolute; left: 0; top: 0; width: 100%; }
        .no-print { display: none !important; }
    }
</style>

<div x-data="posApp()" x-init="init()" class="relative">
    
    {{-- CONTAINER UTAMA --}}
    <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-140px)]">
        
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
                        <div class="bg-white border border-slate-200 rounded-lg p-3 hover:shadow-md hover:border-primary/50 transition-all cursor-pointer group flex flex-col justify-between"
                             @click="addToCart(product)">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-[12px] font-semibold text-slate-700 uppercase leading-tight" x-text="product.name"></h4>
                                </div>
                                <p class="text-primary font-bold text-xs mb-1" x-text="formatRupiah(product.price)"></p>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-[9px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded border border-slate-200" x-text="'Stok: ' + product.stock + ' ' + product.unit"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: KERANJANG --}}
        <div class="w-full lg:w-96 bg-white border border-slate-200 rounded-2xl shadow-xl flex flex-col h-full sticky top-0">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <i class="fas fa-shopping-basket text-primary"></i>
                    <h3 class="font-bold text-slate-800">KERANJANG</h3>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="openHistoryModal()" class="text-xs px-3 py-1 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 flex items-center gap-2"><i class="fas fa-history"></i> HISTORY</button>
                    <span class="px-2 py-1 bg-primary text-white text-xs font-bold rounded-lg" x-text="cartTotalItems + ' ITEM'"></span>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex gap-3 items-start p-3 bg-white border border-slate-100 rounded-xl shadow-sm hover:border-primary/30 transition-colors">
                        <div class="flex-1">
                            <h5 class="text-xs font-bold text-slate-700 mb-1" x-text="item.name"></h5>
                            <p class="text-[10px] text-slate-400 mb-2" x-text="item.unit + ' @ ' + formatRupiah(item.price)"></p>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-bold text-primary" x-text="formatRupiah(item.price * item.qty)"></p>
                                <div class="flex items-center bg-slate-100 rounded-lg border border-slate-200">
                                    <button @click.stop="updateQty(item.id, -1)" class="w-7 h-7 flex items-center justify-center text-slate-500 hover:text-red-500 hover:bg-red-50 rounded-l-lg transition-colors"><i class="fas fa-minus text-[10px]"></i></button>
                                    <span class="w-8 text-center text-xs font-bold text-slate-700" x-text="item.qty"></span>
                                    <button @click.stop="updateQty(item.id, 1)" class="w-7 h-7 flex items-center justify-center text-slate-500 hover:text-green-500 hover:bg-green-50 rounded-r-lg transition-colors"><i class="fas fa-plus text-[10px]"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-slate-300 pb-20">
                    <i class="fas fa-shopping-cart text-5xl mb-4 opacity-20"></i>
                    <p class="text-xs font-bold uppercase tracking-wider">Keranjang Kosong</p>
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 bg-[#0B1120] text-white rounded-b-2xl">
                <div class="flex justify-between items-end mb-4">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Total Bayar</span>
                    <span class="text-2xl font-bold text-white tracking-tight" x-text="formatRupiah(cartTotalPrice)"></span>
                </div>
                <button @click="openPaymentModal()" :disabled="cart.length === 0" :class="cart.length === 0 ? 'bg-slate-700 cursor-not-allowed text-slate-500' : 'bg-primary hover:bg-orange-600 text-white shadow-lg shadow-orange-500/30'" class="w-full py-3.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2">
                    <span>PROSES BAYAR</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- 1. MODAL PEMBAYARAN --}}
    <div x-show="showPaymentModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="showPaymentModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-slate-800 font-bold text-lg">PEMBAYARAN</h3>
                <button @click="showPaymentModal = false" class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <div class="p-6">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 text-center mb-6">
                    <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-1">Total Tagihan</p>
                    <h2 class="text-3xl font-extrabold text-blue-600" x-text="formatRupiah(cartTotalPrice)"></h2>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <button @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-500'" class="flex flex-col items-center justify-center py-3 rounded-xl border-2 font-bold text-xs gap-1"><i class="fas fa-money-bill-wave text-lg"></i> CASH</button>
                    <button @click="paymentMethod = 'qris'" :class="paymentMethod === 'qris' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-500'" class="flex flex-col items-center justify-center py-3 rounded-xl border-2 font-bold text-xs gap-1"><i class="fas fa-qrcode text-lg"></i> QRIS</button>
                    <button @click="paymentMethod = 'transfer'" :class="paymentMethod === 'transfer' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-500'" class="flex flex-col items-center justify-center py-3 rounded-xl border-2 font-bold text-xs gap-1"><i class="fas fa-credit-card text-lg"></i> TRANSFER</button>
                </div>

                {{-- Input Cash --}}
                <div x-show="paymentMethod === 'cash'">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Uang Diterima (Rp)</label>
                    <input type="text"
                           x-data="{ displayCash: '' }"
                           x-model="displayCash"
                           x-init="$watch('showPaymentModal', value => { if(value) displayCash = '' })"
                           @input="
                               let raw = $event.target.value.replace(/\D/g, '');
                               cashReceived = parseInt(raw) || 0;
                               displayCash = formatRupiah(cashReceived);
                           "
                           class="w-full border-2 border-blue-200 rounded-xl px-4 py-3 text-lg font-bold text-slate-800 focus:outline-none focus:border-blue-500 transition-colors mb-4 placeholder-slate-300" placeholder="0">
                    <div class="bg-slate-900 rounded-xl p-4 flex justify-between items-center text-white">
                        <span class="text-xs font-bold text-slate-400 uppercase">Kembalian</span>
                        <span class="text-xl font-bold text-green-400" x-text="formatRupiah(calculateChange())"></span>
                    </div>
                </div>

                {{-- QRIS --}}
                <div x-show="paymentMethod === 'qris'" class="text-center py-2">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=BangunTrack" class="w-40 h-40 mx-auto mb-2 opacity-80">
                    <p class="text-xs font-bold text-slate-400 italic">SCAN QRIS STATIS TOKO</p>
                </div>

                {{-- Transfer --}}
                <div x-show="paymentMethod === 'transfer'">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Pilih Bank</label>
                    <select class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-700"><option>BCA - 123456789</option></select>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 bg-slate-50">
                <button @click="confirmPayment()" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                    <span>KONFIRMASI PEMBAYARAN</span> <i class="fas fa-check-circle"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- 2. MODAL SUKSES (ALUR SETELAH BAYAR) --}}
    <div x-show="showSuccessModal" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/80 backdrop-blur-md" x-transition.opacity>
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 text-center relative overflow-hidden">
            {{-- Icon Check --}}
            <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6 relative">
                <div class="absolute inset-0 bg-green-200 rounded-full animate-ping opacity-75"></div>
                <i class="fas fa-check text-4xl text-green-600 relative z-10"></i>
            </div>
            
            <h2 class="text-2xl font-extrabold text-slate-800 italic mb-2">PEMBAYARAN BERHASIL!</h2>
            <p class="text-xs text-slate-500 mb-8 leading-relaxed">Transaksi telah tercatat dan stok telah diperbarui secara otomatis.</p>

            <div class="space-y-3">
                <button @click="openReceipt()" class="w-full py-3 bg-[#0B1120] hover:bg-slate-800 text-white rounded-xl font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg transition-all">
                    <i class="fas fa-file-invoice"></i> LIHAT PREVIEW NOTA
                </button>
                <button @click="newTransaction()" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 transition-all">
                    TRANSAKSI BARU <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- 3. MODAL PREVIEW NOTA --}}
    <div x-show="showReceiptModal" style="display: none;" class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/80 backdrop-blur-sm" x-transition.opacity>
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm flex flex-col max-h-[90vh]">
            {{-- Header Nota --}}
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-xl">
                <h3 class="text-slate-700 font-bold text-sm uppercase">PREVIEW NOTA</h3>
                <button @click="showReceiptModal = false; showSuccessModal = true" class="text-slate-400 hover:text-slate-600">&times;</button>
            </div>

            {{-- Kertas Nota (Scrollable) --}}
            <div id="receipt-print" class="p-6 overflow-y-auto custom-scrollbar bg-white font-mono text-xs text-slate-600 leading-relaxed">
                <div class="text-center mb-4">
                    <h4 class="font-bold text-slate-800 text-sm uppercase">{{ $storeProfile['name'] ?? 'NAMA TOKO' }}</h4>
                    <p>Pusat Bahan Bangunan & Alat Listrik</p>
                    <p>{{ $storeProfile['address'] ?? 'Alamat Toko' }}</p>
                    <p>Telp: {{ $storeProfile['phone'] ?? '-' }}</p>
                </div>

                <div class="border-b-2 border-dashed border-slate-300 my-4"></div>

                <div class="flex justify-between">
                    <span>No: <span x-text="transactionDetails?.no_trx"></span></span>
                    <span x-text="transactionDetails?.date"></span>
                </div>
                <div class="flex justify-between mb-4">
                    <span>Kasir: {{ Auth::user()->name }}</span>
                    <span x-text="transactionDetails?.time"></span>
                </div>

                {{-- Table Barang --}}
                <div class="flex justify-between font-bold border-b border-slate-300 pb-1 mb-2">
                    <span class="w-1/2">BARANG</span>
                    <span class="w-1/4 text-center">QTY</span>
                    <span class="w-1/4 text-right">TOTAL</span>
                </div>

                <template x-for="item in transactionDetails?.items">
                    <div class="mb-2">
                        <div x-text="item.name"></div>
                        <div class="flex justify-between">
                            <span class="w-1/2 text-[10px] pl-2 text-slate-400" x-text="'@' + formatRupiah(item.price)"></span>
                            <span class="w-1/4 text-center" x-text="item.qty"></span>
                            <span class="w-1/4 text-right text-slate-800" x-text="formatRupiah(item.price * item.qty).replace('Rp ', '')"></span>
                        </div>
                    </div>
                </template>

                <div class="border-b-2 border-dashed border-slate-300 my-4"></div>

                <div class="space-y-1 font-bold text-slate-800">
                    <div class="flex justify-between">
                        <span>TOTAL AKHIR</span>
                        <span x-text="formatRupiah(transactionDetails?.total)"></span>
                    </div>
                    <div class="flex justify-between text-slate-500 font-normal">
                        <span>METODE BAYAR</span>
                        <span class="uppercase" x-text="transactionDetails?.method"></span>
                    </div>
                    <div class="flex justify-between text-slate-500 font-normal">
                        <span>TUNAI</span>
                        <span x-text="formatRupiah(transactionDetails?.cash)"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>KEMBALIAN</span>
                        <span x-text="formatRupiah(transactionDetails?.change)"></span>
                    </div>
                </div>

                <div class="border-b-2 border-dashed border-slate-300 my-4"></div>

                <div class="text-center">
                    <p class="font-bold">TERIMA KASIH</p>
                    <p class="italic text-[10px] mt-1">"Bangun Rumah Impian Bersama Kami"</p>
                    <p class="text-[9px] mt-2 text-slate-400">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
                </div>
            </div>

            {{-- Footer Nota Actions --}}
            <div class="p-4 border-t border-slate-100 bg-slate-50 rounded-b-xl flex gap-3">
                <button @click="window.print()" class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30">
                    <i class="fas fa-print"></i> CETAK NOTA
                </button>
                <button @click="newTransaction()" class="flex-1 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-bold text-xs">
                    SELESAI
                </button>
            </div>
        </div>
    </div>

    {{-- 4. MODAL HISTORY TRANSAKSI POS --}}
    <div x-show="showHistoryModal" style="display: none;" class="fixed inset-0 z-[80] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm" x-transition.opacity>
        <div @click.away="showHistoryModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-slate-800 font-bold text-lg">HISTORY TRANSAKSI</h3>
                <button @click="showHistoryModal = false" class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar">
                <div x-show="isHistoryLoading" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-2xl text-slate-500"></i>
                    <p class="text-xs text-slate-400 mt-2">Memuat...</p>
                </div>
                <div x-show="!isHistoryLoading">
                    <template x-if="history.length === 0">
                        <div class="text-center text-slate-400 italic">Belum ada history transaksi.</div>
                    </template>
                    <template x-for="trx in history" :key="trx.id">
                        <div class="border rounded-lg p-3 mb-3 flex justify-between items-center">
                            <div>
                                <div class="text-sm font-bold text-slate-800" x-text="trx.no_trx"></div>
                                <div class="text-xs text-slate-500" x-text="new Date(trx.created_at).toLocaleString('id-ID') + ' • Kasir: ' + (trx.user || '-')"></div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-sm font-bold text-slate-700" x-text="formatRupiah(trx.total_amount)"></div>
                                <button @click="selectedHistory = trx" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 rounded-lg text-xs font-bold">DETAIL</button>
                            </div>
                        </div>
                    </template>

                    <div x-show="selectedHistory" class="mt-4 border-t pt-4">
                        <div class="text-xs text-slate-400 mb-2">Detail: <span class="font-bold" x-text="selectedHistory.no_trx"></span></div>
                        <template x-for="it in selectedHistory.items" :key="it.name+it.qty">
                            <div class="flex justify-between items-center text-sm py-1">
                                <div>
                                    <div class="font-bold" x-text="it.name"></div>
                                    <div class="text-xs text-slate-500" x-text="it.qty + ' x ' + formatRupiah(it.harga_satuan)"></div>
                                </div>
                                <div class="font-bold" x-text="formatRupiah(it.subtotal)"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-slate-100 bg-slate-50 text-right">
                <button @click="showHistoryModal = false" class="py-2 px-4 bg-slate-200 rounded-lg text-sm font-bold">TUTUP</button>
            </div>
        </div>
    </div>

</div>

<script>
    function posApp() {
        return {
            search: '',
            products: @json($products), 
            cart: [],
            isLoading: false,
            
            // Modal States
            showPaymentModal: false,
            showSuccessModal: false, // Modal Sukses
            showReceiptModal: false, // Modal Nota
            // History Modal
            showHistoryModal: false,
            history: [],
            isHistoryLoading: false,
            selectedHistory: null,

            // Transaction Data
            paymentMethod: 'cash',
            cashReceived: '',
            transactionDetails: null, // Data transaksi yang disimpan sementara

            init() { /* Load localstorage if needed */ },

            // --- COMPUTED ---
            get filteredProducts() {
                const q = (this.search || '').toString().trim().toLowerCase();
                if (!q) return this.products;
                const terms = q.split(/\s+/).filter(Boolean);
                return this.products.filter(p => {
                    const hay = (p.name || '').toString().toLowerCase();
                    return terms.every(t => hay.includes(t));
                });
            },
            get cartTotalItems() { return this.cart.reduce((t, i) => t + i.qty, 0); },
            get cartTotalPrice() { return this.cart.reduce((t, i) => t + (i.price * i.qty), 0); },

            // --- CART ACTIONS ---
            addToCart(product) {
                const existing = this.cart.find(i => i.id === product.id);
                if (existing) {
                    if (existing.qty < product.stock) existing.qty++;
                    else alert('Stok tidak mencukupi!');
                } else {
                    this.cart.push({ ...product, qty: 1 });
                }
            },
            updateQty(id, amount) {
                const item = this.cart.find(i => i.id === id);
                if (!item) return;
                const newQty = item.qty + amount;
                if (newQty > item.stock) { alert('Stok mentok!'); return; }
                if (newQty > 0) item.qty = newQty;
                else this.cart = this.cart.filter(i => i.id !== id);
            },
            formatRupiah(num) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
            },

            // --- PAYMENT FLOW ---
            openPaymentModal() {
                if (this.cart.length === 0) return;
                this.showPaymentModal = true;
                this.paymentMethod = 'cash';
                this.cashReceived = '';
            },
            calculateChange() {
                const received = parseFloat(this.cashReceived) || 0;
                const total = this.cartTotalPrice;
                return received < total ? 0 : received - total;
            },
            
            // 1. Klik Konfirmasi Pembayaran
            async confirmPayment() {
                // 1. Validasi Uang Cash
                if (this.paymentMethod === 'cash') {
                    const received = parseFloat(this.cashReceived) || 0;
                    if (received < this.cartTotalPrice) {
                        alert('Uang yang diterima kurang!');
                        return;
                    }
                }

                // 2. Set Loading agar user tidak klik 2x
                this.isLoading = true;

                // 3. Siapkan Payload Data
                const payload = {
                    cart: this.cart,
                    payment_method: this.paymentMethod,
                    cash_received: parseFloat(this.cashReceived) || this.cartTotalPrice,
                    _token: '{{ csrf_token() }}' // Wajib untuk Laravel POST request
                };

                try {
                    // 4. Kirim Request ke Server
                    const response = await fetch('{{ route("pos.process") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || 'Terjadi kesalahan pada server');
                    }

                    // 5. JIKA SUKSES: Update Data Transaksi untuk Nota
                    const trx = result.data;
                    const trxDate = new Date(trx.created_at);

                    this.transactionDetails = {
                        no_trx: trx.no_trx,
                        date: trxDate.toLocaleDateString('id-ID'),
                        time: trxDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute:'2-digit' }),
                        // Mapping items dari respon server
                        items: trx.items.map(item => ({
                            name: item.product_unit.master_product.nama,
                            price: parseFloat(item.harga_satuan),
                            qty: item.qty
                        })),
                        total: parseFloat(trx.total_amount),
                        method: trx.payment_method,
                        cash: parseFloat(trx.bayar_amount),
                        change: parseFloat(trx.kembalian)
                    };

                    // 6. Reset Keranjang & Update Stok Lokal
                    this.cart = [];
                    trx.items.forEach(item => {
                        const product = this.products.find(p => p.id === item.product_unit_id);
                        if (product) {
                            product.stock -= item.qty;
                        }
                    });
                    
                    // 7. Ganti Modal
                    this.showPaymentModal = false;
                    setTimeout(() => {
                        this.showSuccessModal = true;
                    }, 300);

                } catch (error) {
                    console.error(error);
                    alert('GAGAL MEMPROSES TRANSAKSI:\n' + error.message);
                } finally {
                    this.isLoading = false;
                }
            },

            // --- HISTORY ---
            openHistoryModal() {
                this.showHistoryModal = true;
                this.selectedHistory = null;
                this.loadHistory();
            },

            async loadHistory() {
                this.isHistoryLoading = true;
                try {
                    const res = await fetch('{{ route("pos.history") }}');
                    const json = await res.json();
                    if (!res.ok) throw new Error(json.message || 'Gagal memuat history');
                    this.history = json.data || [];
                } catch (e) {
                    console.error(e);
                    alert('Gagal memuat history: ' + e.message);
                } finally {
                    this.isHistoryLoading = false;
                }
            },

            // --- VIEW NOTA & RESET ---
            openReceipt() {
                this.showSuccessModal = false;
                setTimeout(() => {
                    this.showReceiptModal = true;
                }, 200);
            },

            newTransaction() {
                // Reset Semua State ke Awal
                this.cart = [];
                this.search = '';
                this.cashReceived = '';
                this.transactionDetails = null;
                
                // Tutup Semua Modal
                this.showPaymentModal = false;
                this.showSuccessModal = false;
                this.showReceiptModal = false;
            }
        }
    }
</script>
@endsection