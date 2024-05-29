<?php

namespace Trendyminds\Metalink;

use Illuminate\Support\Facades\Route;
use Statamic\Providers\AddonServiceProvider;
use Trendyminds\Metalink\Fieldtypes\Metalink;
use Trendyminds\Metalink\Http\Controllers\MetadataController;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/main.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon()
    {
        Metalink::register();

        $this->registerActionRoutes(function () {
            Route::post('metadata', MetadataController::class)
                ->middleware('statamic.cp.authenticated');
        });
    }
}
