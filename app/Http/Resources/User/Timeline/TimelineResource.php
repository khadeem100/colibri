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

namespace App\Http\Resources\User\Timeline;

use Carbon\Carbon;
use App\Support\Num;
use Illuminate\Http\Request;
use App\Http\Resources\User\Media\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\Timeline\PollResource;
use App\Http\Resources\User\Timeline\QuoteResource;
use App\Http\Resources\User\User\UserPreviewResource;
use App\Http\Resources\User\Morph\LinkSnapshotResource;
use App\Http\Resources\User\Timeline\ReactionCollection;

class TimelineResource extends JsonResource
{
    public function toArray(Request $request):array
    {
        $isOwner = me()->id === $this->user_id;

        $apiData = [
            'id' => $this->id,
            'content' => e($this->content),
            'type' => $this->type,
            'text_language' => $this->text_language,
            'hash_id' => $this->hash_id,
            'relations' => [
                'user' => UserPreviewResource::make($this->user),
                'reactions' => ReactionCollection::make($this->reactions),
                'comments' => $this->getPreviewComments()
            ],
            'views_count' => [
                'raw' => $this->views_count,
                'formatted' => $this->views_count
            ],
            'comments_count' => [
                'raw' => $this->comments_count,
                'formatted' => Num::abbreviate($this->comments_count)
            ],
            'date' => [
                'iso' => $this->created_at->getIso(),
                'time_ago' => $this->created_at->getTimeAgo()
            ],
            'meta' => [
                'permissions' => [
                    'can_like' => true,
                    'can_comment' => true,
                    'is_admin' => auth_check() ? me()->isAdmin() : false,
                    'can_edit' => auth_check() ? me()->can('update', $this->resource) : false,
                    'can_delete' => auth_check() ? me()->can('delete', $this->resource) : false,
                    'can_report' => auth_check() ? empty($isOwner) : false
                ],
                'activity' => [
                    'bookmarked' => auth_check() ? $this->isBookmarkedBy(me()->id) : false
                ],
                'is_translatable' => $this->isContentTranslatable(),
                'is_quoting' => empty($this->quote_post_id) ? false : true,
                'is_sensitive' => $this->is_sensitive,
                'is_ai_generated' => $this->is_ai_generated
            ],
        ];

        if($this->type->isMedia()) {
            $apiData['relations']['media'] = $this->media->map(function($item) {
                return MediaResource::make($item);
            });
        }

        else if($this->type->isPoll()) {
            $apiData['relations']['poll'] = PollResource::make($this->poll);
        }

        if($this->quotedPost) {
            $apiData['relations']['quoted_post'] = QuoteResource::make($this->quotedPost);
        }

        if($this->linkSnapshot) {
            $apiData['relations']['link_snapshot'] = LinkSnapshotResource::make($this->linkSnapshot);
        }
        
        return $apiData;
    }

    private function getPreviewComments(): array
    {
        return $this->comments->unique('user.id')->map(function($item) {
            return [
                'id' => $item->id,
                'user' => [
                    'avatar_url' => $item->user->avatar_url
                ]
            ];  
        })->toArray();
    }
}
