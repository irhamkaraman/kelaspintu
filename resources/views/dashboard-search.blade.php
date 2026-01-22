@extends('layouts.app')

@section('title', 'Cari Kelas')

@section('content')
    <div class="mb-8">
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Dashboard
        </a>

        <h1 class="text-3xl font-bold text-gray-900 mb-2">Cari Kelas</h1>
        <p class="text-gray-600">Temukan dan bergabung dengan kelas yang tersedia</p>
    </div>

    <!-- Search Section -->
    <div class="card mb-8">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" id="searchInput"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Cari berdasarkan nama kelas, deskripsi, atau kode kelas..." autocomplete="off">
                </div>
                <button type="button" id="searchBtn"
                    class="btn-primary whitespace-nowrap flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </div>
            <div class="text-sm text-gray-500">
                <span id="resultCount">Menampilkan semua kelas</span>
            </div>
        </div>
    </div>

    <!-- Results Grid -->
    <div id="resultsContainer">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="kelasGrid">
            @forelse($semuaKelas as $kelas)
                <div class="card hover:shadow-md transition-shadow flex flex-col" data-kelas-id="{{ $kelas->id }}"
                    data-nama="{{ strtolower($kelas->nama) }}" data-deskripsi="{{ strtolower($kelas->deskripsi) }}"
                    data-kode="{{ strtolower($kelas->kode_unik) }}">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-900 flex-1">{{ $kelas->nama }}</h3>
                        <span
                            class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-1 rounded whitespace-nowrap ml-2">
                            {{ $kelas->anggota->count() }} anggota
                        </span>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-1">{{ $kelas->deskripsi }}</p>

                    <div class="flex items-center justify-between text-sm mb-4 pt-2 border-t border-gray-200">
                        <div class="flex items-center gap-2 text-gray-500">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ $kelas->tugas->count() }} tugas</span>
                        </div>
                        <code class="bg-gray-100 px-2 py-1 rounded text-xs font-mono">{{ $kelas->kode_unik }}</code>
                    </div>

                    <div class="flex gap-2 pt-2">
                        @if (in_array($kelas->id, $kelasDigabungIds))
                            <button type="button" class="w-full btn-primary text-sm" disabled>
                                Sudah Bergabung
                            </button>
                        @else
                            <button type="button" @click="$dispatch('open-modal', 'join-kelas-{{ $kelas->id }}')"
                                class="flex-1 btn-primary text-sm">
                                Bergabung
                            </button>
                        @endif
                        <a href="{{ route('kelas.show', $kelas->kode_unik) }}"
                            class="flex-1 text-center btn-outline text-sm">
                            Lihat
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full card text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kelas</h3>
                    <p class="text-gray-600">Tidak ada kelas yang tersedia untuk bergabung</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div id="paginationContainer" class="mt-8 flex justify-center items-center gap-2">
            <!-- Pagination akan di-generate oleh JavaScript -->
        </div>

        {{-- Laravel Pagination Links (Server-side) --}}
        @if ($semuaKelas->hasPages())
            <div class="mt-6">
                {{ $semuaKelas->links() }}
            </div>
        @endif
    </div>

    <!-- Empty State untuk Search -->
    <div id="emptyState" style="display: none;" class="card text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Hasil</h3>
        <p class="text-gray-600 mb-6">Tidak ditemukan kelas untuk pencarian Anda</p>
        <button type="button" onclick="resetSearch()" class="btn-outline">
            Cari Lagi
        </button>
    </div>

    <!-- Modals untuk setiap kelas -->
    @foreach ($semuaKelas as $kelas)
        <template x-teleport="body">
            <div x-data="{ show: false }"
                x-on:open-modal.window="if ($event.detail === 'join-kelas-{{ $kelas->id }}') show = true"
                x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false" x-show="show"
                class="fixed inset-0 z-[999] overflow-y-auto" style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4 py-6 text-center sm:block sm:p-0">
                    <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 transition-opacity" aria-hidden="true" @click="show = false">
                        <div class="absolute inset-0 bg-gray-500/75 backdrop-blur-sm"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div x-show="show" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[1000]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Bergabung dengan Kelas?</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Apakah Anda yakin ingin bergabung dengan kelas
                                            <strong>{{ $kelas->nama }}</strong>?</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <form action="{{ route('kelas.join.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="kode_unik" value="{{ $kelas->kode_unik }}">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Ya,
                                    Bergabung</button>
                            </form>
                            <button @click="show = false" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Batal</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    @endforeach

    @push('scripts')
        <script>
            const ITEMS_PER_PAGE = 9;
            let allClasses = [];
            let filteredClasses = [];
            let currentPage = 1;

            // Initialize
            document.addEventListener('DOMContentLoaded', function() {
                // Get all classes from DOM
                const kelasElements = document.querySelectorAll('[data-kelas-id]');
                console.log('Found elements:', kelasElements.length);

                allClasses = Array.from(kelasElements).map(el => {
                    const obj = {
                        id: el.dataset.kelasId,
                        nama: el.dataset.nama,
                        deskripsi: el.dataset.deskripsi,
                        kode: el.dataset.kode,
                        element: el
                    };
                    console.log('Class object:', obj);
                    return obj;
                });

                console.log('All classes:', allClasses);
                filteredClasses = [...allClasses];
                displayPage(1);

                // Event listeners
                const searchInput = document.getElementById('searchInput');
                const searchBtn = document.getElementById('searchBtn');

                if (searchInput) {
                    searchInput.addEventListener('keyup', handleSearch);
                }
                if (searchBtn) {
                    searchBtn.addEventListener('click', handleSearch);
                }
            });

            function handleSearch() {
                const query = document.getElementById('searchInput').value.toLowerCase().trim();
                currentPage = 1;

                if (query === '') {
                    filteredClasses = [...allClasses];
                    updateResultCount(allClasses.length, '');
                } else {
                    filteredClasses = allClasses.filter(kelas =>
                        kelas.nama.includes(query) ||
                        kelas.deskripsi.includes(query) ||
                        kelas.kode.includes(query)
                    );
                    updateResultCount(filteredClasses.length, query);
                }

                displayPage(1);
            }

            function displayPage(page) {
                const startIndex = (page - 1) * ITEMS_PER_PAGE;
                const endIndex = startIndex + ITEMS_PER_PAGE;
                const pageItems = filteredClasses.slice(startIndex, endIndex);

                // Hide all items
                document.querySelectorAll('[data-kelas-id]').forEach(el => {
                    el.style.display = 'none';
                });

                // Show current page items
                pageItems.forEach(item => {
                    item.element.style.display = 'block';
                });

                // Update pagination
                updatePagination(page);

                // Show/hide empty state
                if (filteredClasses.length === 0) {
                    document.getElementById('resultsContainer').style.display = 'none';
                    document.getElementById('emptyState').style.display = 'block';
                } else {
                    document.getElementById('resultsContainer').style.display = 'block';
                    document.getElementById('emptyState').style.display = 'none';
                }

                currentPage = page;
            }

            function updatePagination(currentPage) {
                const totalPages = Math.ceil(filteredClasses.length / ITEMS_PER_PAGE);
                const paginationContainer = document.getElementById('paginationContainer');
                paginationContainer.innerHTML = '';

                if (totalPages <= 1) return;

                // Previous button
                if (currentPage > 1) {
                    const prevBtn = createPaginationButton('←', currentPage - 1);
                    paginationContainer.appendChild(prevBtn);
                }

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (i === currentPage) {
                        const activeBtn = document.createElement('button');
                        activeBtn.className = 'px-3 py-2 rounded-lg bg-indigo-600 text-white font-medium';
                        activeBtn.textContent = i;
                        activeBtn.disabled = true;
                        paginationContainer.appendChild(activeBtn);
                    } else if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                        const pageBtn = createPaginationButton(i, i);
                        paginationContainer.appendChild(pageBtn);
                    } else if (i === currentPage - 2 || i === currentPage + 2) {
                        const dots = document.createElement('span');
                        dots.className = 'px-2 py-2 text-gray-500';
                        dots.textContent = '...';
                        paginationContainer.appendChild(dots);
                    }
                }

                // Next button
                if (currentPage < totalPages) {
                    const nextBtn = createPaginationButton('→', currentPage + 1);
                    paginationContainer.appendChild(nextBtn);
                }
            }

            function createPaginationButton(text, page) {
                const btn = document.createElement('button');
                btn.className =
                    'px-3 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium transition-colors';
                btn.textContent = text;
                btn.onclick = () => displayPage(page);
                return btn;
            }

            function updateResultCount(count, query) {
                const resultCount = document.getElementById('resultCount');
                if (query === '') {
                    resultCount.textContent = `Menampilkan semua kelas (${count})`;
                } else {
                    resultCount.textContent = `Ditemukan ${count} kelas untuk "${query}"`;
                }
            }

            function resetSearch() {
                document.getElementById('searchInput').value = '';
                filteredClasses = [...allClasses];
                currentPage = 1;
                updateResultCount(allClasses.length, '');
                displayPage(1);
            }
        </script>
    @endpush

@endsection
