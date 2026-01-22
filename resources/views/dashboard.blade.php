@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
    <p class="text-gray-600">Kelola kelas dan tugas Anda</p>
</div>

<div class="flex flex-col sm:flex-row gap-4 mb-8">
    <a href="{{ route('kelas.create') }}" class="btn-primary flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Buat Kelas Baru</span>
    </a>
    <a href="{{ route('dashboard.search') }}" class="btn-outline flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <span>Cari Kelas</span>
    </a>
    <a href="{{ route('kelas.join') }}" class="btn-outline flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
        </svg>
        <span>Gabung dengan Kode</span>
    </a>
</div>

@if($kelasDibuat->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Kelas yang Saya Buat</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($kelasDibuat as $kelas)
        <div class="card hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-900">{{ $kelas->nama }}</h3>
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium px-2.5 py-1 rounded">Instruktur</a>
            </div>
            
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $kelas->deskripsi }}</p>
            
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-2 text-gray-500">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $kelas->tugas->count() }} tugas</span>
                </div>
                <code class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ $kelas->kode_unik }}</code>
            </div>
            
            <a href="{{ route('kelas.show', $kelas->kode_unik) }}" class="mt-4 block text-center btn-primary">
                Buka Kelas
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

@if($kelasDigabung->count() > 0)
<div>
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Kelas yang Saya Ikuti</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($kelasDigabung as $kelas)
        <div class="card hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <h3 class="text-lg font-semibold text-gray-900">{{ $kelas->nama }}</h3>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1 rounded">Mahasiswa</span>
            </div>
            
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $kelas->deskripsi }}</p>
            
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $kelas->tugas->count() }} tugas</span>
            </div>
            
            <a href="{{ route('kelas.show', $kelas->kode_unik) }}" class="block text-center btn-primary">
                Buka Kelas
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

@if($kelasDibuat->count() === 0 && $kelasDigabung->count() === 0)
<div class="card text-center py-12">
    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
    </svg>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kelas</h3>
    <p class="text-gray-600 mb-6">Mulai dengan membuat kelas baru atau bergabung ke kelas yang sudah ada</p>
    <div class="flex gap-4 justify-center">
        <a href="{{ route('kelas.create') }}" class="btn-primary">Buat Kelas</a>
        <a href="{{ route('kelas.join') }}" class="btn-outline">Gabung Kelas</a>
    </div>
</div>
@endif
@endsection
