<?php

namespace App\Http\Controllers;

use App\Services\RagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $ragService;

    public function __construct(RagService $ragService)
    {
        $this->ragService = $ragService;
    }

    /**
     * Menangani request AJAX dari web widget.
     */
    public function handle(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        try {
            $userMessage = $request->input('message');
            
            // Panggil layanan RAG untuk mendapatkan jawaban dari LLM
            $reply = $this->ragService->askChatbot($userMessage);

            return response()->json([
                'success' => true,
                'reply' => $reply
            ]);

        } catch (\Exception $e) {
            Log::error('ChatbotController Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => 'Maaf, terjadi kesalahan di sisi server kami.'
            ], 500);
        }
    }
}
