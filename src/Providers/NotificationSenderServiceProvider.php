<?php

namespace Amethyst\Providers;

use Amethyst\Core\Support\Router;
use Amethyst\Core\Providers\CommonServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class NotificationSenderServiceProvider extends CommonServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();
        $this->loadExtraRoutes();

        $this->app->register(\Amethyst\Providers\DataBuilderServiceProvider::class);
        $this->app->register(\Amethyst\Providers\NotificationServiceProvider::class);
    }

    /**
     * Load extras routes.
     */
    public function loadExtraRoutes()
    {
        $config = Config::get('amethyst.notification-sender.http.admin.notification-sender');

        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');

                $router->post('/render', ['as' => 'render', 'uses' => $controller.'@render']);
                $router->post('/{id}/execute', ['as' => 'execute', 'uses' => $controller.'@execute'])->where(['id' => '[0-9]+']);
            });
        }
    }
}
