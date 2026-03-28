<?php

namespace App\Notifications;

use App\Models\PostComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewBlogCommentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public PostComment $comment,
    ) {}

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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $post = $this->comment->post;

        return [
            'type' => 'blog_comment',
            'title' => __('admin.notifications.blog_comment.title'),
            'message' => __('admin.notifications.blog_comment.message', [
                'name' => $this->comment->name,
                'post' => $post?->title ?? '#'.$this->comment->post_id,
            ]),
            'url' => route('admin.posts.edit', $this->comment->post_id),
            'post_id' => $this->comment->post_id,
            'comment_id' => $this->comment->id,
        ];
    }
}
