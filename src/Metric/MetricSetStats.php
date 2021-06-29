<?php declare(strict_types=1);

namespace App\Metric;

class MetricSetStats
{
    /**
     * @var float[]
     */
    private $values;

    /**
     * @param Metric[] $metrics
     */
    public function __construct(array $metrics)
    {
        foreach ($metrics as $metric) {
            $this->values[] = $metric->value->value;
        }

        sort($this->values);
    }

    /**
     * @return ByteCount
     */
    public function min(): ByteCount
    {
        return new ByteCount($this->values[0]);
    }

    /**
     * @return ByteCount
     */
    public function max(): ByteCount
    {
        $max = $this->values[count($this->values) - 1];

        return new ByteCount($max);
    }

    /**
     * @return ByteCount
     */
    public function average(): ByteCount
    {
        return new ByteCount(array_sum($this->values) / count($this->values));
    }

    /**
     * @return ByteCount
     */
    public function median(): ByteCount
    {
        $middle = count($this->values) / 2;

        $median = $this->values[$middle];
        if ($middle % 2 != 0) {
            $median = ($median + $this->values[$middle - 1]) / 2;
        }

        return new ByteCount($median);
    }
}
