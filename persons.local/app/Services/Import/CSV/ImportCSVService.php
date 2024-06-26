<?php
declare(strict_types=1);

namespace App\Services\Import\CSV;

use App\Interfaces\ImportProcessJobServiceInterface;
use App\Interfaces\StorePeopleJobServiceInterface;
use App\Jobs\PeopleImport\PersonProcessImportJob;
use Illuminate\Support\Facades\Bus;

readonly class ImportCSVService implements ImportProcessJobServiceInterface
{

    public function __construct(private StorePeopleJobServiceInterface $jobService)
    {
        //
    }

    /**
     * @throws \Throwable
     */
    public function import(string $filePath): void
    {
        $data = file(storage_path('app'.DIRECTORY_SEPARATOR.$filePath));

        $configRowInChunk = config('import.row_in_chunk', 1000);
        // Chunk File
        $chunks = array_chunk($data, min($configRowInChunk, count($data)));

        $batch = Bus::batch([]);
        $batch->onQueue('import');

        foreach($chunks as $chunk)
        {
            $batch->add(new PersonProcessImportJob($this->jobService, $chunk));
        }

        $batch->dispatch();
    }
}
