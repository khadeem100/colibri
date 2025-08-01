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

namespace App\Enums\Chat;

enum ChatType: string
{
	case DIRECT = 'direct';
	case GROUP = 'group';

	public function isGroup():bool
    {
        return $this == self::GROUP;
    }

	public function isDirect():bool
    {
        return $this == self::DIRECT;
    }
}
