<?php

namespace App\Services\External\WhatsApp;

use Illuminate\Support\Facades\Log;

class MockWhatsAppService implements WhatsAppServiceInterface
{
    public function sendMessage(string $to, string $message): bool
    {
        Log::info('[MockWhatsAppService] Mensaje simulado enviado', ['to' => $to, 'message' => $message]);
        return true;
    }
}
