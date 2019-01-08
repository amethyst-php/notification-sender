<?php

namespace Railken\Amethyst\Fakers;

use Faker\Factory;
use Railken\Bag;
use Railken\Lem\Faker;

class NotificationSenderFaker extends Faker
{
    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();

        $bag = new Bag();
        $bag->set('name', $faker->name);
        $bag->set('description', $faker->text);
        $bag->set('data_builder', DataBuilderFaker::make()->parameters()->set('data_builder.class_name', EmailSenderDataBuilder::class)->toArray());
        $bag->set('targets', '1');
        $bag->set('title', $faker->name);
        $bag->set('message', $faker->text);
        $bag->set('options', 'error: false');

        return $bag;
    }
}
