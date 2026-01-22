@extends('layouts.app')

@section('title', 'Gabung ke Kelas')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Gabung ke Kelas</h1>

        <form action="{{ route('kelas.join.store') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Kelas *</label>
                <input 
                    type="text" 
                    name="kode_unik" 
                    value="{{ old('kode_unik') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-mono text-lg text-center tracking-wider uppercase"
                    placeholder="ABC123"
                    maxlength="6"
                    required
                >
                @error('kode_unik')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-2">Masukkan kode 6 karakter yang diberikan oleh instruktur</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                Kode kelas dapat diperoleh dari dosen/instruktur mata kuliah Anda. Setelah bergabung, Anda dapat melihat dan mengumpulkan tugas dari kelas tersebut.
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">
                    Gabung Kelas
                </button>
                <a href="{{ route('dashboard') }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
