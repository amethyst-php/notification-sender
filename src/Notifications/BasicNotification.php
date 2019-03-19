<?php

namespace Railken\Amethyst\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification as IlluminateNotification;

class BasicNotification extends IlluminateNotification implements ShouldQueue
{
    use Queueable;
    use \Illuminate\Queue\SerializesModels;

    public $title;
    public $message;
    public $options;

    /**
     * @param mixed  $title
     * @param string $message
     * @param array  $options
     */
    public function __construct($title, $message, array $options = [])
    {
        $this->title = $title;
        $this->message = $message;
        $this->options = $options;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'options' => $this->options,
        ];
    }
}
