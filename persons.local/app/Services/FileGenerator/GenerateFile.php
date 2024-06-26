<?php

namespace App\Services\FileGenerator;

use App\Interfaces\GenerateFileInterface;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\Storage;

abstract class GenerateFile implements GenerateFileInterface
{
    protected string $dir;
    protected OutputStyle $output;

    public function generate(int $linesNumber): void {}

    public function setDir(string $dir = 'files'): void
    {
        $this->dir = $dir;
    }

    public function setOutput(OutputStyle $output): void
    {
        $this->output = $output;
    }

    protected function createFile(string $fileName): bool
    {
        if (! Storage::exists($this->dir))
        {
            Storage::makeDirectory($this->dir);
        }

        return Storage::disk('local')->put($this->dir.DIRECTORY_SEPARATOR.$fileName, '');
    }

    protected function getFilePath(string $fileName): string
    {
        return base_path('storage/app/'.$this->dir.DIRECTORY_SEPARATOR.$fileName);
    }
}
