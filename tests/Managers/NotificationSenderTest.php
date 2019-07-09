<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\NotificationSenderFaker;
use Amethyst\Managers\DataBuilderManager;
use Amethyst\Managers\NotificationSenderManager;
use Amethyst\Tests\BaseTest;
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

    public function testSend()
    {
        $manager = $this->getManager();

        $result = $manager->create(NotificationSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());
        $resource = $result->getResource();

        $result = $manager->send($resource, [
            'name' => 'Bar',
        ]);

        $this->assertEquals(true, $result->ok());
    }

    public function testRender()
    {
        $manager = $this->getManager();

        $result = $manager->create(NotificationSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());

        $resource = $result->getResource();

        $result = $manager->render($resource->data_builder, [
            'message' => '{{ name }}',
        ], (new DataBuilderManager())->build($resource->data_builder, ['name' => 'Bar'])->getResource());

        $this->assertEquals(true, $result->ok());
        $this->assertEquals('Bar', $result->getResource()['message']);
    }
}
