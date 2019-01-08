<?php

namespace Railken\Amethyst\Tests;

use Illuminate\Support\Facades\Config;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();

        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('amethyst:user:install');

        Config::set('amethyst.notification.data.notification.user', \Railken\Amethyst\Models\User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Railken\Amethyst\Providers\NotificationSenderServiceProvider::class,
            \Railken\Amethyst\Providers\UserServiceProvider::class,
        ];
    }
}
