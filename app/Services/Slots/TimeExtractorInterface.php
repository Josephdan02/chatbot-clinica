<?php

namespace App\Services\Slots;

interface TimeExtractorInterface
{
    public function extract(string $message): ?string;
}
