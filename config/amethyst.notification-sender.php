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
    'notification-class' => Amethyst\Notifications\BasicNotification::class,

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
            'model'      => Amethyst\Models\NotificationSender::class,
            'schema'     => Amethyst\Schemas\NotificationSenderSchema::class,
            'repository' => Amethyst\Repositories\NotificationSenderRepository::class,
            'serializer' => Amethyst\Serializers\NotificationSenderSerializer::class,
            'validator'  => Amethyst\Validators\NotificationSenderValidator::class,
            'authorizer' => Amethyst\Authorizers\NotificationSenderAuthorizer::class,
            'faker'      => Amethyst\Fakers\NotificationSenderFaker::class,
            'manager'    => Amethyst\Managers\NotificationSenderManager::class,
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
                'enabled'    => true,
                'controller' => Amethyst\Http\Controllers\Admin\NotificationSendersController::class,
                'router'     => [
                    'as'     => 'notification-sender.',
                    'prefix' => '/notification-senders',
                ],
            ],
        ],
    ],
];
