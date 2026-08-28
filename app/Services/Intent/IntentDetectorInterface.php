<?php

namespace App\Services\Intent;

use App\Enums\Intent;
use App\Models\Conversation;

interface IntentDetectorInterface
{
    public function detect(string $message, Conversation $conversation): Intent;
}
