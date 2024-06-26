<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Interfaces\ImportProcessJobServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 1200;
    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly ImportProcessJobServiceInterface $importProcessJobService,
        private readonly string $filePath
    ){
        //
    }

    /**
     * Execute the job.
     * @throws \Throwable
     */
    public function handle(): void
    {
        $this->importProcessJobService->import($this->filePath);
    }
}
