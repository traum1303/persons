<?php
declare(strict_types=1);

namespace App\Console\Commands;

use App\Interfaces\GenerateFileInterface;
use App\Traits\PersonData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class GenerateFile extends Command
{
    use PersonData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-file
                            {--extension=csv : File extension}
                            {--lines-number=1000000 : Number of lines (persons) in file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private string $dir = 'files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Generating file');

        $availableExtensions = config('commands.file_generator.available_extensions');
        $extension = $this->option('extension');
        $linesNumber = (int)$this->option('lines-number');

        if (!in_array($extension, $availableExtensions))
        {
            $this->error('Invalid file extension');
            return;
        }

        if ($linesNumber < 0)
        {
            $this->error('Number of lines must be integer and greater than 0');
            return;
        }

        $fileGeneratorService = App::makeWith(GenerateFileInterface::class, ['extension' => $extension]);

        $fileGeneratorService->setOutput($this->getOutput());
        $fileGeneratorService->setDir($this->dir);
        $fileGeneratorService->generate($linesNumber);
    }
}
