<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OpenapiToSwaggerJson extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Swagger Json Generate';

    public function handle()
    {
        $localDisk = Storage::build([
            'driver' => 'local',
            'root' => storage_path('/'),
        ]);

        if (! $localDisk->exists('api-docs')) {
            $localDisk->makeDirectory('api-docs');
        }

        $storagePath = storage_path('api-docs/api-docs.json');
        shell_exec("php artisan openapi:generate > {$storagePath}");
    }
}
