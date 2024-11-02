<?php

namespace Thetemplateblog\Hosting;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'hosting';

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php'
    ];

    public function bootAddon()
    {
        $this->app->booted(function () {
            \Statamic\Facades\CP\Nav::extend(function ($nav) {
                $nav->tools('Hosting')
                    ->route('statamic.cp.hosting.index')
                    ->icon('hammer-wrench');
            });
        });
    }
}
