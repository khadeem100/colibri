@extends('businessLayout::index')

@section('pageContent')
    <x-content>
        <div class="mb-6">
            <x-page-title titleText="{{ __('business/ads.create_title') }}"></x-page-title>
        </div>
        
        @livewire('business.ads.upsert', [
            'adData' => $adData,
            'upsertType' => 'create'
        ])
    </x-content>
@endsection