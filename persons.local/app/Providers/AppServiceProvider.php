<?php

namespace App\Providers;

use App\Interfaces\GenerateFileInterface;
use App\Interfaces\ImportProcessJobServiceInterface;
use App\Interfaces\StorePeopleJobServiceInterface;
use App\Services\FileGenerator\GenerateCSVFile;
use App\Services\FileGenerator\GenerateTXTFile;
use App\Services\Import\CSV\ImportCSVService;
use App\Services\Import\CSV\StoreFromCSVService;
use App\Services\Import\TXT\ImportTXTService;
use App\Services\Import\TXT\StoreFromTXTService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Example of contextual binding https://laravel.com/docs/11.x/container#contextual-binding
        $this->app->bind(ImportProcessJobServiceInterface::class, function (Application $app, array $params) {
            if (isset($params['extension']))
            {
                return match ($params['extension']) {
                    'csv' => $app->make(ImportCSVService::class),
                    'txt' => $app->make(ImportTXTService::class),
//                  'xls' => $app->make(ImportXLSService::class), and other extensions may be added in the future
                    default => throw new Exception(
                        '"File Type" of "' . $params['extension'] . '" has not been implemented',
                        500,
                    ),
                };
            }

            throw new Exception(
                'Expected a "extension" array key with a value of "File Type"',
            );
        });

        //Example of contextual binding https://laravel.com/docs/11.x/container#contextual-binding
        $this->app->when(ImportCSVService::class)
            ->needs(StorePeopleJobServiceInterface::class)
            ->give(StoreFromCSVService::class);

        $this->app->when(ImportTXTService::class)
            ->needs(StorePeopleJobServiceInterface::class)
            ->give(StoreFromTXTService::class);

        $this->app->bind(GenerateFileInterface::class, function (Application $app, array $params) {
            if (isset($params['extension']))
            {
                return match ($params['extension']) {
                    'csv' => $app->make(GenerateCSVFile::class),
                    'txt' => $app->make(GenerateTXTFile::class),
//                  'xls' => $app->make(GenerateXLSFile::class), and other extensions may be added in the future
                    default => throw new Exception(
                        '"File Type" of "' . $params['extension'] . '" has not been implemented',
                        500,
                    ),
                };
            }

            throw new Exception(
                'Expected a "extension" array key with a value of "File Type"',
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
