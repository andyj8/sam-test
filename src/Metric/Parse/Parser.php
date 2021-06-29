<?php

namespace App\Metric\Parse;

use App\Metric\MetricSet;

interface Parser
{
    /**
     * @param string $input
     * @return MetricSet
     */
    public function parse(string $input): MetricSet;
}
