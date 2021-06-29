<?php

namespace App\Metric;

class ByteCount
{
    /**
     * @var float
     */
    public $value;

    /**
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @param float $compare
     * @return bool
     */
    public function lessThan(float $compare)
    {
        return $this->value < $compare;
    }

    /**
     * @param float $compare
     * @return bool
     */
    public function moreThan(float $compare)
    {
        return $this->value > $compare;
    }

    /**
     * @param ByteCount $add
     * @return ByteCount
     */
    public function add(ByteCount $add)
    {
        return new self($this->value + $add->value);
    }

    /**
     * @param int $decimals
     * @return float
     */
    public function asMegabits(int $decimals = 2): float
    {
        return round($this->value / 125000, $decimals);
    }
}
