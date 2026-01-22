@extends('layouts.app')

@section('title', 'Buat Kelas Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Buat Kelas Baru</h1>

        <form action="{{ route('kelas.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas *</label>
                <input 
                    type="text" 
                    name="nama" 
                    value="{{ old('nama') }}"
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
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                Setelah kelas dibuat, Anda akan mendapatkan <strong>kode unik</strong> yang bisa dibagikan ke mahasiswa untuk bergabung.
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    Buat Kelas
                </button>
                <a href="{{ route('dashboard') }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
