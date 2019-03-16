<?php

namespace Railken\Amethyst\Events\NotificationSender;

use Illuminate\Queue\SerializesModels;
use Railken\Amethyst\Models\NotificationSender;
use Railken\Lem\Contracts\AgentContract;

class NotificationSent
{
    use SerializesModels;

    public $notification;
    public $agent;

    /**
     * Create a new event instance.
     *
     * @param \Railken\Amethyst\Models\NotificationSender $notification
     * @param \Railken\Lem\Contracts\AgentContract        $agent
     */
    public function __construct(NotificationSender $notification, AgentContract $agent = null)
    {
        $this->email = $notification;
        $this->agent = $agent;
    }
}
