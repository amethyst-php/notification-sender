<?php

namespace Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class NotificationSenderAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'notification-sender.create',
        Tokens::PERMISSION_UPDATE => 'notification-sender.update',
        Tokens::PERMISSION_SHOW   => 'notification-sender.show',
        Tokens::PERMISSION_REMOVE => 'notification-sender.remove',
    ];
}
