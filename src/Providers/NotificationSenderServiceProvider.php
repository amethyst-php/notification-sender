<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Api\Support\Router;
use Railken\Amethyst\Common\CommonServiceProvider;

class NotificationSenderServiceProvider extends CommonServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();
        $this->loadExtraRoutes();

        $this->app->register(\Railken\Amethyst\Providers\DataBuilderServiceProvider::class);
        $this->app->register(\Railken\Amethyst\Providers\NotificationServiceProvider::class);
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

                $router->post('/{id}/send', ['as' => 'send', 'uses' => $controller.'@send'])->where(['id' => '[0-9]+']);
            });
        }
    }
}
