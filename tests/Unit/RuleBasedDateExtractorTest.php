<?php

namespace Tests\Unit;

use App\Services\Slots\RuleBasedDateExtractor;
use PHPUnit\Framework\TestCase;

class RuleBasedDateExtractorTest extends TestCase
{
    private RuleBasedDateExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extractor = new RuleBasedDateExtractor;
    }

    public function test_extracts_one_explicit_iso_date(): void
    {
        $this->assertSame(
            '2026-08-25',
            $this->extractor->extract('Quiero una limpieza dental el 2026-08-25'),
        );
    }

    public function test_returns_null_without_a_date_or_with_multiple_dates(): void
    {
        $this->assertNull($this->extractor->extract('Quiero una cita'));
        $this->assertNull($this->extractor->extract('Del 2026-08-25 al 2026-08-26'));
        $this->assertNull($this->extractor->extract('¿Cuánto cuesta una limpieza dental?'));
    }

    public function test_returns_explicit_invalid_iso_date_for_central_validation(): void
    {
        $this->assertSame(
            '2026-02-31',
            $this->extractor->extract('Quiero una limpieza dental el 2026-02-31'),
        );
    }

    public function test_does_not_extract_relative_dates(): void
    {
        $today = new \DateTimeImmutable('today', new \DateTimeZone('UTC'));

        $this->assertSame($today->format('Y-m-d'), $this->extractor->extract('hoy'));
        $this->assertSame($today->modify('+1 day')->format('Y-m-d'), $this->extractor->extract('mañana'));
        $this->assertSame($today->modify('+2 days')->format('Y-m-d'), $this->extractor->extract('pasado mañana'));
        $this->assertNull($this->extractor->extract('este viernes'));
        $this->assertNull($this->extractor->extract('próximo viernes'));
    }

    public function test_extracts_each_weekday_as_a_future_iso_date(): void
    {
        $today = new \DateTimeImmutable('today', new \DateTimeZone('UTC'));
        $weekdays = [
            'domingo' => 0, 'lunes' => 1, 'martes' => 2, 'miércoles' => 3,
            'miercoles' => 3, 'jueves' => 4, 'viernes' => 5, 'sábado' => 6, 'sabado' => 6,
        ];

        foreach ($weekdays as $weekday => $weekdayNumber) {
            $daysAhead = ($weekdayNumber - (int) $today->format('w') + 7) % 7;
            $daysAhead = $daysAhead === 0 ? 7 : $daysAhead;
            $expected = $today->modify("+{$daysAhead} days")->format('Y-m-d');
            $actual = $this->extractor->extract($weekday);

            $this->assertSame($expected, $actual, $weekday);
            $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $actual);
            $this->assertGreaterThan($today->format('Y-m-d'), $actual);
        }
    }
}
