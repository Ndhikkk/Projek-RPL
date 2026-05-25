@extends('layouts.app')

@section('title', 'Kuis Evaluasi - RakitKuy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-5rem)] flex flex-col transition-all duration-500">
    
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shrink-0">
        <div>
            <h1 class="text-3xl font-extrabold text-white flex items-center gap-3">
                <i data-lucide="award" class="w-8 h-8 text-pink-400"></i> Kuis Evaluasi
            </h1>
            <p class="text-slate-400 text-sm mt-1 max-w-3xl">
                Uji pemahaman Anda melalui kuis interaktif yang menantang dan dapatkan skor untuk mengukur kemampuan.
            </p>
        </div>
    </div>

    <!-- Quiz Wrapper -->
    <div class="flex-grow flex items-center justify-center min-h-0 pb-4">
        <!-- Quiz Container -->
        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl relative w-full max-w-4xl max-h-full flex flex-col" id="quiz-container">
            <!-- Progress Bar -->
            <div class="h-2 w-full bg-slate-800 shrink-0">
                <div id="progress-bar" class="h-full bg-gradient-to-r from-cyan-400 to-purple-500 w-[0%] transition-all duration-500 rounded-r-full shadow-[0_0_10px_rgba(0,240,255,0.5)]"></div>
            </div>

            <div class="p-6 md:p-8 flex-grow overflow-y-auto custom-scrollbar flex flex-col">
            <!-- Header Quiz -->
            <div id="quiz-header" class="flex justify-between items-center mb-8">
                <span class="px-3 py-1 bg-slate-800 text-slate-300 text-sm font-semibold rounded-full border border-slate-700">
                    Pertanyaan <span id="current-question-num">1</span> / <span id="total-question-num">5</span>
                </span>
                <span class="flex items-center gap-2 text-cyan-400 font-bold" id="timer-display">
                    <i data-lucide="timer" class="w-5 h-5"></i> 10:00
                </span>
            </div>

            <!-- Question Area -->
            <div id="question-area" class="animate-fade-in">
                <h2 id="question-text" class="text-2xl md:text-3xl font-bold text-white leading-tight mb-4">
                    Memuat pertanyaan...
                </h2>
                <div class="w-16 h-1 bg-cyan-500 rounded-full mb-8"></div>
                
                <!-- Options -->
                <div id="options-container" class="space-y-4">
                    <!-- Options will be injected by JS -->
                </div>
            </div>

            <!-- Result Area (Hidden initially) -->
            <div id="result-area" class="hidden text-center py-10 animate-fade-in">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-cyan-500/20 text-cyan-400 mb-6">
                    <i data-lucide="award" class="w-12 h-12"></i>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Kuis Selesai!</h2>
                <p class="text-slate-400 mb-6">Berikut adalah skor akhir Anda:</p>
                <div class="text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-500 mb-8" id="final-score">
                    100
                </div>
                <button onclick="restartQuiz()" class="px-8 py-3 glass border-cyan-500/50 hover:bg-cyan-500/20 text-cyan-400 font-bold rounded-full transition-all">
                    Ulangi Kuis
                </button>
            </div>

            <!-- Actions -->
            <div id="quiz-actions" class="flex justify-between items-center pt-6 border-t border-white/10 mt-auto shrink-0">
                <button id="btn-prev" onclick="prevQuestion()" class="px-6 py-3 rounded-full text-slate-500 font-medium hover:text-white hover:bg-slate-800 transition-colors flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Sebelumnya
                </button>
                <button id="btn-next" onclick="nextQuestion()" class="px-8 py-3 bg-cyan-500 hover:bg-cyan-400 text-slate-900 font-bold rounded-full transition-all shadow-[0_0_15px_rgba(0,240,255,0.3)] hover:shadow-[0_0_25px_rgba(0,240,255,0.5)] flex items-center gap-2">
                    Selanjutnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .correct-answer {
        border-color: #22c55e !important;
        background-color: rgba(34, 197, 94, 0.1) !important;
    }
    .correct-badge {
        background-color: #22c55e !important;
        border-color: #22c55e !important;
        color: white !important;
    }
    .wrong-answer {
        border-color: #ef4444 !important;
        background-color: rgba(239, 68, 68, 0.1) !important;
    }
    .wrong-badge {
        background-color: #ef4444 !important;
        border-color: #ef4444 !important;
        color: white !important;
    }
</style>

<script>
    const questions = [
        {
            text: "Komponen manakah yang berfungsi sebagai otak utama dari sebuah komputer untuk memproses instruksi?",
            options: ["RAM (Random Access Memory)", "Motherboard", "CPU (Central Processing Unit)", "GPU (Graphics Processing Unit)"],
            correctIndex: 2
        },
        {
            text: "Apakah fungsi utama dari Power Supply Unit (PSU) dalam perakitan PC?",
            options: ["Mendinginkan suhu CPU", "Menyediakan dan membagi arus listrik ke komponen", "Menyimpan data secara permanen", "Mengolah grafis untuk monitor"],
            correctIndex: 1
        },
        {
            text: "Media penyimpanan manakah yang saat ini memiliki kecepatan baca/tulis paling tinggi?",
            options: ["Hard Disk Drive (HDD)", "SSD SATA", "SSD NVMe M.2", "Flashdisk USB 2.0"],
            correctIndex: 2
        },
        {
            text: "Apa nama pasta yang harus dioleskan antara CPU dan heatsink fan?",
            options: ["Thermal Paste", "Silicon Glue", "Super Glue", "Cooling Gel"],
            correctIndex: 0
        },
        {
            text: "Jika komputer berbunyi 'beep' berulang kali dan tidak menampilkan gambar saat dinyalakan, komponen mana yang paling mungkin bermasalah?",
            options: ["Hardisk", "RAM", "Power Supply", "Casing"],
            correctIndex: 1
        },
        {
            text: "Kabel 24-pin ATX dari Power Supply harus dihubungkan ke mana?",
            options: ["VGA Card", "Motherboard", "Processor", "Hard Disk"],
            correctIndex: 1
        },
        {
            text: "Kabel Front Panel pada casing berfungsi untuk...",
            options: ["Menghidupkan tombol Power dan Reset di casing", "Menghubungkan monitor ke PC", "Menambah kecepatan kipas", "Mengatur cahaya RGB otomatis"],
            correctIndex: 0
        },
        {
            text: "Mengapa memasang CPU Cooler (Pendingin) sangat krusial?",
            options: ["Agar PC terlihat bagus", "Mencegah CPU mengalami overheat dan mati (Thermal Trip)", "Menambah kecepatan RAM", "Agar listrik yang digunakan menjadi hemat"],
            correctIndex: 1
        },
        {
            text: "Kabel 8-pin EPS dari Power Supply khusus ditujukan untuk mensuplai daya ke...",
            options: ["VGA Card (GPU)", "RAM", "Motherboard (untuk CPU)", "Kipas Casing"],
            correctIndex: 2
        },
        {
            text: "Apa nama tempat atau dudukan pada Motherboard yang digunakan untuk memasang Processor?",
            options: ["Slot DIMM", "Slot PCIe", "SATA Port", "Socket CPU"],
            correctIndex: 3
        }
    ];

    let currentQuestionIndex = 0;
    let selectedAnswers = new Array(questions.length).fill(null);
    let isRevealed = new Array(questions.length).fill(false); // To track if answer was checked
    let score = 0;
    
    // Timer setup (10 minutes = 600 seconds)
    const TOTAL_TIME = 600;
    let timeLeft = TOTAL_TIME;
    let timerInterval = null;
    let endTime = null;
    let isQuizFinished = false;

    const questionTextEl = document.getElementById('question-text');
    const optionsContainerEl = document.getElementById('options-container');
    const currentQNumEl = document.getElementById('current-question-num');
    const totalQNumEl = document.getElementById('total-question-num');
    const progressBarEl = document.getElementById('progress-bar');
    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    const timerDisplayEl = document.getElementById('timer-display');
    
    // Save state to localStorage
    function saveState() {
        const state = {
            currentQuestionIndex,
            selectedAnswers,
            isRevealed,
            score,
            timeLeft,
            isQuizFinished
        };
        localStorage.setItem('rakitkuy_quiz_state', JSON.stringify(state));
    }

    // Load state from localStorage
    function loadState() {
        const saved = localStorage.getItem('rakitkuy_quiz_state');
        if (saved) {
            try {
                const state = JSON.parse(saved);
                // Validate arrays length in case questions changed
                if (state.selectedAnswers && state.selectedAnswers.length === questions.length) {
                    currentQuestionIndex = state.currentQuestionIndex;
                    selectedAnswers = state.selectedAnswers;
                    isRevealed = state.isRevealed;
                    score = state.score;
                    isQuizFinished = state.isQuizFinished;
                    
                    if (state.timeLeft !== undefined) {
                        timeLeft = state.timeLeft;
                        endTime = Date.now() + (timeLeft * 1000);
                    }
                    return true;
                }
            } catch (e) {
                console.error("Failed to parse quiz state", e);
            }
        }
        return false;
    }

    // Init
    totalQNumEl.innerText = questions.length;
    
    if (loadState()) {
        if (isQuizFinished || timeLeft <= 0) {
            finishQuiz(true); // true = skip saving state again inside finishQuiz if we just loaded it
        } else {
            startTimer();
            renderQuestion();
        }
    } else {
        // Fresh start
        endTime = Date.now() + (TOTAL_TIME * 1000);
        saveState();
        startTimer();
        renderQuestion();
    }

    function startTimer() {
        clearInterval(timerInterval);
        
        // Immediate check
        if (timeLeft <= 0) {
            finishQuiz();
            return;
        }
        
        timerInterval = setInterval(() => {
            timeLeft = Math.round((endTime - Date.now()) / 1000);
            if (timeLeft <= 0) {
                timeLeft = 0;
                clearInterval(timerInterval);
                finishQuiz();
                return;
            }
            // Save state every second to keep timeLeft updated for navigation
            saveState();
            updateTimerDisplay();
        }, 1000);
    }

    // Pause timer when switching browser tabs
    document.addEventListener("visibilitychange", () => {
        if (isQuizFinished) return;
        
        if (document.hidden) {
            // Pause
            clearInterval(timerInterval);
        } else {
            // Resume
            endTime = Date.now() + (timeLeft * 1000);
            startTimer();
        }
    });

    function updateTimerDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        let displayColor = 'text-cyan-400';
        if (timeLeft <= 60) displayColor = 'text-red-500 animate-pulse'; // Less than 1 min left

        timerDisplayEl.className = `flex items-center gap-2 font-bold ${displayColor}`;
        timerDisplayEl.innerHTML = `<i data-lucide="timer" class="w-5 h-5"></i> ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        lucide.createIcons();
    }

    function renderQuestion() {
        const q = questions[currentQuestionIndex];
        questionTextEl.innerText = q.text;
        currentQNumEl.innerText = currentQuestionIndex + 1;
        
        // Update Progress
        const progress = ((currentQuestionIndex) / questions.length) * 100;
        progressBarEl.style.width = progress + '%';

        // Update Prev Button State
        btnPrev.disabled = currentQuestionIndex === 0;

        // Render Options
        optionsContainerEl.innerHTML = '';
        const letters = ['A', 'B', 'C', 'D'];
        
        q.options.forEach((opt, index) => {
            const isSelected = selectedAnswers[currentQuestionIndex] === index;
            const revealed = isRevealed[currentQuestionIndex];
            
            let extraClass = 'border-slate-700 bg-slate-800/50 hover:bg-slate-700/50 hover:border-cyan-500/50 cursor-pointer';
            let badgeClass = 'border-slate-600 text-slate-400 group-hover:border-cyan-500/50';
            let textClass = 'text-slate-200';

            // Styling if already selected and revealed
            if (revealed) {
                extraClass = 'border-slate-700 bg-slate-800/50 cursor-not-allowed opacity-70';
                
                if (index === q.correctIndex) {
                    extraClass = 'correct-answer';
                    badgeClass = 'correct-badge';
                    textClass = 'text-white font-medium';
                } else if (isSelected && index !== q.correctIndex) {
                    extraClass = 'wrong-answer';
                    badgeClass = 'wrong-badge';
                    textClass = 'text-white font-medium';
                }
            } else if (isSelected) {
                badgeClass = 'bg-cyan-500 border-cyan-500 text-white';
                textClass = 'text-white font-medium';
            }

            const optHtml = `
                <label class="block relative border rounded-xl p-5 transition-all group ${extraClass}">
                    <input type="radio" name="answer" value="${index}" class="hidden" 
                        onchange="selectOption(${index})" 
                        ${isSelected ? 'checked' : ''}
                        ${revealed ? 'disabled' : ''}>
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center font-bold transition-colors ${badgeClass}">
                            ${letters[index]}
                        </div>
                        <span class="text-lg ${textClass}">${opt}</span>
                    </div>
                </label>
            `;
            optionsContainerEl.insertAdjacentHTML('beforeend', optHtml);
        });

        // Change Next button text on last question
        if (currentQuestionIndex === questions.length - 1) {
            btnNext.innerHTML = `Selesai <i data-lucide="check" class="w-4 h-4"></i>`;
        } else {
            btnNext.innerHTML = `Selanjutnya <i data-lucide="arrow-right" class="w-4 h-4"></i>`;
        }
        lucide.createIcons();
    }

    function selectOption(index) {
        if (!isRevealed[currentQuestionIndex]) {
            selectedAnswers[currentQuestionIndex] = index;
            saveState();
            renderQuestion();
        }
    }

    function checkAnswerAndProceed() {
        // If not answered yet
        if (selectedAnswers[currentQuestionIndex] === null) {
            alert("Pilih jawaban terlebih dahulu!");
            return;
        }

        // If not revealed yet, reveal it and stay on same page to show result
        if (!isRevealed[currentQuestionIndex]) {
            isRevealed[currentQuestionIndex] = true;
            
            // Calculate score
            if (selectedAnswers[currentQuestionIndex] === questions[currentQuestionIndex].correctIndex) {
                score += (100 / questions.length); 
            }
            
            saveState();
            renderQuestion();
            
            // Re-render Next button to say "Lanjut"
            if (currentQuestionIndex === questions.length - 1) {
                btnNext.innerHTML = `Lihat Hasil <i data-lucide="award" class="w-4 h-4"></i>`;
            } else {
                btnNext.innerHTML = `Lanjut <i data-lucide="arrow-right" class="w-4 h-4"></i>`;
            }
            lucide.createIcons();
            return;
        }

        // If already revealed, move to next
        if (currentQuestionIndex < questions.length - 1) {
            currentQuestionIndex++;
            renderQuestion();
        } else {
            finishQuiz();
        }
    }

    function nextQuestion() {
        checkAnswerAndProceed();
    }

    function prevQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            renderQuestion();
        }
    }

    function finishQuiz(fromLoad = false) {
        isQuizFinished = true;
        clearInterval(timerInterval); // Stop timer
        
        if (!fromLoad) {
            saveState();
        }
        
        progressBarEl.style.width = '100%';
        document.getElementById('question-area').classList.add('hidden');
        document.getElementById('quiz-actions').classList.add('hidden');
        document.getElementById('quiz-header').classList.add('hidden');
        
        document.getElementById('result-area').classList.remove('hidden');
        document.getElementById('final-score').innerText = Math.round(score);
    }

    function restartQuiz() {
        currentQuestionIndex = 0;
        selectedAnswers = new Array(questions.length).fill(null);
        isRevealed = new Array(questions.length).fill(false);
        score = 0;
        isQuizFinished = false;
        
        // Reset timer
        endTime = Date.now() + (TOTAL_TIME * 1000);
        timeLeft = TOTAL_TIME;
        
        saveState();
        
        updateTimerDisplay();
        startTimer();
        
        document.getElementById('question-area').classList.remove('hidden');
        document.getElementById('quiz-actions').classList.remove('hidden');
        document.getElementById('quiz-header').classList.remove('hidden');
        
        document.getElementById('result-area').classList.add('hidden');
        
        renderQuestion();
    }
</script>
@endpush
@endsection
