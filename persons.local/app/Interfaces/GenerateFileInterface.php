<?php

namespace App\Interfaces;

use Illuminate\Console\OutputStyle;

interface GenerateFileInterface
{
    public function generate(int $linesNumber): void;
    public function setDir(string $dir = 'files'): void;
    public function setOutput(OutputStyle $output): void;
}
