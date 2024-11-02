<?php

namespace Thetemplateblog\Hosting;

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

            $nav->create('Hosting')
                ->section('Tools')
                ->icon('hammer-wrench')
                ->url(cp_route('hosting.providers.index'))
                ->children([
                    'Providers' => cp_route('hosting.providers.index'),
                    'Servers' => cp_route('hosting.servers.index')
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
