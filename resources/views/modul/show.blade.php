@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('modul.index', $modul->kelas_id) }}"
                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Kembali ke Daftar Modul
            </a>
            <div class="mt-3 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $modul->judul }}</h1>
                    @if ($modul->deskripsi)
                        <p class="text-gray-600 mt-2">{{ $modul->deskripsi }}</p>
                    @endif
                </div>
                @if ($keanggotaan->sebagai === 'instruktur')
                    <a href="{{ route('sub-modul.create', $modul->id) }}" class="btn-primary">
                        + Tambah Sub-Modul
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success mb-6">{{ session('success') }}</div>
        @endif

        <!-- Sub-Modul List -->
        @if ($modul->subModul->count() > 0)
            <div class="space-y-3">
                @foreach ($modul->subModul as $index => $sub)
                    <div class="card hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <!-- Completion Indicator -->
                                    @if ($sub->is_selesai)
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @else
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-600 font-semibold text-sm">{{ $index + 1 }}</span>
                                        </div>
                                    @endif

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $sub->judul }}</h3>
                                        @if ($sub->estimasi_menit)
                                            <p class="text-sm text-gray-600">⏱ {{ $sub->estimasi_menit }} menit</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('sub-modul.show', $sub->id) }}" class="btn-primary text-sm">
                                    {{ $sub->is_selesai ? 'Baca Lagi' : 'Mulai Belajar' }} →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📄</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Sub-Modul</h3>
                <p class="text-gray-600 mb-6">Sub-modul belum ditambahkan untuk modul ini.</p>
                @if ($keanggotaan->sebagai === 'instruktur')
                    <a href="{{ route('sub-modul.create', $modul->id) }}" class="btn-primary">
                        + Tambah Sub-Modul Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
