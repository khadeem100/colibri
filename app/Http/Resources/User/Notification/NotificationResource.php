<?php
/*
|--------------------------------------------------------------------------
| ColibriPlus - The Social Network Web Application.
|--------------------------------------------------------------------------
| Author: Mansur Terla. Full-Stack Web Developer, UI/UX Designer.
| Website: www.terla.me
| E-mail: mansurtl.contact@gmail.com
| Instagram: @mansur_terla
| Telegram: @mansurtl_contact
|--------------------------------------------------------------------------
| Copyright (c)  ColibriPlus. All rights reserved.
|--------------------------------------------------------------------------
*/

namespace App\Http\Resources\User\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'message' => $this->message,
            'type' => $this->type,
            'actor' => $this->data['actor'],
            'entity' => $this->data['entity'],
            'is_read' => $this->read_at ? true : false,
            'metadata' => $this->getMetadata(),
            'date' => [
                'time_ago' => $this->created_at->getTimeAgo(),
                'timestamp' => $this->created_at->getTimestamp()
            ]
        ];

        return $data;
    }

    private function getMetadata(): array
    {
        if(isset($this->data['metadata'])) {
            $metadata = $this->data['metadata'];

            if(isset($metadata['reaction_unified_id'])) {
                $metadata['reaction_image_url'] = reaction_image_url($metadata['reaction_unified_id']);
            }

            return $metadata;
        }

        return [];
    }
}
