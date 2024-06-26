<?php
declare(strict_types=1);

namespace App\Services\FileGenerator;

use App\Interfaces\GenerateFileInterface;

class GenerateTXTFile extends GenerateFile implements GenerateFileInterface
{

    public function generate(int $linesNumber): void
    {
        $fileName = uniqid() . '.txt';
        $this->output->info('Generating TXT file: ' . $fileName);
    }
}
