<?php

namespace Amethyst\Events\NotificationSender;

use Exception;
use Illuminate\Queue\SerializesModels;
use Amethyst\Models\NotificationSender;
use Railken\Lem\Contracts\AgentContract;

class NotificationFailed
{
    use SerializesModels;

    public $notification;
    public $error;
    public $agent;

    /**
     * Create a new event instance.
     *
     * @param \Amethyst\Models\NotificationSender $notification
     * @param \Exception                                  $exception
     * @param \Railken\Lem\Contracts\AgentContract        $agent
     */
    public function __construct(NotificationSender $notification, Exception $exception, AgentContract $agent = null)
    {
        $this->email = $notification;
        $this->error = (object) [
            'class'   => get_class($exception),
            'message' => $exception->getMessage(),
        ];

        $this->agent = $agent;
    }
}
