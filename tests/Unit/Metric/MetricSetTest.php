<?php

namespace App\Tests\Unit\Metric;

use App\Metric\ByteCount;
use App\Metric\Metric;
use App\Metric\MetricSet;
use DateTime;
use PHPUnit\Framework\TestCase;

class MetricSetTest extends TestCase
{
    /**
     * @var MetricSet
     */
    protected $metricSet;

    protected function setUp(): void
    {
        $this->metricSet = new MetricSet([
            new Metric(new DateTime('2020-01-01'), new ByteCount(1000)),
            new Metric(new DateTime('2020-01-02'), new ByteCount(5000)),
            new Metric(new DateTime('2020-01-03'), new ByteCount(1000)),
            new Metric(new DateTime('2020-01-04'), new ByteCount(1000)),
            new Metric(new DateTime('2020-01-05'), new ByteCount(5000)),
            new Metric(new DateTime('2020-01-06'), new ByteCount(1000)),
        ]);
    }

    public function testGetsLeadingUnderPerformingPeriod()
    {
        $underPerforming = $this->metricSet->underPerformingPeriods(3000);

        $this->assertEquals(new DateTime('2020-01-01'), $underPerforming[0]->start);
        $this->assertEquals(new DateTime('2020-01-01'), $underPerforming[0]->end);
    }

    public function testGetsMiddleUnderPerformingPeriod()
    {
        $underPerforming = $this->metricSet->underPerformingPeriods(3000);

        $this->assertEquals(new DateTime('2020-01-03'), $underPerforming[1]->start);
        $this->assertEquals(new DateTime('2020-01-04'), $underPerforming[1]->end);
    }

    public function testGetsTrailingUnderPerformingPeriod()
    {
        $underPerforming = $this->metricSet->underPerformingPeriods(3000);

        $this->assertEquals(new DateTime('2020-01-06'), $underPerforming[2]->start);
        $this->assertEquals(new DateTime('2020-01-06'), $underPerforming[2]->end);
    }
}
