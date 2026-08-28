<?php

namespace Tests\Unit;

use App\Services\Slots\RuleBasedTimeExtractor;
use PHPUnit\Framework\TestCase;

class RuleBasedTimeExtractorTest extends TestCase
{
    private RuleBasedTimeExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extractor = new RuleBasedTimeExtractor;
    }

    public function test_extracts_normalized_24_hour_times(): void
    {
        $this->assertSame('10:30', $this->extractor->extract('a las 10:30'));
        $this->assertSame('09:00', $this->extractor->extract('a las 9:00'));
        $this->assertSame('16:00', $this->extractor->extract('a las 4 pm'));
        $this->assertSame('10:00', $this->extractor->extract('a las 10 a.m.'));
    }

    public function test_returns_invalid_explicit_time_for_central_validation(): void
    {
        $this->assertSame('25:00', $this->extractor->extract('a las 25:00'));
        $this->assertSame('10:75', $this->extractor->extract('a las 10:75'));
    }

    public function test_returns_null_without_a_time_or_with_multiple_times(): void
    {
        $this->assertNull($this->extractor->extract('Quiero una cita'));
        $this->assertNull($this->extractor->extract('entre las 10:00 y las 16:00'));
    }
}
