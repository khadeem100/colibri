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

namespace App\Http\Resources\User\Story;

use Illuminate\Http\Request;
use App\Http\Resources\User\Story\ViewResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ViewCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->map(function($viewItem) {
            return ViewResource::make($viewItem->resource);
        })->all();
    }
}
