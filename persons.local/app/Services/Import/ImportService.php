<?php
declare(strict_types=1);

namespace App\Services\Import;

use App\Interfaces\ImportProcessJobServiceInterface;
use App\Jobs\ImportProcessJob;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ImportService
{
    private string $dir = 'import';

    private function store(UploadedFile $file): false|string
    {
        if (! Storage::exists($this->dir))
        {
            Storage::makeDirectory($this->dir);
        }

        return $file->store($this->dir);
    }

    /**
     * @throws Exception
     */
    public function import(UploadedFile $file): void
    {
        if (! $storedFile = $this->store($file)){
            throw new Exception("Import error");
        }

        $processJobService = App::makeWith(
            ImportProcessJobServiceInterface::class,
            ['extension' => $file->getClientOriginalExtension()]
        );

        ImportProcessJob::dispatch($processJobService, $storedFile)->onQueue('import');
    }
}
