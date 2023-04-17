<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotifications extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $post_id;
    public $comment_post;
    public $content_comment;
    public function __construct($post_id, $comment_post, $content_comment)
    {
        $this->post_id         = $post_id;
        $this->comment_post    = $comment_post;
        $this->content_comment = $content_comment;
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
            'post_id'         => $this->post_id,
            'comment_post'    => $this->comment_post,
            'content_comment' => $this->content_comment,
            ];
    }
}
