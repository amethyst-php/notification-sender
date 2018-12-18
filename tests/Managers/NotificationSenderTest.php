<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\NotificationSenderFaker;
use Railken\Amethyst\Managers\NotificationSenderManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class NotificationSenderTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = NotificationSenderManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = NotificationSenderFaker::class;
}
