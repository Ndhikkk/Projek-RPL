@extends('layouts.app')

@section('title', 'Materi - RakitKuy')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-5rem)] flex flex-col transition-all duration-500">
        <!-- Header -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
            <div>
                <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                    <i data-lucide="book-open" class="w-8 h-8 text-cyan-400"></i> Modul Materi
                </h1>
                <p class="text-slate-400 text-sm mt-1 max-w-2xl">
                    Pelajari teori dasar, fungsi, dan spesifikasi masing-masing komponen pembentuk komputer.
                </p>
            </div>

            <!-- Search/Filter -->
            <div class="relative w-full sm:w-64">
                <input type="text" id="search-materi" onkeyup="filterMateri()" placeholder="Cari komponen..."
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg py-2 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 transition-colors">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-2.5"></i>
            </div>
        </div>

        <!-- Materi Grid -->
        <div class="flex-grow overflow-y-auto custom-scrollbar pr-2 pb-8 min-h-0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="materi-grid">

                <!-- CPU Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="cpu" class="w-12 h-12 text-cyan-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Processor (CPU)</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Otak dari komputer yang memproses semua instruksi. Kenali jenis socket, arsitektur core, thread, dan
                        clock speed.
                    </p>
                    <button onclick="openModal('cpu-modal')"
                        class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Motherboard Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="circuit-board" class="w-12 h-12 text-purple-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Motherboard</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Papan sirkuit utama yang menghubungkan seluruh komponen. Pelajari chipset, form factor (ATX, mATX),
                        dan port I/O.
                    </p>
                    <button onclick="openModal('mobo-modal')"
                        class="text-purple-400 hover:text-purple-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- RAM Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-green-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="memory-stick" class="w-12 h-12 text-green-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">RAM (Memory)</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Penyimpanan data sementara yang sangat cepat. Pahami perbedaan DDR3, DDR4, DDR5, kapasitas, dan
                        frekuensi.
                    </p>
                    <button onclick="openModal('ram-modal')"
                        class="text-green-400 hover:text-green-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- GPU Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-red-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="monitor-speaker" class="w-12 h-12 text-red-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">VGA Card (GPU)</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Komponen khusus pengolah grafis. Sangat penting untuk gaming dan rendering. Pelajari VRAM dan
                        arsitekturnya.
                    </p>
                    <button onclick="openModal('gpu-modal')"
                        class="text-red-400 hover:text-red-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Storage Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-yellow-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="hard-drive" class="w-12 h-12 text-yellow-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Storage (SSD/HDD)</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Media penyimpanan permanen. Pahami perbedaan HDD konvensional, SSD SATA, dan SSD NVMe M.2 yang super
                        cepat.
                    </p>
                    <button onclick="openModal('storage-modal')"
                        class="text-yellow-400 hover:text-yellow-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- PSU Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="plug" class="w-12 h-12 text-orange-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Power Supply (PSU)</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Pemasok daya listrik untuk semua komponen. Pelajari efisiensi 80+, watt, dan manajemen kabel
                        modular.
                    </p>
                    <button onclick="openModal('psu-modal')"
                        class="text-orange-400 hover:text-orange-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- CPU Cooler Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="fan" class="w-12 h-12 text-cyan-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">CPU Cooler</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Pendingin prosesor untuk menjaga suhu tetap stabil. Kenali jenis pendingin udara (HSF) dan pendingin
                        cair (AIO/Liquid Cooler).
                    </p>
                    <button onclick="openModal('cooler-modal')"
                        class="text-cyan-400 hover:text-cyan-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Thermal Paste Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-slate-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="droplet" class="w-12 h-12 text-slate-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Thermal Paste</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Pasta penghantar panas antara CPU dan Cooler. Sangat vital untuk mencegah panas terperangkap
                        (overheating).
                    </p>
                    <button onclick="openModal('paste-modal')"
                        class="text-slate-400 hover:text-slate-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Kabel Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-pink-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="cable" class="w-12 h-12 text-pink-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Kabel Konektor</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Kabel utama untuk menyalurkan listrik (ATX, EPS, PCIe) serta kabel Front Panel untuk menyambungkan
                        tombol casing.
                    </p>
                    <button onclick="openModal('cable-modal')"
                        class="text-pink-400 hover:text-pink-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

                <!-- Casing Card -->
                <div
                    class="glass-card rounded-2xl p-6 group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110">
                    </div>
                    <i data-lucide="box" class="w-12 h-12 text-blue-400 mb-6 relative z-10"></i>
                    <h3 class="text-xl font-bold text-white mb-2 relative z-10">Casing PC</h3>
                    <p class="text-sm text-slate-400 mb-4 line-clamp-3 relative z-10">
                        Rumah bagi seluruh komponen komputer. Berperan penting dalam sirkulasi udara (airflow) dan estetika
                        build Anda.
                    </p>
                    <button onclick="openModal('casing-modal')"
                        class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center gap-1 relative z-10">
                        Baca Selengkapnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Overlay & Containers -->
    <div id="modal-overlay"
        class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4 transition-opacity">

        <!-- CPU Modal -->
        <div id="cpu-modal"
            class="modal-content hidden glass-card border-cyan-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-cyan-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="cpu"
                        class="w-6 h-6 text-cyan-400"></i> Processor (CPU)</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/114PLBJuBeCEmy4NYVZr_FOk4dxHLTaR4/preview"
                        title="Processor CPU Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Central Processing Unit (CPU)</strong> adalah komponen keras komputer yang memahami dan
                    melaksanakan perintah dan data dari perangkat lunak. Istilah lain dari komponen ini adalah prosesor.</p>
                <p><strong>Fungsi Utama:</strong></p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Mengambil instruksi dari memori (Fetch).</li>
                    <li>Menerjemahkan instruksi (Decode).</li>
                    <li>Mengeksekusi instruksi (Execute).</li>
                    <li>Menulis kembali hasil ke memori (Writeback).</li>
                </ul>
                <p><strong>Spesifikasi Penting:</strong> Core (Inti), Thread, Clock Speed (GHz), dan Cache Size.</p>
            </div>
        </div>

        <!-- Motherboard Modal -->
        <div id="mobo-modal"
            class="modal-content hidden glass-card border-purple-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-purple-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="circuit-board"
                        class="w-6 h-6 text-purple-400"></i> Motherboard</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1b3RZCdQ89FGM-_OEhdLmxrBwDEBdN34j/preview"
                        title="Motherboard Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Motherboard</strong> adalah papan sirkuit cetak utama (PCB) di komputer yang mengalokasikan daya
                    dan memfasilitasi komunikasi antara CPU, RAM, dan komponen perangkat keras lainnya.</p>
                <p><strong>Komponen pada Motherboard:</strong></p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Socket CPU (tempat menempelnya Prosesor).</li>
                    <li>Slot RAM (DIMM).</li>
                    <li>Slot PCIe (untuk VGA Card atau kartu ekspansi).</li>
                    <li>Port SATA / M.2 NVMe (untuk Storage).</li>
                    <li>Chipset & VRM.</li>
                </ul>
            </div>
        </div>

        <!-- RAM Modal -->
        <div id="ram-modal"
            class="modal-content hidden glass-card border-green-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-green-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="memory-stick"
                        class="w-6 h-6 text-green-400"></i> RAM (Memory)</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1LdLzxMm4hQbjsxUfYJdOO5FRAFlZPwuP/preview"
                        title="RAM Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Random Access Memory (RAM)</strong> adalah tempat penyimpanan data sementara yang sangat cepat,
                    digunakan oleh CPU untuk memproses aplikasi yang sedang berjalan secara aktif.</p>
                <p>Data di dalam RAM akan hilang ketika komputer dimatikan (Volatile). Semakin besar kapasitas RAM, semakin
                    banyak aplikasi yang bisa dijalankan bersamaan tanpa membuat komputer melambat.</p>
            </div>
        </div>

        <!-- GPU Modal -->
        <div id="gpu-modal"
            class="modal-content hidden glass-card border-red-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-red-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="monitor-speaker"
                        class="w-6 h-6 text-red-400"></i> VGA Card (GPU)</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1cLiQyQKLhsoLe1x0BWSt11F6b7oXU8Oj/preview"
                        title="VGA GPU Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Graphics Processing Unit (GPU)</strong> atau VGA Card adalah komponen yang bertugas merender
                    gambar, video, dan animasi 2D maupun 3D untuk ditampilkan di layar monitor.</p>
                <p>Komponen ini sangat krusial untuk keperluan Gaming, Video Editing, Rendering 3D, dan Machine Learning.
                </p>
            </div>
        </div>

        <!-- Storage Modal -->
        <div id="storage-modal"
            class="modal-content hidden glass-card border-yellow-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-yellow-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="hard-drive"
                        class="w-6 h-6 text-yellow-400"></i> Storage (SSD/HDD)</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1gWiRwtnD34clHXW04kGXFEyNbHlgH2wB/preview"
                        title="Storage Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Storage</strong> adalah media penyimpanan permanen (Non-volatile) tempat menyimpan Sistem
                    Operasi, Aplikasi, dan file-file Anda.</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>HDD (Hard Disk Drive):</strong> Menggunakan piringan magnetik mekanik. Lebih lambat tapi
                        kapasitas besar & murah.</li>
                    <li><strong>SSD (Solid State Drive):</strong> Menggunakan chip flash memory. Jauh lebih cepat, hening,
                        dan tahan guncangan. Model modern menggunakan antarmuka NVMe M.2 yang kecepatannya bisa menembus
                        7000 MB/s.</li>
                </ul>
            </div>
        </div>

        <!-- PSU Modal -->
        <div id="psu-modal"
            class="modal-content hidden glass-card border-orange-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-orange-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="plug"
                        class="w-6 h-6 text-orange-400"></i> Power Supply (PSU)</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/15ter6rrProas-kyWyu3L199PxSphf_kS/preview"
                        title="PSU Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Power Supply Unit (PSU)</strong> bertugas mengubah arus listrik AC dari stopkontak dinding
                    menjadi arus DC tegangan rendah yang dapat digunakan oleh komponen internal komputer.</p>
                <p>PSU sangat penting karena PSU yang buruk atau kurang daya bisa menyebabkan komputer mati mendadak atau
                    bahkan merusak komponen lain (Motherboard/VGA).</p>
            </div>
        </div>

        <!-- Cooler Modal -->
        <div id="cooler-modal"
            class="modal-content hidden glass-card border-cyan-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-cyan-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="fan"
                        class="w-6 h-6 text-cyan-400"></i> CPU Cooler</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1Y7kjMvKWl7i4IdjaMaBtIuzEx_xx8XDg/preview"
                        title="CPU Cooler Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>CPU Cooler (Pendingin Prosesor)</strong> bertugas membuang panas yang dihasilkan oleh Processor
                    (CPU) saat bekerja. Tanpa pendingin, CPU bisa mencapai suhu di atas 100&deg;C dalam hitungan detik dan
                    langsung mati (Thermal Trip).</p>
                <p><strong>Jenis CPU Cooler:</strong></p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Air Cooler (HSF):</strong> Menggunakan blok logam (Heatsink) dan pipa tembaga untuk menyerap
                        panas, lalu didinginkan oleh kipas angin. Paling umum dan awet.</li>
                    <li><strong>Liquid Cooler (AIO/Custom Loop):</strong> Menggunakan cairan pendingin yang mengalir melalui
                        selang ke Radiator. Sangat efektif untuk CPU kelas atas yang panas.</li>
                </ul>
            </div>
        </div>

        <!-- Paste Modal -->
        <div id="paste-modal"
            class="modal-content hidden glass-card border-slate-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-slate-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="droplet"
                        class="w-6 h-6 text-slate-400"></i> Thermal Paste</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1IbNzk3fwh4tAY02ylkqopo0vaujB5FMU/preview"
                        title="Thermal Paste Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Thermal Paste (Pasta Termal)</strong> adalah cairan atau pasta khusus yang dioleskan di antara
                    permukaan Processor dan dasar CPU Cooler.</p>
                <p>Tujuannya adalah untuk <strong>mengisi celah udara mikroskopis</strong> di antara kedua permukaan logam
                    tersebut. Karena udara adalah penghantar panas yang sangat buruk, pasta ini memastikan perpindahan panas
                    dari CPU ke Cooler terjadi secara maksimal.</p>
            </div>
        </div>

        <!-- Cable Modal -->
        <div id="cable-modal"
            class="modal-content hidden glass-card border-pink-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-pink-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="cable"
                        class="w-6 h-6 text-pink-400"></i> Kabel & Konektor</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/1bFXbXEY-xqrvfiYd_8PaBcOHHJOFh6TW/preview"
                        title="Kabel Konektor Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p>Merakit PC bukan hanya memasang komponen, tapi juga menyambungkan jalur kelistrikannya dengan benar.</p>
                <p><strong>Kabel Utama dari PSU:</strong></p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>24-Pin ATX:</strong> Menyalurkan daya utama ke Motherboard. Ini adalah kabel paling besar.
                    </li>
                    <li><strong>8-Pin EPS (CPU):</strong> Menyalurkan daya khusus untuk menghidupkan Processor. Dicolokkan
                        di pojok kiri atas Motherboard.</li>
                    <li><strong>6/8-Pin PCIe:</strong> Menyalurkan daya tambahan untuk VGA Card / GPU yang haus daya.</li>
                </ul>
                <p><strong>Kabel Front Panel:</strong></p>
                <p>Kabel-kabel kecil dari casing yang disambungkan ke pojok kanan bawah Motherboard. Berfungsi agar tombol
                    Power, tombol Reset, dan lampu indikator casing bisa menyala.</p>
            </div>
        </div>

        <!-- Casing Modal -->
        <div id="casing-modal"
            class="modal-content hidden glass-card border-blue-500/30 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl shadow-blue-500/10">
            <div class="p-6 border-b border-white/10 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-2xl font-bold text-white flex items-center gap-2"><i data-lucide="box"
                        class="w-6 h-6 text-blue-400"></i> Casing PC</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition-colors"><i data-lucide="x"
                        class="w-6 h-6"></i></button>
            </div>
            <div class="p-6 text-slate-300 space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                <!-- Video Section -->
                <div class="aspect-video w-full rounded-xl overflow-hidden mb-6 bg-slate-800 border border-white/10">
                    <iframe class="w-full h-full"
                        src="https://drive.google.com/file/d/19ZRMzggsU90-v18Nq0roD8B78cVJwPvp/preview"
                        title="Casing PC Video" frameborder="0" allowfullscreen></iframe>
                </div>
                <p><strong>Casing PC (Computer Case)</strong> bukan sekadar kotak pembungkus. Ia melindungi komponen fisik
                    dari debu, benturan, dan menopang berat tiap komponen (khususnya Motherboard yang dikencangkan dengan
                    baut standoff).</p>
                <p><strong>Fungsi Krusial Casing:</strong></p>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Sirkulasi Udara (Airflow):</strong> Casing yang baik memiliki kipas masuk (intake) dan
                        keluar (exhaust) agar suhu di dalam kotak tetap adem.</li>
                    <li><strong>Cable Management:</strong> Ruang tersembunyi di balik casing untuk merapikan sisa-sisa kabel
                        agar aliran udara tidak terhalang.</li>
                </ul>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            const modalOverlay = document.getElementById('modal-overlay');
            const modals = document.querySelectorAll('.modal-content');

            function openModal(modalId) {
                // Hide all modals first
                modals.forEach(m => m.classList.add('hidden'));

                // Show overlay and specific modal
                modalOverlay.classList.remove('hidden');
                document.getElementById(modalId).classList.remove('hidden');

                // Disable body scroll
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modalOverlay.classList.add('hidden');
                modals.forEach(m => m.classList.add('hidden'));

                // Enable body scroll
                document.body.style.overflow = 'auto';
            }

            // Close when clicking outside modal content
            modalOverlay.addEventListener('click', function (e) {
                if (e.target === modalOverlay) {
                    closeModal();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
                    closeModal();
                }
            });

            // Search/Filter Function
            function filterMateri() {
                const input = document.getElementById('search-materi');
                const filter = input.value.toLowerCase();
                const grid = document.getElementById('materi-grid');
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