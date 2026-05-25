<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function handle(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        
        $reply = "Maaf, saya kurang mengerti. Bisa diulangi pertanyaannya seputar rakit PC?";
        
        if (str_contains($message, 'cpu') || str_contains($message, 'prosesor') || str_contains($message, 'processor')) {
            $reply = "CPU (Central Processing Unit) adalah otak dari komputer. Komponen ini bertanggung jawab untuk memproses semua instruksi dan kalkulasi. Pastikan memilih pendingin (cooler) yang tepat agar CPU tidak overheat!";
        } elseif (str_contains($message, 'ram') || str_contains($message, 'memori')) {
            $reply = "RAM (Random Access Memory) berfungsi untuk menyimpan data sementara dari program yang sedang berjalan. Semakin besar RAM, semakin banyak aplikasi yang bisa kamu buka secara bersamaan tanpa lag.";
        } elseif (str_contains($message, 'gpu') || str_contains($message, 'vga')) {
            $reply = "GPU (Graphics Processing Unit) sangat penting untuk gaming dan editing video. Komponen ini merender gambar dan grafik agar tampil mulus di monitor.";
        } elseif (str_contains($message, 'motherboard') || str_contains($message, 'mobo')) {
            $reply = "Motherboard adalah papan sirkuit utama tempat semua komponen terhubung. Saat memilih motherboard, pastikan 'socket' prosesornya cocok dengan CPU pilihanmu!";
        } elseif (str_contains($message, 'psu') || str_contains($message, 'power supply')) {
            $reply = "Power Supply Unit (PSU) menyuplai listrik ke seluruh komponen. Jangan pernah menggunakan PSU murahan atau abal-abal, karena bisa merusak seluruh isi PC-mu!";
        } elseif (str_contains($message, 'ssd') || str_contains($message, 'hdd') || str_contains($message, 'penyimpanan')) {
            $reply = "SSD (Solid State Drive) jauh lebih cepat daripada HDD biasa. SSD M.2 NVMe yang dipasang di motherboard bisa mentransfer data hingga ribuan MB per detik!";
        } elseif (str_contains($message, 'thermal paste') || str_contains($message, 'pasta')) {
            $reply = "Thermal paste berfungsi mengisi celah mikroskopis antara CPU dan pendingin (cooler). Tanpa thermal paste, penyaluran panas tidak optimal dan CPU bisa overheat seketika.";
        } elseif (str_contains($message, 'halo') || str_contains($message, 'hai') || str_contains($message, 'hello')) {
            $reply = "Halo! Saya Asisten AI RakitKuy. Ada pertanyaan tentang merakit PC atau spesifikasi hardware? Tanyakan saja pada saya!";
        } elseif (str_contains($message, 'terima kasih') || str_contains($message, 'makasih')) {
            $reply = "Sama-sama! Senang bisa membantu. Selamat merakit PC!";
        }

        // Simulasi delay layaknya AI berpikir
        sleep(1);

        return response()->json([
            'reply' => $reply
        ]);
    }
}
