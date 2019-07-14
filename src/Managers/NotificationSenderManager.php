<?php

namespace Amethyst\Managers;

use Amethyst\Common\ConfigurableManager;
use Amethyst\Exceptions;
use Amethyst\Jobs\NotificationSender\SendNotification;
use Amethyst\Models\DataBuilder;
use Amethyst\Models\NotificationSender;
use Illuminate\Support\Collection;
use Railken\Bag;
use Railken\Lem\Manager;
use Railken\Lem\Result;
use Railken\Template\Generators;

/**
 * @method \Amethyst\Models\NotificationSender                 newEntity()
 * @method \Amethyst\Schemas\NotificationSenderSchema          getSchema()
 * @method \Amethyst\Repositories\NotificationSenderRepository getRepository()
 * @method \Amethyst\Serializers\NotificationSenderSerializer  getSerializer()
 * @method \Amethyst\Validators\NotificationSenderValidator    getValidator()
 * @method \Amethyst\Authorizers\NotificationSenderAuthorizer  getAuthorizer()
 */
class NotificationSenderManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.notification-sender.data.notification-sender';

    /**
     * Send a notification..
     *
     * @param NotificationSender $notification
     * @param array              $data
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function execute(NotificationSender $notification, array $data = [])
    {
        $result = (new DataBuilderManager())->validateRaw($notification->data_builder, $data);

        dispatch(new SendNotification($notification, $data, $this->getAgent()));

        return $result;
    }

    /**
     * Render a notification.
     *
     * @param DataBuilder $data_builder
     * @param array       $parameters
     * @param array       $data
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function render(DataBuilder $data_builder, $parameters, array $data = [])
    {
        $parameters = $this->castParameters($parameters);

        $generator = new Generators\TextGenerator();

        $result = new Result();

        try {
            $bag = new Bag($parameters);

            $bag->set('title', $generator->generateAndRender(strval($bag->get('title')), $data));
            $bag->set('message', $generator->generateAndRender(strval($bag->get('message')), $data));
            $bag->set('targets', $generator->generateAndRender(strval($bag->get('targets')), $data));
            $bag->set('options', $generator->generateAndRender(strval($bag->get('options')), $data));

            $result->setResources(new Collection([$bag->toArray()]));
        } catch (\Twig_Error $e) {
            $e = new Exceptions\NotificationSenderRenderException($e->getRawMessage().' on line '.$e->getTemplateLine());

            $result->addErrors(new Collection([$e]));
        }

        return $result;
    }

    /**
     * Describe extra actions.
     *
     * @return array
     */
    public function getDescriptor()
    {
        return [
            'components' => [
                'renderer',
            ],
            'actions' => [
                'executor',
            ],
        ];
    }
}
