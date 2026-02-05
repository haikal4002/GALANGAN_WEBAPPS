<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BangunTrack')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: '#E65100', // Orange Branding
                        sidebar: '#0F172A', // Dark Slate
                        cardDark: '#1E293B',
                    }
                }
            }
        }

        // Global function for Rupiah formatting
        window.formatRupiah = function(number) {
            if (!number) return '0';
            return new Intl.NumberFormat('id-ID').format(number);
        }

        window.unformatRupiah = function(string) {
            return parseInt(string.replace(/\D/g, '')) || 0;
        }
    </script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 font-sans antialiased overflow-hidden" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen">
        {{-- sidebar --}}
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="sidebar-transition bg-sidebar text-white flex flex-col fixed h-full z-50">
                <div class="h-20 flex items-center border-b border-slate-700/50 sidebar-transition" :class="sidebarOpen ? 'px-6' : 'justify-center'">
                <div class="flex-shrink-0 w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain">
                </div>
                <div x-show="sidebarOpen" x-transition.opacity class="ml-3 overflow-hidden">
                    <h1 class="font-bold text-lg leading-tight whitespace-nowrap">BangunTrack</h1>
                    <p class="text-[10px] text-slate-400 font-medium tracking-wider whitespace-nowrap uppercase">Pro Management</p>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center rounded-xl transition-all group 
                   {{ request()->routeIs('dashboard') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-chart-line w-6 text-center text-lg {{ request()->routeIs('dashboard') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="font-bold text-sm whitespace-nowrap">Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                        <div x-show="sidebarOpen" class="ml-auto w-2 h-2 bg-primary rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('stok.index') }}" 
                   class="flex items-center rounded-xl transition-all group 
                   {{ request()->routeIs('stok.*') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-th-large w-6 text-center text-lg {{ request()->routeIs('stok.*') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="{{ request()->routeIs('stok.*') ? 'font-bold' : 'font-medium' }} text-sm whitespace-nowrap">Master Stock</span>
                    @if(request()->routeIs('stok.*'))
                        <div x-show="sidebarOpen" class="ml-auto w-2 h-2 bg-primary rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('pos.index') }}" 
                class="flex items-center rounded-xl transition-all group 
                {{ request()->routeIs('pos.*') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-shopping-cart w-6 text-center text-lg {{ request()->routeIs('pos.*') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="{{ request()->routeIs('pos.*') ? 'font-bold' : 'font-medium' }} text-sm whitespace-nowrap">Point of Sale</span>
                    
                    {{-- Indikator Aktif --}}
                    @if(request()->routeIs('pos.*'))
                        <div x-show="sidebarOpen" class="ml-auto w-2 h-2 bg-primary rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('report.index') }}" 
                class="flex items-center rounded-xl transition-all group {{ request()->routeIs('report.*') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-file-invoice-dollar w-6 text-center text-lg {{ request()->routeIs('report.*') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="{{ request()->routeIs('report.*') ? 'font-bold' : 'font-medium' }} text-sm whitespace-nowrap">Laporan Bulanan</span>
                    @if(request()->routeIs('report.*'))
                        <div x-show="sidebarOpen" class="ml-auto w-2 h-2 bg-primary rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('cashflow.index') }}" 
                class="flex items-center rounded-xl transition-all group {{ request()->routeIs('cashflow.*') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-wallet w-6 text-center text-lg {{ request()->routeIs('cashflow.*') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="{{ request()->routeIs('cashflow.*') ? 'font-bold' : 'font-medium' }} text-sm whitespace-nowrap">Cash Flow</span>
                    @if(request()->routeIs('cashflow.*'))
                        <div x-show="sidebarOpen" class="ml-auto w-2 h-2 bg-primary rounded-full"></div>
                    @endif
                </a>

                <a href="{{ route('expenses.index') }}" 
                class="flex items-center rounded-xl transition-all group {{ request()->routeIs('expenses.*') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-layer-group w-6 text-center text-lg {{ request()->routeIs('expenses.*') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="{{ request()->routeIs('expenses.*') ? 'font-bold' : 'font-medium' }} text-sm whitespace-nowrap">Lainnya (Expenses)</span>
                    @if(request()->routeIs('expenses.*'))
                        <div x-show="sidebarOpen" class="ml-auto w-2 h-2 bg-primary rounded-full"></div>
                    @endif
                </a>
                
                <div x-show="sidebarOpen" class="pt-4 pb-2">
                    <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest whitespace-nowrap">Settings</p>
                </div>

                <a href="{{ route('profile.index') }}" 
                   class="flex items-center rounded-xl transition-all group 
                   {{ request()->routeIs('profile.*') ? 'bg-white text-primary shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}"
                   :class="sidebarOpen ? 'px-4 py-3' : 'p-3 justify-center'">
                    <i class="fas fa-cog w-6 text-center text-lg {{ request()->routeIs('profile.*') ? '' : 'group-hover:text-primary transition-colors' }}" :class="sidebarOpen && 'mr-2'"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="{{ request()->routeIs('profile.*') ? 'font-bold' : 'font-medium' }} text-sm whitespace-nowrap">Pengaturan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-700/50 bg-[#0B1120] overflow-hidden">
                <div class="flex items-center sidebar-transition" :class="sidebarOpen ? 'mb-6' : 'mb-6 justify-center'">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-sm border-2 border-slate-800 shadow-sm">
                        {{ substr(Auth::user()->name ?? 'AD', 0, 2) }}
                    </div>
                    <div x-show="sidebarOpen" x-transition.opacity class="ml-3 overflow-hidden">
                        <h4 class="text-sm font-bold text-white truncate whitespace-nowrap">{{ Auth::user()->name ?? 'Administrator' }}</h4>
                        <p class="text-xs text-green-400 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block animate-pulse"></span> Online</p>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button class="w-full py-2 rounded-lg border border-slate-600 text-slate-300 text-xs font-bold hover:bg-red-500/10 hover:text-red-400 hover:border-red-500 transition-all flex items-center justify-center"
                        :class="sidebarOpen ? 'px-4 gap-2' : 'px-0'">
                        <i class="fas fa-sign-out-alt"></i> 
                        <span x-show="sidebarOpen" x-transition.opacity class="whitespace-nowrap uppercase">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main :class="sidebarOpen ? 'ml-64' : 'ml-20'"
            class="sidebar-transition flex-1 h-full overflow-y-auto bg-[#F8FAFC]">
            
            <header class="bg-white sticky top-0 z-40 px-6 py-4 flex items-center justify-between border-b border-slate-200/60 shadow-sm">
    <div class="flex items-center gap-4">
        {{-- Toggle button --}}
        <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-primary transition-all p-2 rounded-lg hover:bg-slate-100">
            <i class="fas text-lg" :class="sidebarOpen ? 'fa-angle-left' : 'fa-bars'"></i>
        </button>

        {{-- Judul Halaman Dinamis --}}
        <div class="flex items-center gap-2 text-slate-400 text-sm font-bold tracking-wide uppercase">
            @yield('header-title', 'Dashboard View')
        </div>
    </div>
    
    <div class="flex items-center gap-6">
        
        {{-- LOGIKA DINAMIS DI SINI --}}
        @if (View::hasSection('header-right'))
            {{-- Jika halaman mendefinisikan 'header-right', tampilkan isinya --}}
            @yield('header-right')
        @else
            {{-- Default: Tampilkan Search Bar jika tidak ada custom header-right --}}
            <div class="relative hidden md:block w-72 lg:w-96">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 text-xs"></i>
                </span>
                <input type="text" class="w-full pl-9 pr-4 py-2 bg-slate-100/50 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder-slate-400" placeholder="Cari data...">
            </div>
        @endif
        
        {{-- Status System (Selalu Muncul) --}}
        <div class="flex items-center gap-3 px-3 py-1 bg-slate-50 border border-slate-200 rounded-full">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">System Online</span>
        </div>
    </div>
</header>

            <div class="p-8 pb-20">
                @yield('content')
            </div>

        </main>
    </div>

    @stack('scripts')

</body>
</html>