@extends('layouts.app')

@section('title', 'Buat Lab Session Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('kelas.show', $kelas->kode_unik) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Kelas
        </a>
    </div>

    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
            </svg>
            <h1 class="text-2xl font-bold text-gray-900">Buat Lab Session Baru</h1>
        </div>

        <form action="{{ route('lab.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Lab *</label>
                <input 
                    type="text" 
                    name="judul" 
                    value="{{ old('judul') }}"
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
                >{{ old('deskripsi') }}</textarea>
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
                    <option value="c" {{ old('bahasa_pemrograman') == 'c' ? 'selected' : '' }}>C</option>
                    <option value="cpp" {{ old('bahasa_pemrograman') == 'cpp' ? 'selected' : '' }}>C++</option>
                    <option value="java" {{ old('bahasa_pemrograman') == 'java' ? 'selected' : '' }}>Java</option>
                    <option value="python" {{ old('bahasa_pemrograman') == 'python' ? 'selected' : '' }}>Python</option>
                    <option value="php" {{ old('bahasa_pemrograman') == 'php' ? 'selected' : '' }}>PHP</option>
                    <option value="javascript" {{ old('bahasa_pemrograman') == 'javascript' ? 'selected' : '' }}>JavaScript</option>
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
                >{{ old('template_code') }}</textarea>
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
                >{{ old('test_cases') }}</textarea>
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
                    value="{{ old('deadline') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                >
                @error('deadline')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">
                    Buat Lab Session
                </button>
                <a href="{{ route('kelas.show', $kelas->kode_unik) }}" class="btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
