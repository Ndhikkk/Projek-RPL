<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function handle(Request $request)
    {
        $message = $request->input('message', '');
        
        if (empty($message)) {
            return response()->json(['reply' => 'Pesan tidak boleh kosong.']);
        }

        $apiKey = env('GEMINI_API_KEY');

        // Jika API Key tidak ada, gunakan balasan simulasi
        if (!$apiKey) {
            return $this->simulatedReply($message);
        }

        try {
            $cleanApiKey = trim($apiKey);
            
            // Auto-discovery model dari Google untuk menghindari error 404
            $modelName = 'gemini-1.5-flash'; // default fallback
            $modelsResponse = Http::withHeaders([
                'x-goog-api-key' => $cleanApiKey,
            ])->get("https://generativelanguage.googleapis.com/v1beta/models");
            
            if ($modelsResponse->successful()) {
                $modelsData = $modelsResponse->json();
                $availableModels = [];
                foreach ($modelsData['models'] ?? [] as $m) {
                    if (in_array('generateContent', $m['supportedGenerationMethods'] ?? [])) {
                        $availableModels[] = str_replace('models/', '', $m['name']);
                    }
                }
                
                if (!empty($availableModels)) {
                    // Cari model yang mengandung kata 'flash' atau 'pro', jika tidak ada, gunakan yang pertama
                    $selectedModel = $availableModels[0];
                    foreach ($availableModels as $am) {
                        if (str_contains($am, 'flash') || str_contains($am, 'pro')) {
                            $selectedModel = $am;
                            break;
                        }
                    }
                    $modelName = $selectedModel;
                }
            } else {
                return response()->json([
                    'reply' => "ERROR FETCH MODELS: HTTP " . $modelsResponse->status() . " - " . $modelsResponse->body()
                ]);
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $cleanApiKey,
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Anda adalah Asisten AI bernama RakitKuy, ahli dalam merakit PC dan hardware komputer. Berikan jawaban yang ramah, informatif, singkat (maks 2-3 paragraf) dan jelas mengenai pertanyaan berikut: " . $message]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa memproses jawaban saat ini.';
                
                // Konversi markdown sederhana ke HTML (Bold)
                $reply = preg_replace('/(\*\*|__)(.*?)\1/', '<b>$2</b>', $reply);
                
                // Tambahkan info model di akhir pesan
                $reply .= "\n\n<div class='mt-3 pt-2 border-t border-slate-700/50 text-[10px] text-slate-500 text-right'>Model: {$modelName}</div>";
                
                return response()->json([
                    'reply' => nl2br($reply) 
                ]);
            } else {
                return response()->json([
                    'reply' => "ERROR DARI GOOGLE: HTTP " . $response->status() . " - " . $response->body()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'reply' => "ERROR SERVER RAILWAY: " . $e->getMessage()
            ]);
        }
    }

    private function simulatedReply($message)
    {
        $messageStr = strtolower($message);
        
        $reply = "Maaf, saya kurang mengerti. Bisa diulangi pertanyaannya seputar rakit PC?";
        
        if (str_contains($messageStr, 'cpu') || str_contains($messageStr, 'prosesor') || str_contains($messageStr, 'processor')) {
            $reply = "CPU (Central Processing Unit) adalah otak dari komputer. Komponen ini bertanggung jawab untuk memproses semua instruksi dan kalkulasi. Pastikan memilih pendingin (cooler) yang tepat agar CPU tidak overheat!";
        } elseif (str_contains($messageStr, 'ram') || str_contains($messageStr, 'memori')) {
            $reply = "RAM (Random Access Memory) berfungsi untuk menyimpan data sementara dari program yang sedang berjalan. Semakin besar RAM, semakin banyak aplikasi yang bisa kamu buka secara bersamaan tanpa lag.";
        } elseif (str_contains($messageStr, 'gpu') || str_contains($messageStr, 'vga')) {
            $reply = "GPU (Graphics Processing Unit) sangat penting untuk gaming dan editing video. Komponen ini merender gambar dan grafik agar tampil mulus di monitor.";
        } elseif (str_contains($messageStr, 'motherboard') || str_contains($messageStr, 'mobo')) {
            $reply = "Motherboard adalah papan sirkuit utama tempat semua komponen terhubung. Saat memilih motherboard, pastikan 'socket' prosesornya cocok dengan CPU pilihanmu!";
        } elseif (str_contains($messageStr, 'psu') || str_contains($messageStr, 'power supply')) {
            $reply = "Power Supply Unit (PSU) menyuplai listrik ke seluruh komponen. Jangan pernah menggunakan PSU murahan atau abal-abal, karena bisa merusak seluruh isi PC-mu!";
        } elseif (str_contains($messageStr, 'ssd') || str_contains($messageStr, 'hdd') || str_contains($messageStr, 'penyimpanan')) {
            $reply = "SSD (Solid State Drive) jauh lebih cepat daripada HDD biasa. SSD M.2 NVMe yang dipasang di motherboard bisa mentransfer data hingga ribuan MB per detik!";
        } elseif (str_contains($messageStr, 'thermal paste') || str_contains($messageStr, 'pasta')) {
            $reply = "Thermal paste berfungsi mengisi celah mikroskopis antara CPU dan pendingin (cooler). Tanpa thermal paste, penyaluran panas tidak optimal dan CPU bisa overheat seketika.";
        } elseif (str_contains($messageStr, 'halo') || str_contains($messageStr, 'hai') || str_contains($messageStr, 'hello')) {
            $reply = "Halo! Saya Asisten AI RakitKuy. Ada pertanyaan tentang merakit PC atau spesifikasi hardware? Tanyakan saja pada saya!";
        } elseif (str_contains($messageStr, 'terima kasih') || str_contains($messageStr, 'makasih')) {
            $reply = "Sama-sama! Senang bisa membantu. Selamat merakit PC!";
        }

        // Tambahkan peringatan jika API Key belum dipasang
        if (!env('GEMINI_API_KEY')) {
             $reply = "*(Mode Simulasi - API Key Gemini belum diatur di .env)*\n\n" . $reply;
        }

        // Simulasi delay layaknya AI berpikir
        sleep(1);

        return response()->json([
            'reply' => nl2br($reply)
        ]);
    }
}
