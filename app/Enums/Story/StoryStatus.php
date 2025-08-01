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

namespace App\Enums\Story;

enum StoryStatus: string
{
	case DRAFT = 'draft';
	case ACTIVE = 'active';
    case PROCESSING = 'processing';

	public function isDraft():bool
    {
        return $this == self::DRAFT;
    }

	public function isActive():bool
    {
        return $this == self::ACTIVE;
    }

    public function isProcessing():bool
    {
        return $this == self::PROCESSING;
    }
}
