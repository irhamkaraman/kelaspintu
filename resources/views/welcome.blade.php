@extends('layouts.guest')

@section('title', 'KelasPintu - Satu Pintu untuk Semua Kelas')

@section('content')
    <div x-data="{ mobileMenuOpen: false }" class="relative">

        {{-- Navbar --}}
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-2">
                        @include('components.logo')
                        <span class="text-xl font-bold text-slate-900 font-heading">KelasPintu</span>
                    </div>

                    {{-- Desktop Menu --}}
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#fitur"
                            class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Fitur</a>
                        <a href="#untuk-dosen"
                            class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Untuk
                            Dosen</a>
                        <a href="#untuk-mahasiswa"
                            class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Untuk
                            Mahasiswa</a>
                        <a href="#testimoni"
                            class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Testimoni</a>
                    </div>

                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-medium text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-100 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                            Daftar
                        </a>
                    </div>

                    {{-- Mobile Menu Button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95" class="md:hidden border-t border-slate-200 bg-white"
                style="display: none;">
                <div class="px-4 py-4 space-y-3">
                    <a href="#fitur" class="block text-sm font-medium text-slate-700 hover:text-indigo-600">Fitur</a>
                    <a href="#untuk-dosen" class="block text-sm font-medium text-slate-700 hover:text-indigo-600">Untuk
                        Dosen</a>
                    <a href="#untuk-mahasiswa" class="block text-sm font-medium text-slate-700 hover:text-indigo-600">Untuk
                        Mahasiswa</a>
                    <a href="#testimoni"
                        class="block text-sm font-medium text-slate-700 hover:text-indigo-600">Testimoni</a>
                    <div class="pt-3 border-t border-slate-200 space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center px-4 py-2 text-sm font-medium text-slate-700 border border-slate-300 rounded-lg hover:bg-slate-100">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-slate-50 -z-10"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-4xl mx-auto">
                    <h1
                        class="hero-title text-5xl sm:text-6xl lg:text-7xl font-extrabold text-slate-900 mb-6 tracking-tight">
                        Satu Pintu untuk<br>
                        <span class="text-indigo-600">Semua Kelas</span>
                    </h1>

                    <p class="text-lg sm:text-xl text-slate-600 mb-8 max-w-2xl mx-auto leading-relaxed animate-fade-up"
                        style="animation-delay: 0.1s;">
                        Platform Belajar & Praktikum Coding Modern. <br class="hidden sm:block">
                        Kelola tugas, validasi file otomatis, hingga eksekusi kode langsung di browser. <br>
                        <span class="text-indigo-600 font-semibold">Satu platform untuk semua kebutuhan akademik
                            Anda.</span>
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-up"
                        style="animation-delay: 0.2s;">
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 text-base font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all hover:scale-105 shadow-lg shadow-indigo-500/30 flex items-center gap-2">
                            <span>Mulai Sekarang</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="#demo-lab"
                            class="px-8 py-4 text-base font-semibold text-slate-700 bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                            Coba Demo Lab
                        </a>
                    </div>

                    {{-- Right: Illustration --}}
                    <div class="relative scroll-fade mt-12" style="transition-delay: 0.2s;">
                        {{-- Hero Image --}}
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ asset('images/hero_section_main illustration.png') }}"
                                alt="KelasPintu Platform Illustration" class="w-full h-auto object-cover">
                            {{-- Overlay gradient for better integration --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-indigo-900/10 to-transparent pointer-events-none">
                            </div>
                        </div>

                        {{-- Floating decoration elements --}}
                        <div
                            class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full blur-2xl opacity-30 animate-pulse">
                        </div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-gradient-to-br from-purple-400 to-pink-500 rounded-full blur-2xl opacity-20 animate-pulse"
                            style="animation-delay: 1s;"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section id="fitur" class="py-20 bg-white" data-scroll-section>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 scroll-fade">
                    <h2 class="text-4xl font-bold text-slate-900 mb-4">Fitur Unggulan</h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Platform lengkap untuk manajemen kelas, tugas, dan coding lab dengan teknologi terkini
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Feature 1: Virtual Lab --}}
                    <div class="scroll-fade group p-8 bg-gradient-to-br from-indigo-50 to-white rounded-2xl border border-indigo-100 hover:shadow-2xl hover:scale-105 transition-all duration-500 overflow-hidden"
                        style="transition-delay: 0s;">
                        {{-- Feature Image --}}
                        <div class="relative mb-6 -mx-8 -mt-8 h-48 overflow-hidden">
                            <img src="{{ asset('images/virtual_coding_lab_illustration.png') }}" alt="Virtual Coding Lab"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-indigo-50 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform duration-500 shadow-lg">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-indigo-600 transition-colors">
                            Virtual Coding Lab</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Eksekusi code Python, JavaScript, PHP langsung di browser. Real-time feedback dengan test cases
                            otomatis. Coding tanpa setup environment lokal.
                        </p>
                    </div>

                    {{-- Feature 2: Google OAuth --}}
                    <div class="scroll-fade group p-8 bg-gradient-to-br from-emerald-50 to-white rounded-2xl border border-emerald-100 hover:shadow-2xl hover:scale-105 transition-all duration-500 overflow-hidden"
                        style="transition-delay: 0.15s;">
                        {{-- Feature Image --}}
                        <div class="relative mb-6 -mx-8 -mt-8 h-48 overflow-hidden">
                            <img src="{{ asset('images/google_oauth_login_illustration.png') }}" alt="Google OAuth Login"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-50 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform duration-500 shadow-lg">

                            <svg class="w-9 h-9 text-white" viewBox="0 0 20 20" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                fill="#ffffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>google [#178]</title>
                                    <desc>Created with Sketch.</desc>
                                    <defs> </defs>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7399.000000)"
                                            fill="#ffffffff">
                                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                                <path
                                                    d="M263.821537,7247.00386 L254.211298,7247.00386 C254.211298,7248.0033 254.211298,7250.00218 254.205172,7251.00161 L259.774046,7251.00161 C259.560644,7252.00105 258.804036,7253.40026 257.734984,7254.10487 C257.733963,7254.10387 257.732942,7254.11086 257.7309,7254.10986 C256.309581,7255.04834 254.43389,7255.26122 253.041161,7254.98137 C250.85813,7254.54762 249.130492,7252.96451 248.429023,7250.95364 C248.433107,7250.95064 248.43617,7250.92266 248.439233,7250.92066 C248.000176,7249.67336 248.000176,7248.0033 248.439233,7247.00386 L248.438212,7247.00386 C249.003881,7245.1669 250.783592,7243.49084 252.969687,7243.0321 C254.727956,7242.65931 256.71188,7243.06308 258.170978,7244.42831 C258.36498,7244.23842 260.856372,7241.80579 261.043226,7241.6079 C256.0584,7237.09344 248.076756,7238.68155 245.090149,7244.51127 L245.089128,7244.51127 C245.089128,7244.51127 245.090149,7244.51127 245.084023,7244.52226 L245.084023,7244.52226 C243.606545,7247.38565 243.667809,7250.75975 245.094233,7253.48622 C245.090149,7253.48921 245.087086,7253.49121 245.084023,7253.49421 C246.376687,7256.0028 248.729215,7257.92672 251.563684,7258.6593 C254.574796,7259.44886 258.406843,7258.90916 260.973794,7256.58747 C260.974815,7256.58847 260.975836,7256.58947 260.976857,7256.59047 C263.15172,7254.63157 264.505648,7251.29445 263.821537,7247.00386"
                                                    id="google-[#178]"> </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>

                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-emerald-600 transition-colors">
                            Login dengan Google</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Login sekali klik dengan akun Google. Hubungkan akun existing atau daftar baru. Aman, cepat,
                            tanpa password tambahan.
                        </p>

                    </div>

                    {{-- Feature 3: Class Management --}}
                    <div class="scroll-fade group p-8 bg-gradient-to-br from-violet-50 to-white rounded-2xl border border-violet-100 hover:shadow-2xl hover:scale-105 transition-all duration-500 overflow-hidden"
                        style="transition-delay: 0.3s;">
                        {{-- Feature Image --}}
                        <div class="relative mb-6 -mx-8 -mt-8 h-48 overflow-hidden">
                            <img src="{{ asset('images/class_management_dashboard_illustration.png') }}"
                                alt="Class Management Dashboard"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-violet-50 via-transparent to-transparent">
                            </div>
                        </div>

                        <div
                            class="w-16 h-16 bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform duration-500 shadow-lg">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-violet-600 transition-colors">
                            Manajemen Kelas Praktis</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Buat kelas dengan kode unik, kelola tugas & lab session, tracking pengumpulan otomatis.
                            Dashboard lengkap untuk instruktur dan mahasiswa.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Live Demo Section --}}
        <section id="demo-lab" class="py-24 bg-slate-900 text-white overflow-hidden relative">
            {{-- PrismJS CSS for Syntax Highlighting --}}
            <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css"
                rel="stylesheet" />
            <style>
                .custom-scrollbar::-webkit-scrollbar {
                    width: 10px;
                    height: 10px;
                }

                .custom-scrollbar::-webkit-scrollbar-track {
                    background: #0f172a;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: #334155;
                    border-radius: 5px;
                    border: 2px solid #0f172a;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #475569;
                }

                /* Override Prism background to match editor */
                pre[class*="language-"] {
                    background: transparent !important;
                    margin: 0 !important;
                    /* Force padding to match textarea (py-4 pr-4 pl-14) */
                    padding-top: 1rem !important;
                    padding-bottom: 1rem !important;
                    padding-right: 1rem !important;
                    padding-left: 3.5rem !important;
                    /* pl-14 = 3.5rem */
                    text-shadow: none !important;
                    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
                    /* Force Tailwind font-mono */
                    line-height: 1.5rem !important;
                    /* Match leading-6 */
                    font-size: 0.875rem !important;
                    /* Match text-sm */
                    border: none !important;
                    box-shadow: none !important;
                }

                code[class*="language-"],
                pre[class*="language-"] {
                    font-family: inherit !important;
                }
            </style>

            {{-- Background Glow --}}
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-7xl pointer-events-none">
                <div
                    class="absolute top-20 left-20 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl mix-blend-screen animate-blob">
                </div>
                <div
                    class="absolute bottom-20 right-20 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl mix-blend-screen animate-blob animation-delay-2000">
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm font-medium mb-6">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        Live Interactive Demo
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold font-heading mb-6 leading-tight">
                        Coba <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Virtual
                            Lab</span> Sekarang
                    </h2>
                    <p class="text-slate-400 text-lg max-w-2xl mx-auto leading-relaxed">
                        Tidak perlu instalasi compiler atau setup environment. Tulis kode, jalankan, dan lihat hasilnya
                        langsung di browser Anda.
                    </p>
                </div>

                {{-- Editor Window --}}
                <div class="max-w-5xl mx-auto" x-data="codeDemo()" x-init="initHighlight()">
                    <div
                        class="bg-slate-800 rounded-xl shadow-2xl border border-slate-700 overflow-hidden ring-1 ring-white/10">
                        {{-- Toolbar --}}
                        <div class="flex items-center justify-between px-4 py-3 bg-slate-900 border-b border-slate-700">
                            <div class="flex items-center gap-2">
                                <div class="flex gap-1.5">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                </div>
                                <div
                                    class="ml-4 flex items-center gap-2 px-3 py-1 bg-slate-800 rounded text-xs text-slate-400 border border-slate-700 font-mono">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    main.js
                                </div>
                            </div>
                            <button @click="runCode" :disabled="isRunning"
                                class="flex items-center gap-2 px-4 py-1.5 bg-green-600 hover:bg-green-500 text-white text-sm font-medium rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg x-show="!isRunning" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg x-show="isRunning" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span x-text="isRunning ? 'Running...' : 'Run Code'"></span>
                            </button>
                        </div>

                        {{-- Split View --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[400px]">
                            {{-- Code Input --}}
                            <div class="relative group bg-slate-900 min-h-[300px] lg:min-h-[400px]">
                                {{-- Line Numbers --}}
                                <div
                                    class="absolute left-0 top-0 bottom-0 w-10 sm:w-12 bg-slate-900 border-r border-slate-700 flex flex-col items-end pr-2 sm:pr-3 pt-4 text-slate-600 font-mono text-xs sm:text-sm select-none z-20 overflow-hidden">
                                    <template x-for="i in 20">
                                        <div x-text="i" class="leading-6"></div>
                                    </template>
                                </div>

                                {{-- Syntax Highlight Overlay --}}
                                <pre class="absolute inset-0 pl-12 sm:pl-14 pr-3 sm:pr-4 py-4 font-mono text-xs sm:text-sm leading-6 whitespace-pre-wrap break-words pointer-events-none z-0 overflow-hidden"
                                    aria-hidden="true" x-ref="highlightLayer"><code class="language-javascript" x-html="highlightedCode"></code></pre>

                                {{-- Textarea (Transparent) --}}
                                <textarea x-model="code" @input="highlight" @scroll="$refs.highlightLayer.scrollTop = $event.target.scrollTop"
                                    class="custom-scrollbar w-full h-full pl-12 sm:pl-14 pr-3 sm:pr-4 py-4 bg-transparent text-transparent font-mono text-xs sm:text-sm border-none focus:ring-0 resize-none leading-6 caret-indigo-500 relative z-10"
                                    spellcheck="false"></textarea>
                            </div>

                            {{-- Output Panel --}}
                            <div
                                class="bg-slate-950 border-t lg:border-t-0 lg:border-l border-slate-700 p-3 sm:p-4 font-mono text-xs sm:text-sm overflow-auto custom-scrollbar min-h-[200px] lg:min-h-[400px]">
                                <div class="text-slate-500 mb-2 uppercase text-xs tracking-wider font-semibold">Terminal
                                    Output</div>

                                <template x-if="output">
                                    <div class="space-y-1">
                                        <div class="flex gap-2 text-slate-400">
                                            <span class="text-green-500">➜</span>
                                            <span>node main.js</span>
                                        </div>
                                        <div class="text-slate-300 whitespace-pre-wrap" x-text="output"></div>
                                        <div class="text-slate-500 pt-2" x-show="!isRunning">
                                            Program exited with code 0
                                        </div>
                                    </div>
                                </template>

                                <template x-if="!output && !isRunning">
                                    <div class="text-slate-600 italic">
                                        Click "Run Code" to see the output...
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Prism JS for Syntax Highlighting --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>

        <script>
            function codeDemo() {
                return {
                    code: `// Virtual Lab - Development Team
const creators = [
    "Lazuardi Irham Karaman",
    "Andika Dwi Putra",
    "Galang Finto Anergi",
    "Abid Ghufron"
];

const info = {
    universitas: "Universitas Muhammadiyah Ponorogo",
    fakultas: "Fakultas Teknik",
    prodi: "Teknik Informatika"
};

function tampilkanKreator() {
    console.log("=== Creator Development ===");
    creators.forEach(nama => console.log("- " + nama));
    
    console.log("\\n---------------------------");
    console.log(info.universitas);
    console.log(info.fakultas + " | " + info.prodi);
}

tampilkanKreator();`,
                    highlightedCode: '',
                    output: '',
                    isRunning: false,

                    initHighlight() {
                        this.highlight();
                    },

                    highlight() {
                        // Use PrismJS for robust highlighting
                        if (window.Prism) {
                            this.highlightedCode = Prism.highlight(
                                this.code,
                                Prism.languages.javascript,
                                'javascript'
                            );
                        } else {
                            // Fallback if Prism not loaded yet
                            this.highlightedCode = this.code
                                .replace(/&/g, "&amp;")
                                .replace(/</g, "&lt;")
                                .replace(/>/g, "&gt;");
                        }
                    },

                    runCode() {
                        this.isRunning = true;
                        this.output = '';

                        setTimeout(() => {
                            try {
                                const logs = [];
                                const mockConsole = {
                                    log: (...args) => {
                                        logs.push(args.join(' '));
                                    }
                                };

                                const func = new Function('console', this.code);
                                func(mockConsole);

                                this.output = logs.join('\n');
                            } catch (e) {
                                this.output = 'Error: ' + e.message;
                            }

                            this.isRunning = false;
                        }, 800);
                    }
                }
            }
        </script>

        {{-- For Students --}}
        <section id="untuk-mahasiswa" class="py-20 bg-white" data-scroll-section>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="scroll-fade order-2 lg:order-1">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-2xl p-8 text-white">
                            <h3 class="text-2xl font-bold mb-6">Dashboard Mahasiswa</h3>
                            <div class="space-y-4">
                                <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold">Proyek ML</span>
                                        <span
                                            class="text-xs bg-green-400 text-green-900 px-2 py-1 rounded-full">Lulus</span>
                                    </div>
                                    <div class="text-sm opacity-90">Nilai: 92 | ZIP 300MB via GDrive</div>
                                </div>
                                <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold">Esai Filsafat</span>
                                        <span
                                            class="text-xs bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full">Dicek</span>
                                    </div>
                                    <div class="text-sm opacity-90">PDF 2MB | Menunggu feedback</div>
                                </div>
                                <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold">Kode Java</span>
                                        <span class="text-xs bg-blue-400 text-blue-900 px-2 py-1 rounded-full">Baru</span>
                                    </div>
                                    <div class="text-sm opacity-90">ZIP 5MB | Sudah dikumpulkan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-fade order-1 lg:order-2">
                        <span
                            class="inline-block px-4 py-2 bg-purple-100 text-purple-600 text-sm font-semibold rounded-full mb-4">
                            Untuk Mahasiswa
                        </span>
                        <h2 class="text-4xl font-bold text-slate-900 mb-6">
                            Kumpulkan Tugas,<br>Sesederhana Itu
                        </h2>
                        <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                            Upload file kecil langsung. File besar? Pakai link Google Drive. Sistem akan validasi otomatis
                            dan beri konfirmasi instant.
                        </p>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-purple-500 flex-shrink-0 mt-1" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-slate-700">Notifikasi real-time untuk setiap perubahan status</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-purple-500 flex-shrink-0 mt-1" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-slate-700">Lihat nilai dan feedback langsung di dashboard</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-purple-500 flex-shrink-0 mt-1" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-slate-700">Kumpulkan ulang jika perlu revisi, tanpa ribet</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Testimonials --}}
        <section id="testimoni" class="py-20 bg-slate-900 overflow-hidden" data-scroll-section>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 scroll-fade">
                    <h2 class="text-4xl font-bold text-white mb-4">Kata Pengguna</h2>
                    <p class="text-lg text-slate-400">
                        Pengalaman nyata dari dosen dan mahasiswa
                    </p>
                </div>

                <div class="relative">
                    <div class="flex gap-6 testimonial-track">
                        {{-- Testimonial 1 --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-indigo-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    AS
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>

                        {{-- Testimonial 2 --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-purple-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    SP
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Sarah Putri</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1 Teknik Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "ZIP proyek ML-ku 300MB — langsung lolos tanpa error. Pakai Google Drive link, dosen
                                langsung bisa download. Perfect!"
                            </p>
                        </div>

                        {{-- Testimonial 3 --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-emerald-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    BW
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Prof. Budi Widodo</div>
                                    <div class="text-sm text-slate-400">Dosen Matematika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Validasi ZIP otomatis sangat membantu! Mahasiswa yang kirim tugas tanpa README langsung
                                dapat notif error. Menghemat waktu cek manual."
                            </p>
                        </div>

                        {{-- Testimonial 4 --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-amber-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-amber-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    RH
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Rizki Hidayat</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1 Sistem Informasi</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Dulu pakai email buat kirim tugas, sering masuk spam. Sekarang semua terorganisir rapi.
                                Feedback dosen juga langsung keliatan!"
                            </p>
                        </div>

                        {{-- Testimonial 5 --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-rose-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    DN
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Dewi Nuraini</div>
                                    <div class="text-sm text-slate-400">Dosen Fisika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Interface-nya bersih dan intuitif. Mahasiswa langsung paham tanpa perlu training panjang.
                                Cocok untuk semua mata kuliah!"
                            </p>
                        </div>

                        {{-- Testimonial 6 --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-cyan-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    FA
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Farah Amelia</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S2 Data Science</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Dataset CSV 50MB bisa langsung di-upload atau via link. Flexibel banget! Plus ada tracking
                                status revisi juga."
                            </p>
                        </div>

                        {{-- Duplicate items untuk seamless loop --}}
                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-indigo-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    AS
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>

                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-purple-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    SP
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Sarah Putri</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1 Teknik Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "ZIP proyek ML-ku 300MB — langsung lolos tanpa error. Pakai Google Drive link, dosen
                                langsung bisa download. Perfect!"
                            </p>
                        </div>

                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-emerald-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    BW
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Prof. Budi Widodo</div>
                                    <div class="text-sm text-slate-400">Dosen Matematika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Validasi ZIP otomatis sangat membantu! Mahasiswa yang kirim tugas tanpa README langsung
                                dapat notif error. Menghemat waktu cek manual."
                            </p>
                        </div>

                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-amber-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-amber-400 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    RH
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Rizki Hidayat</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1 Sistem Informasi</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Dulu pakai email buat kirim tugas, sering masuk spam. Sekarang semua terorganisir rapi.
                                Feedback dosen juga langsung keliatan!"
                            </p>
                        </div>

                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-rose-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-rose-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    DN
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Dewi Nuraini</div>
                                    <div class="text-sm text-slate-400">Dosen Fisika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Interface-nya bersih dan intuitif. Mahasiswa langsung paham tanpa perlu training panjang.
                                Cocok untuk semua mata kuliah!"
                            </p>
                        </div>

                        <div
                            class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700 hover:border-cyan-500 transition-colors">
                            <div class="flex items-center gap-4 mb-6">
                                <div
                                    class="w-12 h-12 bg-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    FA
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Farah Amelia</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S2 Data Science</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Dataset CSV 50MB bisa langsung di-upload atau via link. Flexibel banget! Plus ada tracking
                                status revisi juga."
                            </p>
                        </div>

                        {{-- Testimonial 1 --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>

                        {{-- Testimonial 2 --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Sarah Putri</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "ZIP proyek ML-ku 300MB — langsung lolos tanpa error. Pakai Google Drive link, dosen
                                langsung bisa download. Perfect!"
                            </p>
                        </div>

                        {{-- Duplicate for seamless scroll --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>
                        {{-- Testimonial 1 --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>

                        {{-- Testimonial 2 --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Sarah Putri</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "ZIP proyek ML-ku 300MB — langsung lolos tanpa error. Pakai Google Drive link, dosen
                                langsung bisa download. Perfect!"
                            </p>
                        </div>

                        {{-- Duplicate for seamless scroll --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>
                        {{-- Testimonial 1 --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>

                        {{-- Testimonial 2 --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Sarah Putri</div>
                                    <div class="text-sm text-slate-400">Mahasiswa S1</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "ZIP proyek ML-ku 300MB — langsung lolos tanpa error. Pakai Google Drive link, dosen
                                langsung bisa download. Perfect!"
                            </p>
                        </div>

                        {{-- Duplicate for seamless scroll --}}
                        <div class="flex-shrink-0 w-96 bg-slate-800 rounded-2xl p-8 border border-slate-700">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Dr. Ahmad Santoso</div>
                                    <div class="text-sm text-slate-400">Dosen Informatika</div>
                                </div>
                            </div>
                            <p class="text-slate-300 leading-relaxed">
                                "Akhirnya ada sistem yang tidak memaksa mahasiswa scan tangan atau repot dengan role
                                berbelit. Sederhana tapi powerful."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Final CTA --}}
        <section class="py-24 bg-gradient-to-br from-indigo-600 to-purple-700" data-scroll-section>
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="scroll-fade">
                    <h2 class="text-4xl sm:text-5xl font-bold text-white mb-6">
                        Siap Membuka Pintu Baru<br>untuk Kelas Anda?
                    </h2>
                    <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto">
                        Bergabunglah dengan ratusan dosen dan ribuan mahasiswa yang sudah merasakan kemudahan KelasPintu
                    </p>
                    <a href="{{ route('register') }}"
                        class="inline-block px-10 py-5 text-lg font-bold text-indigo-600 bg-white rounded-xl hover:bg-slate-100 transition-all shadow-2xl hover:scale-105">
                        Buat Kelas Pertama Anda
                    </a>
                    <p class="mt-6 text-sm text-indigo-200">
                        Gratis · Open-source · Dibuat oleh pendidik, untuk pendidik
                    </p>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Intersection Observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('visible');
                        }, index * 100);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-fade').forEach(el => {
                observer.observe(el);
            });

            // Dynamic typography for hero title
            const heroTitle = document.querySelector('.hero-title');
            let ticking = false;

            function updateHeroTitle() {
                const scroll = window.scrollY;
                const maxScroll = 300;
                const scrollProgress = Math.min(scroll / maxScroll, 1);

                const scale = 1 - (scrollProgress * 0.2);
                const fontWeight = scroll > 100 ? 700 : 800;

                heroTitle.style.transform = `scale(${scale})`;
                heroTitle.style.fontWeight = fontWeight;

                ticking = false;
            }

            window.addEventListener('scroll', () => {
                if (!ticking) {
                    window.requestAnimationFrame(updateHeroTitle);
                    ticking = true;
                }
            }, {
                passive: true
            });
        });
    </script>
@endpush
