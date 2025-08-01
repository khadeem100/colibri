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

namespace App\Http\Resources\User\Chat;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\User\UserPreviewResource;
use App\Http\Resources\User\Morph\LinkSnapshotResource;
use App\Http\Resources\User\Timeline\ReactionCollection;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $messageData = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'chat_uuid' => $this->chat_uuid,
            'content' => $this->content,
            'has_parent' => (empty($this->parent_id)) ? false : true,
            'relations' => [
                'user' => UserPreviewResource::make($this->user),
                'reactions' => ReactionCollection::make($this->reactions),
                'parent' => $this->getParentMessageData(),
                'participant' => [
                    'color' => $this->participant->metadata['color']
                ]
            ],
            'date' => [
                'iso' => $this->created_at->getIso(),
                'time_ago' => $this->created_at->getTimeAgo()
            ],
            'meta' => [
                'is_deleted' => $this->is_deleted,
                'permissions' => [
                    'can_edit' => true,
                    'can_delete' => true
                ],
                'is_translatable' => $this->isMessageTranslatable()
            ]
        ];

        if($this->linkSnapshot) {
            $messageData['relations']['link_snapshot'] = LinkSnapshotResource::make($this->linkSnapshot);
        }

        return $messageData;
    }

    private function getParentMessageData()
    {
        if($this->parent) {
            return [
                'content' => Str::limit($this->parent->content, 120),
                'user' => [
                    'name' => $this->parent->user->name,
                    'username' => $this->parent->user->username,
                    'id' => $this->parent->user->id
                ],
                'participant' => [
                    'color' => $this->parent->participant->metadata['color']
                ]
            ];
        }
    }
}
