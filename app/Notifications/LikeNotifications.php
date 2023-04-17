<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LikeNotifications extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $post_id;
    public $like_post;
    public $image_post;

    public function __construct($post_id, $like_post, $image_post)
    {
        $this->post_id   = $post_id;
        $this->like_post = $like_post;
        $this->image_post = $image_post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_id'   => $this->post_id,
            'like_post' => $this->like_post,
            'image_post' => $this->image_post,
        ];
    }

}
