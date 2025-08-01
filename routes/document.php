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

Route::name('document.')->prefix('document')->group(function() {
    Route::view('/about', 'apps.mpa.document.about.index')->name('about.index');
    Route::view('/help-center', 'apps.mpa.document.help.index')->name('help.index');
    Route::view('/terms-of-use', 'apps.mpa.document.terms.index')->name('terms.index');
    Route::view('/privacy-policy', 'apps.mpa.document.privacy.index')->name('privacy.index');
    Route::view('/cookies-policy', 'apps.mpa.document.cookies.index')->name('cookies.index');
    Route::view('/developers-api', 'apps.mpa.document.developers.index')->name('developers.index');
    Route::view('/verification-rules', 'apps.mpa.document.verification.index')->name('verification.index');
});
