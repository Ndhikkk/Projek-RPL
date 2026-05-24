@extends('layouts.app')

@section('title', 'Simulasi Perakitan PC - RakitKuy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-5rem)] flex flex-col transition-all duration-500" id="simulation-container">
    <!-- Header -->
    <div class="mb-4 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-2 xl:gap-4" id="sim-header">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white flex items-center gap-2 sm:gap-3">
                <i data-lucide="mouse-pointer-click" class="w-6 h-6 sm:w-8 sm:h-8 text-cyan-400"></i> Perakitan Lanjut
            </h1>
            <p class="text-slate-400 text-xs sm:text-sm mt-1">
                Drag & Drop dari inventory, klik pengunci manual, dan tarik kabel (*wiring*) langsung di dalam *casing*.
            </p>
        </div>
        
        <div class="flex flex-wrap gap-2 sm:gap-3 items-center w-full xl:w-auto justify-end">
            <div class="glass px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg flex items-center gap-2 border-cyan-500/30">
                <div id="status-indicator" class="w-2 h-2 sm:w-3 sm:h-3 rounded-full bg-cyan-400 animate-pulse shadow-[0_0_10px_rgba(0,240,255,0.8)]"></div>
                <span id="status-text" class="text-xs sm:text-sm font-bold text-cyan-50">Memuat...</span>
            </div>
            
            <button onclick="toggleFullScreen()" id="fs-btn" class="w-8 h-8 sm:w-10 sm:h-10 bg-slate-800 hover:bg-slate-700 text-white rounded-lg transition-colors flex items-center justify-center shadow-lg border border-white/10" title="Full Screen">
                <i data-lucide="maximize" class="w-4 h-4 sm:w-5 sm:h-5"></i>
            </button>

            <button onclick="undoStep()" class="px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 hover:from-yellow-500/40 hover:to-orange-500/40 border border-yellow-500/50 text-white rounded-lg transition-all flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-medium shadow-[0_0_15px_rgba(234,179,8,0.2)]">
                <i data-lucide="undo" class="w-3 h-3 sm:w-4 sm:h-4"></i> <span class="hidden sm:inline">Undo</span>
            </button>

            <button onclick="resetSimulation()" class="px-3 py-1.5 sm:px-4 sm:py-2 bg-gradient-to-r from-red-500/20 to-orange-500/20 hover:from-red-500/40 hover:to-orange-500/40 border border-red-500/50 text-white rounded-lg transition-all flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-medium shadow-[0_0_15px_rgba(239,68,68,0.2)]">
                <i data-lucide="rotate-ccw" class="w-3 h-3 sm:w-4 sm:h-4"></i> <span class="hidden sm:inline">Reset</span>
            </button>
        </div>
    </div>

    <!-- Simulation Workspace -->
    <div class="flex-grow grid grid-cols-1 lg:grid-cols-4 gap-6 min-h-0" id="sim-workspace">
        
        <!-- Inventory Sidebar -->
        <div class="glass-card rounded-2xl flex flex-col overflow-hidden relative z-40 shadow-[0_0_30px_rgba(0,0,0,0.5)] border-t border-l border-white/10">
            <div class="p-4 border-b border-white/10 bg-gradient-to-r from-slate-900 to-slate-800">
                <h3 class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-400 flex items-center gap-2 text-lg">
                    <i data-lucide="list-checks" class="w-5 h-5 text-cyan-400"></i> Tahapan
                </h3>
            </div>
            <!-- Inventory List Populated by JS -->
            <div class="p-3 overflow-y-auto flex-grow space-y-3 custom-scrollbar bg-slate-900/50 pb-20" id="inventory-list">
            </div>
        </div>

        <!-- 2D Canvas Area -->
        <div class="lg:col-span-3 flex flex-col gap-4 min-h-0">
            <!-- Dynamic Guide Box -->
            <div class="glass border-l-4 border-cyan-500 rounded-lg p-4 shadow-lg bg-slate-900/80 relative">
                <div class="flex gap-4 items-start">
                    <div class="p-2 bg-cyan-500/20 rounded-full text-cyan-400">
                        <i data-lucide="info" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg mb-1" id="guide-title">Tunggu sebentar...</h4>
                        <p class="text-slate-300 text-sm leading-relaxed" id="guide-text">Memuat panduan simulasi...</p>
                    </div>
                </div>
            </div>

            <div class="flex-grow glass-card rounded-2xl relative flex flex-col items-center justify-start bg-slate-950 border border-slate-800 shadow-[inset_0_0_100px_rgba(0,0,0,1)] p-2 sm:p-4 lg:p-8 overflow-hidden min-h-[400px]" id="canvas-container">
                
                <!-- Alert Overlay -->
            <div id="sim-alert" class="absolute top-6 left-1/2 transform -translate-x-1/2 -translate-y-[200%] transition-transform duration-500 z-[100] pointer-events-none">
                <div class="bg-slate-800/90 backdrop-blur border border-white/20 px-6 py-4 rounded-2xl flex items-center gap-4 shadow-[0_10px_40px_rgba(0,0,0,0.5)]">
                    <div id="alert-icon-container" class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-400 shadow-[0_0_15px_rgba(34,197,94,0.5)]">
                        <i data-lucide="check-circle-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <div class="font-extrabold text-white text-lg tracking-wide" id="alert-title">Sukses</div>
                        <div class="text-sm text-slate-300 font-medium" id="alert-msg">Komponen terpasang!</div>
                    </div>
                </div>
            </div>
            
            <!-- Dynamic Scaler Wrapper -->
            <div id="case-wrapper" class="relative w-full flex justify-center mt-4">
                <!-- PC Case 2D Base (Fixed Size) -->
                <div class="relative w-[800px] h-[700px] flex-shrink-0 bg-slate-900 border-4 border-slate-700 rounded-xl shadow-2xl overflow-hidden p-6" id="pc-case" style="transform-origin: top center;" ondragover="allowDropGlobal(event)" ondrop="dropGlobal(event)">
                <!-- Case Vents / Details -->
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-slate-400 via-slate-900 to-black pointer-events-none z-0"></div>
                
                <!-- PSU Shroud -->
                <div class="absolute bottom-0 left-0 right-0 h-[22%] bg-slate-950 border-t-[3px] border-slate-800 flex items-center px-8 z-[5] shadow-[0_-10px_20px_rgba(0,0,0,0.5)]">
                    <div class="text-slate-800 font-black text-3xl sm:text-4xl tracking-[0.3em] opacity-40 select-none">RAKITKUY</div>
                    <div class="ml-auto flex gap-6 opacity-30">
                        <div class="w-12 h-3 bg-slate-800 rounded-full shadow-inner"></div>
                        <div class="w-12 h-3 bg-slate-800 rounded-full shadow-inner"></div>
                    </div>
                </div>

                <!-- Cable Management Grommets -->
                <div class="absolute right-[22%] top-[10%] bottom-[30%] w-12 flex flex-col justify-around opacity-60 z-[5] pointer-events-none">
                    <div class="w-8 h-20 bg-slate-950 border-2 border-slate-800 rounded-lg shadow-inner"></div>
                    <div class="w-8 h-20 bg-slate-950 border-2 border-slate-800 rounded-lg shadow-inner"></div>
                    <div class="w-8 h-20 bg-slate-950 border-2 border-slate-800 rounded-lg shadow-inner"></div>
                </div>
                
                <!-- Front panel fans -->
                <div class="absolute right-2 top-4 bottom-4 w-12 bg-slate-800 rounded-md flex flex-col justify-around py-4 border border-slate-700 shadow-inner z-[5]">
                    <div class="w-8 h-8 rounded-full bg-slate-950 mx-auto opacity-70 flex items-center justify-center shadow-inner"><i data-lucide="fan" class="w-6 h-6 text-slate-500 animate-spin-slow"></i></div>
                    <div class="w-8 h-8 rounded-full bg-slate-950 mx-auto opacity-70 flex items-center justify-center shadow-inner"><i data-lucide="fan" class="w-6 h-6 text-slate-500 animate-spin-slow"></i></div>
                    <div class="w-8 h-8 rounded-full bg-slate-950 mx-auto opacity-70 flex items-center justify-center shadow-inner"><i data-lucide="fan" class="w-6 h-6 text-slate-500 animate-spin-slow"></i></div>
                </div>

                <!-- Cable Sources (In-Case Drag Start Zones) -->
                <div id="cable-sources" class="absolute bottom-[2%] left-[20%] w-[60%] h-[15%] z-[60] flex justify-center gap-8 items-center pointer-events-none">
                    <div id="src-atx" class="hidden pointer-events-auto w-10 h-10 bg-orange-500/40 border-[3px] border-orange-400 rounded cursor-pointer animate-pulse flex flex-col justify-center items-center shadow-[0_0_15px_rgba(249,115,22,0.6)] hover:scale-110 transition-transform" draggable="true" ondragstart="dragStart(event, 'atx')" ondragend="dragEnd(event)" onclick="autoInstall('atx')">
                        <i data-lucide="cable" class="w-5 h-5 text-white pointer-events-none"></i><span class="text-[7px] text-white font-bold pointer-events-none">24-PIN</span>
                    </div>
                    <div id="src-eps" class="hidden pointer-events-auto w-10 h-10 bg-orange-500/40 border-[3px] border-orange-400 rounded cursor-pointer animate-pulse flex flex-col justify-center items-center shadow-[0_0_15px_rgba(249,115,22,0.6)] hover:scale-110 transition-transform" draggable="true" ondragstart="dragStart(event, 'eps')" ondragend="dragEnd(event)" onclick="autoInstall('eps')">
                        <i data-lucide="cable" class="w-5 h-5 text-white pointer-events-none"></i><span class="text-[7px] text-white font-bold pointer-events-none">8-PIN</span>
                    </div>
                    <div id="src-pcie" class="hidden pointer-events-auto w-10 h-10 bg-red-500/40 border-[3px] border-red-400 rounded cursor-pointer animate-pulse flex flex-col justify-center items-center shadow-[0_0_15px_rgba(239,68,68,0.6)] hover:scale-110 transition-transform" draggable="true" ondragstart="dragStart(event, 'pcie')" ondragend="dragEnd(event)" onclick="autoInstall('pcie')">
                        <i data-lucide="cable" class="w-5 h-5 text-white pointer-events-none"></i><span class="text-[7px] text-white font-bold pointer-events-none">PCIe</span>
                    </div>
                </div>
                <!-- CPU FAN cable source near cooler -->
                <div id="src-cpufan" class="absolute top-[35%] left-[55%] hidden pointer-events-auto w-8 h-8 bg-slate-400/40 border-2 border-white rounded cursor-pointer animate-pulse z-[60] flex flex-col items-center justify-center shadow-[0_0_10px_white] hover:scale-110 transition-transform" draggable="true" ondragstart="dragStart(event, 'cpufan')" ondragend="dragEnd(event)" onclick="autoInstall('cpufan')">
                    <span class="text-[6px] text-white font-bold leading-tight pointer-events-none">FAN<br>CABLE</span>
                </div>
                <!-- Front Panel Source on Casing Front Panel -->
                <div id="src-frontpanel" class="absolute top-[40%] right-[3%] hidden pointer-events-auto w-10 h-10 bg-yellow-500/40 border-[3px] border-yellow-400 rounded cursor-pointer animate-pulse z-[60] flex flex-col items-center justify-center shadow-[0_0_15px_rgba(234,179,8,0.6)] hover:scale-110 transition-transform" draggable="true" ondragstart="dragStart(event, 'frontpanel')" ondragend="dragEnd(event)" onclick="autoInstall('frontpanel')">
                    <i data-lucide="cable" class="w-4 h-4 text-white pointer-events-none"></i><span class="text-[6px] text-white font-bold pointer-events-none">F.PANEL</span>
                </div>


                <!-- CABLES VISUAL LAYER (SVG) -->
                <svg id="cables-layer" class="absolute inset-0 w-full h-full pointer-events-none z-[60]" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                    <defs>
                        <!-- Shadow Filter -->
                        <filter id="cable-shadow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="15" stdDeviation="10" flood-color="#000" flood-opacity="0.6"/>
                        </filter>
                        <!-- Textured Sleeved Wire Patterns -->
                        <linearGradient id="atx-texture" x1="0" y1="0" x2="1" y2="0" spreadMethod="repeat">
                            <stop offset="0%" stop-color="#222" />
                            <stop offset="30%" stop-color="#555" />
                            <stop offset="100%" stop-color="#222" />
                        </linearGradient>
                    </defs>
                    
                    <style>
                        /* Fullscreen specific styling */
                        #sim-workspace:fullscreen {
                            background-color: #020617; /* bg-slate-950 */
                            padding: 2rem;
                            gap: 2rem;
                            overflow: hidden;
                        }
                        #sim-workspace:-webkit-full-screen {
                            background-color: #020617;
                            padding: 2rem;
                            gap: 2rem;
                            overflow: hidden;
                        }
                    </style>

                    <!-- ATX 24-Pin Cable (Neat routing through grommet) -->
                    <!-- M 624,300 (Grommet) to M 488,297 (ATX Port) -->
                    <g id="visual-atx" class="hidden">
                        <path d="M 640,300 C 600,300 550,297 488,297" fill="none" stroke="rgba(0,0,0,0.6)" stroke-width="26" stroke-linecap="round" filter="url(#cable-shadow)" />
                        <path d="M 640,300 C 600,300 550,297 488,297" fill="none" stroke="#e2e8f0" stroke-width="22" stroke-linecap="round" />
                        <!-- Ribbed texture -->
                        <path d="M 640,300 C 600,300 550,297 488,297" fill="none" stroke="#475569" stroke-width="22" stroke-dasharray="2,3" stroke-linecap="round" />
                        <path d="M 640,300 C 600,300 550,297 488,297" fill="none" stroke="#1e293b" stroke-width="22" stroke-dasharray="1,4" stroke-linecap="round" />
                        <!-- Cable Comb -->
                        <rect x="560" y="280" width="12" height="34" fill="#0f172a" rx="3" transform="rotate(-2 560 280)" shadow="url(#cable-shadow)" />
                        <rect x="562" y="282" width="8" height="30" fill="#334155" rx="2" transform="rotate(-2 562 282)" />
                    </g>
                    
                    <!-- EPS 8-Pin Cable (Neat routing along the left edge) -->
                    <!-- M 56,0 to M 56,43 -->
                    <g id="visual-eps" class="hidden">
                        <path d="M 56,-10 C 56,10 56,20 56,43" fill="none" stroke="rgba(0,0,0,0.6)" stroke-width="16" stroke-linecap="round" filter="url(#cable-shadow)" />
                        <path d="M 56,-10 C 56,10 56,20 56,43" fill="none" stroke="#e2e8f0" stroke-width="12" stroke-linecap="round" />
                        <!-- Ribbed texture -->
                        <path d="M 56,-10 C 56,10 56,20 56,43" fill="none" stroke="#475569" stroke-width="12" stroke-dasharray="2,3" stroke-linecap="round" />
                        <!-- Comb -->
                        <rect x="47" y="15" width="18" height="8" fill="#0f172a" rx="2" />
                    </g>
                    
                    <!-- PCIe Cable (Neat curve from PSU to GPU) -->
                    <!-- M 312,546 (Shroud) to M 312,512 (GPU) -->
                    <g id="visual-pcie" class="hidden">
                        <path d="M 312,600 C 312,550 312,530 312,512" fill="none" stroke="rgba(0,0,0,0.6)" stroke-width="16" stroke-linecap="round" filter="url(#cable-shadow)" />
                        <path d="M 312,600 C 312,550 312,530 312,512" fill="none" stroke="#ef4444" stroke-width="12" stroke-linecap="round" />
                        <path d="M 312,600 C 312,550 312,530 312,512" fill="none" stroke="#7f1d1d" stroke-width="12" stroke-dasharray="2,3" stroke-linecap="round" />
                        <!-- Comb -->
                        <rect x="303" y="550" width="18" height="8" fill="#0f172a" rx="2" />
                    </g>
                    
                    <!-- CPU FAN Cable (Tucked neatly near socket) -->
                    <!-- Cooler: x=240,y=100. Port: x=424,y=48 -->
                    <g id="visual-cpufan" class="hidden">
                        <path d="M 340,140 C 380,140 430,90 424,48" fill="none" stroke="rgba(0,0,0,0.6)" stroke-width="8" stroke-linecap="round" filter="url(#cable-shadow)" />
                        <path d="M 340,140 C 380,140 430,90 424,48" fill="none" stroke="#0f172a" stroke-width="6" stroke-linecap="round" />
                        <path d="M 340,140 C 380,140 430,90 424,48" fill="none" stroke="#475569" stroke-width="2" stroke-dasharray="3,3" stroke-linecap="round" />
                    </g>
                    
                    <!-- Front Panel Cables (Tucked along bottom right) -->
                    <!-- M 440,560 to M 440,543 -->
                    <g id="visual-frontpanel" class="hidden">
                        <!-- Rainbow ribbon look -->
                        <path d="M 437,580 L 437,543" fill="none" stroke="#ef4444" stroke-width="2" filter="url(#cable-shadow)" />
                        <path d="M 439,580 L 439,543" fill="none" stroke="#eab308" stroke-width="2" filter="url(#cable-shadow)" />
                        <path d="M 441,580 L 441,543" fill="none" stroke="#3b82f6" stroke-width="2" filter="url(#cable-shadow)" />
                        <path d="M 443,580 L 443,543" fill="none" stroke="#111" stroke-width="2" filter="url(#cable-shadow)" />
                    </g>
                </svg>


                <!-- Dropzone: Motherboard -->
                <div id="zone-mobo" class="dropzone absolute w-[60%] h-[75%] left-10 top-8 border-2 border-dashed border-purple-500/50 bg-purple-500/10 rounded-lg flex items-center justify-center transition-all z-[10]" ondragover="allowDrop(event, 'mobo')" ondrop="drop(event, 'mobo')" ondragenter="dragEnter(event, 'mobo')" ondragleave="dragLeave(event)">
                    <span class="text-purple-400/50 font-bold tracking-widest uppercase text-2xl pointer-events-none zone-label flex flex-col items-center">
                        <i data-lucide="circuit-board" class="w-16 h-16 mb-2 opacity-50"></i>Motherboard
                    </span>
                    
                    <!-- Motherboard Installed Visual -->
                    <div id="visual-mobo" class="absolute inset-0 bg-[#121212] rounded-lg border-[3px] border-[#0a0a0a] hidden shadow-[0_0_40px_rgba(0,0,0,0.8)] flex flex-col overflow-hidden">
                        <!-- PCB Traces / Pattern -->
                        <div class="absolute inset-0 opacity-20 bg-[linear-gradient(45deg,transparent_45%,#475569_49%,#475569_51%,transparent_55%)] bg-[length:10px_10px] pointer-events-none"></div>
                        
                        <!-- VRM Heatsinks (Top & Left of CPU) -->
                        <div class="absolute top-4 left-[20%] w-[35%] h-8 bg-gradient-to-r from-slate-700 to-slate-500 rounded-sm shadow-md border-b border-slate-400"></div>
                        <div class="absolute top-12 left-4 w-8 h-[25%] bg-gradient-to-b from-slate-700 to-slate-500 rounded-sm shadow-md border-r border-slate-400"></div>
                        
                        <!-- Chipset Heatsink (Bottom Right) -->
                        <div class="absolute bottom-16 right-12 w-20 h-20 bg-gradient-to-br from-slate-800 to-slate-900 border-2 border-slate-600 rounded-md shadow-lg flex items-center justify-center">
                            <i data-lucide="shield" class="w-8 h-8 text-slate-500 opacity-50"></i>
                        </div>
                        
                        <!-- PCIe Slots Decoration (Behind GPU) -->
                        <div class="absolute bottom-16 left-[5%] w-[80%] h-3 bg-[#0a0a0a] border border-slate-700"></div>
                        <div class="absolute bottom-24 left-[5%] w-[80%] h-3 bg-[#0a0a0a] border border-slate-700"></div>

                        <!-- Zones on Motherboard -->
                        <div class="relative w-full h-full z-10">
                            
                            <!-- MANUAL CLICK: Screws -->
                            <div id="zone-screws" class="hidden absolute inset-0 z-40 pointer-events-none">
                                <div id="screw-1" onclick="handleManualClick('screws', 'screw-1')" class="absolute top-2 left-2 w-6 h-6 rounded-full border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex items-center justify-center hover:scale-125 transition-transform"><i data-lucide="target" class="w-4 h-4 text-red-500"></i></div>
                                <div id="screw-2" onclick="handleManualClick('screws', 'screw-2')" class="absolute top-2 right-2 w-6 h-6 rounded-full border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex items-center justify-center hover:scale-125 transition-transform"><i data-lucide="target" class="w-4 h-4 text-red-500"></i></div>
                                <div id="screw-3" onclick="handleManualClick('screws', 'screw-3')" class="absolute bottom-2 left-2 w-6 h-6 rounded-full border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex items-center justify-center hover:scale-125 transition-transform"><i data-lucide="target" class="w-4 h-4 text-red-500"></i></div>
                                <div id="screw-4" onclick="handleManualClick('screws', 'screw-4')" class="absolute bottom-2 right-2 w-6 h-6 rounded-full border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex items-center justify-center hover:scale-125 transition-transform"><i data-lucide="target" class="w-4 h-4 text-red-500"></i></div>
                            </div>
                            <!-- Visual Screws (Shown when done) -->
                            <div id="visual-screws" class="hidden absolute inset-0 pointer-events-none z-30">
                                <div class="absolute top-2 left-2 w-3 h-3 rounded-full bg-slate-400 border border-slate-500 flex items-center justify-center"><i data-lucide="plus" class="w-2 h-2 text-slate-700"></i></div>
                                <div class="absolute top-2 right-2 w-3 h-3 rounded-full bg-slate-400 border border-slate-500 flex items-center justify-center"><i data-lucide="plus" class="w-2 h-2 text-slate-700"></i></div>
                                <div class="absolute bottom-2 left-2 w-3 h-3 rounded-full bg-slate-400 border border-slate-500 flex items-center justify-center"><i data-lucide="plus" class="w-2 h-2 text-slate-700"></i></div>
                                <div class="absolute bottom-2 right-2 w-3 h-3 rounded-full bg-slate-400 border border-slate-500 flex items-center justify-center"><i data-lucide="plus" class="w-2 h-2 text-slate-700"></i></div>
                            </div>

                            <!-- Dropzone: CPU -->
                            <div id="zone-cpu" class="dropzone absolute w-24 h-24 top-12 left-1/2 -translate-x-1/2 border-2 border-dashed border-cyan-500/50 bg-cyan-500/10 hidden items-center justify-center rounded-md z-30" ondragover="allowDrop(event, 'cpu')" ondrop="drop(event, 'cpu')" ondragenter="dragEnter(event, 'cpu')" ondragleave="dragLeave(event)">
                                <span class="text-cyan-400/70 text-sm font-bold pointer-events-none zone-label">CPU Socket</span>
                                <!-- CPU Visual -->
                                <div id="visual-cpu" class="absolute inset-1 bg-[#165133] border-2 border-[#0f3822] rounded-sm hidden shadow-2xl flex items-center justify-center relative z-10 transition-all duration-300">
                                    <!-- Golden Pin 1 Indicator -->
                                    <div class="absolute bottom-1 left-1 w-2.5 h-2.5 bg-yellow-400 rounded-sm" style="clip-path: polygon(0 100%, 100% 100%, 0 0);"></div>
                                    
                                    <!-- Edge Notches (Intel style) -->
                                    <div class="absolute top-8 -left-1.5 w-3 h-3 bg-slate-900 rounded-full"></div>
                                    <div class="absolute top-8 -right-1.5 w-3 h-3 bg-slate-900 rounded-full"></div>
                                    
                                    <!-- Integrated Heat Spreader (IHS) - The silver part -->
                                    <div class="w-[82%] h-[82%] bg-gradient-to-br from-slate-200 via-slate-300 to-slate-400 rounded shadow-[inset_0_0_8px_rgba(0,0,0,0.2)] border-b-2 border-r-2 border-slate-400 flex flex-col items-center justify-center relative overflow-hidden">
                                        <!-- Reflective shine -->
                                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/50 to-transparent"></div>
                                        <span class="text-slate-600 text-[9px] font-black tracking-[0.2em] z-10 mt-1">INTEL</span>
                                        <span class="text-slate-800 text-sm font-black tracking-tighter z-10">CORE i7</span>
                                        <div class="absolute bottom-1 text-[6px] text-slate-500 font-mono z-10">LGA 1700</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- MANUAL CLICK: CPU Lever -->
                            <div id="zone-cpu-lock" class="hidden absolute top-12 left-[62%] w-2 h-24 z-40 pointer-events-none">
                                <div id="visual-cpu-lock" class="w-1 h-full bg-slate-300 origin-top transition-transform duration-500 shadow-sm border border-slate-400"></div>
                                <div id="cpu-lever-handle" onclick="handleManualClick('cpu-lock', 'cpu-lever-handle')" class="absolute bottom-0 -left-3 w-8 h-8 rounded-full border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex items-center justify-center hover:scale-110">
                                    <i data-lucide="lock" class="w-4 h-4 text-red-500"></i>
                                </div>
                            </div>

                            <!-- Dropzone: Thermal Paste -->
                            <div id="zone-paste" class="dropzone absolute w-24 h-24 top-12 left-1/2 -translate-x-1/2 z-40 border-2 border-dashed border-slate-400/50 hidden items-center justify-center rounded-md" ondragover="allowDrop(event, 'paste')" ondrop="drop(event, 'paste')" ondragenter="dragEnter(event, 'paste')" ondragleave="dragLeave(event)">
                                <div id="visual-paste" class="w-8 h-8 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full blur-[2px] hidden absolute z-20 shadow-inner" style="border-radius: 50% 40% 60% 40% / 40% 50% 40% 60%;"></div>
                            </div>

                            <!-- Dropzone: Cooler -->
                            <div id="zone-cooler" class="dropzone absolute w-36 h-36 top-6 left-1/2 -translate-x-1/2 z-50 border-2 border-dashed border-cyan-300/50 hidden rounded-full items-center justify-center" ondragover="allowDrop(event, 'cooler')" ondrop="drop(event, 'cooler')" ondragenter="dragEnter(event, 'cooler')" ondragleave="dragLeave(event)">
                                <div id="visual-cooler" class="absolute inset-0 bg-gradient-to-br from-slate-300 via-slate-400 to-slate-500 rounded-md hidden flex items-center justify-center shadow-2xl z-30 border border-slate-300 overflow-hidden">
                                    <!-- Heatsink fins lines -->
                                    <div class="absolute inset-0 opacity-30" style="background: repeating-linear-gradient(to right, transparent, transparent 4px, #000 4px, #000 5px);"></div>
                                    <!-- RGB Fan Ring -->
                                    <div class="w-[90%] h-[90%] bg-slate-900 rounded-full border-4 border-cyan-400/80 shadow-[0_0_20px_rgba(34,211,238,0.8)] flex items-center justify-center relative">
                                        <div class="absolute inset-0 rounded-full bg-cyan-400/20 blur-md animate-pulse"></div>
                                        <i data-lucide="fan" class="w-full h-full text-slate-300 animate-spin-fast opacity-90 p-2"></i>
                                        <!-- Fan Center Logo -->
                                        <div class="absolute w-6 h-6 bg-slate-800 rounded-full border border-cyan-500 flex items-center justify-center">
                                            <div class="w-3 h-3 bg-cyan-400 rounded-full blur-[2px]"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Dropzone (CABLE): CPU FAN -->
                            <div id="zone-cpufan" class="dropzone absolute top-4 right-[20%] w-10 h-6 border-2 border-dashed border-slate-400/50 hidden flex flex-col items-center justify-center rounded-sm z-[60]" ondragover="allowDrop(event, 'cpufan')" ondrop="drop(event, 'cpufan')" ondragenter="dragEnter(event, 'cpufan')" ondragleave="dragLeave(event)">
                                <div id="visual-cpufan-port" class="hidden w-full h-full bg-slate-800 border border-slate-500 rounded-sm flex items-center justify-around px-1"><div class="w-0.5 h-1 bg-white"></div><div class="w-0.5 h-1 bg-white"></div><div class="w-0.5 h-1 bg-white"></div></div>
                            </div>

                            <!-- Dropzone (CABLE): EPS Power -->
                            <div id="zone-eps" class="dropzone absolute top-2 left-4 w-10 h-6 border-2 border-dashed border-orange-500/50 hidden flex items-center justify-center rounded-sm z-30" ondragover="allowDrop(event, 'eps')" ondrop="drop(event, 'eps')" ondragenter="dragEnter(event, 'eps')" ondragleave="dragLeave(event)">
                                <div id="visual-eps-port" class="hidden w-full h-full bg-slate-800 border border-slate-600 grid grid-cols-4 grid-rows-2 gap-[1px] p-[1px]"></div>
                            </div>

                            <!-- Dropzone (CABLE): ATX Power -->
                            <div id="zone-atx" class="dropzone absolute top-1/2 right-2 -translate-y-1/2 w-6 h-28 border-2 border-dashed border-orange-500/50 hidden flex items-center justify-center rounded-sm z-30" ondragover="allowDrop(event, 'atx')" ondrop="drop(event, 'atx')" ondragenter="dragEnter(event, 'atx')" ondragleave="dragLeave(event)">
                                <div id="visual-atx-port" class="hidden w-full h-full bg-slate-800 border border-slate-600 grid grid-cols-2 grid-rows-12 gap-[1px] p-[1px]"></div>
                            </div>

                            <!-- Dropzone: RAM -->
                            <div id="zone-ram" class="dropzone absolute w-20 h-36 top-6 right-12 border-2 border-dashed border-pink-500/50 bg-pink-500/10 hidden items-center justify-center rounded z-30" ondragover="allowDrop(event, 'ram')" ondrop="drop(event, 'ram')" ondragenter="dragEnter(event, 'ram')" ondragleave="dragLeave(event)">
                                <span class="text-pink-400/50 text-xs font-bold pointer-events-none zone-label rotate-90 whitespace-nowrap">RAM Slots</span>
                                
                                <div id="visual-ram" class="absolute inset-0 px-2 py-1 flex justify-between hidden z-10 transition-transform duration-300">
                                    <!-- Stick 1 -->
                                    <div class="w-[40%] h-full bg-[#111] border border-slate-700 rounded-sm shadow-xl relative overflow-hidden flex flex-col justify-between">
                                        <!-- RGB Top -->
                                        <div class="w-full h-1.5 bg-gradient-to-r from-pink-500 via-purple-500 to-cyan-500 animate-pulse shadow-[0_0_10px_rgba(236,72,153,0.8)]"></div>
                                        <!-- Heatspreader -->
                                        <div class="w-full flex-grow bg-gradient-to-b from-slate-700 to-slate-900 flex items-center justify-center">
                                            <span class="text-[7px] text-slate-300 font-bold -rotate-90">DDR5</span>
                                        </div>
                                        <!-- Golden Contacts -->
                                        <div class="w-full h-1 bg-yellow-600"></div>
                                    </div>
                                    <!-- Stick 2 -->
                                    <div class="w-[40%] h-full bg-[#111] border border-slate-700 rounded-sm shadow-xl relative overflow-hidden flex flex-col justify-between">
                                        <!-- RGB Top -->
                                        <div class="w-full h-1.5 bg-gradient-to-r from-cyan-500 via-purple-500 to-pink-500 animate-pulse shadow-[0_0_10px_rgba(34,211,238,0.8)]"></div>
                                        <!-- Heatspreader -->
                                        <div class="w-full flex-grow bg-gradient-to-b from-slate-700 to-slate-900 flex items-center justify-center">
                                            <span class="text-[7px] text-slate-300 font-bold -rotate-90">DDR5</span>
                                        </div>
                                        <!-- Golden Contacts -->
                                        <div class="w-full h-1 bg-yellow-600"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- MANUAL CLICK: RAM Clips -->
                            <div id="zone-ram-lock" class="hidden absolute top-4 right-10 w-24 h-40 z-40 pointer-events-none">
                                <div id="ram-clip-1" onclick="handleManualClick('ram-lock', 'ram-clip-1')" class="absolute -top-3 left-3 w-16 h-4 rounded border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex justify-center items-center hover:bg-red-500/40"><i data-lucide="lock" class="w-3 h-3 text-red-500"></i></div>
                                <div id="ram-clip-2" onclick="handleManualClick('ram-lock', 'ram-clip-2')" class="absolute -bottom-3 left-3 w-16 h-4 rounded border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex justify-center items-center hover:bg-red-500/40"><i data-lucide="lock" class="w-3 h-3 text-red-500"></i></div>
                            </div>

                            <!-- Dropzone: SSD -->
                            <div id="zone-ssd" class="dropzone absolute w-28 h-8 bottom-32 left-10 border-2 border-dashed border-green-500/50 bg-green-500/10 hidden items-center justify-center rounded z-30" ondragover="allowDrop(event, 'ssd')" ondrop="drop(event, 'ssd')" ondragenter="dragEnter(event, 'ssd')" ondragleave="dragLeave(event)">
                                <span class="text-green-400/70 text-xs font-bold pointer-events-none zone-label">M.2 Slot</span>
                                <div id="visual-ssd" class="absolute inset-1 bg-[#1a1a1a] border border-[#0a0a0a] rounded-sm hidden flex items-center justify-between px-1 z-10 shadow-lg origin-right transform rotate-12 transition-transform duration-500">
                                    <!-- Screw hole -->
                                    <div class="w-2.5 h-2.5 border-2 border-yellow-600 rounded-full bg-transparent flex-shrink-0 -ml-1.5"></div>
                                    <!-- Sticker -->
                                    <div class="flex-grow h-[70%] mx-2 bg-gradient-to-r from-slate-800 to-black border border-slate-600 flex items-center justify-center">
                                        <span class="text-[7px] text-white font-bold tracking-widest">980 PRO 1TB</span>
                                    </div>
                                    <!-- Golden connector -->
                                    <div class="w-1.5 h-full bg-yellow-600 flex flex-col justify-evenly py-[1px] -mr-1 rounded-r-sm">
                                        <div class="w-full h-[1px] bg-black/50"></div>
                                        <div class="w-full h-[1px] bg-black/50"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- MANUAL CLICK: SSD Screw -->
                            <div id="zone-ssd-screw" class="hidden absolute bottom-[124px] left-8 w-6 h-6 z-40 pointer-events-none">
                                <div id="ssd-screw-1" onclick="handleManualClick('ssd-screw', 'ssd-screw-1')" class="absolute top-0 left-0 w-6 h-6 rounded-full border-2 border-red-500 bg-red-500/20 animate-pulse cursor-pointer pointer-events-auto flex items-center justify-center hover:scale-125"><i data-lucide="target" class="w-3 h-3 text-red-500"></i></div>
                            </div>

                            <!-- Dropzone: GPU -->
                            <div id="zone-gpu" class="dropzone absolute w-[90%] h-20 bottom-10 left-[5%] border-2 border-dashed border-red-500/50 bg-red-500/10 hidden items-center justify-center rounded z-30" ondragover="allowDrop(event, 'gpu')" ondrop="drop(event, 'gpu')" ondragenter="dragEnter(event, 'gpu')" ondragleave="dragLeave(event)">
                                <span class="text-red-400/50 text-sm font-bold pointer-events-none zone-label">PCIe x16</span>
                                <div id="visual-gpu" class="absolute -left-[5%] w-[110%] h-full bg-gradient-to-b from-[#111] to-[#222] border-t-2 border-[#444] border-b-4 border-[#000] rounded hidden shadow-2xl flex flex-col items-center justify-center z-40 overflow-hidden">
                                    <!-- Metallic accents -->
                                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 via-orange-500 to-red-600"></div>
                                    <div class="absolute top-1 left-3 text-[9px] font-black text-white/60 tracking-[0.2em] italic">RTX 4090</div>
                                    <!-- Shroud geometry -->
                                    <div class="w-full h-full flex items-center justify-between px-6 pt-3 pb-1">
                                        <!-- Fan 1 -->
                                        <div class="w-14 h-14 rounded-full bg-[#0a0a0a] border-2 border-slate-700 flex items-center justify-center shadow-[inset_0_0_10px_#000]">
                                            <i data-lucide="fan" class="w-12 h-12 text-slate-400 animate-spin-fast opacity-80"></i>
                                        </div>
                                        <!-- Fan 2 -->
                                        <div class="w-14 h-14 rounded-full bg-[#0a0a0a] border-2 border-slate-700 flex items-center justify-center shadow-[inset_0_0_10px_#000]">
                                            <i data-lucide="fan" class="w-12 h-12 text-slate-400 animate-spin-fast opacity-80"></i>
                                        </div>
                                        <!-- Fan 3 -->
                                        <div class="w-14 h-14 rounded-full bg-[#0a0a0a] border-2 border-slate-700 flex items-center justify-center shadow-[inset_0_0_10px_#000]">
                                            <i data-lucide="fan" class="w-12 h-12 text-slate-400 animate-spin-fast opacity-80"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dropzone (CABLE): PCIe Cable -->
                            <div id="zone-pcie" class="dropzone absolute bottom-12 left-1/2 w-16 h-6 border-2 border-dashed border-red-500/50 hidden items-center justify-center rounded-sm z-50 bg-slate-900" ondragover="allowDrop(event, 'pcie')" ondrop="drop(event, 'pcie')" ondragenter="dragEnter(event, 'pcie')" ondragleave="dragLeave(event)">
                                <div id="visual-pcie-port" class="hidden w-full h-full bg-slate-800 border border-slate-600 grid grid-cols-8 grid-rows-2 gap-[1px] p-[1px]"></div>
                            </div>

                            <!-- Dropzone (CABLE): Front Panel -->
                            <div id="zone-frontpanel" class="dropzone absolute bottom-2 right-12 w-16 h-6 border-2 border-dashed border-yellow-500/50 hidden flex items-center justify-center rounded-sm z-30 bg-slate-900" ondragover="allowDrop(event, 'frontpanel')" ondrop="drop(event, 'frontpanel')" ondragenter="dragEnter(event, 'frontpanel')" ondragleave="dragLeave(event)">
                                <div id="visual-frontpanel-port" class="hidden w-full h-full border border-slate-600 grid grid-cols-4 gap-[2px] p-[2px]">
                                    <div class="bg-yellow-400"></div><div class="bg-yellow-400"></div><div class="bg-red-400"></div><div class="bg-red-400"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Dropzone: PSU -->
                <div id="zone-psu" class="dropzone absolute w-[30%] h-[18%] bottom-2 left-10 border-2 border-dashed border-orange-500/50 bg-orange-500/10 rounded-lg hidden items-center justify-center transition-all z-[10]" ondragover="allowDrop(event, 'psu')" ondrop="drop(event, 'psu')" ondragenter="dragEnter(event, 'psu')" ondragleave="dragLeave(event)">
                    <span class="text-orange-400/50 font-bold tracking-widest uppercase text-sm pointer-events-none zone-label flex flex-col items-center">
                        <i data-lucide="plug" class="w-8 h-8 mb-1 opacity-50"></i>PSU
                    </span>
                    <div id="visual-psu" class="absolute inset-0 bg-[#1a1a1a] border border-[#0a0a0a] rounded-md hidden shadow-2xl flex items-center justify-center z-[11] overflow-hidden">
                        <!-- Left side sticker -->
                        <div class="absolute left-0 top-0 bottom-0 w-[35%] bg-[#0a0a0a] flex flex-col justify-center items-center border-r border-slate-800">
                            <div class="text-yellow-500 font-black text-[10px] transform -rotate-90 whitespace-nowrap tracking-wider">850W GOLD</div>
                        </div>
                        <!-- Fan Grille Area -->
                        <div class="absolute right-[10%] w-[60px] h-[60px] sm:w-16 sm:h-16 bg-black rounded-full shadow-[inset_0_0_15px_rgba(0,0,0,1)] border-[3px] border-slate-700 flex items-center justify-center relative">
                            <!-- Wire grille (cross) -->
                            <div class="absolute w-full h-[2px] bg-slate-500 rotate-45 z-20 shadow-sm"></div>
                            <div class="absolute w-[2px] h-full bg-slate-500 rotate-45 z-20 shadow-sm"></div>
                            <div class="absolute w-full h-[2px] bg-slate-500 -rotate-45 z-20 shadow-sm"></div>
                            <div class="absolute w-[2px] h-full bg-slate-500 -rotate-45 z-20 shadow-sm"></div>
                            <!-- Fan -->
                            <i data-lucide="fan" class="w-14 h-14 text-slate-300 animate-spin-slow opacity-80 z-10"></i>
                        </div>
                    </div>
                </div>

                </div> <!-- End Case Wrapper -->

            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .inventory-item { padding: 0.75rem; border-width: 2px; border-radius: 0.75rem; display: flex; align-items: center; gap: 1rem; transition: all 0.2s; user-select: none; }
    .inventory-item.locked { opacity: 0.3; cursor: not-allowed; border-color: rgba(51, 65, 85, 0.5); background-color: rgba(30, 41, 59, 0.3); filter: grayscale(100%); pointer-events: none; }
    .inventory-item.unlocked { cursor: pointer; border-color: rgba(51, 65, 85, 1); background-color: rgba(30, 41, 59, 0.8); filter: grayscale(0%); }
    .inventory-item.unlocked[draggable="true"]:active { cursor: grabbing; }
    .inventory-item.unlocked:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
    .inventory-item.installed { opacity: 0.2; cursor: default; border-color: rgba(34, 197, 94, 0.5); background-color: rgba(20, 83, 45, 0.2); pointer-events: none; }
    
    .icon-box { width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; border-width: 1px; background: rgba(15, 23, 42, 0.5); transition: transform 0.2s; }
    .item-title { font-size: 0.8rem; font-weight: 800; color: white; transition: color 0.2s; }
    .item-desc { font-size: 0.6rem; color: #94a3b8; text-transform: uppercase; font-weight: 600; margin-top: 2px; }

    .dropzone { transition: all 0.3s ease; }
    .dropzone.drag-over { background-color: rgba(255, 255, 255, 0.15) !important; transform: scale(1.03); box-shadow: 0 0 20px rgba(255, 255, 255, 0.2); }
    
    .animate-spin-slow { animation: spin 4s linear infinite; }
    .animate-spin-fast { animation: spin 0.8s linear infinite; }
</style>

<script>
    const steps = [
        { id: 'mobo', type: 'drag-from-inventory', name: 'Motherboard', color: 'purple', icon: 'circuit-board', instruction: 'Seret Motherboard dari menu kiri ke dalam kotak putus-putus ungu di casing, ATAU klik komponen di menu kiri untuk memasang otomatis.' },
        { id: 'screws', type: 'click-multi', target: 4, name: 'Baut Mobo', color: 'slate', icon: 'plus-circle', instruction: 'Klik 4 titik merah berkedip di sudut-sudut Motherboard untuk mengencangkan bautnya secara manual.' },
        { id: 'cpu', type: 'drag-from-inventory', name: 'Processor', color: 'cyan', icon: 'cpu', instruction: 'Tarik Processor (CPU) ke soket persegi di tengah atas Motherboard, atau cukup klik untuk pasang.' },
        { id: 'cpu-lock', type: 'click-single', name: 'Kunci Tuas CPU', color: 'cyan', icon: 'lock', instruction: 'Klik tuas merah berkedip di sebelah kanan soket CPU untuk mengunci Processor agar tidak terlepas.' },
        { id: 'paste', type: 'drag-from-inventory', name: 'Thermal Paste', color: 'slate', icon: 'droplet', instruction: 'Tarik Thermal Paste ke atas permukaan Processor untuk mendinginkan suhu.' },
        { id: 'cooler', type: 'drag-from-inventory', name: 'CPU Cooler', color: 'cyan', icon: 'fan', instruction: 'Tarik Kipas Pendingin (Cooler) tepat ke atas Processor yang sudah diberi paste.' },
        { id: 'cpufan', type: 'drag-cable', name: 'Kabel Kipas CPU', color: 'slate', icon: 'cable', instruction: 'Fungsi: Memberikan daya dari Motherboard ke Kipas CPU agar berputar. Tarik konektor berkedip (FAN CABLE) ke port kipas di dekatnya.' },
        { id: 'ram', type: 'drag-from-inventory', name: 'RAM Memory', color: 'pink', icon: 'memory-stick', instruction: 'Tarik RAM Memory ke slot tegak panjang di sebelah kanan Prosesor.' },
        { id: 'ram-lock', type: 'click-multi', target: 2, name: 'Kunci Klip RAM', color: 'pink', icon: 'lock', instruction: 'Klik 2 klip pengunci merah di ujung atas dan bawah slot RAM agar terpasang rapat.' },
        { id: 'ssd', type: 'drag-from-inventory', name: 'SSD NVMe', color: 'green', icon: 'hard-drive', instruction: 'Tarik SSD NVMe ke slot mendatar (M.2) di bagian bawah Motherboard.' },
        { id: 'ssd-screw', type: 'click-single', name: 'Baut SSD', color: 'green', icon: 'settings', instruction: 'Klik titik merah berkedip di ujung SSD untuk memasang baut penahannya.' },
        { id: 'psu', type: 'drag-from-inventory', name: 'Power Supply', color: 'orange', icon: 'plug', instruction: 'Tarik kotak Power Supply (PSU) ke bagian bawah casing (PSU Shroud).' },
        { id: 'atx', type: 'drag-cable', name: 'Kabel 24-pin ATX', color: 'orange', icon: 'cable', instruction: 'Fungsi: Menyalurkan daya utama dari Power Supply ke seluruh Motherboard. Tarik konektor 24-PIN yang menyala menuju port tegak panjang di tepi kanan Motherboard.' },
        { id: 'eps', type: 'drag-cable', name: 'Kabel 8-pin EPS', color: 'orange', icon: 'cable', instruction: 'Fungsi: Menyalurkan daya khusus dari Power Supply langsung ke Prosesor (CPU). Tarik konektor 8-PIN menuju port kecil di sudut kiri atas Motherboard.' },
        { id: 'gpu', type: 'drag-from-inventory', name: 'VGA Card', color: 'red', icon: 'monitor-speaker', instruction: 'Tarik VGA Card (GPU) ke slot PCIe (mendatar panjang) di bawah slot SSD.' },
        { id: 'pcie', type: 'drag-cable', name: 'Kabel Power GPU', color: 'red', icon: 'cable', instruction: 'Fungsi: Menyalurkan daya ekstra dari PSU untuk mengangkat beban kerja grafis berat. Tarik konektor PCIe menuju port di punggung VGA Card.' },
        { id: 'frontpanel', type: 'drag-cable', name: 'Kabel Front Panel', color: 'yellow', icon: 'link', instruction: 'Fungsi: Menyambungkan tombol Power/Reset casing ke Motherboard agar tombol bisa ditekan. Tarik konektor F.PANEL menuju pin kuning di sudut kanan bawah Motherboard.' }
    ];

    let currentStepIndex = 0;
    let currentlyDragging = null;
    let clicksDone = 0;

    function initUI() {
        const list = document.getElementById('inventory-list');
        steps.forEach(step => {
            const div = document.createElement('div');
            div.id = `item-${step.id}`;
            div.className = 'inventory-item locked';
            div.draggable = false;
            div.ondragstart = (e) => dragStart(e, step.id);
            div.ondragend = dragEnd;
            div.onclick = () => autoInstall(step.id);
            div.innerHTML = `
                <div class="icon-box text-${step.color}-400"><i data-lucide="${step.icon}" class="w-6 h-6"></i></div>
                <div class="pointer-events-none w-full">
                    <div class="item-title">${step.name}</div>
                    <div class="item-desc flex justify-between" id="desc-${step.id}">
                        <span>Terkunci</span>
                        <span class="opacity-50">${step.type === 'drag-from-inventory' ? '(Drag)' : step.type.includes('click') ? '(Klik)' : '(Tarik Kabel)'}</span>
                    </div>
                </div>
            `;
            list.appendChild(div);
        });
        lucide.createIcons();
        updateStepUI();
    }

    function showAlert(title, msg, color) {
        const alertBox = document.getElementById('sim-alert');
        const iconContainer = document.getElementById('alert-icon-container');
        document.getElementById('alert-title').innerText = title;
        document.getElementById('alert-msg').innerText = msg;
        let iconName = color === 'red' ? 'x-circle' : color === 'orange' ? 'alert-triangle' : 'check-circle-2';
        iconContainer.className = `w-10 h-10 rounded-full flex items-center justify-center shadow-lg bg-${color}-500/20 text-${color}-400 shadow-[0_0_15px_rgba(0,0,0,0.5)]`;
        iconContainer.innerHTML = `<i data-lucide="${iconName}" class="w-6 h-6"></i>`;
        lucide.createIcons({ root: iconContainer });
        alertBox.classList.remove('-translate-y-[200%]');
        setTimeout(() => alertBox.classList.add('-translate-y-[200%]'), 3000);
    }

    function getComponentName(id) {
        const step = steps.find(s => s.id === id);
        return step ? step.name : 'Komponen';
    }

    function updateStepUI() {
        if(currentStepIndex >= steps.length) {
            document.getElementById('status-indicator').className = 'w-3 h-3 rounded-full bg-green-400 shadow-[0_0_15px_rgba(34,197,94,0.8)]';
            document.getElementById('status-text').className = 'text-sm font-black text-green-100 uppercase tracking-widest';
            document.getElementById('status-text').innerText = 'PC SELESAI DIRAKIT!';
            document.getElementById('pc-case').classList.add('shadow-[0_0_80px_rgba(34,197,94,0.4)]', 'border-green-500/50');
            showAlert('Sukses!', 'PC berhasil dirakit sepenuhnya.', 'green');
            return;
        }

        const nextStep = steps[currentStepIndex];
        const nextId = nextStep.id;

        // Update Guide Box
        document.getElementById('guide-title').innerText = `Langkah ${currentStepIndex + 1}: Pasang ${nextStep.name}`;
        document.getElementById('guide-text').innerText = nextStep.instruction;

        document.getElementById('status-indicator').className = `w-3 h-3 rounded-full bg-${nextStep.color}-400 animate-pulse shadow-[0_0_10px_var(--color-${nextStep.color}-500)]`;
        document.getElementById('status-text').className = `text-sm font-bold text-${nextStep.color}-100`;
        document.getElementById('status-text').innerText = `${currentStepIndex + 1}/${steps.length}: Pasang ${nextStep.name}`;
        
        const itemEl = document.getElementById(`item-${nextId}`);
        itemEl.className = `inventory-item unlocked border-${nextStep.color}-500 bg-${nextStep.color}-500/20 shadow-[0_0_15px_var(--color-${nextStep.color}-500)]`;
        const iconBox = itemEl.querySelector('.icon-box');
        iconBox.classList.add(`border-${nextStep.color}-500`, `shadow-[0_0_10px_var(--color-${nextStep.color}-500)]`);
        const titleEl = itemEl.querySelector('.item-title');
        titleEl.classList.add(`text-${nextStep.color}-400`);
        const descEl = document.getElementById(`desc-${nextId}`);
        
        if (nextStep.type === 'drag-from-inventory') {
            itemEl.draggable = true;
            descEl.innerHTML = '<span>Tarik ke Casing</span>';
            const nextZone = document.getElementById(`zone-${nextId}`);
            if(nextZone) nextZone.classList.remove('hidden');
            
        } else if (nextStep.type === 'click-multi' || nextStep.type === 'click-single') {
            itemEl.draggable = false;
            descEl.innerHTML = '<span class="text-yellow-400 font-bold">KLIK INDIKATOR DI CASING</span>';
            const clickZone = document.getElementById(`zone-${nextId}`);
            if(clickZone) clickZone.classList.remove('hidden');
            
        } else if (nextStep.type === 'drag-cable') {
            itemEl.draggable = false;
            descEl.innerHTML = '<span class="text-orange-400 font-bold">TARIK KABEL DI CASING</span>';
            const src = document.getElementById(`src-${nextId}`);
            if(src) {
                src.classList.remove('hidden');
                src.classList.add('flex');
            }
            const nextZone = document.getElementById(`zone-${nextId}`);
            if(nextZone) nextZone.classList.remove('hidden');
        }
    }

    // --- AUTO INSTALL (CLICK MODE) ---
    function autoInstall(type) {
        const expectedStep = steps[currentStepIndex];
        if (expectedStep.id !== type) {
            // If they clicked on an inventory item that is NOT the current step
            if(expectedStep.type !== 'click-multi' && expectedStep.type !== 'click-single') {
                showAlert('Belum Waktunya!', `Silakan kerjakan langkah: ${expectedStep.name} terlebih dahulu.`, 'orange');
            }
            return;
        }
        
        // Auto-install is only for dragging elements. Clicks must be done on the board manually.
        if (expectedStep.type === 'drag-from-inventory' || expectedStep.type === 'drag-cable') {
            installComponent(type, expectedStep);
        }
    }

    // --- MANUAL CLICKS ---
    function handleManualClick(type, elementId) {
        const expectedStep = steps[currentStepIndex];
        if(expectedStep.id !== type) {
            showAlert('Belum Waktunya!', `Selesaikan langkah: ${expectedStep.name} terlebih dahulu.`, 'orange');
            return;
        }
        
        const el = document.getElementById(elementId);
        
        if(expectedStep.type === 'click-single') {
            el.classList.remove('animate-pulse', 'border-red-500', 'bg-red-500/20');
            el.classList.add('bg-green-500/50', 'border-green-500');
            
            // Animasi Khusus
            if(type === 'cpu-lock') {
                document.getElementById('visual-cpu-lock').style.transform = 'rotate(-90deg) translateX(-10px)';
            }
            if(type === 'ssd-screw') {
                el.innerHTML = '<i data-lucide="plus" class="w-4 h-4 text-slate-800"></i>';
                document.getElementById('visual-ssd').style.transform = 'rotate(0deg)'; // SSD lays flat
            }
            lucide.createIcons({ root: el });
            installComponent(type, expectedStep);
            
        } else if (expectedStep.type === 'click-multi') {
            if(!el.classList.contains('clicked')) {
                el.classList.add('clicked', 'bg-slate-400');
                el.classList.remove('animate-pulse', 'border-red-500', 'bg-red-500/20');
                el.innerHTML = '<i data-lucide="plus" class="w-full h-full text-slate-800"></i>';
                lucide.createIcons({ root: el });
                
                clicksDone++;
                if(clicksDone >= expectedStep.target) {
                    clicksDone = 0;
                    installComponent(type, expectedStep);
                }
            }
        }
    }


    // --- DRAG AND DROP ---
    function dragStart(e, type) {
        currentlyDragging = type;
        e.dataTransfer.setData('text/plain', type);
        e.dataTransfer.effectAllowed = 'move';
        setTimeout(() => {
            e.target.style.opacity = '0.4';
            e.target.style.transform = 'scale(0.95)';
        }, 10);
    }

    function dragEnd(e) {
        currentlyDragging = null;
        e.target.style.opacity = '1';
        e.target.style.transform = 'scale(1)';
    }

    function allowDropGlobal(e) {
        e.preventDefault(); e.dataTransfer.dropEffect = 'move';
    }

    function dropGlobal(e) {
        e.preventDefault();
        if(!currentlyDragging) return;
        const expectedStep = steps[currentStepIndex];
        resetDragStyle(currentlyDragging);

        if(currentlyDragging !== expectedStep.id) {
            showAlert('Salah Komponen!', `Sekarang giliran memasang ${expectedStep.name}, bukan ${getComponentName(currentlyDragging)}.`, 'red');
        } else {
            showAlert('Salah Penempatan!', `Letakkan ${expectedStep.name} di area kotak putus-putus yang disorot.`, 'orange');
        }
        currentlyDragging = null;
    }

    function allowDrop(e, zoneType) {
        e.preventDefault(); e.dataTransfer.dropEffect = 'move';
    }

    function dragEnter(e, zoneType) {
        e.preventDefault();
        const expectedStep = steps[currentStepIndex];
        if (zoneType === expectedStep.id) {
            e.currentTarget.classList.add('drag-over');
        } else {
            e.currentTarget.style.backgroundColor = 'rgba(239, 68, 68, 0.2)'; 
        }
    }

    function dragLeave(e) {
        e.currentTarget.classList.remove('drag-over');
        e.currentTarget.style.backgroundColor = ''; 
    }

    function resetDragStyle(type) {
        const itemEl = document.getElementById(`item-${type}`);
        if(itemEl) { itemEl.style.opacity = '1'; itemEl.style.transform = 'scale(1)'; }
        
        const srcEl = document.getElementById(`src-${type}`);
        if(srcEl) { srcEl.style.opacity = '1'; srcEl.style.transform = 'scale(1)'; }
    }

    function drop(e, zoneType) {
        e.preventDefault(); e.stopPropagation(); 
        e.currentTarget.classList.remove('drag-over');
        e.currentTarget.style.backgroundColor = '';
        
        const draggedType = currentlyDragging || e.dataTransfer.getData('text/plain');
        if(!draggedType) return;
        
        const expectedStep = steps[currentStepIndex];
        resetDragStyle(draggedType);

        if(draggedType !== expectedStep.id) {
            showAlert('Salah Komponen!', `Langkah salah. Silakan pasang ${expectedStep.name} terlebih dahulu.`, 'red');
        } else if (draggedType === expectedStep.id && draggedType !== zoneType) {
            showAlert('Salah Penempatan!', `Ini adalah slot untuk komponen lain!`, 'orange');
        } else if(draggedType === zoneType && draggedType === expectedStep.id) {
            installComponent(draggedType, expectedStep);
        }
        currentlyDragging = null;
    }

    function installComponent(type, stepData) {
        // Inventory state
        const itemEl = document.getElementById(`item-${type}`);
        itemEl.className = 'inventory-item installed';
        itemEl.draggable = false;
        document.getElementById(`desc-${type}`).innerHTML = '<span class="text-green-400">Terpasang!</span>';

        // Zone Visual Update
        const zone = document.getElementById(`zone-${type}`);
        if(zone) {
            const label = zone.querySelector('.zone-label');
            if(label) label.classList.add('hidden');
            zone.classList.remove('border-dashed', `bg-${stepData.color}-500/10`, 'border-2');
            zone.classList.add('border-0');
            if(stepData.type.includes('click')) zone.classList.add('hidden');
        }
        
        // Hide cable source if any
        const src = document.getElementById(`src-${type}`);
        if(src) src.classList.add('hidden');

        // Show Visuals
        const visual = document.getElementById(`visual-${type}`);
        if(visual) visual.classList.remove('hidden');
        const visualPort = document.getElementById(`visual-${type}-port`);
        if(visualPort) visualPort.classList.remove('hidden');
        
        // Specific Adjustments
        if(type === 'paste') { if(zone) zone.classList.add('hidden'); }
        if(type === 'cooler') { document.getElementById('zone-cpu').style.zIndex = '10'; }
        if(type === 'gpu') { document.getElementById('zone-pcie').classList.remove('hidden'); } // Ensure port is ready for cable

        lucide.createIcons();
        showAlert(`${stepData.name} Selesai`, `Lanjut ke tahap berikutnya.`, stepData.color);
        
        currentStepIndex++;
        updateStepUI();
    }

    function resetSimulation() { location.reload(); }
    
    function undoStep() {
        if (currentStepIndex <= 0) return; // Nothing to undo
        
        // Remove success styles from PC case if it was fully finished
        if (currentStepIndex >= steps.length) {
            document.getElementById('pc-case').classList.remove('shadow-[0_0_80px_rgba(34,197,94,0.4)]', 'border-green-500/50');
        }

        currentStepIndex--;
        const stepData = steps[currentStepIndex];
        const type = stepData.id;

        // Revert Inventory state
        const itemEl = document.getElementById(`item-${type}`);
        itemEl.className = 'inventory-item unlocked';

        // Revert Zone Visual Update
        const zone = document.getElementById(`zone-${type}`);
        if(zone) {
            const label = zone.querySelector('.zone-label');
            if(label) label.classList.remove('hidden');
            zone.classList.add('border-dashed', `bg-${stepData.color}-500/10`, 'border-2');
            zone.classList.remove('border-0');
            if(stepData.type.includes('click')) zone.classList.remove('hidden');
        }
        
        // Hide Visuals
        const visual = document.getElementById(`visual-${type}`);
        if(visual) visual.classList.add('hidden');
        const visualPort = document.getElementById(`visual-${type}-port`);
        if(visualPort) visualPort.classList.add('hidden');
        
        // Revert Specific Adjustments
        if(type === 'paste') { if(zone) zone.classList.remove('hidden'); }
        if(type === 'cooler') { document.getElementById('zone-cpu').style.zIndex = '30'; }
        if(type === 'gpu') { document.getElementById('zone-pcie').classList.add('hidden'); }

        // Revert handleManualClick specific classes
        if(stepData.type === 'click-single') {
            let elId = '';
            if(type === 'cpu-lock') elId = 'cpu-lever-handle';
            if(type === 'ssd-screw') elId = 'ssd-screw-1';
            
            if(elId) {
                const el = document.getElementById(elId);
                el.classList.add('animate-pulse', 'border-red-500', 'bg-red-500/20');
                el.classList.remove('bg-green-500/50', 'border-green-500');
                
                if(type === 'cpu-lock') {
                    document.getElementById('visual-cpu-lock').style.transform = '';
                }
                if(type === 'ssd-screw') {
                    el.innerHTML = '<i data-lucide="target" class="w-3 h-3 text-red-500"></i>';
                    document.getElementById('visual-ssd').style.transform = 'rotate(12deg)'; 
                }
            }
        } else if (stepData.type === 'click-multi') {
            if (type === 'screws') {
                for(let i=1; i<=4; i++) revertMultiClick('screw-'+i, 'target', 4);
            }
            if (type === 'ram-lock') {
                for(let i=1; i<=2; i++) revertMultiClick('ram-clip-'+i, 'lock', 3);
            }
            clicksDone = 0; // Reset clicks
        }

        // Lock the next step's inventory item that was unlocked
        const nextStep = steps[currentStepIndex + 1];
        if (nextStep) {
            const nextItemEl = document.getElementById(`item-${nextStep.id}`);
            if (nextItemEl) {
                nextItemEl.className = 'inventory-item locked';
                nextItemEl.draggable = false;
                document.getElementById(`desc-${nextStep.id}`).innerHTML = '<span>Terkunci</span>';
                
                // Remove specific styles applied by updateStepUI
                nextItemEl.classList.remove(`border-${nextStep.color}-500`, `bg-${nextStep.color}-500/20`, `shadow-[0_0_15px_var(--color-${nextStep.color}-500)]`);
                const iconBox = nextItemEl.querySelector('.icon-box');
                iconBox.classList.remove(`border-${nextStep.color}-500`, `shadow-[0_0_10px_var(--color-${nextStep.color}-500)]`);
                const titleEl = nextItemEl.querySelector('.item-title');
                titleEl.classList.remove(`text-${nextStep.color}-400`);

                // Hide its zones if needed
                const nextZone = document.getElementById(`zone-${nextStep.id}`);
                if (nextZone && nextStep.type !== 'click-multi' && nextStep.type !== 'click-single') {
                    nextZone.classList.add('hidden');
                }
                const nextSrc = document.getElementById(`src-${nextStep.id}`);
                if (nextSrc) {
                    nextSrc.classList.add('hidden');
                    nextSrc.classList.remove('flex');
                }
            }
        }

        lucide.createIcons();
        updateStepUI();
        showAlert('Undo Berhasil', `Langkah dikembalikan.`, 'yellow');
    }

    function revertMultiClick(id, iconName, iconSize) {
        const el = document.getElementById(id);
        if(el) {
            el.classList.remove('clicked', 'bg-slate-400');
            el.classList.add('animate-pulse', 'border-red-500', 'bg-red-500/20');
            el.innerHTML = `<i data-lucide="${iconName}" class="w-${iconSize} h-${iconSize} text-red-500"></i>`;
        }
    }
    
    // --- FULLSCREEN TOGGLE ---
    function toggleFullScreen() {
        // Fokuskan fullscreen ke area kerja simulasi saja agar melebar penuh!
        const simContainer = document.getElementById('sim-workspace') || document.documentElement;
        if (!document.fullscreenElement) {
            simContainer.requestFullscreen().catch(e => console.error(e));
        } else {
            document.exitFullscreen();
        }
    }

    document.addEventListener('fullscreenchange', () => {
        const fsBtnIcon = document.querySelector('#fs-btn i');
        if (fsBtnIcon) {
            if (document.fullscreenElement) fsBtnIcon.setAttribute('data-lucide', 'minimize');
            else fsBtnIcon.setAttribute('data-lucide', 'maximize');
            lucide.createIcons();
        }
    });

    // --- RESPONSIVE SCALING ENGINE ---
    function resizeCanvas() {
        const wrapper = document.getElementById('case-wrapper');
        const caseEl = document.getElementById('pc-case');
        const container = document.getElementById('canvas-container');
        
        if (!wrapper || !caseEl || !container) return;

        const containerStyle = window.getComputedStyle(container);
        const paddingLeft = parseFloat(containerStyle.paddingLeft);
        const paddingRight = parseFloat(containerStyle.paddingRight);
        const paddingTop = parseFloat(containerStyle.paddingTop);
        const paddingBottom = parseFloat(containerStyle.paddingBottom);
        
        const availableWidth = container.clientWidth - paddingLeft - paddingRight;
        // Gunakan clientHeight kontainer agar menempel presisi di atas dan bawah
        let availableHeight = container.clientHeight - paddingTop - paddingBottom;
        
        // Jika kontainer terlalu pendek di awal muat, paksa ukuran minimum
        if (availableHeight < 300) availableHeight = 400;
        
        // Ukuran asli casing (tetap)
        const originalWidth = 800;
        const originalHeight = 700;
        
        // Kalkulasi skala
        const scaleWidth = availableWidth / originalWidth;
        const scaleHeight = availableHeight / originalHeight;
        
        // Ambil skala terkecil agar muat sempurna di dalam kontainer tanpa scroll
        let scale = Math.min(scaleWidth, scaleHeight);
        
        // Batas wajar
        if (scale < 0.2) scale = 0.2;
        if (scale > 2.5) scale = 2.5;
        
        caseEl.style.transform = `scale(${scale})`;
        
        // Sesuaikan ukuran wrapper pembungkus secara pasti
        wrapper.style.height = `${originalHeight * scale}px`;
        wrapper.style.width = `${originalWidth * scale}px`;
    }

    window.addEventListener('resize', resizeCanvas);

    // Mulai UI
    initUI();
    // Tunggu DOM sedikit, lalu terapkan scaling awal
    setTimeout(resizeCanvas, 50);
</script>
@endpush
@endsection
