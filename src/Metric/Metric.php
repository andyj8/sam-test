<?php

namespace App\Metric;

class Metric
{
    /**
     * @var \DateTime
     */
    public $dateTime;

    /**
     * @var ByteCount
     */
    public $value;

    /**
     * @param \DateTime $dateTime
     * @param ByteCount $value
     */
    public function __construct(\DateTime $dateTime, ByteCount $value)
    {
        $this->dateTime = $dateTime;
        $this->value = $value;
    }
}
