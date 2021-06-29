<?php

namespace App\Metric;

use DateTime;

class Period
{
    /**
     * @var DateTime
     */
    public $start;

    /**
     * @var DateTime
     */
    public $end;

    /**
     * @param DateTime $start
     * @param DateTime|null $end
     */
    public function __construct(DateTime $start, DateTime $end = null)
    {
        $this->start = $start;
        $this->end = $start;

        if (!is_null($end)) {
            $this->end = $end;
        }
    }

    /**
     * @param DateTime $end
     * @return Period
     */
    public function withFutureEnd(DateTime $end)
    {
        return new self($this->start, $end);
    }

    /**
     * @return string
     */
    public function asUnderPerformingMessage(): string
    {
        $message = 'The period between %s and %s was under-performing.';

        return sprintf($message, $this->start->format('Y-m-d'), $this->end->format('Y-m-d'));
    }
}
