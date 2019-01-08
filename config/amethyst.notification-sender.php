<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Base Notification
    |--------------------------------------------------------------------------
    |
    | Here you can change class of the notification that will be used
    |
    */
    'notification-class' => Railken\Amethyst\Notifications\BasicNotification::class,

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components.
    |
    */
    'data' => [
        'notification-sender' => [
            'table'      => 'amethyst_notification_senders',
            'comment'    => 'NotificationSender',
            'model'      => Railken\Amethyst\Models\NotificationSender::class,
            'schema'     => Railken\Amethyst\Schemas\NotificationSenderSchema::class,
            'repository' => Railken\Amethyst\Repositories\NotificationSenderRepository::class,
            'serializer' => Railken\Amethyst\Serializers\NotificationSenderSerializer::class,
            'validator'  => Railken\Amethyst\Validators\NotificationSenderValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\NotificationSenderAuthorizer::class,
            'faker'      => Railken\Amethyst\Authorizers\NotificationSenderFaker::class,
            'manager'    => Railken\Amethyst\Authorizers\NotificationSenderManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'notification-sender' => [
                'enabled'     => true,
                'controller'  => Railken\Amethyst\Http\Controllers\Admin\NotificationSendersController::class,
                'router'      => [
                    'as'        => 'notification-sender.',
                    'prefix'    => '/notification-senders',
                ],
            ],
        ],
    ],
];
