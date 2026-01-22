@extends('layouts.app')

@section('title', 'Edit Lab Session - ' . $lab->judul)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('lab.show', $lab->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Lab
        </a>
    </div>

    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900">Edit Lab Session</h1>
        </div>

        <form action="{{ route('lab.update', $lab->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" name="kelas_id" value="{{ $lab->kelas_id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Lab *</label>
                <input 
                    type="text" 
                    name="judul" 
                    value="{{ old('judul', $lab->judul) }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Contoh: Lab 1 - Selection Sort Algorithm"
                    required
                >
                @error('judul')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea 
                    name="deskripsi" 
                    rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Jelaskan tujuan lab, instruksi, dan kriteria penilaian..."
                >{{ old('deskripsi', $lab->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa Pemrograman *</label>
                <select 
                    name="bahasa_pemrograman"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    required
                >
                    <option value="">Pilih Bahasa</option>
                    @foreach(['c', 'cpp', 'java', 'python', 'php', 'javascript'] as $lang)
                        <option value="{{ $lang }}" {{ old('bahasa_pemrograman', $lab->bahasa_pemrograman) == $lang ? 'selected' : '' }}>
                            {{ ucfirst($lang) }}
                        </option>
                    @endforeach
                </select>
                @error('bahasa_pemrograman')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Template Code (Optional)</label>
                <textarea 
                    name="template_code" 
                    rows="10"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-gray-900 text-green-400"
                    placeholder="// Starter code untuk mahasiswa (opsional)..."
                >{{ old('template_code', $lab->template_code) }}</textarea>
                @error('template_code')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Test Cases (JSON Format, Optional)</label>
                <textarea 
                    name="test_cases" 
                    rows="5"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg font-mono text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder='{"input": "5\n3 1 4 2 5", "expected_output": "1 2 3 4 5"}'
                >{{ old('test_cases', is_array($lab->test_cases) ? json_encode($lab->test_cases) : $lab->test_cases) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Format: {"input": "...", "expected_output": "..."}</p>
                @error('test_cases')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deadline (Optional)</label>
                <input 
                    type="datetime-local" 
                    name="deadline" 
                    value="{{ old('deadline', $lab->deadline ? $lab->deadline->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
                @error('deadline')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('lab.show', $lab->id) }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
