<?php

namespace App\Services\External\WhatsApp;

interface WhatsAppServiceInterface
{
    public function sendMessage(string $to, string $message): bool;
}
