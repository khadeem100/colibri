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

Route::post('/products', [App\Http\Controllers\Api\User\Market\MarketController::class, 'getProducts']);
Route::get('/products/{productId}', [App\Http\Controllers\Api\User\Market\MarketController::class, 'getProductData']);
Route::get('/categories', [App\Http\Controllers\Api\User\Market\MarketController::class, 'getCategories']);
Route::get('/metadata', [App\Http\Controllers\Api\User\Market\MarketController::class, 'getMetadata']);
Route::get('/bookmarks', [App\Http\Controllers\Api\User\Market\MarketController::class, 'getBookmarks']);
Route::get('/bookmarks/count', [App\Http\Controllers\Api\User\Market\MarketController::class, 'getBookmarksCount']);
Route::post('/bookmarks/add', [App\Http\Controllers\Api\User\Market\MarketController::class, 'bookmark']);