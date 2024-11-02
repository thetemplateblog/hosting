<?php

namespace TheTemplateBlog\Hosting;

use Statamic\Facades\CP\Nav;
use Statamic\Facades\User;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'hosting';

    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php'
    ];

    public function bootAddon()
    {
        Nav::extend(function ($nav) {
            $user = User::current();
            $providers = $user->get('providers', []);
            $servers = $user->get('servers', []);

            $nav->create('Hosting')
                ->section('Tools')
                ->icon('hammer-wrench')
                ->url(cp_route('hosting.sites.index'))  // Changed default URL to sites
                ->children([
                    'Providers' => cp_route('hosting.providers.index'),
                    'Servers' => cp_route('hosting.servers.index'),
                    'Sites' => cp_route('hosting.sites.index')
                ]);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/hosting.php', 'hosting'
        );
    }
}
