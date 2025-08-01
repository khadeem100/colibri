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

namespace App\Http\Controllers\Downloads\Documents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

class DocumentDownloadController extends Controller
{
    public function downloadDocument(Request $request) {
        $postMedia = Media::with('post')->findOrFail($request->route('media_id'));
        $filePath = $postMedia->source_path;
        $disk = $postMedia->disk;

        if (! Storage::disk($disk)->exists($filePath)) {
            abort(404);
        }

        $metadata = $postMedia->metadata;
        $metadata['downloads'] = ($metadata['downloads'] ?? 0) + 1;

        $fileName = $metadata['file_name'] ?? basename($filePath);

        $postMedia->update([
            'metadata' => $metadata
        ]);

        return Storage::disk($disk)->download($filePath, $fileName);
    }
}
