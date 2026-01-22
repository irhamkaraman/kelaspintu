<footer class="bg-slate-900 text-slate-300 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            {{-- Logo & Tagline --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <div class="text-indigo-500">
                        @include('components.logo')
                    </div>
                    <span class="text-xl font-bold text-white font-heading">KelasPintu</span>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Satu Pintu untuk Semua Kelas. Platform pengumpulan tugas yang inklusif dan modern.
                </p>
            </div>

            {{-- Creators --}}
            <div>
                <h4 class="font-semibold text-white mb-4 font-heading">Development Team</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>Lazuardi Irham Karaman</li>
                    <li>Andika Dwi Putra</li>
                    <li>Galang Finto Anergi</li>
                    <li>Abid Ghufron</li>
                </ul>
            </div>

            {{-- Origin / Academy --}}
            <div>
                <h4 class="font-semibold text-white mb-4 font-heading">Academy</h4>
                <ul class="space-y-2 text-sm text-slate-400">
                    <li>Teknik Informatika</li>
                    <li>Fakultas Teknik</li>
                    <li>Universitas Muhammadiyah Ponorogo</li>
                </ul>
            </div>

            {{-- Social & specific links --}}
            <div>
                <h4 class="font-semibold text-white mb-4 font-heading">Tautan</h4>
                <ul class="space-y-2 text-sm mb-6">
                    <li><a href="#fitur" class="hover:text-white transition-colors">Fitur Platform</a></li>
                </ul>
                
                <div class="flex gap-4">
                    <a href="https://github.com/irhamkaraman" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                    </a>
                    <a href="mailto:irhamkaraman@gmail.com" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-slate-800 pt-8 text-center text-sm">
            <p class="text-slate-400">
                &copy; 2026 KelasPintu. Dibuat untuk pendidikan yang lebih adil.
            </p>
            <p class="text-slate-500 text-xs mt-2">
                Open-source · Laravel 12 · Tailwind CSS v4
            </p>
        </div>
    </div>
</footer>
