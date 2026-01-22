@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('kelas.show', $kelas->kode_unik) }}"
                        class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mb-2 inline-block">
                        ← Kembali ke Kelas
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">📚 Modul Pembelajaran</h1>
                    <p class="text-gray-600 mt-1">{{ $kelas->nama }}</p>
                </div>

                @if ($keanggotaan->sebagai === 'instruktur')
                    <a href="{{ route('modul.create', $kelas->id) }}" class="btn-primary">
                        + Buat Modul Baru
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success mb-6">{{ session('success') }}</div>
        @endif

        <!-- Modul List -->
        @if ($moduls->count() > 0)
            <div class="space-y-4">
                @foreach ($moduls as $modul)
                    <div class="card hover:shadow-lg transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">
                                        📖 Bab {{ $modul->urutan }}: {{ $modul->judul }}
                                    </h3>
                                    @if ($modul->status === 'draft')
                                        <span class="badge-warning">Draft</span>
                                    @else
                                        <span class="badge-success">Published</span>
                                    @endif
                                </div>

                                @if ($modul->deskripsi)
                                    <p class="text-gray-600 mb-4">{{ $modul->deskripsi }}</p>
                                @endif

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="flex items-center justify-between text-sm mb-1">
                                        <span class="text-gray-700 font-medium">Progress Anda</span>
                                        <span class="text-indigo-600 font-bold">{{ $modul->persentase }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500"
                                            style="width: {{ $modul->persentase }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $modul->progress_count }}/{{ $modul->total_count }} sub-bab selesai
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('modul.show', $modul->id) }}" class="btn-primary text-sm">
                                        Lihat Detail →
                                    </a>

                                    @if ($keanggotaan->sebagai === 'instruktur')
                                        <a href="{{ route('modul.edit', $modul->id) }}" class="btn-outline text-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('modul.destroy', $modul->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin ingin menghapus modul ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn-outline text-sm text-red-600 border-red-600 hover:bg-red-50">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Modul</h3>
                <p class="text-gray-600 mb-6">Modul pembelajaran belum tersedia untuk kelas ini.</p>
                @if ($keanggotaan->sebagai === 'instruktur')
                    <a href="{{ route('modul.create', $kelas->id) }}" class="btn-primary">
                        + Buat Modul Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
