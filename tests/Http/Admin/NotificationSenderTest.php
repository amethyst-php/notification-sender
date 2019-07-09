<?php

namespace Amethyst\Tests\Http\Admin;

use Amethyst\Api\Support\Testing\TestableBaseTrait;
use Amethyst\Fakers\NotificationSenderFaker;
use Amethyst\Managers\NotificationSenderManager;
use Amethyst\Tests\BaseTest;

class NotificationSenderTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = NotificationSenderFaker::class;

    /**
     * Router group resource.
     *
     * @var string
     */
    protected $group = 'admin';

    /**
     * Route name.
     *
     * @var string
     */
    protected $route = 'admin.notification-sender';

    public function testSend()
    {
        $manager = new NotificationSenderManager();
        $result = $manager->create(NotificationSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());

        $resource = $result->getResource();
        $response = $this->callAndTest('POST', route('admin.notification-sender.send', ['id' => $resource->id]), ['data' => ['name' => $resource->name]], 200);
    }

    public function testRender()
    {
        $manager = new NotificationSenderManager();
        $result = $manager->create(NotificationSenderFaker::make()->parameters());
        $this->assertEquals(1, $result->ok());
        $resource = $result->getResource();

        $response = $this->callAndTest('post', route('admin.notification-sender.render'), [
            'data_builder_id' => $resource->data_builder->id,
            'targets'         => '1',
            'message'         => '{{ name }}',
            'options'         => 'error: false',
            'data'            => ['name' => 'ban'],
        ], 200);

        $this->assertEquals('ban', base64_decode(json_decode($response->getContent())->resource->message, true));
    }
}
