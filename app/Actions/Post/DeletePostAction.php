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

namespace App\Actions\Post;

use App\Models\Post;
use App\Actions\Media\DeleteMediaAction;

class DeletePostAction
{
	private $postData;

	public function __construct(Post $postData)
	{
		$this->postData = $postData;
	}

	public function execute()
	{
		$this->postData->media->each(function ($mediaItem) {
			(new DeleteMediaAction($mediaItem))->execute();
		});

		$quotingPost = $this->postData->quotingPost;

		if($quotingPost) {
			$quotingPost->update([
				'quote_post_id' => null,
			]);
		}

		// TODO: Delete all quotes of the post, and polls and other related data.

		$this->postData->user->decrementValue('publications_count', 1);

		$this->postData->delete();
	}
}