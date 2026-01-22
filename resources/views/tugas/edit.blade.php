@extends('layouts.app')

@section('title', 'Edit Tugas - ' . $tugas->judul)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('tugas.show', $tugas->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Tugas
        </a>
    </div>

    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900">Edit Tugas</h1>
        </div>

        <form action="{{ route('tugas.update', $tugas->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="kelas_id" value="{{ $tugas->kelas_id }}">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Tugas *</label>
                <input 
                    type="text" 
                    name="judul" 
                    value="{{ old('judul', $tugas->judul) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Contoh: Tugas Praktikum 1 - CRUD Laravel"
                    required
                >
                @error('judul')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                <textarea 
                    name="deskripsi" 
                    rows="5"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Jelaskan detail tugas, kriteria penilaian, dan hal-hal yang perlu diperhatikan..."
                    required
                >{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deadline *</label>
                <input 
                    type="datetime-local" 
                    name="deadline" 
                    value="{{ old('deadline', $tugas->deadline->format('Y-m-d\TH:i')) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    required
                >
                @error('deadline')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Jenis File yang Diizinkan *</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach(['pdf', 'docx', 'pptx', 'zip', 'csv', 'txt', 'java', 'py', 'dart', 'xlsx', 'png', 'jpg'] as $type)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="jenis_file[]" 
                            value="{{ $type }}"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            {{ in_array($type, old('jenis_file', $tugas->jenis_file ?? [])) ? 'checked' : '' }}
                        >
                        <span class="text-sm text-gray-700 uppercase">{{ $type }}</span>
                    </label>
                    @endforeach
                </div>
                @error('jenis_file')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Maksimal File (MB) *</label>
                <input 
                    type="number" 
                    name="ukuran_maks_mb" 
                    value="{{ old('ukuran_maks_mb', $tugas->ukuran_maks_mb) }}"
                    min="1"
                    max="100"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    required
                >
                <p class="text-sm text-gray-500 mt-1">Upload langsung maksimal 10 MB. Untuk file lebih besar, mahasiswa akan menggunakan link.</p>
                @error('ukuran_maks_mb')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Validasi Konten ZIP (Opsional)</label>
                <textarea 
                    name="validasi_konten" 
                    rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-mono text-sm"
                    placeholder='{"zip": ["README.md", "index.php"]}'
                >{{ old('validasi_konten', $tugas->validasi_konten ? json_encode($tugas->validasi_konten) : '') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Format JSON. Jika diisi, file ZIP harus mengandung file-file yang disebutkan.</p>
                @error('validasi_konten')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('tugas.show', $tugas->id) }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
