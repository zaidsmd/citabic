<?php

namespace App\Notifications;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactSubmissionNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ContactSubmission $submission,
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
        return [
            'type' => 'contact_submission',
            'title' => __('admin.notifications.contact_submission.title'),
            'message' => __('admin.notifications.contact_submission.message', [
                'name' => $this->submission->name ?: __('admin.notifications.unknown_sender'),
                'subject' => $this->submission->subject ?: __('admin.notifications.no_subject'),
            ]),
            'url' => route('admin.contact-submissions.index'),
            'contact_submission_id' => $this->submission->id,
        ];
    }
}
