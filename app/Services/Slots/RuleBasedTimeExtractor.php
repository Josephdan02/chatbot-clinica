<?php

namespace App\Services\Slots;

use Illuminate\Support\Str;

class RuleBasedTimeExtractor implements TimeExtractorInterface
{
    public function extract(string $message): ?string
    {
        $normalized = Str::ascii(Str::lower(Str::squish($message)));
        $matches = [];

        if (preg_match_all('/(?<![\d:])(\d{1,2}):(\d{2})(?!\d)/', $normalized, $timeMatches, PREG_SET_ORDER) > 0) {
            foreach ($timeMatches as $match) {
                $matches[] = sprintf('%02d:%02d', (int) $match[1], (int) $match[2]);
            }
        }

        if (preg_match_all('/(?<![\d:])(\d{1,2})\s*(?:de\s+la\s+)?(am|pm|a\.m\.|p\.m\.)(?!\w)/', $normalized, $meridiemMatches, PREG_SET_ORDER) > 0) {
            foreach ($meridiemMatches as $match) {
                $hour = (int) $match[1];
                $meridiem = str_replace(['.', ' '], '', $match[2]);

                if ($hour >= 1 && $hour <= 12) {
                    if ($meridiem === 'pm' && $hour < 12) {
                        $hour += 12;
                    } elseif ($meridiem === 'am' && $hour === 12) {
                        $hour = 0;
                    }

                    $matches[] = sprintf('%02d:00', $hour);
                }
            }
        }

        return count(array_unique($matches)) === 1 ? $matches[0] : null;
    }
}
