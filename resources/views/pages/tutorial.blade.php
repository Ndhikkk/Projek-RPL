@extends('layouts.app')

@section('title', 'Video Tutorial - RakitKuy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-5rem)] flex flex-col transition-all duration-500">
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
        <div>
            <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                <i data-lucide="youtube" class="w-8 h-8 text-red-500"></i> Video Tutorial
            </h1>
            <p class="text-slate-400 text-sm mt-1 max-w-2xl">
                Pelajari cara merakit komputer selangkah demi selangkah melalui seri video tutorial komprehensif kami. Mulai dari persiapan hingga pengujian komponen.
            </p>
        </div>
        
        <!-- Search/Filter -->
        <div class="relative w-full sm:w-64">
            <input type="text" id="search-tutorial" onkeyup="filterTutorial()" placeholder="Cari tutorial..." class="w-full bg-slate-900 border border-slate-700 rounded-lg py-2 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
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
    // Search/Filter Function
    function filterTutorial() {
        const input = document.getElementById('search-tutorial');
        const filter = input.value.toLowerCase();
        const grid = document.getElementById('tutorial-grid');
        const cards = grid.getElementsByClassName('glass-card');

        for (let i = 0; i < cards.length; i++) {
            const title = cards[i].getElementsByTagName("h3")[0];
            const desc = cards[i].getElementsByTagName("p")[0];
            if (title || desc) {
                const textValue = (title ? title.textContent || title.innerText : "") + " " + 
                                  (desc ? desc.textContent || desc.innerText : "");
                if (textValue.toLowerCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }       
        }
    }
</script>
@endpush
@endsection
