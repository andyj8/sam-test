<?php

namespace App\Report;

class ConsoleWriter implements Writer
{
    /**
     * @var string[]
     */
    private $lines;

    /**
     * @param string $text
     */
    public function init(string $text)
    {
        $this->lines[] = $text;
        $this->lines[] = str_repeat('=', strlen($text));
        $this->lines[] = '';
    }

    /**
     * @param string $header
     * @param array $stats
     */
    public function addAttributes(string $header, array $stats)
    {
        $this->lines[] = $header . ':';
        $this->lines[] = '';
        foreach ($stats as $name => $value) {
            $this->lines[] = sprintf('    %s: %s', $name, $value);
        }
        $this->lines[] = '';
    }

    /**
     * @param string $header
     * @param string[] $bulletPoints
     */
    public function addBulletPoints(string $header, array $bulletPoints)
    {
        $this->lines[] = $header . ':';
        $this->lines[] = '';
        foreach ($bulletPoints as $bulletPoint) {
            $this->lines[] = sprintf('    * %s', $bulletPoint);
        }
        $this->lines[] = '';
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $output = '';
        foreach ($this->lines as $line) {
            $output .= $line . "\n";
        }

        return substr($output, 0, -1);
    }
}
