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
            document.getElementById('status-container').classList.add('hidden');
            const pwrBtn = document.getElementById('btn-power-on');
            if (pwrBtn) pwrBtn.classList.remove('hidden');
            
            document.getElementById('pc-case').classList.add('shadow-[0_0_80px_rgba(34,197,94,0.4)]', 'border-green-500/50');
            showAlert('Sukses!', 'PC berhasil dirakit sepenuhnya. Klik POWER ON untuk menyalakan.', 'green');
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
    
    // --- BOOT SEQUENCE & BENCHMARK ---
    function startBootSequence() {
        document.getElementById('monitor-modal').classList.remove('hidden');
        const bootText = document.getElementById('boot-text');
        bootText.innerHTML = '';
        
        const sequence = [
            "American Megatrends Inc.",
            "BIOS Date 05/25/2026 10:32:11 Ver 09.00.02",
            "CPU: Intel(R) Core(TM) i7-13700K CPU @ 3.40GHz",
            "Speed: 3.40 GHz",
            "Memory: 32768 MB (DDR5 6000MHz)",
            "",
            "Initializing USB Controllers .. Done.",
            "Detecting NVMe M.2 980 PRO 1TB .. Done.",
            "Auto-detecting GPU RTX 4090 .. Done.",
            "",
            "Checking NVRAM...",
            "Update OK!",
            "Booting from Hard Disk..."
        ];

        let i = 0;
        const typeInterval = setInterval(() => {
            if (i < sequence.length) {
                bootText.innerHTML += sequence[i] + "<br/>";
                i++;
            } else {
                clearInterval(typeInterval);
                setTimeout(() => {
                    bootText.innerHTML = '';
                    showOS();
                }, 1000);
            }
        }, 300);
    }

    function showOS() {
        document.getElementById('os-screen').classList.remove('hidden');
        
        // Random benchmark values
        document.getElementById('bench-fps').innerText = Math.floor(Math.random() * (165 - 120 + 1) + 120);
        document.getElementById('bench-temp').innerText = Math.floor(Math.random() * (75 - 60 + 1) + 60);
    }

    // --- AI CHATBOT LOGIC ---
    function toggleChat() {
        const chatWindow = document.getElementById('ai-chat-window');
        if (chatWindow.classList.contains('hidden')) {
            chatWindow.classList.remove('hidden');
            // Give a tiny delay for transition to work if scale-95 opacity-0 is applied
            setTimeout(() => {
                chatWindow.classList.remove('scale-95', 'opacity-0');
                chatWindow.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.getElementById('chat-input').focus();
        } else {
            chatWindow.classList.remove('scale-100', 'opacity-100');
            chatWindow.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                chatWindow.classList.add('hidden');
            }, 300);
        }
    }

    function appendMessage(sender, text) {
        const chatMessages = document.getElementById('chat-messages');
        const isUser = sender === 'user';
        const bg = isUser ? 'bg-cyan-600 text-white' : 'bg-slate-800 text-slate-200 border border-slate-700';
        const rounded = isUser ? 'rounded-2xl rounded-tr-sm' : 'rounded-2xl rounded-tl-sm';
        const align = isUser ? 'justify-end' : 'justify-start';
        
        let iconHtml = '';
        if (!isUser) {
            iconHtml = `<div class="w-6 h-6 rounded-full bg-cyan-600 flex-shrink-0 flex items-center justify-center mt-1">
                            <i data-lucide="bot" class="w-3 h-3 text-white"></i>
                        </div>`;
        }

        const msgHtml = `
            <div class="flex gap-2 w-full ${align}">
                ${!isUser ? iconHtml : ''}
                <div class="${bg} p-3 ${rounded} max-w-[80%]">
                    ${text}
                </div>
            </div>
        `;
        
        chatMessages.insertAdjacentHTML('beforeend', msgHtml);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        lucide.createIcons();
    }

    async function sendChatMessage(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;
        
        // Show user message
        appendMessage('user', text);
        input.value = '';
        
        // Show typing indicator
        const indicator = document.getElementById('typing-indicator');
        const chatMessages = document.getElementById('chat-messages');
        indicator.classList.remove('hidden');
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        try {
            const token = document.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ message: text })
            });
            
            const data = await response.json();
            indicator.classList.add('hidden');
            
            if (response.ok) {
                appendMessage('ai', data.reply);
            } else {
                appendMessage('ai', 'Maaf, terjadi kesalahan saat menghubungi server AI.');
            }
        } catch (error) {
            console.error(error);
            indicator.classList.add('hidden');
            appendMessage('ai', 'Maaf, gagal terhubung ke server.');
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
// Make functions globally available for inline HTML handlers
window.autoInstall = autoInstall;
window.undoStep = undoStep;
window.toggleFullScreen = toggleFullScreen;
window.dragStart = dragStart;
window.dragEnd = dragEnd;
window.allowDropGlobal = allowDropGlobal;
window.dropGlobal = dropGlobal;
window.allowDrop = allowDrop;
window.dragEnter = dragEnter;
window.dragLeave = dragLeave;
window.drop = drop;
window.handleManualClick = handleManualClick;
window.startBootSequence = startBootSequence;
window.toggleChat = toggleChat;
window.sendChatMessage = sendChatMessage;
