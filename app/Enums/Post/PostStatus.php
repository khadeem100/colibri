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

namespace App\Enums\Post;

enum PostStatus:string
{
    case ACTIVE = 'active';
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case DELETED = 'deleted';
    case PROCESSING_VIDEO = 'processing_video';
}
