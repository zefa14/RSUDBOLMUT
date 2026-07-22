<?php

namespace App\Services;

use App\Models\DoctorSchedule;
use App\Models\Room;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RagService
{
    /**
     * Tentukan URL API Gemini
     */
    protected $geminiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    /**
     * Menerima pertanyaan pasien, menarik data dari database (RAG),
     * dan mengirimkan prompt ke Gemini AI.
     */
    public function askChatbot($userMessage)
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            return "Mohon maaf, sistem AI kami sedang dalam pemeliharaan (API Key belum dikonfigurasi). Silakan hubungi resepsionis kami.";
        }

        // 1. RETRIEVAL: Tarik data dari Database
        $context = $this->getHospitalContext();

        // 2. AUGMENT: Rangkai Prompt (System + Context + User Message)
        $currentTime = now()->setTimezone('Asia/Makassar')->format('d F Y, H:i:s'); // Bolmong Utara is in WITA (Asia/Makassar)
        $systemPrompt = "Anda adalah 'Asisten Virtual RSUD', customer service rumah sakit yang ramah, profesional, dan empatik. 
Anda membantu pasien menjawab pertanyaan mereka berdasarkan data jadwal dokter dan ketersediaan kamar.
Waktu saat ini adalah: {$currentTime} (WITA).
Jangan menjawab hal medis yang bersifat diagnosa/resep obat. Selalu arahkan ke pendaftaran poliklinik jika mereka sakit.
Jawab dengan ringkas dan sopan dalam bahasa Indonesia. Sesuaikan salam dengan waktu saat ini jika diperlukan.

=== DATA RUMAH SAKIT HARI INI ===
" . $context . "
=================================";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $systemPrompt . "\n\nPertanyaan Pasien: " . $userMessage]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.3, // Rendah agar tidak berhalusinasi, tetap fokus pada data RAG
                'maxOutputTokens' => 1024,
            ]
        ];

        try {
            // 3. GENERATION: Tembak ke API Gemini
            $response = Http::post($this->geminiUrl . '?key=' . $apiKey, $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }

            Log::error('Gemini API Error: ' . $response->body());
            return "Mohon maaf, saya sedang mengalami sedikit gangguan jaringan. Silakan coba lagi nanti.";

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return "Mohon maaf, sistem kami sedang sibuk. Silakan coba lagi nanti.";
        }
    }

    /**
     * Mengambil konteks database secara realtime.
     */
    private function getHospitalContext()
    {
        $context = "";

        // Tarik Jadwal Dokter (Semua jadwal dokter yang aktif saat ini)
        $schedules = DoctorSchedule::with(['doctor.department'])
            ->where('is_active', true)
            ->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $context .= "[Jadwal Praktik Dokter]\n";
        if ($schedules->isEmpty()) {
            $context .= "- Belum ada jadwal yang tersedia saat ini.\n";
        } else {
            foreach ($schedules as $schedule) {
                if (!$schedule->doctor) continue;
                $doctorName = $schedule->doctor->name;
                $poli = $schedule->doctor->department ? $schedule->doctor->department->name : 'Poli';
                $hari = $schedule->day_name;
                $context .= "- {$doctorName} ({$poli}) pada hari {$hari} jam {$schedule->start_time} - {$schedule->end_time}.\n";
            }
        }

        $context .= "\n[Ketersediaan Kamar Rawat Inap (Bed Management)]\n";
        // Tarik status ruangan
        $rooms = Room::all();
        if ($rooms->isEmpty()) {
            $context .= "- Belum ada data ruangan.\n";
        } else {
            foreach ($rooms as $room) {
                $price = number_format($room->price_per_night, 0, ',', '.');
                $context .= "- Ruang {$room->name} (Kelas {$room->room_class}): Tersedia {$room->available_beds} kasur kosong dari total {$room->total_beds}. Tarif: Rp {$price}/malam.\n";
            }
        }

        $context .= "\n[Informasi Umum RSUD Bolmong Utara]\n";
        $context .= "- Nama Direktur: drg. Firlia Mokoagow\n";
        $context .= "- Alamat: Jl. Trans Sulawesi, Bolaang Mongondow Utara\n";
        $context .= "- Moto: Melayani dengan Kasih Sayang\n";

        return $context;
    }
}
