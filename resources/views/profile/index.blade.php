@extends('layouts.admin')

@section('title', 'Pengaturan Profil')
@section('header-title', 'Pengaturan Profil')

@section('content')
<div class="max-w-4xl mx-auto">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm flex items-center shadow-sm rounded-r-lg">
            <i class="fas fa-check-circle mr-3"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm shadow-sm rounded-r-lg">
            <div class="flex items-center mb-2 font-bold">
                <i class="fas fa-exclamation-circle mr-3"></i>
                Terdapat kesalahan input:
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Sisi Kiri: Info Ringkas --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="h-24 bg-primary relative">
                    <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                        <div class="w-20 h-20 rounded-full bg-white p-1 shadow-md">
                            <div class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center text-primary text-2xl font-bold border border-slate-100 uppercase">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-12 pb-6 px-6 text-center">
                    <h3 class="font-bold text-slate-800 text-lg">{{ $user->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $user->email }}</p>
                    <div class="mt-4 flex flex-center justify-center">
                        <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                            {{ $user->role ?? 'User' }}
                        </span>
                    </div>
                </div>
                <div class="border-t border-slate-50 p-4 bg-slate-50/50">
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                        <span>Status Akun</span>
                        <span class="text-green-500 font-bold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                        </span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span>Bergabung Sejak</span>
                        <span class="font-medium text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form Edit --}}
        <div class="md:col-span-2 space-y-6">
            
            {{-- Update Profile --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h2 class="font-bold text-slate-800">Informasi Pribadi</h2>
                        <p class="text-xs text-slate-500">Perbarui informasi profil dan alamat email Anda.</p>
                    </div>
                    <i class="fas fa-user-edit text-slate-300"></i>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="far fa-user"></i>
                                </span>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                    required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <i class="far fa-envelope"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                    class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-primary hover:bg-orange-600 text-white px-6 py-2 rounded-xl text-sm font-bold shadow-md shadow-orange-200 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h2 class="font-bold text-slate-800 text-red-600">Keamanan & Password</h2>
                        <p class="text-xs text-slate-500">Pastikan akun Anda menggunakan password yang aman.</p>
                    </div>
                    <i class="fas fa-shield-alt text-slate-300"></i>
                </div>
                <form action="{{ route('profile.password') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password" 
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 transition-all"
                                required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Password Baru</label>
                                <input type="password" name="password" 
                                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 transition-all"
                                    required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" 
                                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-red-200 focus:border-red-500 transition-all"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-6 py-2 rounded-xl text-sm font-bold shadow-md shadow-slate-200 transition-all flex items-center gap-2">
                            <i class="fas fa-key"></i> Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
