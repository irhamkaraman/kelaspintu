@extends('layouts.app')

@section('title', 'Kumpulkan Tugas')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card mb-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $tugas->judul }}</h2>
            <p class="text-sm text-gray-600">Deadline: {{ $tugas->deadline->format('d M Y, H:i') }}</p>
        </div>

        <div class="alert-info mb-6">
            <strong>Ketentuan:</strong>
            <ul class="list-disc list-inside mt-2 text-sm space-y-1">
                <li>Jenis file:
                    {{ $tugas->jenis_file ? implode(', ', array_map('strtoupper', $tugas->jenis_file)) : 'Semua jenis file' }}
                </li>
                <li>Upload langsung maksimal 10 MB</li>
                <li>Untuk file >10 MB, gunakan link Google Drive/cloud storage lainnya (HTTPS)</li>
            </ul>
        </div>

        <div class="card">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">
                {{ $pengumpulan ? 'Kumpulkan Ulang Tugas' : 'Kumpulkan Tugas' }}
            </h1>

            <form action="{{ route('pengumpulan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                id="formPengumpulan">
                @csrf
                <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pengumpulan *</label>
                    <div class="space-y-2">
                        <label
                            class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="metode" value="upload"
                                class="text-indigo-600 focus:ring-indigo-500" checked onchange="toggleMetode()">
                            <div>
                                <div class="font-medium text-gray-900">Upload File</div>
                                <div class="text-sm text-gray-500">Untuk file ≤10 MB</div>
                            </div>
                        </label>

                        <label
                            class="flex items-center gap-3 p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="metode" value="link"
                                class="text-indigo-600 focus:ring-indigo-500" onchange="toggleMetode()">
                            <div>
                                <div class="font-medium text-gray-900">Kirim Link Unduhan</div>
                                <div class="text-sm text-gray-500">Untuk file >10 MB (Google Drive, dll)</div>
                            </div>
                        </label>
                    </div>
                    @error('metode')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="uploadSection">
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Tugas *</label>
                    <input type="file" name="file"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        accept="{{ $tugas->jenis_file ? '.' . implode(',.', $tugas->jenis_file) : '*' }}">
                    @error('file')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="linkSection" style="display: none;">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Unduhan (HTTPS) *</label>
                            <input type="url" name="link_unduhan" value="{{ old('link_unduhan') }}"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="https://drive.google.com/file/d/...">
                            <p class="text-sm text-gray-500 mt-1">Pastikan link dapat diakses publik atau beri izin ke
                                instruktur</p>
                            @error('link_unduhan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Link *</label>
                            <textarea name="deskripsi_link" rows="4"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Jelaskan isi file (ukuran, format, konten, dll)...">{{ old('deskripsi_link') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Minimal 5 karakter</p>
                            @error('deskripsi_link')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="btn-primary" id="submitBtn">
                        <span id="submitText">Kumpulkan Tugas</span>
                        <span id="submitLoading" style="display: none;">Mengirim...</span>
                    </button>
                    <a href="{{ route('tugas.show', $tugas->id) }}" class="btn-outline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleMetode() {
            const metode = document.querySelector('input[name="metode"]:checked').value;
            const uploadSection = document.getElementById('uploadSection');
            const linkSection = document.getElementById('linkSection');
            const fileInput = uploadSection.querySelector('input[type="file"]');
            const linkInput = linkSection.querySelector('input[name="link_unduhan"]');

            if (metode === 'upload') {
                uploadSection.style.display = 'block';
                linkSection.style.display = 'none';
                // Remove required from link, add to file
                if (fileInput) fileInput.required = true;
                if (linkInput) linkInput.required = false;
            } else {
                uploadSection.style.display = 'none';
                linkSection.style.display = 'block';
                // Remove required from file, add to link
                if (fileInput) fileInput.required = false;
                if (linkInput) linkInput.required = true;
            }
        }

        // Form submission handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formPengumpulan');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoading = document.getElementById('submitLoading');

            if (form) {
                form.addEventListener('submit', function(e) {
                    // Show loading state
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitText.style.display = 'none';
                        submitLoading.style.display = 'inline';
                    }
                });
            }

            // Initialize metode on page load
            toggleMetode();
        });
    </script>
@endsection
