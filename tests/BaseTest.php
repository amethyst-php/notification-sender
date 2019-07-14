<?php

namespace Amethyst\Tests;

use Illuminate\Support\Facades\Config;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('amethyst:user:install');

        Config::set('amethyst.notification.data.notification.user', Models\Foo::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\NotificationSenderServiceProvider::class,
            \Amethyst\Providers\FooServiceProvider::class
        ];
    }
}
