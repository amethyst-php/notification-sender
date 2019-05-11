<?php

namespace Railken\Amethyst\Jobs\NotificationSender;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Notification;
use Railken\Amethyst\Events\NotificationSender\NotificationFailed;
use Railken\Amethyst\Events\NotificationSender\NotificationSent;
use Railken\Amethyst\Managers\DataBuilderManager;
use Railken\Amethyst\Managers\NotificationSenderManager;
use Railken\Amethyst\Models\NotificationSender;
use Railken\Bag;
use Railken\Lem\Contracts\AgentContract;
use Symfony\Component\Yaml\Yaml;

class SendNotification implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $notification;
    protected $data;
    protected $agent;

    /**
     * Create a new job instance.
     *
     * @param NotificationSender                   $notification
     * @param array                                $data
     * @param \Railken\Lem\Contracts\AgentContract $agent
     */
    public function __construct(NotificationSender $notification, array $data = [], AgentContract $agent = null)
    {
        $this->notification = $notification;
        $this->data = $data;
        $this->agent = $agent;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $data = $this->data;
        $notification = $this->notification;

        $esm = new NotificationSenderManager();
        $dbm = new DataBuilderManager();

        $result = $dbm->build($notification->data_builder, $data);

        if (!$result->ok()) {
            return event(new NotificationFailed($notification, $result->getErrors()[0], $this->agent));
        }

        $data = $result->getResource();
        $result = $esm->render($notification->data_builder, [
            'targets' => $notification->targets,
            'title'   => $notification->title,
            'message' => $notification->message,
            'options' => $notification->options,
        ], $data);

        $bag = new Bag($result->getResource());

        $classTargets = Config::get('amethyst.notification.data.notification.user');

        $targets = $classTargets::whereIn('id', (array) Yaml::parse($bag->get('targets')))->get();

        if (!$result->ok()) {
            return event(new NotificationFailed($notification, $result->getErrors()[0], $this->agent));
        }

        $bag = new Bag($result->getResource());

        $classNotification = Config::get('amethyst.notification-sender.notification-class');

        Notification::send($targets, new $classNotification($bag->get('title'), $bag->get('message'), (array) Yaml::parse($bag->get('options'))));

        event(new NotificationSent($notification, $this->agent));
    }
}
