<?php
/*
|--------------------------------------------------------------------------
| ColibriPlus - The Ultimate Social Network Web Application.
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

use Illuminate\Support\Facades\Route;

Route::get('/feed', [App\Http\Controllers\Api\User\Story\StoryController::class, 'getFeed']);
Route::get('/stories/{storyId}', [App\Http\Controllers\Api\User\Story\StoryController::class, 'getStories']);
Route::get('/views/{frameId}', [App\Http\Controllers\Api\User\Story\StoryController::class, 'getStoryViews']);
Route::post('/views/record', [App\Http\Controllers\Api\User\Story\StoryController::class, 'recordView']);
Route::delete('/delete', [App\Http\Controllers\Api\User\Story\StoryController::class, 'deleteStory']);