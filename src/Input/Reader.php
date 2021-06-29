<?php

namespace App\Input;

interface Reader
{
    public function read(array $options): string;
}
