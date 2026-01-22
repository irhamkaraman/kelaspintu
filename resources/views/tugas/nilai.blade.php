@extends('layouts.app')

@section('title', 'Penilaian - ' . $tugas->judul)

@section('content')
<div class="mb-6">
    <a href="{{ route('tugas.show', $tugas->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Tugas
    </a>
</div>

<div class="card mb-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $tugas->judul }}</h1>
    <p class="text-gray-600">{{ $tugas->kelas->nama }}</p>
    <div class="mt-3 text-sm text-gray-600">
        Total Pengumpulan: <strong>{{ $pengumpulanList->count() }}</strong>
    </div>
</div>

@if($pengumpulanList->count() > 0)
    <div class="space-y-4">
        @foreach($pengumpulanList as $pengumpulan)
        <div class="card">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg">{{ $pengumpulan->mahasiswa->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $pengumpulan->mahasiswa->email }}</p>
                        </div>
                        
                        @if($pengumpulan->status === 'baru')
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium">Baru</span>
                        @elseif($pengumpulan->status === 'dicek')
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-sm font-medium">Dicek</span>
                        @elseif($pengumpulan->status === 'revisi')
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-lg text-sm font-medium">Revisi</span>
                        @elseif($pengumpulan->status === 'lulus')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium">Lulus</span>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="text-sm text-gray-600 mb-2">Dikumpulkan: {{ $pengumpulan->created_at->format('d M Y, H:i') }}</div>
                        
                        @if($pengumpulan->file_path)
                            <div class="flex items-center gap-2 text-sm">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700">{{ $pengumpulan->namaFile() }}</span>
                                <a href="{{ route('pengumpulan.download', $pengumpulan->id) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                    Download
                                </a>
                            </div>
                        @else
                            <div class="text-sm">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                                    </svg>
                                    <a href="{{ $pengumpulan->link_unduhan }}" target="_blank" class="text-indigo-600 hover:text-indigo-700 font-medium">
                                        Buka Link Eksternal
                                    </a>
                                </div>
                                <div class="bg-white p-3 rounded border border-gray-200">
                                    <div class="text-xs text-gray-500 mb-1">Deskripsi:</div>
                                    <div class="text-gray-700">{{ $pengumpulan->deskripsi_link }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($pengumpulan->nilai || $pengumpulan->feedback)
                        <div class="border-t border-gray-200 pt-3">
                            @if($pengumpulan->nilai)
                                <div class="text-sm mb-2">
                                    <span class="text-gray-600">Nilai saat ini:</span>
                                    <span class="text-2xl font-bold text-indigo-600 ml-2">{{ $pengumpulan->nilai }}</span>
                                </div>
                            @endif
                            @if($pengumpulan->feedback)
                                <div class="text-sm">
                                    <span class="text-gray-600">Feedback:</span>
                                    <div class="bg-yellow-50 p-2 rounded mt-1 text-gray-700">{{ $pengumpulan->feedback }}</div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="lg:w-80 border-t lg:border-t-0 lg:border-l border-gray-200 pt-4 lg:pt-0 lg:pl-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Berikan Penilaian</h4>
                    <form action="{{ route('pengumpulan.update', $pengumpulan->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai (0-100)</label>
                            <input 
                                type="number" 
                                name="nilai" 
                                value="{{ $pengumpulan->nilai ?? '' }}"
                                min="0"
                                max="100"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                required
                            >
                                <option value="baru" {{ $pengumpulan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                                <option value="dicek" {{ $pengumpulan->status === 'dicek' ? 'selected' : '' }}>Dicek</option>
                                <option value="revisi" {{ $pengumpulan->status === 'revisi' ? 'selected' : '' }}>Revisi</option>
                                <option value="lulus" {{ $pengumpulan->status === 'lulus' ? 'selected' : '' }}>Lulus</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Feedback</label>
                            <textarea 
                                name="feedback" 
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm"
                                placeholder="Catatan untuk mahasiswa..."
                            >{{ $pengumpulan->feedback }}</textarea>
                        </div>

                        <button type="submit" class="w-full btn-primary text-sm">
                            Simpan Penilaian
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengumpulan</h3>
        <p class="text-gray-600">Belum ada mahasiswa yang mengumpulkan tugas ini</p>
    </div>
@endif
@endsection
