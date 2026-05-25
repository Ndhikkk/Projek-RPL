@extends('layouts.app')

@section('title', 'Beranda - RakitKuy')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-5rem)] flex flex-col transition-all duration-500">
        <div class="flex-grow overflow-y-auto custom-scrollbar pr-2 pb-8 min-h-0 relative rounded-2xl">

            <!-- Hero Section -->
            <section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden">
                <!-- 3D/Floating Elements Background -->
                <div class="absolute inset-0 z-0 opacity-30 pointer-events-none">
                    <div class="absolute top-1/4 left-1/4 w-32 h-32 rounded-lg bg-cyan-500/20 blur-xl animate-float"
                        style="animation-delay: 0s;"></div>
                    <div class="absolute top-1/3 right-1/4 w-40 h-40 rounded-full bg-purple-500/20 blur-xl animate-float"
                        style="animation-delay: 2s;"></div>
                    <div class="absolute bottom-1/4 left-1/3 w-24 h-24 rounded-full bg-blue-500/20 blur-xl animate-float"
                        style="animation-delay: 4s;"></div>
                </div>

                <div class="relative z-10 w-full">
                    <div class="text-center max-w-4xl mx-auto">
                        <div
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass border-cyan-500/30 text-cyan-400 text-sm mb-8 animate-glow">
                            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                            Platform Edukasi Generasi Baru
                        </div>

                        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                            Kuasai <span class="text-gradient">Perakitan PC</span><br />
                            Tanpa Resiko Rusak.
                        </h1>

                        <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                            Pelajari setiap komponen, cara kerja, dan praktek merakit komputer dalam laboratorium virtual 2D
                            interaktif dari mana saja.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('simulasi') }}"
                                class="group relative px-8 py-4 bg-cyan-500 hover:bg-cyan-400 text-slate-900 font-bold rounded-full transition-all duration-300 w-full sm:w-auto shadow-[0_0_20px_rgba(0,240,255,0.4)] hover:shadow-[0_0_30px_rgba(0,240,255,0.6)] hover:-translate-y-1 overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    Mulai Simulasi <i data-lucide="zap" class="w-5 h-5 group-hover:animate-bounce"></i>
                                </span>
                                <div
                                    class="absolute inset-0 h-full w-0 bg-white/20 transition-all duration-300 ease-out group-hover:w-full z-0">
                                </div>
                            </a>

                            <a href="{{ route('materi') }}"
                                class="px-8 py-4 glass border-slate-700 hover:border-cyan-500/50 text-white font-medium rounded-full transition-all duration-300 w-full sm:w-auto hover:-translate-y-1 flex items-center justify-center gap-2 hover:bg-slate-800/80">
                                Pelajari Materi <i data-lucide="book-open" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="py-20 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Fitur <span class="text-cyan-400">Unggulan</span></h2>
                    <p class="text-slate-400 max-w-2xl mx-auto">Kami merancang pengalaman belajar terbaik untuk memahami
                        arsitektur komputer secara mendalam.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-6">
                    <!-- Feature 1: Materi -->
                    <div class="glass-card rounded-2xl p-6 hover:-translate-y-2 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 mb-5 group-hover:scale-110 transition-transform">
                            <i data-lucide="book-open" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Materi Pembelajaran</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">
                            Penjelasan detail fungsi dan spesifikasi setiap komponen utama pada komputer.
                        </p>
                        <a href="{{ route('materi') }}"
                            class="inline-flex items-center gap-1 mt-4 text-purple-400 hover:text-purple-300 text-sm font-medium transition-colors">
                            Lihat Modul <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <!-- Feature 2: Tutorial -->
                    <div class="glass-card rounded-2xl p-6 hover:-translate-y-2 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center text-red-500 mb-5 group-hover:scale-110 transition-transform">
                            <i data-lucide="video" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Video Tutorial</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">
                            Panduan visual langkah demi langkah merakit komputer dari nol hingga siap digunakan.
                        </p>
                        <a href="{{ route('tutorial') }}"
                            class="inline-flex items-center gap-1 mt-4 text-red-500 hover:text-red-400 text-sm font-medium transition-colors">
                            Tonton Video <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <!-- Feature 3: Simulasi -->
                    <div
                        class="glass-card rounded-2xl p-6 hover:-translate-y-2 transition-all duration-300 group border-cyan-500/30 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10 text-cyan-400">
                            <i data-lucide="monitor-play" class="w-24 h-24 transform rotate-12"></i>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center text-cyan-400 mb-5 group-hover:scale-110 transition-transform relative z-10">
                            <i data-lucide="mouse-pointer-click" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 relative z-10">Simulasi Interaktif</h3>
                        <p class="text-slate-400 leading-relaxed text-sm relative z-10">
                            Praktek langsung memasang komponen ke dalam casing virtual dengan panduan interaktif.
                        </p>
                        <a href="{{ route('simulasi') }}"
                            class="inline-flex items-center gap-1 mt-4 text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-colors relative z-10">
                            Coba Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>

                    <!-- Feature 4: Quiz -->
                    <div class="glass-card rounded-2xl p-6 hover:-translate-y-2 transition-all duration-300 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-pink-500/20 flex items-center justify-center text-pink-400 mb-5 group-hover:scale-110 transition-transform">
                            <i data-lucide="help-circle" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Evaluasi & Kuis</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">
                            Uji pemahaman Anda melalui kuis interaktif yang menantang untuk mengukur kemampuan.
                        </p>
                        <a href="{{ route('quiz') }}"
                            class="inline-flex items-center gap-1 mt-4 text-pink-400 hover:text-pink-300 text-sm font-medium transition-colors">
                            Mulai Ujian <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Stats / Divider Section -->
            <section
                class="py-12 mb-16 border border-white/10 bg-slate-900/50 backdrop-blur-md rounded-3xl mx-4 sm:mx-6 shadow-[0_0_30px_rgba(0,0,0,0.5)]">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/10">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-400 mb-3">
                            <i data-lucide="book-open" class="w-6 h-6"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-white mb-1">9+</div>
                        <div class="text-sm font-medium text-slate-400">Modul Materi</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center text-red-500 mb-3">
                            <i data-lucide="video" class="w-6 h-6"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-red-400 mb-1">1</div>
                        <div class="text-sm font-medium text-slate-400">Video Tutorial</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-cyan-500/20 flex items-center justify-center text-cyan-400 mb-3">
                            <i data-lucide="monitor-play" class="w-6 h-6"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-cyan-400 mb-1">2D</div>
                        <div class="text-sm font-medium text-slate-400">Simulasi Visual</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="w-12 h-12 rounded-full bg-pink-500/20 flex items-center justify-center text-pink-400 mb-3">
                            <i data-lucide="help-circle" class="w-6 h-6"></i>
                        </div>
                        <div class="text-4xl font-extrabold text-white mb-1"> 5+ </div>
                        <div class="text-sm font-medium text-slate-400">Soal Evaluasi</div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection