<?php

namespace App\Input;

class FilesystemReader implements Reader
{
    /**
     * @param array $options
     * @return string
     */
    public function read(array $options): string
    {
        if (!file_exists($options['path'])) {
            throw new \InvalidArgumentException('no file at specified path');
        }

        $content = file_get_contents($options['path']);
        if (!$content) {
            return '';
        }

        return $content;
    }
}
