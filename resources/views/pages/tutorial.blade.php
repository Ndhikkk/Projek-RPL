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
                Pelajari cara merakit komputer selangkah demi selangkah melalui seri video tutorial komprehensif kami. Mulai dari persiapan hingga pengujian komponen.
            </p>
        </div>
    </div>

    <!-- Video Grid -->
    <div class="flex-grow overflow-y-auto custom-scrollbar pr-2 pb-8 min-h-0">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="tutorial-grid">
        
        <!-- Video Item 1 -->
        <div class="glass-card rounded-2xl overflow-hidden group hover:border-cyan-500/50 transition-colors flex flex-col">
            <div class="relative aspect-video bg-slate-900 border-b border-white/10 w-full">
                <!-- YouTube Embed -->
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/OZaFqY8FNow?si=w7G1c_N6XN2L-c7R" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
            <div class="p-5 flex-grow">
                <h3 class="text-lg font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors">1. Cara Merakit PC untuk Pemula</h3>
                <p class="text-sm text-slate-400 line-clamp-2">Panduan langkah demi langkah cara merakit PC dari nol, khusus untuk pemula yang belum pernah merakit sama sekali.</p>
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
