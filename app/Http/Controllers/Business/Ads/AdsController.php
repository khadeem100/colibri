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

namespace App\Http\Controllers\Business\Ads;

use App\Enums\Ad\AdStatus;
use Illuminate\Http\Request;
use App\Actions\Ad\AdDeleteAction;
use App\Http\Controllers\Controller;

class AdsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->string('type', 'all');
        $type = in_array($type, ['all', 'active', 'archived']) ? $type : 'all';
        
        $adsList = me()->advertising()->with(['user', 'media'])->excludeDraft()->when($type, function($query) use ($type) {
            if($type == 'active') {
                $query->where('status', AdStatus::PUBLISHED);
            }
            else if($type == 'archived') {
                $query->where('status', [AdStatus::COMPLETED, AdStatus::PAUSED]);
            }
        })->latest('id')->paginate(10);

        return view('business::ads.index.index', [
            'type' => $type,
            'adsList' => $adsList
        ]);
    }

    public function create()
    {
        return view('business::ads.create', [
            'adData' => $this->fetchOrInitializeDraftAd()
        ]);
    }

    public function edit($adId)
    {
        $adData = me()->advertising()->excludeDraft()->with(['media'])->findOrFail($adId);

        return view('business::ads.edit', [
            'adData' => $adData
        ]);
    }

    private function fetchOrInitializeDraftAd()
    {
        $adData = me()->advertising()->where('status', AdStatus::DRAFT)->first();
    
        if(empty($adData)) {
            me()->advertising()->create([
                'status' => AdStatus::DRAFT
            ]);

            return me()->advertising()->where('status', AdStatus::DRAFT)->first();
        }

        else {
            return $adData;
        }
    }

    public function show($adId)
    {
        $adData = me()->advertising()->excludeDraft()->with(['media'])->findOrFail($adId);

        return view('business::ads.show.index', [
            'adData' => $adData
        ]);
    }

    public function destroy($adId)
    {
        $adData = me()->advertising()->findOrFail($adId);

        (new AdDeleteAction($adData))->execute();

        return redirect()->route('business.ads.index');
    }

    public function pause($adId)
    {
        $adData = me()->advertising()->findOrFail($adId);

        if($adData->status->isPublished()) {
            $adData->update(['status' => AdStatus::PAUSED]);
        }

        return redirect()->route('business.ads.show', $adId);
    }

    public function publish($adId)
    {
        $adData = me()->advertising()->findOrFail($adId);

        if($adData->status->isPaused()) {
            $adData->update(['status' => AdStatus::PUBLISHED]);
        }

        return redirect()->route('business.ads.show', $adId);
    }
}
