<?php

namespace App\Services\Slots;

interface ServiceExtractorInterface
{
    public function extract(string $message): ?string;
}
