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

namespace App\Enums\User;

enum PrivacyPermit: string
{
	case ALL = 'all';
	case FOLLOWERS = 'followers';
	case NOBODY = 'nobody';
	case APPROVED = 'approved';

	public static function followPermits(): array
	{
		return [
			self::ALL,
			self::APPROVED
		];
	}

	public function onlyApproved()
	{
		return $this === self::APPROVED;
	}
}