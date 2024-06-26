<?php
declare(strict_types=1);

namespace App\Services\FileGenerator;

use App\Interfaces\GenerateFileInterface;
use App\Traits\PersonData;

class GenerateCSVFile extends GenerateFile implements GenerateFileInterface
{
    use PersonData;

    public function generate(int $linesNumber): void
    {
        $fileName = uniqid() . '.csv';
        if (! $this->createFile($fileName))
        {
            $this->output->error('Error creating file: ' . $fileName);
            return;
        }

        $file = fopen($this->getFilePath($fileName),'w');
        $bar = $this->output->createProgressBar($linesNumber);
        $bar->start();

        while ($linesNumber > 0) {
            fputcsv($file, $this->getPersonData());
            $bar->advance();
            $linesNumber--;
        }

        fclose($file);
        $bar->finish();
        $this->output->success('File generated: ' . $fileName);
    }
}
