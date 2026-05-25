<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RakitKuy | Virtual Lab Perakitan Komputer')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons (Lucide) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-200 antialiased min-h-screen flex flex-col font-sans relative overflow-x-hidden">
    
    <!-- Background Effects -->
    <div class="fixed inset-0 z-[-1] pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-cyan-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-purple-600/20 rounded-full blur-[120px]"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-white/10 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-cyan-500/30">
                        <i data-lucide="cpu" class="w-6 h-6"></i>
                    </div>
                    <a href="{{ route('home') }}" class="font-bold text-xl tracking-tight text-white hover:text-cyan-400 transition-colors">
                        Rakit<span class="text-cyan-400">Kuy</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium hover:text-cyan-400 transition-colors {{ request()->routeIs('home') ? 'text-cyan-400' : 'text-slate-300' }}">Home</a>
                    <a href="{{ route('tutorial') }}" class="text-sm font-medium hover:text-cyan-400 transition-colors {{ request()->routeIs('tutorial') ? 'text-cyan-400' : 'text-slate-300' }}">Tutorial</a>
                    <a href="{{ route('materi') }}" class="text-sm font-medium hover:text-cyan-400 transition-colors {{ request()->routeIs('materi') ? 'text-cyan-400' : 'text-slate-300' }}">Materi</a>
                    <a href="{{ route('simulasi') }}" class="text-sm font-medium hover:text-cyan-400 transition-colors {{ request()->routeIs('simulasi') ? 'text-cyan-400' : 'text-slate-300' }}">Simulasi</a>
                    <a href="{{ route('quiz') }}" class="text-sm font-medium hover:text-cyan-400 transition-colors {{ request()->routeIs('quiz') ? 'text-cyan-400' : 'text-slate-300' }}">Quiz</a>
                </div>

                <!-- Start Button (Desktop) -->
                <div class="hidden md:flex">
                    <a href="{{ route('simulasi') }}" class="px-5 py-2.5 rounded-full bg-cyan-500/10 border border-cyan-500/50 text-cyan-400 text-sm font-medium hover:bg-cyan-500 hover:text-white transition-all shadow-[0_0_15px_rgba(0,240,255,0.3)] hover:shadow-[0_0_25px_rgba(0,240,255,0.6)]">
                        Mulai Rakit
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-slate-300 hover:text-white focus:outline-none" id="mobile-menu-btn">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Panel -->
        <div class="md:hidden hidden bg-slate-900 border-b border-white/10" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-slate-800 text-cyan-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Home</a>
                <a href="{{ route('tutorial') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('tutorial') ? 'bg-slate-800 text-cyan-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Tutorial</a>
                <a href="{{ route('materi') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('materi') ? 'bg-slate-800 text-cyan-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Materi</a>
                <a href="{{ route('simulasi') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('simulasi') ? 'bg-slate-800 text-cyan-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Simulasi</a>
                <a href="{{ route('quiz') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('quiz') ? 'bg-slate-800 text-cyan-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Quiz</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 bg-slate-900/50 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:justify-start mb-6 md:mb-0">
                    <div class="flex items-center gap-2">
                        <i data-lucide="cpu" class="w-5 h-5 text-cyan-400"></i>
                        <span class="text-xl font-bold text-white">Rakit<span class="text-cyan-400">Kuy</span></span>
                    </div>
                </div>
                <div class="flex justify-center space-x-6 md:order-2">
                    <p class="text-slate-400 text-sm">
                        &copy; {{ date('Y') }} RakitKuy. Designed for education.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-lg');
                navbar.classList.replace('bg-slate-900/50', 'bg-slate-900/90');
            } else {
                navbar.classList.remove('shadow-lg');
                navbar.classList.replace('bg-slate-900/90', 'bg-slate-900/50');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
