<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CrudNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subject;
    public $message;
    public $route;
    /**
     * Create a new notification instance.
     */
    public function __construct(string $subject, string $message, string $route)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->route = $route;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->markdown('mail.crud', [
                'message' => $this->message,
                'route' => $this->route,
            ])
            ->subject($this->subject);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    /**
     * Set the queue for the notification.
     */
    public function viaQueues(): array
    {
        return [
            'mail' => 'emails',
        ];
    }
}
