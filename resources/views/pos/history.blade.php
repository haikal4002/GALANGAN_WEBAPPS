@extends('layouts.admin')

@section('title', 'History Transaksi POS - BangunTrack')

@section('header-title')
    <i class="fas fa-history text-primary mr-2"></i> HISTORY POS
@endsection

@section('content')

<div class="p-6">
    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('pos.index') }}" class="py-2 px-4 bg-slate-200 rounded font-bold text-sm">KEMBALI KE POS</a>
        <input type="date" id="start_date" class="border p-2 rounded">
        <span class="text-xs text-slate-400">sampai</span>
        <input type="date" id="end_date" class="border p-2 rounded">
        <button id="filterBtn" class="ml-3 py-2 px-4 bg-primary text-white rounded">Filter</button>
        <a id="exportBtn" class="ml-2 py-2 px-4 bg-slate-200 rounded" href="#">Export CSV</a>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detailModal" class="fixed inset-0 hidden z-50 items-center justify-center bg-slate-900/60">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-4">
            <div class="flex justify-between items-center mb-3">
                <h3 id="detailNo" class="font-bold text-lg"></h3>
                <button onclick="closeDetail()" class="text-slate-400 hover:text-slate-600 text-xl">&times;</button>
            </div>
            <div id="detailBody" class="space-y-2 text-sm text-slate-700"></div>
            <div class="text-right mt-4">
                <button onclick="closeDetail()" class="py-2 px-4 bg-slate-200 rounded">TUTUP</button>
            </div>
        </div>
    </div>

    <div id="list" class="space-y-3">
        <!-- JS will populate -->
    </div>
</div>

<script>
    async function loadHistory(start, end) {
        const params = new URLSearchParams();
        if (start) params.append('start', start);
        if (end) params.append('end', end);
        const res = await fetch('{{ route("pos.history") }}' + (params.toString() ? ('?' + params.toString()) : ''));
        const json = await res.json();
        const list = document.getElementById('list');
        list.innerHTML = '';
        (json.data || []).forEach(trx => {
            const d = new Date(trx.created_at);
            const el = document.createElement('div');
            el.className = 'border rounded p-3 flex justify-between items-center';
            el.innerHTML = `
                <div>
                    <div class="font-bold">${trx.no_trx}</div>
                    <div class="text-xs text-slate-500">${d.toLocaleString('id-ID')} • Kasir: ${trx.user || '-'}</div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="font-bold">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits:0 }).format(trx.total_amount)}</div>
                    <button class="py-2 px-3 bg-slate-100 rounded text-xs" onclick="openDetail(${trx.id})">DETAIL</button>
                </div>
            `;
            list.appendChild(el);
        });
    }

    async function openDetail(id) {
        try {
            const res = await fetch('/pos/history/' + id + '/detail');
            const json = await res.json();
            if (!res.ok) throw new Error(json.message || 'Gagal memuat detail');
            const trx = json.data;
            document.getElementById('detailNo').textContent = trx.no_trx;
            const body = document.getElementById('detailBody');
            body.innerHTML = '';
            const d = new Date(trx.created_at);
            const header = document.createElement('div');
            header.className = 'text-xs text-slate-500 mb-2';
            header.textContent = d.toLocaleString('id-ID') + ' • Kasir: ' + (trx.user || '-');
            body.appendChild(header);
            trx.items.forEach(it => {
                const row = document.createElement('div');
                row.className = 'flex justify-between items-center';
                row.innerHTML = `<div><div class="font-bold">${it.name}</div><div class="text-xs text-slate-500">${it.qty} x ${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits:0 }).format(it.harga_satuan)}</div></div><div class="font-bold">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits:0 }).format(it.subtotal)}</div>`;
                body.appendChild(row);
            });
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        } catch (e) {
            console.error(e);
            alert('Gagal memuat detail: ' + e.message);
        }
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
        document.getElementById('detailModal').classList.remove('flex');
    }

    document.getElementById('filterBtn').addEventListener('click', () => {
        const s = document.getElementById('start_date').value;
        const e = document.getElementById('end_date').value;
        loadHistory(s, e);
        // Update export link
        const exportBtn = document.getElementById('exportBtn');
        const params = new URLSearchParams();
        if (s) params.append('start', s);
        if (e) params.append('end', e);
        exportBtn.href = '{{ route("pos.history.view") }}?export=csv&' + params.toString();
    });

    // Initial load (last 30 days)
    (function () {
        const end = new Date();
        const start = new Date();
        start.setDate(end.getDate() - 30);
        document.getElementById('start_date').value = start.toISOString().slice(0,10);
        document.getElementById('end_date').value = end.toISOString().slice(0,10);
        loadHistory(document.getElementById('start_date').value, document.getElementById('end_date').value);
    })();
</script>

@endsection