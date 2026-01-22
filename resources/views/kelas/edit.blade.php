@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kelas</h1>
        </div>

        <form action="{{ route('kelas.update', $kelas->kode_unik) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas *</label>
                <input 
                    type="text" 
                    name="nama" 
                    value="{{ old('nama', $kelas->nama) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Contoh: Pemrograman Web Lanjut"
                    required
                >
                @error('nama')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea 
                    name="deskripsi" 
                    rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Deskripsi singkat tentang kelas ini..."
                >{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-sm text-gray-700">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-medium mb-1">Kode Kelas: <code class="bg-white px-2 py-0.5 rounded">{{ $kelas->kode_unik }}</code></p>
                        <p class="text-xs text-gray-600">Kode kelas tidak dapat diubah</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('kelas.show', $kelas->kode_unik) }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
