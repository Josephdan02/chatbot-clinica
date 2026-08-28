<?php

namespace App\Services\External\AI;

interface AIServiceInterface
{
    /** @param array<int, array{sender: string, message: string}> $history */
    public function generateReply(string $message, array $history = []): string;
}
