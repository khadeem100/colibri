<?php

namespace App\Notifications\User\Follows;

use Illuminate\Bus\Queueable;
use App\Constants\Notifications;
use App\Notifications\Traits\HasUserActor;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Channels\WebPushChannel;
use App\Notifications\Traits\BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class FollowAcceptNotification extends Notification implements ShouldQueue
{
    use Queueable,
        BaseNotification,
        HasUserActor;

    private array $actorData;

    private $notificationType = Notifications::FOLLOW_ACCEPTED;
    
    public function __construct()
    {
        $this->actorData = $this->getUserActor();
    }
    
    public function via(object $notifiable): array
    {
        $channels = [];

		if($notifiable->pushNotificationSettings->follow_request) {
			if($this->isPushEnabled()) {
				array_push($channels, WebPushChannel::class);
			}

			if($this->isBroadcastEnabled()) {
				array_push($channels, 'broadcast');
			}

			array_push($channels, 'database');
		}

		if($notifiable->emailNotificationSettings->follow_request) {
            if($this->isEmailEnabled()) {
                array_push($channels, 'mail');
            }
		}

		return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->subject(__('notifications.subjects.follow_accepted', locale: $notifiable->language))->view($this->notificationViewPath, [
            'notifiable' => $notifiable,
            'data' => $this->getData(),
            'notificationType' => $this->notificationType,
            'destinationLink' => $this->getDestinationLink(),
            'locale' => $notifiable->language
        ]);
    }

    public function toPush(object $notifiable): array
    {
        return [
        ];
    }
    
    public function toDatabase(): array
    {
        return $this->getData();
    }

    private function getData()
    {
        return [
            'message_group' => 'user',
            'message_key' => 'follow_accepted',
            'message_params' => [],
            'entity' => [
                'id' => $this->actorData['id'],
                'username' => $this->actorData['username']
            ],
            'actor' => $this->actorData,
            'metadata' => [
                'is_viewable' => true
            ]
        ];
    }

    protected function getDestinationLink(): string
	{
		return url("/@{$this->actorData['username']}");
	}
}
