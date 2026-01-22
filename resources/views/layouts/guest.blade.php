<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KelasPintu - Platform Pengumpulan Tugas Akademik')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
            --font-heading: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', 'Courier New', monospace;
            
            --color-primary: #4f46e5;
            --color-primary-hover: #4338ca;
        }

        @layer components {
            .btn-primary {
                @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md;
            }

            .btn-outline {
                @apply border-2 border-slate-300 hover:border-indigo-600 text-slate-700 hover:text-indigo-600 font-medium px-6 py-2.5 rounded-lg transition-all;
            }

            .card {
                @apply bg-white rounded-xl shadow-sm border border-slate-200 p-6 transition-all;
            }

            .form-input {
                @apply w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all;
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes infiniteScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .animate-fade-up {
            animation: fadeUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .scroll-fade {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .scroll-fade.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-title {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .testimonial-track {
            animation: infiniteScroll 30s linear infinite;
        }

        .testimonial-track:hover {
            animation-play-state: paused;
        }

        * {
            font-family: var(--font-sans);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
        }

        code, pre {
            font-family: var(--font-mono);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    @yield('content')
    
    @include('components.footer')
    
    @stack('scripts')
</body>
</html>
