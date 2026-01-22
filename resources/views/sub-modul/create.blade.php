@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('modul.index', $modul->kelas_id) }}"
                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Kembali ke Daftar Modul
            </a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">Buat Sub-Modul Baru</h1>
            <p class="text-gray-600">{{ $modul->judul }}</p>
        </div>

        <div class="card">
            <form action="{{ route('sub-modul.store', $modul->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Sub-Modul *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Contoh: Pengenalan Routing di Laravel">
                        @error('judul')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konten with Quill Editor -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Konten Pembelajaran *</label>
                        <div id="editor" style="height: 400px;"></div>
                        <input type="hidden" name="konten" id="konten" value="{{ old('konten') }}">
                        @error('konten')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estimasi Waktu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estimasi Waktu Baca (menit)</label>
                        <input type="number" name="estimasi_menit" value="{{ old('estimasi_menit') }}" min="1"
                            max="999"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="15">
                        @error('estimasi_menit')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Lampiran (PDF/PPT)</label>
                        <input type="file" name="file" accept=".pdf,.ppt,.pptx"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <p class="text-sm text-gray-500 mt-1">Maksimal 20MB. Format: PDF, PPT, PPTX</p>
                        @error('file')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Eksternal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Link Eksternal (YouTube, Google Drive,
                            dll)</label>
                        <input type="url" name="link_eksternal" value="{{ old('link_eksternal') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="https://youtube.com/watch?v=...">
                        @error('link_eksternal')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="btn-primary">
                            Simpan Sub-Modul
                        </button>
                        <a href="{{ route('modul.show', $modul->id) }}" class="btn-outline">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quill.js -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        // Initialize Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    [{
                        'align': []
                    }],
                    ['clean']
                ]
            }
        });

        // Set old content if exists
        @if (old('konten'))
            quill.root.innerHTML = {!! json_encode(old('konten')) !!};
        @endif

        // Custom image handler
        quill.getModule('toolbar').addHandler('image', function() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = async () => {
                const file = input.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('image', file);

                try {
                    const response = await fetch('{{ route('api.upload-image') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        const range = quill.getSelection();
                        quill.insertEmbed(range.index, 'image', data.url);
                    }
                } catch (error) {
                    alert('Gagal upload gambar');
                }
            };
        });

        // Save to hidden input before submit
        document.querySelector('form').onsubmit = function() {
            document.getElementById('konten').value = quill.root.innerHTML;
            return true;
        };
    </script>
@endsection
