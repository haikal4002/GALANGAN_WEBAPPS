<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Stok Inventori - Galangan</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#E65100',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <div class="min-h-screen flex flex-col" x-data="{ searchQuery: '' }">
        
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white shadow-lg shadow-orange-500/30">
                        <i class="fas fa-cube text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800 tracking-tight">BangunTrack</h1>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Inventori Real-Time</p>
                    </div>
                </div>

                <!-- Live Search -->
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </span>
                    <input type="text" 
                           x-model="searchQuery"
                           class="w-full pl-10 pr-4 py-2 bg-slate-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder-slate-400" 
                           placeholder="Cari nama barang...">
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
            
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-list text-primary"></i> Daftar Stok Barang
                </h2>
                <div class="flex items-center gap-2 px-3 py-1 bg-green-50 border border-green-100 rounded-full">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-[10px] font-bold text-green-600 uppercase">Live Data</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider border-b border-slate-200">
                                <th class="px-6 py-4 whitespace-nowrap">No</th>
                                <th class="px-6 py-4 whitespace-nowrap">Nama Barang</th>
                                <th class="px-6 py-4 whitespace-nowrap">Satuan</th>
                                <th class="px-6 py-4 whitespace-nowrap text-center">Unit Ecer</th>
                                <th class="px-6 py-4 whitespace-nowrap text-center">Stok Tersedia</th>
                                <th class="px-6 py-4 whitespace-nowrap text-green-600">Harga Jual</th>
                                <th class="px-6 py-4 whitespace-nowrap text-blue-600">Harga Atas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($units as $item)
                            <tr x-show="searchQuery === '' || '{{ strtolower($item->masterProduct->nama ?? '') }}'.includes(searchQuery.toLowerCase())" 
                                class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-slate-400 font-mono text-xs">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-800">{{ $item->masterProduct->nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-slate-100 border border-slate-200 rounded text-xs font-bold text-slate-600">
                                        {{ $item->masterUnit->nama ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item->is_base_unit)
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 rounded text-[10px] font-bold border border-emerald-200 uppercase">Eceran</span>
                                    @else
                                        <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-[10px] font-bold border border-slate-200 uppercase">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center font-bold {{ $item->stok == 0 ? 'text-red-500' : 'text-slate-700' }}">
                                    {{ $item->stok }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">
                                    Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-bold">
                                    Rp {{ number_format($item->harga_atas, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-slate-400">Belum ada data stok yang tersedia.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-6">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-xs text-slate-400 font-medium">© 2026 BangunTrack - Sistem Manajemen Galangan. Semua data diperbarui secara otomatis.</p>
            </div>
        </footer>
    </div>

</body>
</html>
