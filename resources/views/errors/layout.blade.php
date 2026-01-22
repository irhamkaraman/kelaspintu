<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error') - KelasPintu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .error-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        {{-- Error Container --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            {{-- Top Gradient Bar --}}
            <div class="gradient-bg h-2"></div>

            {{-- Content --}}
            <div class="p-8 md:p-12 text-center">
                {{-- Error Code Circle --}}
                <div
                    class="inline-flex items-center justify-center w-32 h-32 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white mb-8 error-float shadow-xl">
                    <span class="text-5xl md:text-6xl font-bold">@yield('code')</span>
                </div>

                {{-- SVG Icon --}}
                <div class="mb-6">
                    @yield('icon')
                </div>

                {{-- Error Title --}}
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                    @yield('title')
                </h1>

                {{-- Error Message --}}
                <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-md mx-auto">
                    @yield('message')
                </p>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="javascript:history.back()"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Ke Dashboard
                    </a>
                </div>

                {{-- Additional Info (Optional) --}}
                @hasSection('additional')
                    <div class="mt-8 pt-8 border-t border-slate-200">
                        @yield('additional')
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-200">
                <p class="text-sm text-slate-500 text-center">
                    Butuh bantuan? Hubungi
                    <a href="mailto:support@kelaspintu.com" class="text-indigo-600 hover:text-indigo-700 font-medium">
                        support@kelaspintu.com
                    </a>
                </p>
            </div>
        </div>

        {{-- Decorative Elements --}}
        <div class="absolute top-10 left-10 w-20 h-20 bg-indigo-200 rounded-full blur-3xl opacity-30 pulse-slow"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-purple-200 rounded-full blur-3xl opacity-30 pulse-slow"
            style="animation-delay: 1s;"></div>
    </div>
</body>

</html>
