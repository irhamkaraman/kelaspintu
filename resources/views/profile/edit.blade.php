@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Profil</h1>
        <p class="text-gray-600 mt-1">Kelola informasi akun Anda</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-50 text-red-800 border border-red-200 rounded-lg p-4 mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Profile Information --}}
    <div class="card mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Profil</h2>
        
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    placeholder="Nama Anda"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input 
                    type="email" 
                    value="{{ $user->email }}"
                    disabled
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                >
                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
            </div>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="btn-primary"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="card mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubah Password</h2>
        
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <input type="hidden" name="name" value="{{ $user->name }}">

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Saat Ini
                </label>
                <input 
                    type="password" 
                    name="current_password" 
                    id="current_password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    placeholder="Masukkan password saat ini"
                >
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru
                </label>
                <input 
                    type="password" 
                    name="new_password" 
                    id="new_password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    placeholder="Minimal 8 karakter"
                >
            </div>

            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>
                <input 
                    type="password" 
                    name="new_password_confirmation" 
                    id="new_password_confirmation"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    placeholder="Ketik ulang password baru"
                >
            </div>

            <div class="pt-4">
                <button 
                    type="submit" 
                    class="btn-primary"
                >
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

    {{-- Google Account Connection --}}
    <div class="card">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Koneksi Akun Google</h2>
        
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <div>
                    <p class="font-medium text-gray-900">Akun Google</p>
                    @if($user->google_id)
                        <p class="text-sm text-green-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Terhubung
                        </p>
                    @else
                        <p class="text-sm text-gray-500">Belum terhubung</p>
                    @endif
                </div>
            </div>

            @if($user->google_id)
                <button 
                    disabled
                    class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed"
                >
                    Sudah Terhubung
                </button>
            @else
                <a 
                    href="{{ route('profile.connect-google') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Hubungkan dengan Google
                </a>
            @endif
        </div>

        @if($user->google_id)
            <p class="text-sm text-gray-600 mt-3">
                Dengan menghubungkan akun Google, Anda dapat login menggunakan Google tanpa perlu memasukkan password.
            </p>
        @else
            <p class="text-sm text-gray-600 mt-3">
                Hubungkan akun Google Anda untuk kemudahan login di masa mendatang.
            </p>
        @endif
    </div>
</div>
@endsection
