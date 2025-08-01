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

Route::get('/categories', [App\Http\Controllers\Api\User\Job\JobController::class, 'getCategories']);
Route::post('/jobs', [App\Http\Controllers\Api\User\Job\JobController::class, 'getJobs']);
Route::get('/jobs/{jobId}', [App\Http\Controllers\Api\User\Job\JobController::class, 'getJob']);
Route::post('/bookmarks/add', [App\Http\Controllers\Api\User\Job\JobController::class, 'bookmark']);
Route::get('/bookmarks/count', [App\Http\Controllers\Api\User\Job\JobController::class, 'getBookmarksCount']);
