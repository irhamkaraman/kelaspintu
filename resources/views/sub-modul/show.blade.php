@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Navigation Header -->
        <div class="mb-6">
            <a href="{{ route('modul.show', $subModul->modul_id) }}"
                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Kembali ke {{ $subModul->modul->judul }}
            </a>
            <div class="mt-3">
                <h2 class="text-sm text-gray-600">{{ $subModul->modul->judul }}</h2>
                <h1 class="text-3xl font-bold text-gray-900 mt-1">{{ $subModul->judul }}</h1>
                @if ($subModul->estimasi_menit)
                    <p class="text-gray-600 mt-2">⏱ Estimasi waktu baca: {{ $subModul->estimasi_menit }} menit</p>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success mb-6">{{ session('success') }}</div>
        @endif

        <!-- Content Card -->
        <div class="card mb-6">
            <!-- Rich Text Content -->
            <div class="prose prose-indigo max-w-none">
                {!! $subModul->konten !!}
            </div>

            <!-- File Attachment -->
            @if ($subModul->file_path)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📎 File Lampiran</h3>
                    <a href="{{ Storage::url($subModul->file_path) }}" target="_blank" download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="font-medium">{{ $subModul->file_name }}</span>
                    </a>
                </div>
            @endif

            <!-- External Link -->
            @if ($subModul->link_eksternal)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">🔗 Link Eksternal</h3>
                    <a href="{{ $subModul->link_eksternal }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Buka Link
                    </a>
                </div>
            @endif
        </div>

        <!-- Progress & Navigation -->
        <div class="card">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <!-- Mark Complete Button -->
                <form action="{{ route('sub-modul.complete', $subModul->id) }}" method="POST">
                    @csrf
                    @if ($isSelesai)
                        <button type="submit" class="btn-outline border-green-600 text-green-600 hover:bg-green-50">
                            <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Sudah Selesai
                        </button>
                    @else
                        <button type="submit" class="btn-primary">
                            ✓ Tandai Selesai
                        </button>
                    @endif
                </form>

                <!-- Navigation Buttons -->
                <div class="flex gap-2">
                    @if ($previousSubModul)
                        <a href="{{ route('sub-modul.show', $previousSubModul->id) }}" class="btn-outline">
                            ← Sebelumnya
                        </a>
                    @endif

                    @if ($nextSubModul)
                        <a href="{{ route('sub-modul.show', $nextSubModul->id) }}" class="btn-primary">
                            Lanjut →
                        </a>
                    @else
                        <a href="{{ route('modul.show', $subModul->modul_id) }}" class="btn-primary">
                            Selesai →
                        </a>
                    @endif
                </div>
            </div>

            <!-- Edit/Delete for Instruktur -->
            @if ($keanggotaan->sebagai === 'instruktur')
                <div class="mt-4 pt-4 border-t border-gray-200 flex gap-2">
                    <a href="{{ route('sub-modul.edit', $subModul->id) }}" class="btn-outline text-sm">
                        Edit Sub-Modul
                    </a>
                    <form action="{{ route('sub-modul.destroy', $subModul->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus sub-modul ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline text-sm text-red-600 border-red-600 hover:bg-red-50">
                            Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Prose Styling for Rich Content -->
    <style>
        .prose {
            color: #374151;
            max-width: none;
        }

        .prose h1 {
            font-size: 2em;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 0.8em;
        }

        .prose h2 {
            font-size: 1.5em;
            font-weight: 600;
            margin-top: 2em;
            margin-bottom: 1em;
        }

        .prose h3 {
            font-size: 1.25em;
            font-weight: 600;
            margin-top: 1.6em;
            margin-bottom: 0.6em;
        }

        .prose p {
            margin-bottom: 1.25em;
            line-height: 1.75;
        }

        .prose ul,
        .prose ol {
            margin-bottom: 1.25em;
            padding-left: 1.625em;
        }

        .prose li {
            margin-bottom: 0.5em;
        }

        .prose blockquote {
            border-left: 4px solid #4F46E5;
            padding-left: 1em;
            margin: 1.6em 0;
            font-style: italic;
            color: #6B7280;
        }

        .prose pre {
            background: #1F2937;
            color: #F3F4F6;
            padding: 1em;
            border-radius: 0.5em;
            overflow-x: auto;
            margin: 1.6em 0;
        }

        .prose code {
            background: #F3F4F6;
            padding: 0.2em 0.4em;
            border-radius: 0.25em;
            font-size: 0.875em;
            font-family: 'Courier New', monospace;
        }

        .prose pre code {
            background: transparent;
            padding: 0;
        }

        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5em;
            margin: 1.6em 0;
        }

        .prose a {
            color: #4F46E5;
            text-decoration: underline;
        }

        .prose a:hover {
            color: #4338CA;
        }
    </style>
@endsection
