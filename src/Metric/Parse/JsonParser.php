<?php declare(strict_types=1);

namespace App\Metric\Parse;

use App\Metric\ByteCount;
use App\Metric\Metric;
use App\Metric\MetricSet;

class JsonParser implements Parser
{
    /**
     * @param string $input
     * @return MetricSet
     * @throws \Exception
     */
    public function parse(string $input): MetricSet
    {
        $data = json_decode($input);

        if (!isset($data->data)) {
            throw new \LengthException('no data in json');
        }

        $metrics = [];
        foreach ($this->findMetricData($data->data) as $metric) {
            $metrics[] = new Metric(new \DateTime($metric->dtime), new ByteCount($metric->metricValue));
        }

        return new MetricSet($metrics);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    private function findMetricData(array $data): array
    {
        $metricData = null;
        foreach ($data as $item) {
            if (isset($item->metricData)) {
                $metricData = $item->metricData;
                break;
            }
        }

        if (is_null($metricData)) {
            throw new \LengthException('no metric data in json');
        }

        return $metricData;
    }
}
