@extends('layouts.app')

@section('title', $tugas->judul)

@section('content')
    <div class="mb-6">
        <a href="{{ route('kelas.show', $tugas->kelas->kode_unik) }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Kelas: {{ $tugas->kelas->nama }}
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $tugas->judul }}</h1>

                <div class="flex flex-wrap gap-2 mb-6">
                    @if ($tugas->sudahLewatDeadline())
                        <span
                            class="flex items-center gap-1.5 bg-red-100 text-red-800 px-3 py-1 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Deadline Terlewat
                        </span>
                    @else
                        <span
                            class="flex items-center gap-1.5 bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Masih Aktif
                        </span>
                    @endif

                    <span class="flex items-center gap-1.5 bg-gray-100 text-gray-800 px-3 py-1 rounded-lg text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $tugas->deadline->format('d M Y, H:i') }}
                    </span>
                </div>

                <div class="prose max-w-none mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi Tugas</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $tugas->deskripsi }}</p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Ketentuan File</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <div>
                            <strong>Jenis file yang diizinkan:</strong>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @if ($tugas->jenis_file)
                                    @foreach ($tugas->jenis_file as $jenis)
                                        <span
                                            class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs uppercase font-mono">{{ $jenis }}</span>
                                    @endforeach
                                @else
                                    <span class="text-gray-500 text-xs">Semua jenis file diizinkan</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <strong>Ukuran maksimal:</strong> {{ $tugas->ukuran_maks_mb }} MB
                            <span class="text-gray-500">(untuk upload langsung maks 10 MB)</span>
                        </div>
                        @if ($tugas->validasi_konten)
                            <div class="alert-info mt-3">
                                <strong>Validasi Konten:</strong>
                                <pre class="mt-2 text-xs">{{ json_encode($tugas->validasi_konten, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card sticky top-20">
                @if (!$isInstruktur)
                    @if ($pengumpulan)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-900 mb-3">Status Pengumpulan Anda</h3>

                            @if ($pengumpulan->status === 'baru')
                                <span
                                    class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium mb-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Sudah Dikumpulkan
                                </span>
                            @elseif($pengumpulan->status === 'dicek')
                                <span
                                    class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-3 py-1 rounded-lg text-sm font-medium mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Sedang Dicek
                                </span>
                            @elseif($pengumpulan->status === 'revisi')
                                <span
                                    class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-800 px-3 py-1 rounded-lg text-sm font-medium mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Perlu Revisi
                                </span>
                            @elseif($pengumpulan->status === 'lulus')
                                <span
                                    class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium mb-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Lulus
                                </span>
                            @endif

                            @if ($pengumpulan->nilai)
                                <div class="mb-3">
                                    <div class="text-sm text-gray-600">Nilai</div>
                                    <div class="text-3xl font-bold text-indigo-600">{{ $pengumpulan->nilai }}</div>
                                </div>
                            @endif

                            @if ($pengumpulan->feedback)
                                <div class="mb-3">
                                    <div class="text-sm text-gray-600 mb-1">Feedback</div>
                                    <div class="bg-gray-50 p-3 rounded text-sm text-gray-700">
                                        {{ $pengumpulan->feedback }}
                                    </div>
                                </div>
                            @endif

                            <div class="text-sm text-gray-600 mb-3">
                                File: {{ $pengumpulan->namaFile() }}
                            </div>

                            @if ($pengumpulan->status === 'revisi')
                                <a href="{{ route('pengumpulan.create', $tugas->id) }}"
                                    class="block text-center btn-primary">
                                    Kumpulkan Ulang
                                </a>
                            @endif
                        </div>
                    @else
                        @if (!$tugas->sudahLewatDeadline())
                            <a href="{{ route('pengumpulan.create', $tugas->id) }}"
                                class="block text-center btn-primary mb-3">
                                Kumpulkan Tugas
                            </a>
                        @else
                            <div class="alert-error">
                                Deadline sudah terlewat. Anda tidak dapat mengumpulkan tugas ini.
                            </div>
                        @endif
                    @endif
                @else
                    <h3 class="font-semibold text-gray-900 mb-3">Aksi Instruktur</h3>
                    <a href="{{ route('tugas.nilai', $tugas->id) }}" class="block text-center btn-primary">
                        Lihat & Nilai Pengumpulan
                    </a>
                    <div class="mt-3 text-sm text-gray-600 text-center">
                        {{ $tugas->pengumpulan->count() }} mahasiswa sudah mengumpulkan
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
