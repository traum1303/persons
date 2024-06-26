<?php
declare(strict_types=1);

namespace App\Services\Import\TXT;

use App\Interfaces\ImportProcessJobServiceInterface;
use App\Interfaces\StorePeopleJobServiceInterface;

readonly class ImportTXTService implements ImportProcessJobServiceInterface
{

    public function __construct(private StorePeopleJobServiceInterface $jobService)
    {
        //
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function import(string $filePath): void
    {
        // TODO: Implement import() method.
    }
}
