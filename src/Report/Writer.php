<?php

namespace App\Report;

interface Writer
{
    /**
     * @param string $text
     */
    public function init(string $text);

    /**
     * @param string $header
     * @param array $stats
     */
    public function addAttributes(string $header, array $stats);

    /**
     * @param string $header
     * @param string[] $bulletPoints
     */
    public function addBulletPoints(string $header, array $bulletPoints);

    /**
     * @return string
     */
    public function render(): string;
}
