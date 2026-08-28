<?php

namespace Tests\Unit;

use App\Services\Slots\RuleBasedServiceExtractor;
use PHPUnit\Framework\TestCase;

class RuleBasedServiceExtractorTest extends TestCase
{
    private RuleBasedServiceExtractor $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new RuleBasedServiceExtractor([
            'limpieza_dental' => [
                'name' => 'Limpieza dental',
                'aliases' => ['limpieza dental', 'limpieza'],
            ],
            'extraccion_dental' => [
                'name' => 'Extracción dental',
                'aliases' => ['extracción dental', 'extraccion dental', 'extracción', 'extraccion'],
            ],
            'blanqueamiento_dental' => [
                'name' => 'Blanqueamiento dental',
                'aliases' => ['blanqueamiento dental', 'blanqueamiento'],
            ],
            'ortodoncia' => ['name' => 'Ortodoncia', 'aliases' => ['ortodoncia']],
            'endodoncia' => ['name' => 'Endodoncia', 'aliases' => ['endodoncia']],
            'implantes_dentales' => [
                'name' => 'Implantes dentales',
                'aliases' => ['implantes dentales', 'implantes'],
            ],
        ]);
    }

    public function test_extracts_known_services_and_aliases(): void
    {
        $cases = [
            'Quiero una limpieza dental' => 'Limpieza dental',
            'Necesito limpieza' => 'Limpieza dental',
            'extracción dental' => 'Extracción dental',
            'extraccion dental' => 'Extracción dental',
            'blanqueamiento' => 'Blanqueamiento dental',
            'Quiero ortodoncia' => 'Ortodoncia',
            'Necesito endodoncia' => 'Endodoncia',
            'implantes' => 'Implantes dentales',
        ];

        foreach ($cases as $message => $expected) {
            $this->assertSame($expected, $this->extractor->extract($message), $message);
        }
    }

    public function test_does_not_extract_without_sufficient_service_evidence(): void
    {
        $this->assertNull($this->extractor->extract('dental'));
        $this->assertNull($this->extractor->extract('Quiero información sobre la clínica'));
        $this->assertNull($this->extractor->extract('Hola'));
        $this->assertNull($this->extractor->extract('Quiero una cita'));
    }

    public function test_returns_null_when_two_services_are_mentioned(): void
    {
        $this->assertNull($this->extractor->extract('Quiero limpieza dental o blanqueamiento'));
    }
}
