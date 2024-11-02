<?php

namespace Thetemplateblog\Hosting;

use Statamic\Facades\CP\Nav;
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
            Nav::extend(function ($nav) {
                $nav->tools('Hosting')
                    ->route('hosting.servers.index')  // Changed this to point directly to servers
                    ->icon('hammer-wrench');
            });
        });
    }
}
