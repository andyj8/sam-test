<?php declare(strict_types=1);

namespace App\Metric;

class MetricSet
{
    /**
     * @var Metric[]
     */
    private $metrics;

    /**
     * @var Period
     */
    private $period;

    /**
     * @param Metric[] $metrics
     * @throws \Exception
     */
    public function __construct(array $metrics)
    {
        if (empty($metrics)) {
            throw new \LengthException('no metrics');
        }

        $this->metrics = $metrics;
        $this->period = new Period(
            $metrics[0]->dateTime,
            $metrics[count($metrics)-1]->dateTime
        );
    }

    /**
     * @return Period
     */
    public function period(): Period
    {
        return $this->period;
    }

    /**
     * @return Metric[]
     */
    public function metrics(): array
    {
        return $this->metrics;
    }

    /**
     * @return MetricSetStats
     */
    public function stats(): MetricSetStats
    {
        return new MetricSetStats($this->metrics);
    }

    /**
     * @param float $threshold
     * @return Period[]
     */
    public function underPerformingPeriods(float $threshold): array
    {
        $periods = [];
        $currentPeriod = null;

        foreach ($this->metrics as $metric) {
            // new period
            if ($metric->value->lessThan($threshold) && is_null($currentPeriod)) {
                $currentPeriod = new Period($metric->dateTime);
            }
            // add metric to existing period
            if ($metric->value->lessThan($threshold) && !is_null($currentPeriod)) {
                $currentPeriod = $currentPeriod->withFutureEnd($metric->dateTime);
            }
            // close period
            if ($metric->value->moreThan($threshold) && !is_null($currentPeriod)) {
                $periods[] = $currentPeriod;
                $currentPeriod = null;
            }
        }

        if (!is_null($currentPeriod)) {
            $periods[] = $currentPeriod;
        }

        return $periods;
    }
}
