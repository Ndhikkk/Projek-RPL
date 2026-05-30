@extends('layouts.app')

@section('title', 'Video Tutorial - RakitKuy')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-5rem)] flex flex-col transition-all duration-500">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                    <i data-lucide="video" class="w-8 h-8 text-red-500"></i> Video Tutorial
                </h1>
                <p class="text-slate-400 text-sm mt-1 max-w-2xl">
                    Pelajari cara merakit komputer selangkah demi selangkah melalui seri video tutorial komprehensif kami.
                    Mulai dari persiapan hingga pengujian komponen.
                </p>
            </div>
        </div>

        <!-- Video Grid -->
        <div class="flex-grow overflow-y-auto custom-scrollbar pr-2 pb-8 min-h-0 flex justify-center">
            <div class="w-full max-w-5xl" id="tutorial-grid">

                <!-- Video Item 1 -->
                <div
                    class="glass-card rounded-2xl overflow-hidden group border-8 border-slate-700/50 hover:border-cyan-500 transition-all flex flex-col">
                    <div class="relative aspect-video bg-slate-900 border-b-8 border-slate-700/50 w-full">
                        <!-- Google Drive Embed -->
                        <iframe class="w-full h-full"
                            src="https://drive.google.com/file/d/10k_nuZ--aazpZX2gdCQHiNsfzeCFIzws/preview"
                            title="Google Drive Video Player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                    <div class="p-5 flex-grow flex flex-col">
                        <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">1. Cara
                            Merakit PC untuk Pemula</h3>
                        <p class="text-sm text-slate-400 line-clamp-2 mb-4">Panduan langkah demi langkah cara merakit PC
                            dari
                            nol, khusus untuk pemula yang belum pernah merakit sama sekali.</p>

                        <div class="mt-auto">
                            <a href="https://drive.google.com/file/d/10k_nuZ--aazpZX2gdCQHiNsfzeCFIzws/view" target="_blank"
                                class="inline-flex items-center gap-2 text-xs text-cyan-400 hover:text-cyan-300 transition-colors bg-cyan-950/30 px-3 py-2 rounded-lg border border-cyan-900/50">
                                <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                Video tidak jalan? Buka di tab baru
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Video Item 2 to 6 Removed per user request -->

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Scripts for tutorial (if any)
        </script>
    @endpush
@endsection