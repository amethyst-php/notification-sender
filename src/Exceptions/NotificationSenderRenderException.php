<?php

namespace Railken\Amethyst\Exceptions;

use Railken\Lem\Exceptions\ModelException;

class NotificationSenderRenderException extends ModelException
{
    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'NOTIFICATION-SENDER_RENDER_ERROR';

    /**
     * Construct.
     *
     * @param mixed $message
     */
    public function __construct($message = null)
    {
        $this->message = $message;

        parent::__construct();
    }
}
