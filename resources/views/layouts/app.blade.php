<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true }" x-init="sidebarOpen = window.innerWidth >= 1024">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KelasPintu') - Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', system-ui, sans-serif;
            --font-heading: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        @layer components {
            .btn-primary {
                @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md;
            }

            .btn-outline {
                @apply border-2 border-slate-300 hover:border-indigo-600 text-slate-700 hover:text-indigo-600 font-medium px-6 py-2.5 rounded-lg transition-all;
            }

            .card {
                @apply bg-white rounded-xl shadow-sm border border-slate-200 p-6 transition-all hover:shadow-md;
            }

            .sidebar-link {
                @apply flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all relative;
            }

            .sidebar-link.active {
                @apply bg-indigo-50 text-indigo-600 font-medium;
            }
        }

        * {
            font-family: var(--font-sans);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--font-heading);
        }
    </style>
</head>

<body class="bg-slate-50">
    {{-- Mobile Backdrop Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-30 lg:hidden" style="display: none;">
    </div>

    {{-- Sidebar --}}
    <aside x-show="sidebarOpen" @click.away="if (window.innerWidth < 1024) sidebarOpen = false"
        x-transition:enter="transition-transform duration-300 ease-out" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform duration-300 ease-in"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed left-0 top-0 h-full w-64 bg-white border-r border-slate-200 z-40 lg:translate-x-0"
        style="display: none;">
        <div class="flex flex-col h-full">
            {{-- Logo --}}
            <div class="p-6 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    @include('components.logo')
                    <span class="text-xl font-bold text-slate-900 font-heading">KelasPintu</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Beranda</span>
                </a>

                {{-- Kelas Section with nested menu --}}
                <div x-data="{ kelasOpen: {{ request()->routeIs('kelas.*') ? 'true' : 'false' }} }">
                    <button @click="kelasOpen = !kelasOpen"
                        class="w-full sidebar-link {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="flex-1 text-left">Kelas</span>
                        <svg class="w-4 h-4 transition-transform" :class="kelasOpen ? 'rotate-180' : ''" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Nested Menu --}}
                    <div x-show="kelasOpen" x-transition:enter="transition-all duration-200"
                        x-transition:leave="transition-all duration-150" class="ml-4 mt-1 space-y-1"
                        style="display: none;">
                        <a href="{{ route('kelas.create') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all {{ request()->routeIs('kelas.create') ? 'bg-indigo-50 text-indigo-600 font-medium' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Buat Kelas</span>
                        </a>

                        <a href="{{ route('dashboard.search') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all {{ request()->routeIs('dashboard.search') ? 'bg-indigo-50 text-indigo-600 font-medium' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span>Cari Kelas</span>
                        </a>

                        <a href="{{ route('kelas.join') }}"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition-all {{ request()->routeIs('kelas.join') ? 'bg-indigo-50 text-indigo-600 font-medium' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Gabung dengan Kode</span>
                        </a>
                    </div>
                </div>

                {{-- Lab Menu --}}
                <a href="{{ route('lab.index') }}"
                    class="sidebar-link {{ request()->routeIs('lab.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    <span>Lab</span>
                </a>
            </nav>

            {{-- User Menu --}}
            <div class="p-4 border-t border-slate-200">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 mb-3 p-2 rounded-lg hover:bg-indigo-50 transition-colors group">
                    <div
                        class="w-10 h-10 bg-indigo-600 group-hover:bg-indigo-700 rounded-full flex items-center justify-center text-white font-bold transition-colors">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-slate-900 truncate group-hover:text-indigo-600 transition-colors">
                            {{ auth()->user()->name }}</div>
                        <div class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</div>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="transition-all duration-300" :class="{ 'lg:ml-64': sidebarOpen, 'lg:ml-0': !sidebarOpen }">
        {{-- Top Navbar --}}
        <header class="bg-white border-b border-slate-200 sticky top-0 z-20">
            <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600 hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="px-4 sm:px-6 lg:px-8 py-8">
            @if (session('success'))
                <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 text-red-800 border border-red-200 rounded-xl p-4 mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>
