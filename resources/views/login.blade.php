<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BangunTrack</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#E65100', // Warna Orange Tua
                        primaryHover: '#cc4400',
                        bgSoft: '#F0F4F8', // Warna Background Kebiruan
                        iconBg: '#FFF0E6', // Warna Background Icon Orange Muda
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-bgSoft min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white p-10 rounded-2xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] w-full max-w-[400px] text-center">
        
        <div class="w-12 h-12 bg-white text-primary rounded-xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm">
            {{-- <i class="fas fa-cube"></i> --}}
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>

        <h3 class="text-xl font-bold text-slate-800 mb-1">BangunTrack</h3>
        <p class="text-[10px] font-bold text-slate-400 tracking-[1.5px] uppercase mb-8">Manajemen Toko Bangunan</p>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 text-xs py-2 px-3 rounded-lg mb-4 text-left border border-red-100">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="text-left">
                <label for="email" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-2">Username / Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="far fa-user text-sm"></i>
                    </div>
                    <input type="email" name="email" id="email" 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all placeholder-slate-300"
                        placeholder="admin / user" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="text-left">
                <label for="password" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fas fa-lock text-sm"></i>
                    </div>
                    <input type="password" name="password" id="password" 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-all placeholder-slate-300"
                        placeholder="admin123 / user123" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primaryHover text-white font-bold py-2.5 rounded-lg text-sm transition-colors shadow-md shadow-orange-200 mt-6">
                MASUK
            </button>
        </form>

        <div class="mt-8 text-[10px] text-slate-300 font-bold tracking-wide">
            AKSES ADMIN: ADMIN@TOKO.COM / PASSWORD
        </div>
    </div>

</body>
</html>