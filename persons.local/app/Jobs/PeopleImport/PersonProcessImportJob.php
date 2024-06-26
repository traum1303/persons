<?php
declare(strict_types=1);

namespace App\Jobs\PeopleImport;

use App\Interfaces\StorePeopleJobServiceInterface;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PersonProcessImportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly StorePeopleJobServiceInterface $jobService,
        private readonly array $chunk
    ){
       //
    }

    /**
     * Execute the job.
     * @throws \Throwable
     */
    public function handle(): void
    {
        $this->jobService->store($this->chunk);
    }
}
