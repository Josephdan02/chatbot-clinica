<?php

namespace App\Services\Slots;

interface DateExtractorInterface
{
    public function extract(string $message): ?string;
}
