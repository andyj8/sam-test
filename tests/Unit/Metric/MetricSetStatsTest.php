<?php

namespace App\Tests\Unit\Metric;

use App\Metric\ByteCount;
use App\Metric\Metric;
use App\Metric\MetricSetStats;
use DateTime;
use PHPUnit\Framework\TestCase;

class MetricSetStatsTest extends TestCase
{
    /**
     * @var MetricSetStats
     */
    protected $stats;

    protected function setUp(): void
    {
        $this->stats = new MetricSetStats([
            new Metric(new DateTime('2020-01-01'), new ByteCount(2000)),
            new Metric(new DateTime('2020-01-02'), new ByteCount(1000)),
            new Metric(new DateTime('2020-01-03'), new ByteCount(3000)),
        ]);
    }

    public function testGetsMinimum()
    {
        $this->assertEquals(new ByteCount(1000), $this->stats->min());
    }

    public function testGetsMaximum()
    {
        $this->assertEquals(new ByteCount(3000), $this->stats->max());
    }

    public function testGetsAverage()
    {
        $this->assertEquals(new ByteCount(2000), $this->stats->average());
    }

    public function testGetsMedian()
    {
        $this->assertEquals(new ByteCount(1500), $this->stats->median());
    }
}
